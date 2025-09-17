<?php
session_start();
require_once('../Model/applyHistoryModel.php');

$job_name = "System Analyst";

// Check if the job has already been applied (global)
$already_applied = hasApplied($job_name);

// Bookmark functionality - same as software_engineering.php
$bookmarks = [];
if (isset($_COOKIE['bookmarked_jobs'])) {
    $cookieValue = $_COOKIE['bookmarked_jobs'];
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

$already_bookmarked = in_array($job_name, $bookmarks);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($job_name) ?></title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f7f9fc; color: #333; }
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.job-name { font-size: 28px; font-weight: bold; color: #2c3e50; }
.apply-btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; background-color: #27ae60; color: white; }
.apply-btn:disabled { background-color: gray; cursor: not-allowed; }
.bookmark-btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; background-color: #f39c12; color: white; }
.bookmark-btn:disabled { background-color: gray; cursor: not-allowed; }
a { text-decoration: none; color: #fff; background: #2980b9; padding: 10px 15px; border-radius: 5px; margin-left: 10px; }
a:hover { background: #1f618d; }
.message { text-align: center; color: blue; margin-top: 15px; }
h2 { margin-top: 30px; color: #34495e; }
p, ul { margin: 5px 0; }
</style>
</head>
<body>

<div class="header">
    <div class="job-name"><?= htmlspecialchars($job_name) ?></div>
    <div>
        <!-- Apply Button -->
        <?php if (!$already_applied): ?>
           <form method="POST" action="../Controller/save_apply.php" style="display:inline;">
              <input type="hidden" name="job_name" value="<?= htmlspecialchars($job_name) ?>">
              <input type="hidden" name="redirect_to" value="<?= basename($_SERVER['PHP_SELF']) ?>">
              <button type="submit" class="apply-btn">Apply</button>
           </form>
        <?php else: ?>
            <button class="apply-btn" disabled>Already Applied</button>
        <?php endif; ?>

        <!-- Bookmark Button -->
        <?php if (!$already_bookmarked): ?>
            <form method="POST" action="../Controller/bookmarkController.php" style="display:inline;">
                <input type="hidden" name="action" value="add_bookmark">
                <input type="hidden" name="job_name" value="<?= htmlspecialchars($job_name) ?>">
                <input type="hidden" name="redirect_to" value="<?= basename($_SERVER['PHP_SELF']) ?>">
                <button type="submit" class="bookmark-btn">Bookmark</button>
            </form>
        <?php else: ?>
            <button class="bookmark-btn" disabled>Bookmarked</button>
        <?php endif; ?>

        <a href="../Controller/applyHistoryController.php">Apply History</a>
        <a href="../Controller/bookmarkController.php?action=show_history">Bookmark History</a>
        <a href="home.php">Home</a>
    </div>
</div>

<!-- Show message -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?= htmlspecialchars($_SESSION['message']) ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!-- Job Details -->
<h2>Summary:</h2>
<p>Age: 25 to 40 years</p>
<p>Experience: At least 3 years in IT or business systems</p>
<p>Salary: Negotiable</p>

<h2>Minimum Qualifications:</h2>
<ul>
    <li>Bachelor's degree in Computer Science, Information Systems, or related field.</li>
    <li>Experience analyzing and improving IT systems.</li>
    <li>Knowledge of databases, networks, and software lifecycle management.</li>
    <li>Strong problem-solving and analytical skills.</li>
</ul>

<h2>Preferred Qualifications:</h2>
<ul>
    <li>Master's degree in IT, Business Analytics, or related field.</li>
    <li>Experience with project management and business process modeling.</li>
    <li>Knowledge of software development methodologies and tools.</li>
</ul>

<h2>About the Job:</h2>
<p>The System Analyst will evaluate, analyze, and improve IT systems within the organization. 
You will work closely with stakeholders and development teams to ensure systems meet business 
requirements. Responsibilities include documenting processes, gathering requirements, recommending 
solutions, and supporting system implementation.</p>

<h2>Responsibilities:</h2>
<ul>
    <li>Analyze existing IT systems and recommend improvements.</li>
    <li>Gather and document business requirements.</li>
    <li>Work with developers to design solutions that meet organizational needs.</li>
    <li>Perform system testing and validation.</li>
    <li>Provide ongoing support and troubleshooting for systems.</li>
</ul>

</body>
</html>