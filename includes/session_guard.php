<?php
// Make sure a session isn't already started
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Maje syre there are no logged in uses in this session
if(!isset($_SESSION['user'])){
    header('Location: ../login.php');
    exit();
}
?>