<?php
session_start();     // Start session
session_unset();     // Clear session variables
session_destroy();   // End the session

header("Location: login.php");
exit;
?>