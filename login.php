<?php
session_start();

// If not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: profile.php"); // or login.php if you renamed
    exit();
}
?>
