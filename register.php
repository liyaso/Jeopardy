<?php
session_start();

if(isset($_SESSION['user'])){
    header('Location: game.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm']);

    if(empty($username) || empty($password) || empty($confirm)){
        $error = 'All fields are required';
    }
    elseif(strlen($username) < 3){
        $error = 'Username must be at least 3 characters long';
    }
    elseif($password != $confirm){
        $error = 'Passwords do not match';
    }
    else{
        $users_file = __DIR__. '/data/users.txt';
        $existing = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $taken = false;

        foreach($existing as $line){
            list($stored_user) = explode(':', $line);
            if(strtolower($stored_user) === strtolower($username)){
                $taken = true;
                break;
            }
        }
        if($taken){
            $error = 'That username is already taken';
        }
        else{
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $new_line = $username . ':' . $hashed . PHP_EOL;
            file_put_contents($users_file, $new_line, FILE_APPEND | LOCK_EX);
            $success = 'Account created! You can now log in.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy – Register</title>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <div class="card">
        <div class="logo">
            <h1>JEOPARDY</h1>
            <p>Create an account</p>
        </div>

        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="success"><?php echo $success; ?></div>
            <p class="footer-link"><a href="login.php">Go to Login</a></p>
        <?php else: ?>
            <form method="POST" action="register.php">
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Choose a username">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Choose a password">
                </div>
                <div class="field">
                    <label for="confirm">Confirm Password</label>
                    <input type="password" id="confirm" name="confirm" required placeholder="Repeat your password">
                </div>
                <button type="submit">Register</button>
            </form>
            <p class="footer-link">Already have an account? <a href="login.php">Log in</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
