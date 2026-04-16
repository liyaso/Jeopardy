<?php
session_start();

if(isset($_SESSION['user'])){
    header('Location: game.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim(htmlspecialchars($_POST['username'])); // htmlspecialchars is used to sanatize the username input
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    // Validation:

    // Check if the user filled all the fields
    if(empty($username) || empty($password) || empty($confirm)){
        $error = 'All fields are required';
    }
    // Check if the user created a long enough username
    elseif(strlen($username) < 3){
        $error = 'Username must be at least 3 characters long';
    }
    // Check if the user's password match with the confirmation password
    elseif($password != $confirm){
        $error = 'Passwords do no match';
    }
    // Check if the username exists
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
            // If the username has not been taken, then save the username as a new user
            $hashed = password_hash($password, PASSWORD_DEFAULT); // Never store the the raw password, this will convert the password to a hash before saving
            $new_line = $username . ':' . $hashed . PHP_EOL;
            file_put_contents($users_file, $new_line, FILE_APPEND | LOCK_EX);
            $success = 'Account created! You can now log in!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Account</title>
</head>
<body>
    <h1>Create an Account</h1>

    <?php if($error):?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
        <a href="login.php">Go to Login Page</a>
    <?php else: ?>
        <form method="POST" action="register.php">
            <label>Username:<br>
                <input type="text" name="username" required>
            </label><br><br>
            
            <label>Password:<br>
                <input type="password" name="password" required>
            </label><br><br>
            
            <label>Confirm Password:<br>
                <input type="password" name="confirm" required>
            </label><br><br>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    <?php endif; ?>
</body>
</html>