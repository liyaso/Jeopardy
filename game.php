<?php
require_once __DIR__ . '/includes/session_guard.php';

/* Player 1 must select another player to play Jeopardy
   This will happen by showing Player 1 (the logged in user) a list of registered users, and they have to pick 1
*/

// Show all the registered users
$users_file = __DIR__ . '/data/users.txt';
$all_lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$other_users = [];
foreach($all_lines as $line){
    list($uname) = explode(':', $line, 2);
    if(strtolower($uname) !== strtolower($_SESSION['user'])){
        $other_users[] = $uname;
    }
}

// If there aren't any other registered users, then the player will bot be able to play the game
if(empty($other_users)){
    die('<p>Al least one other registered user is required to play. <a href="register.php">Register a second account here!</a></p>');
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player2'])){
    $p2 = trim($_POST['player2']);
    if(in_array($p2, $other_users)){
        $_SESSION['player2'] = $p2;
        $_SESSION['score'] = [$_SESSION['user'] => 0, $p2 => 0];
        // Player 1 will go first
        $_SESSION['turn'] = $_SESSION['user']; 
        $_SESSION['used'] = [];
    }

    // If the players accidentally refresh the page, redirect to GET, this way the form won't be resubmitted
    header('Location: game.php');
    exit();
}

// Board Values
$categories = ['Category 1', 'Category 2', 'Category 3', 'Category 4', 'Category 5'];
$point_values = [200, 400, 600, 800, 1000];
$player1 = $_SESSION['user'];
$player2 = $_SESSION['player2'] ?? null;
$scores = $_SESSION['score'] ?? [];
$turn = $_SESSION['turn'] ?? $player1;
$used = $_SESSION['used'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy</title>

    <link rel="stylesheet" href="styles/game.css">
</head>
<body>
    <h1>Jeopardy</h1>

    <?php if(!$player2): ?>
    <!-- Select a Player 2 -->
        <div class="setup">
            <h2>Welcome, <?php echo htmlspecialchars($player1); ?>!</h2>
            <p>Who is Player 2?</p>
            <form method="POST" action="game.php">
                <select name="player2">
                    <?php foreach($other_users as $u): ?>
                        <option value="<?php echo htmlspecialchars($u) ?>">
                            <?php echo htmlspecialchars($u); ?>
                        </option>
                        <?php endforeach; ?>
                </select>
                <button type="submit">Start Game</button>
            </form>
        </div>
    
    <?php else: ?>
    <!-- Scoreboard -->
    <div class="scoreboard">
        <div class="player-score" <?php echo ($turn === $player1) ? 'active' : ''; ?>> 
            <h2><?php echo htmlspecialchars($player1); ?></h2>
            <p>$<?php echo number_format($scores[$player1]); ?></p>
        </div>
        <div class="player-score" <?php echo ($turn === $player2) ? 'active' : ''; ?>> 
            <h2><?php echo htmlspecialchars($player2); ?></h2>
            <p>$<?php echo number_format($scores[$player2]); ?></p>
        </div>
    </div>

    <p style="font-style:1.1rem;">
        It's <strong><?php echo htmlspecialchars($turn); ?></strong>'s turn
    </p>

    <!-- Jeopardy Board -->
     <table>
        <thead>
            <tr>
                <?php foreach($categories as $cat): ?>
                    <th><?php echo htmlspecialchars($cat); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($point_values as $pts): ?>
                <tr>
                    <?php foreach($categories as $i => $cat): ?>
                        <?php $title_id = $i . '-' . $pts; ?>
                        <?php if(in_array($title_id, $used)): ?>
                            <td class"used""></td>
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

    <!-- Logout -->
    <div class="logout">
        <a href="logout.php">Log Out</a>
        &nbsp;|&nbsp;
        <a href="game.php?reset=1" onclick="return confirm('Reset the game?')">New Game</a>
    </div>
    <?php endif; ?>

    <?php 
    // Game Reset Logic
    if(isset($_GET['reset'])){
        unset($_SESSION['player2'], $_SESSION['score'], $_SESSION['turn'], $_SESSION['used']);
        header('Location: game.php');
        exit();
    }
    ?>
</body>
</html>