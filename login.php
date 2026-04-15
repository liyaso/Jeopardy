<?php
session_start();

// Check if the user has already logged in, if so skip the login page and go straight to the game
if(isset($_SESSION['user'])){
    header('Location: game.php');
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if the user filled both fields
    if(empty($username) || empty($password)){
        $error = 'Both fields are required';
    }

    // Check if the username matches to one in users.txt
    else{
        $users_file = __DIR__. '/data/users.txt';
        $lines = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $authenticated = false;

        foreach($lines as $line){
            // Remember that the lines in users.txt are stored in the format: username:hashed_password
            list($stored_user, $stored_hash) = explode(':', $line, 2);
            if(strtolower($stored_user) === strtolower($username)){
                // The username matches, so now check if the password is correct
                if(password_verify($password, $stored_hash)){
                    $authenticated = true;
                    $_SESSION['user'] = $stored_user;
                }
                // Now that the username has been found, stop the search process
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
    <title>Login</title>
</head>
<body>
    <h1>Log In</h1>
    <?php if($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action = "login.php">
        <label>Username:<br>
            <input type="text" name="username" required autofocus>
        </label><br><br>

        <label>Password:<br>
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">Log In</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here!</a></p>
</body>
</html>