<?php
session_start();

// Clear all the session variables
session_unset();

// Destroy the session
session_destroy();

header('Location: login.php');
exit();
?>