<?php
require_once __DIR__ . '/includes/session_guard.php';
require_once __DIR__ . '/includes/question_bank.php';

// Validate URL parameters
$cat = isset($_GET['cat']) ? (int)$_GET['cat'] : -1;
$pts = isset($_GET['pts']) ? (int)$_GET['pts'] : -1;

$valid_cats = [0, 1, 2, 3, 4, 5];
$valid_pts = [200, 400, 600, 800, 1000];

if(!in_array($cat, $valid_cats) || !in_array($pts, $valid_pts)){
    header('Location: game.php');
    exit();
}

// If the tile has been used, then block it from being used again
$tile_id = $cat . '-' . $pts;
if(in_array($tile_id, $_SESSION['used'] ?? [])){
    header('Location: game.php');
    exit();
}

// Load the questions
$question = get_question($cat, $pts);
$clue = $question['clue'];
$answer = $question['answer'];

$player1 = $_SESSION['user'];
$player2 = $_SESSION['player2'];
$turn = $_SESSION['turn'];

// null = not answered yet, true = correct, false = incorrect
$result = null; 

// Answer submission logic
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])){
    $submitted = strtolower(trim($_POST['answer']));
    $correct = strtolower(trim($answer));

    // Mark the tile as used
    $_SESSION['used'][] = $tile_id;
    if($submitted === $correct){
        // If the answer is correct, add points to the current player - True/Correct
        $_SESSION['score'][$turn] += $pts;
        $result = true;
    }
    else{
        // If the answer is wrong, deduct points from the current player - False/Incorrect
        $_SESSION['score'][$turn] -= $pts;
        $result = false;
    }

    // After the question has been answerd, switch the turn to the other player
    $_SESSION['turn'] = ($turn === $player1) ? $player2 : $player1;
}

// Game is over when all tiles are used
$game_over = count($_SESSION['used'] ?? []) >= 30;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy</title>

    <link rel="stylesheet" href="styles/question.css">
</head>
<body>
    <div class="card">
        <?php if($game_over && $result !== null): ?>
            <h1>Game Over!</h1>
            <div class="game-over-scores">
                <div><?php echo htmlspecialchars($player1); ?>: $<?php echo number_format($_SESSION['score'][$player1]); ?></div>
                <div><?php echo htmlspecialchars($player2); ?>: $<?php echo number_format($_SESSION['score'][$player2]); ?></div>
            </div>

            <?php
                $s1 = $_SESSION['score'][$player1];
                $s2 = $_SESSION['score'][$player2];
                if($s1 > $s2){
                    echo '<div class="winner">' . htmlspecialchars($player1) . 'wins!</div>';
                }
                elseif($s2 > $s1){
                    echo '<div class="winner">' . htmlspecialchars($player2) . 'wins!</div>';
                }
                else{
                    echo '<div class="winner">It\'s a tie!</div>';
                }
            ?>

            <a href="game.php?reset=1">Play Again</a>
            &nbsp;|&nbsp;
            <a href="logout.php">Log Out</a>

        <?php elseif($result !== null):?>
        <!-- Answer result -->
            <?php if($result): ?>
                <div class="result correct">Correct! +$<?php echo $pts; ?></div>
            <?php else: ?>
                <div class="result wrong">Wrong! -$<?php echo $pts; ?></div>
                <div class="correct-answer">
                    The correct answer was: <strong><?php echo htmlspecialchars($answer); ?></strong>
                </div>
            <?php endif; ?>

            <p style="color:#ccc;">
                Next Up: <strong><?php echo htmlspecialchars($_SESSION['turn']); ?></strong>
            </p>
            <a href="game.php" class="back">Back to Board</a>
        
        <?php else: ?>
        <!-- Display the question -->
            <div class="points">$<?php echo $pts; ?></div>
            <div class="clue"><?php echo htmlspecialchars($clue); ?></div>

            <div class="turn-label">
                <?php echo htmlspecialchars($turn); ?>, what is your answer?
            </div>

            <form method="POST" action="question.php?cat=<?php echo $cat; ?>&pts=<?php echo $pts; ?>">
                <input type="text" name="answer" autofocus placeholder ="Your answer" required><br>
                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>