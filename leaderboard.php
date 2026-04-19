<?php
require_once __DIR__ . '/includes/session_guard.php';

$lb_file = __DIR__ . '/data/leaderboard.txt';
$entries = [];

if(file_exists($lb_file)){
    $lines = file($lb_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line){
        $parts = explode(':', $line, 3);
        if(count($parts) === 3){
            $entries[] = [
                'username'    => $parts[0],
                'wins'        => (int)$parts[1],
                'total_score' => (int)$parts[2],
            ];
        }
    }
    usort($entries, function($a, $b){
        if($b['wins'] !== $a['wins']) return $b['wins'] - $a['wins'];
        return $b['total_score'] - $a['total_score'];
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard – Jeopardy</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #060CE9;
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 30px 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin: 20px 0 30px;
        }
        .back-link {
            display: inline-block;
            color: #FFD700;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .back-link:hover { text-decoration: underline; }
        .empty {
            font-size: 1rem;
            color: #ccc;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 90%;
            max-width: 600px;
        }
        thead tr { background: #000080; }
        thead th {
            padding: 14px 20px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #FFD700;
            border: 4px solid #060CE9;
        }
        tbody tr { background: #000080; }
        tbody tr:hover { background: #00009a; }
        tbody td {
            padding: 14px 20px;
            font-size: 1rem;
            text-align: left;
            border: 4px solid #060CE9;
        }
        td.rank {
            font-size: 1.1rem;
            width: 60px;
            font-weight: bold;
            color: #FFD700;
        }
        td.name { font-weight: bold; }
    </style>
</head>
<body>
    <a href="game.php" class="back-link">← Back to Game</a>
    <h1>Leaderboard</h1>

    <?php if(empty($entries)): ?>
        <p class="empty">No games have been completed yet. Play a game to get on the board!</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Wins</th>
                    <th>Total Earnings</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($entries as $i => $entry): ?>
                    <tr>
                        <td class="rank">
                            <?php
                                if($i === 0) echo '🥇';
                                elseif($i === 1) echo '🥈';
                                elseif($i === 2) echo '🥉';
                                else echo '#' . ($i + 1);
                            ?>
                        </td>
                        <td class="name"><?php echo htmlspecialchars($entry['username']); ?></td>
                        <td><?php echo $entry['wins']; ?></td>
                        <td>$<?php echo number_format($entry['total_score']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
