<?php
session_start();
require_once('../Model/applyHistoryModel.php');

$job_name = "Software Engineer";

$already_applied = hasApplied($job_name);

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
<title><?= $job_name ?></title>
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
ul { padding-left: 20px; }
</style>
</head>
<body>

<div class="header">
    <div class="job-name"><?= $job_name ?></div>
    <div>
      
        <?php if (!$already_applied): ?>
          <form method="POST" action="../Controller/save_apply.php" style="display:inline;">
            <input type="hidden" name="job_name" value="<?= htmlspecialchars($job_name) ?>">
            <input type="hidden" name="redirect_to" value="<?= basename($_SERVER['PHP_SELF']) ?>">
            <button type="submit" class="apply-btn">Apply</button>
          </form>
        <?php else: ?>
            <button class="apply-btn" disabled>Already Applied</button>
        <?php endif; ?>

        
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

        <a href="../View/applyHistory.php">Apply History</a>
        <a href="../Controller/bookmarkController.php?action=show_history">Bookmark History</a>
        <a href="../View/home.php">Home</a>
    </div>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?= htmlspecialchars($_SESSION['message']) ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<h2>Summary</h2>
<p>Age: 30 to 42 years</p>
<p>Experience: At least 5 years</p>
<p>Salary: Negotiable</p>
<p>Location: Remote / Hybrid</p>

<h2>Minimum Qualifications</h2>
<ul>
    <li>Bachelor's degree in Computer Science or equivalent practical experience.</li>
    <li>2+ years of experience with software development in C++ or Java.</li>
    <li>Experience with data structures and algorithms.</li>
    <li>Knowledge of SQL and relational databases.</li>
</ul>

<h2>Preferred Qualifications</h2>
<ul>
    <li>Master's degree or PhD in Computer Science or related field.</li>
    <li>Experience with cloud platforms (AWS, GCP, or Azure).</li>
    <li>Familiarity with machine learning and AI technologies.</li>
    <li>Strong problem-solving and debugging skills.</li>
</ul>

<h2>About the Job</h2>
<p>
    As a Software Engineer, you will be part of a collaborative team building scalable
    and efficient solutions that impact millions of users worldwide. You'll be working
    with modern technologies, contributing to system design, and ensuring high-quality
    product delivery.
</p>

<h2>Responsibilities</h2>
<ul>
    <li>Design, develop, test, and deploy software solutions.</li>
    <li>Participate in design and code reviews.</li>
    <li>Collaborate with cross-functional teams on technical decisions.</li>
    <li>Maintain and improve existing systems and features.</li>
    <li>Contribute to documentation and provide mentorship to junior engineers.</li>
</ul>

</body>
</html>