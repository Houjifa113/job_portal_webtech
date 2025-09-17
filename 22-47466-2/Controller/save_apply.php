<?php
session_start();
require_once('../Model/applyHistoryModel.php');

if (isset($_POST['job_name'])) {
    $job_name = $_POST['job_name'];

    if (saveApply($job_name)) {
        $_SESSION['message'] = "You have successfully applied for $job_name.";
    } else {
        $_SESSION['message'] = "You have already applied for $job_name.";
    }
}


$redirect_page = $_POST['redirect_to'] ?? 'home.php';
header("Location: ../View/$redirect_page");
exit();
