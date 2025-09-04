<?php
session_start();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply History</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { color: #333; }
    ul { list-style-type: disc; }
    li { margin-bottom: 5px; }
  </style>
</head>
<body>
  <h2>Applied Jobs History</h2>

  <?php if (!empty($_SESSION['applied_jobs'])): ?>
    <ul>
      <?php foreach ($_SESSION['applied_jobs'] as $job): ?>
        <li><?php echo ucfirst(str_replace('_', ' ', $job)); ?></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>You have not applied to any jobs yet.</p>
  <?php endif; ?>

  <a href="job.php">Back to Job Search</a>
</body>
</html>
