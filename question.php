<?php
require_once __DIR__ . '/includes/session_guard.php';
require_once __DIR__ . '/includes/question_bank.php';

$cat = isset($_GET['cat']) ? (int)$_GET['cat'] : -1;
$pts = isset($_GET['pts']) ? (int)$_GET['pts'] : -1;

$valid_cats = [0, 1, 2, 3, 4, 5];
$valid_pts  = [200, 400, 600, 800, 1000];

if (!in_array($cat, $valid_cats) || !in_array($pts, $valid_pts)) {
    header('Location: game.php');
    exit();
}

$tile_id = $cat . '-' . $pts;
if (in_array($tile_id, $_SESSION['used'] ?? [])) {
    header('Location: game.php');
    exit();
}

// ── Per-player AI difficulty setup ───────────────────────────────────────
if (!isset($_SESSION['seen_ids'])) $_SESSION['seen_ids'] = [];

$player1 = $_SESSION['user'];
$player2 = $_SESSION['player2'];
$turn    = $_SESSION['turn'];

// Each player gets their own difficulty (1-3) and answer history
if (!isset($_SESSION['ai_diff'][$player1])) $_SESSION['ai_diff'][$player1] = 2;
if (!isset($_SESSION['ai_diff'][$player2])) $_SESSION['ai_diff'][$player2] = 2;
if (!isset($_SESSION['ai_hist'][$player1])) $_SESSION['ai_hist'][$player1] = [];
if (!isset($_SESSION['ai_hist'][$player2])) $_SESSION['ai_hist'][$player2] = [];

// Use the current player's difficulty to pick the question
$current_diff = (int)$_SESSION['ai_diff'][$turn];

$result = null;

// ── Answer submission ─────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'], $_POST['q_id'])) {

    $q_id = $_POST['q_id'];
    $all  = get_all_questions();
    $question = null;
    foreach ($all as $q) {
        if ($q['id'] === $q_id) { $question = $q; break; }
    }

    if (!$question) {
        header('Location: game.php');
        exit();
    }

    $answer    = $question['answer'];
    $submitted = strtolower(trim($_POST['answer']));
    $is_correct = ($submitted === strtolower(trim($answer)));
    $result = $is_correct;

    $_SESSION['used'][]     = $tile_id;
    $_SESSION['seen_ids'][] = $q_id;

    if ($is_correct) {
        $_SESSION['score'][$turn] += $pts;
    } else {
        $_SESSION['score'][$turn] -= $pts;
    }

    // Update THIS player's history and difficulty
    $_SESSION['ai_hist'][$turn][] = $is_correct;
    $_SESSION['ai_diff'][$turn]   = adjust_difficulty($_SESSION['ai_hist'][$turn], $current_diff);

    $_SESSION['turn'] = ($turn === $player1) ? $player2 : $player1;

} else {
    $question = get_question($cat, $current_diff, $_SESSION['seen_ids']);
    if (!$question) {
        header('Location: game.php');
        exit();
    }
}

$clue   = $question['clue'];
$answer = $question['answer'];
$q_id   = $question['id'];

$game_over = count($_SESSION['used'] ?? []) >= 30;

// ── Leaderboard write on game over ────────────────────────────────────────
if ($game_over && $result !== null && !isset($_SESSION['game_logged'])) {
    $_SESSION['game_logged'] = true;
    $s1 = $_SESSION['score'][$player1];
    $s2 = $_SESSION['score'][$player2];
    $winner = null;
    if ($s1 > $s2)     $winner = $player1;
    elseif ($s2 > $s1) $winner = $player2;

    if ($winner !== null) {
        $lb_file = __DIR__ . '/data/leaderboard.txt';
        $lb_data = [];
        if (file_exists($lb_file)) {
            foreach (file($lb_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $ln) {
                $p = explode(':', $ln, 3);
                if (count($p) === 3)
                    $lb_data[strtolower($p[0])] = ['username'=>$p[0],'wins'=>(int)$p[1],'total_score'=>(int)$p[2]];
            }
        }
        $key = strtolower($winner);
        if (isset($lb_data[$key])) {
            $lb_data[$key]['wins']++;
            $lb_data[$key]['total_score'] += max($s1, $s2);
        } else {
            $lb_data[$key] = ['username'=>$winner,'wins'=>1,'total_score'=>max($s1,$s2)];
        }
        $out = '';
        foreach ($lb_data as $e) $out .= $e['username'].':'.$e['wins'].':'.$e['total_score'].PHP_EOL;
        file_put_contents($lb_file, $out, LOCK_EX);
    }
}

// Show each player's current difficulty label in the badge
$turn_diff_label = difficulty_label($_SESSION['ai_diff'][$turn] ?? 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy</title>
    <link rel="stylesheet" href="styles/question.css">
    <style>
        .ai-badge {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .ai-badge.easy   { background: #28a745; color: #fff; }
        .ai-badge.medium { background: #FFD700; color: #000; }
        .ai-badge.hard   { background: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="card">
        <div>
            <span class="ai-badge <?php echo strtolower($turn_diff_label); ?>">
                AI: <?php echo $turn_diff_label; ?>
            </span>
        </div>

        <?php if ($game_over && $result !== null): ?>
            <h1>Game Over!</h1>
            <div class="game-over-scores">
                <div><?php echo htmlspecialchars($player1); ?>: $<?php echo number_format($_SESSION['score'][$player1]); ?></div>
                <div><?php echo htmlspecialchars($player2); ?>: $<?php echo number_format($_SESSION['score'][$player2]); ?></div>
            </div>
            <?php
                $s1 = $_SESSION['score'][$player1];
                $s2 = $_SESSION['score'][$player2];
                if ($s1 > $s2)     echo '<div class="winner">' . htmlspecialchars($player1) . ' wins!</div>';
                elseif ($s2 > $s1) echo '<div class="winner">' . htmlspecialchars($player2) . ' wins!</div>';
                else               echo '<div class="winner">It\'s a tie!</div>';
            ?>
            <div style="margin-top:20px;">
                <a href="leaderboard.php">🏆 View Leaderboard</a>
                &nbsp;|&nbsp;
                <a href="game.php?reset=1">Play Again</a>
                &nbsp;|&nbsp;
                <a href="logout.php">Log Out</a>
            </div>

        <?php elseif ($result !== null): ?>
            <?php if ($result): ?>
                <div class="result correct">Correct! +$<?php echo $pts; ?></div>
            <?php else: ?>
                <div class="result wrong">Wrong! -$<?php echo $pts; ?></div>
                <div class="correct-answer">
                    The correct answer was: <strong><?php echo htmlspecialchars($answer); ?></strong>
                </div>
            <?php endif; ?>
            <p style="color:#ccc; margin-top:16px;">
                Next Up: <strong><?php echo htmlspecialchars($_SESSION['turn']); ?></strong>
            </p>
            <a href="game.php" class="back">Back to Board</a>

        <?php else: ?>
            <div class="points">$<?php echo $pts; ?></div>
            <div class="clue"><?php echo htmlspecialchars($clue); ?></div>
            <div class="turn-label">
                <?php echo htmlspecialchars($turn); ?>, what is your answer?
            </div>
            <form method="POST" action="question.php?cat=<?php echo $cat; ?>&pts=<?php echo $pts; ?>">
                <input type="hidden" name="q_id" value="<?php echo htmlspecialchars($q_id); ?>">
                <input type="text" name="answer" autofocus placeholder="Your answer" required><br>
                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
