<?php
session_start();


session_unset();  // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page with a logout message
header("Location: ../admin/login.php");
exit;