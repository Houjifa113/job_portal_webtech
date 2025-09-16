<?php
require_once '../Model/config.php';

// Destroy session
session_destroy();

// Clear any auth cookies if they exist
if (isset($_COOKIE['status'])) {
    setcookie('status', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: ../View/UserAuthetication.php');
exit();