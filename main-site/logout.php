<?php
session_start();        // Start the session (required before destroying)
session_unset();        // Remove all session variables
session_destroy();      // Destroy the session completely

// Redirect to login page
header("Location: login.php");
exit;
?>

