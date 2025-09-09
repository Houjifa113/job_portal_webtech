<?php
session_start();
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Jobs</title>
  <link rel="stylesheet" href="../css/search.css">
</head>
<body>
  <h2>Job Search</h2>

  <form action="../controller/save_search.php" method="POST">
    <input type="text" name="job_title" placeholder="Enter job name..." required>
    <select name="status" required>
      <option value="">-- Select preference --</option>
      <option value="Remote">Remote</option>
      <option value="Onsite">Onsite</option>
      <option value="Hybrid">Hybrid</option>
    </select>
    <input type="submit" value="Search">
  </form>

  <br>
  <a href="search_history.php">View Search History</a>
</body>
</html>
