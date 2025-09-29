<?php
session_start();
require_once '../Model/searchHistoryModel.php';

$user_id = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_title = $_POST['search'] ?? '';
    $status = $_POST['preference'] ?? '';

    if ($user_id && !empty($job_title) && !empty($status)) {
        saveSearch($user_id, $job_title, $status);
        echo "Search saved successfully!";
    } else {
        echo "Please enter a job title and select a status.";
    }
}
?>