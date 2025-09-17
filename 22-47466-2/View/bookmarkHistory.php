<?php
session_start();

$bookmarks = isset($_SESSION['bookmark_history']) ? $_SESSION['bookmark_history'] : [];

unset($_SESSION['bookmark_history']);


if (empty($bookmarks) && isset($_COOKIE['bookmarked_jobs'])) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookmark History</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f9fc; margin: 0; padding: 20px; color: #333; }
        h2 { text-align: center; color: #2c3e50; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; }
        th { background: #f39c12; color: white; text-transform: uppercase; }
        tr:nth-child(even) { background: #f2f6fa; }
        tr:hover { background: #eaf2fb; }
        a { display: inline-block; margin: 10px; padding: 10px 20px; background: #3498db; color: white; text-decoration: none; border-radius: 6px; text-align: center; }
        a:hover { background: #217dbb; }
        .remove-btn { background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
        .remove-btn:hover { background: #c0392b; }
        p { text-align: center; font-style: italic; color: #777; }
        .message { text-align: center; color: blue; margin: 10px 0; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Bookmarked Jobs</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (empty($bookmarks)): ?>
        <p>No bookmarked jobs found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Job Title</th>
                <th>Action</th>
            </tr>
            <?php foreach ($bookmarks as $job): ?>
            <tr>
                <td><?= htmlspecialchars($job) ?></td>
                <td>
                    <a href="../Controller/bookmarkController.php?action=remove_bookmark&job_name=<?= urlencode($job) ?>" class="remove-btn">Remove</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <div style="text-align:center;">
        <a href="home.php">Home</a>
    </div>

</body>
</html>