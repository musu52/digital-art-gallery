<?php
session_start();

// Sab session variables destroy karo
session_unset();
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit();
?>