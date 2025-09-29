<?php
session_start();


$jobs = isset($_SESSION["jobs"]) ? $_SESSION["jobs"] : [];


$lastSearch = $_SESSION['last_search'] ?? [
    'search' => '',
    'preference' => ''
];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Search page</title>
 
  <link rel="stylesheet" href="../Asset/search.css">
</head>
<body>

<?php

if (isset($_GET['error']) && $_GET['error'] === 'invalid_input') {
    echo "<p style='color:red; text-align:center;'>Please enter a job name and select preference.</p>";
}
?>

<form id="jobForm" method="POST" action="../Controller/searchbarValidation.php">
    <table>
      <tr>
        <td>
          <div class="search-container">
            
            <input type="search" name="search" id="search" placeholder="Enter job name..." 
                   value="<?= $lastSearch['search'] ?>">

          
            <select name="preference" id="preference">
              <option value="">-- Select preference --</option>
              <option value="remote" <?= ($lastSearch['preference'] === 'remote') ? 'selected' : '' ?>>Remote</option>
              <option value="onsite" <?= ($lastSearch['preference'] === 'onsite') ? 'selected' : '' ?>>Onsite</option>
              <option value="hybrid" <?= ($lastSearch['preference'] === 'hybrid') ? 'selected' : '' ?>>Hybrid</option>
            </select>
          </div>
          <br>

          <span id="search_bar_error" class="sError_msg"></span>
          <span id="preference_error" class="pError_msg"></span>
          <br>

          <input type="submit" value="Search">
        </td>
      </tr>

      <tr>
        <td>
          <div id="job_list">
            <?php if (!empty($jobs)) : ?>
              <?php foreach ($jobs as $job) : ?>
                <div class="job-item">
                  <a href="<?= $job['link'] ?>"><?= $job['title'] ?></a>
                  <p class="job-highlight"><?= $job['highlight'] ?></p>
                  <p class="job-location">Location: <?= $job['location'] ?></p>
                  <p class="job-status">Status: <?= $job['status'] ?></p>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <p>No jobs available.</p>
            <?php endif; ?>
          </div>
          <div id="pagination"></div>
        </td>
      </tr>
    </table>

    <script>
      const jobs = <?= json_encode($jobs) ?>;
    </script>
   
    <script src="../Asset/search_bar.js"></script>
</form>
</body>
</html>
