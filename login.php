<?php
session_start();

if(isset($_SESSION['user'])){
    header('Location: game.php');
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)){
        $error = 'Both fields are required';
    }
    else{
        $users_file = __DIR__. '/data/users.txt';
        $lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $authenticated = false;

        foreach($lines as $line){
            list($stored_user, $stored_hash) = explode(':', $line, 2);
            if(strtolower($stored_user) === strtolower($username)){
                if(password_verify($password, $stored_hash)){
                    $authenticated = true;
                    $_SESSION['user'] = $stored_user;
                }
                break;
            }
        }
        if($authenticated){
            header('Location: game.php');
            exit();
        }
        else{
            $error = 'Incorrect username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeopardy – Log In</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="card">
        <div class="logo">
            <h1>JEOPARDY</h1>
            <p>Sign in to play</p>
        </div>

        <?php if($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus placeholder="Enter your username">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit">Log In</button>
        </form>

        <p class="footer-link">Don't have an account? <a href="register.php">Register here!</a></p>
    </div>
</body>
</html>
