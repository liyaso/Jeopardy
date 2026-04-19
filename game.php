<?php
require_once __DIR__ . '/includes/session_guard.php';
require_once __DIR__ . '/includes/question_bank.php';

$users_file = __DIR__ . '/data/users.txt';
$all_lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$other_users = [];
foreach ($all_lines as $line) {
    list($uname) = explode(':', $line, 2);
    if (strtolower($uname) !== strtolower($_SESSION['user']))
        $other_users[] = $uname;
}

if (empty($other_users)) {
    die('<p>At least one other registered user is required to play. <a href="register.php">Register a second account here!</a></p>');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player2'])) {
    $p2 = trim($_POST['player2']);
    if (in_array($p2, $other_users)) {
        $p1 = $_SESSION['user'];
        $_SESSION['player2']      = $p2;
        $_SESSION['score']        = [$p1 => 0, $p2 => 0];
        $_SESSION['turn']         = $p1;
        $_SESSION['used']         = [];
        $_SESSION['seen_ids']     = [];
        $_SESSION['ai_diff']      = [$p1 => 2, $p2 => 2]; // each player starts at Medium
        $_SESSION['ai_hist']      = [$p1 => [], $p2 => []];
        unset($_SESSION['game_logged']);
    }
    header('Location: game.php');
    exit();
}

if (isset($_GET['reset'])) {
    unset($_SESSION['player2'], $_SESSION['score'], $_SESSION['turn'],
          $_SESSION['used'], $_SESSION['seen_ids'], $_SESSION['ai_diff'],
          $_SESSION['ai_hist'], $_SESSION['game_logged']);
    header('Location: game.php');
    exit();
}

$categories   = ['Science', 'History', 'Geography', 'Movies & TV', 'Sports', 'Food & Drink'];
$point_values = [200, 400, 600, 800, 1000];
$player1 = $_SESSION['user'];
$player2 = $_SESSION['player2'] ?? null;
$scores  = $_SESSION['score'] ?? [];
$turn    = $_SESSION['turn'] ?? $player1;
$used    = $_SESSION['used'] ?? [];

$p1_diff = difficulty_label($_SESSION['ai_diff'][$player1] ?? 2);
$p2_diff = $player2 ? difficulty_label($_SESSION['ai_diff'][$player2] ?? 2) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy</title>
    <link rel="stylesheet" href="styles/game.css">
    <style>
        .ai-badge {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 10px;
            border-radius: 20px;
            margin-top: 6px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .ai-badge.easy   { background: #28a745; color: #fff; }
        .ai-badge.medium { background: #FFD700; color: #000; }
        .ai-badge.hard   { background: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <h1>Jeopardy</h1>

    <?php if (!$player2): ?>
        <div class="setup">
            <h2>Welcome, <?php echo htmlspecialchars($player1); ?>!</h2>
            <p>Who is Player 2?</p>
            <form method="POST" action="game.php">
                <select name="player2">
                    <?php foreach ($other_users as $u): ?>
                        <option value="<?php echo htmlspecialchars($u); ?>">
                            <?php echo htmlspecialchars($u); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Start Game</button>
            </form>
        </div>

    <?php else: ?>
        <div class="scoreboard">
            <div class="player-score <?php echo ($turn === $player1) ? 'active' : ''; ?>">
                <h2><?php echo htmlspecialchars($player1); ?></h2>
                <p>$<?php echo number_format($scores[$player1]); ?></p>
                <span class="ai-badge <?php echo strtolower($p1_diff); ?>"><?php echo $p1_diff; ?></span>
            </div>
            <div class="player-score <?php echo ($turn === $player2) ? 'active' : ''; ?>">
                <h2><?php echo htmlspecialchars($player2); ?></h2>
                <p>$<?php echo number_format($scores[$player2]); ?></p>
                <span class="ai-badge <?php echo strtolower($p2_diff); ?>"><?php echo $p2_diff; ?></span>
            </div>
        </div>

        <p style="font-size:1.1rem;">
            It's <strong><?php echo htmlspecialchars($turn); ?></strong>'s turn
        </p>

        <table>
            <thead>
                <tr>
                    <?php foreach ($categories as $cat): ?>
                        <th><?php echo htmlspecialchars($cat); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($point_values as $pts): ?>
                    <tr>
                        <?php foreach ($categories as $i => $cat): ?>
                            <?php $tile_id = $i . '-' . $pts; ?>
                            <?php if (in_array($tile_id, $used)): ?>
                                <td class="used"></td>
                            <?php else: ?>
                                <td>
                                    <a href="question.php?cat=<?php echo $i; ?>&pts=<?php echo $pts; ?>">
                                        $<?php echo $pts; ?>
                                    </a>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="logout">
            <a href="leaderboard.php">🏆 Leaderboard</a>
            &nbsp;|&nbsp;
            <a href="game.php?reset=1" onclick="return confirm('Reset the game?')">New Game</a>
            &nbsp;|&nbsp;
            <a href="logout.php">Log Out</a>
        </div>
    <?php endif; ?>
</body>
</html>
