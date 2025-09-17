<?php
session_start();
require_once('../Model/jobModel.php');


if (isset($_POST["submit"])) {
   
    $_SESSION["jobs"] = getJobs();

    
    header('Location: ../View/job.php');
    exit();
} else {
   
    header('Location: ../View/home.php');
    exit();
}
?>
