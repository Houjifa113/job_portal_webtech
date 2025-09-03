<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job']) && isset($_POST['redirect'])) {
    $job = $_POST['job'];
    $redirectPage = $_POST['redirect'];

    // SESSION'applied' array
    if (!isset($_SESSION['applied']) || !is_array($_SESSION['applied'])) {
        $_SESSION['applied'] = [];
    }

    // Save applied 
    $_SESSION['applied'][$job] = true;

    //  back to the job page
    header("Location: $redirectPage");
    exit;
}
?>
