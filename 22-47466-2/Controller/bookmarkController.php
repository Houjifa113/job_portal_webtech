<?php
session_start();

function getBookmarks() {
    if (isset($_COOKIE['bookmarked_jobs'])) {
        
        $cookieValue = $_COOKIE['bookmarked_jobs'];
        $bookmarks = [];
        $current = '';
        
       
        for ($i = 0; $i < strlen($cookieValue); $i++) {
            if ($cookieValue[$i] === ',') {
                $trimmed = trim($current);
                if (!empty($trimmed)) {
                    $bookmarks[] = $trimmed;
                }
                $current = '';
            } else {
                $current .= $cookieValue[$i];
            }
        }
        
        
        $trimmed = trim($current);
        if (!empty($trimmed)) {
            $bookmarks[] = $trimmed;
        }
        
        return $bookmarks;
    }
    return [];
}

function saveBookmarks($bookmarks) {
    
    $bookmarkString = '';
    $first = true;
    
    foreach ($bookmarks as $bookmark) {
        if (!$first) {
            $bookmarkString .= ',';
        }
        $bookmarkString .= $bookmark;
        $first = false;
    }
    
    setcookie('bookmarked_jobs', $bookmarkString, time() + (86400 * 30), "/");
}


if (isset($_POST['action']) && $_POST['action'] == 'add_bookmark' && isset($_POST['job_name'])) {
    $jobName = trim($_POST['job_name']);
    $bookmarks = getBookmarks();

    if (!in_array($jobName, $bookmarks)) {
        $bookmarks[] = $jobName;
        saveBookmarks($bookmarks);
        $_SESSION['message'] = "Job '$jobName' bookmarked successfully!";
    } else {
        $_SESSION['message'] = "Job '$jobName' is already bookmarked.";
    }

    $redirect_url = $_POST['redirect_to'] ?? '../View/home.php';
    header("Location: ../View/" . $redirect_url);
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'remove_bookmark' && isset($_GET['job_name'])) {
    $jobName = trim($_GET['job_name']);
    $bookmarks = getBookmarks();

    $key = array_search($jobName, $bookmarks);
    if ($key !== false) {
        unset($bookmarks[$key]);
        saveBookmarks($bookmarks);
        $_SESSION['message'] = "Bookmark for '$jobName' removed successfully!";
    }

    header("Location: ../View/bookmarkHistory.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'show_history') {
    $bookmarks = getBookmarks();
    $_SESSION['bookmark_history'] = $bookmarks;
    header("Location: ../View/bookmarkHistory.php");
    exit();
}

header("Location: ../View/home.php");
exit();
?>