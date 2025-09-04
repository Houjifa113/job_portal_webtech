<?php
session_start();

$jobs = isset($_SESSION["jobs"]) ? $_SESSION["jobs"] : [];
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search page</title>
  <link rel="stylesheet" href="../css/search.css">
</head>
<body>
  <form id="jobForm">
    <table>
      <tr>
        <td>
          <div class="search-container">
            <input type="search" name="search" id="search" placeholder="Enter job name...">
            <select name="preference" id="preference">
              <option value="">-- Select preference --</option>
              <option value="remote" id="remote">Remote</option>
              <option value="onsite" id="onsite">Onsite</option>
              <option value="hybrid" id="hybrid">Hybrid</option>
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
    <script src="../js/search_bar.js"></script>
  </form>
</body>
</html>
