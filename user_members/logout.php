<?php
// Include the necessary files
include '../config.php';

// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Destroy all sessions to log out the user
session_destroy();

// Display a message box to confirm logout and redirect to the register page
echo "<script>
    alert('You have successfully logged out.');
    window.location.href = 'register.php';
</script>";

// Make sure no further code is executed
exit();
?>
