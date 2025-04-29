<?php
// Start the session to access existing session data
session_start();

// Completely destroy the session, removing all session variables, effectively logs the user out by removing their session data
session_destroy();

// Redirect the user back to the login page (index.html), ensuring they can't access protected pages without logging in again
header("Location: index.html");

?>
