<?php
session_start();

$searchText = $_POST['search'] ?? '';
$preference = $_POST['preference'] ?? '';

// If search or preference is empty → send back error in URL
if (empty(trim($searchText)) || empty($preference)) {
    header("Location: ../View/job.php?error=invalid_input");
    exit();
}

// Prevent numeric search
if (is_numeric(trim($searchText))) {
    header("Location: ../View/job.php?error=invalid_input");
    exit();
}

// Save last search
$_SESSION['last_search'] = [
    'search' => $searchText,
    'preference' => $preference
];

header("Location: ../View/job.php");
exit();
?>
