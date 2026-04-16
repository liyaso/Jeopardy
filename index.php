<?php
session_start();

// Check if the user has already logged in, if go to the game, otherwise direct user to login
if(isset($_SESSION['user'])){
    header('Location: game.php');
}
else{
    header('Location: login.php');
}
exit();
?>