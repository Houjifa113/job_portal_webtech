<?php
require_once('dbConnection.php');

function saveApply($jobname) {
    $con = getConnection();

    
    $sql_check = "SELECT jobname FROM apply_history WHERE jobname = '$jobname' LIMIT 1";
    $result = mysqli_query($con, $sql_check);

    if ($result && mysqli_num_rows($result) > 0) {
        return false; 
    }

    
    $sql = "INSERT INTO apply_history (jobname, apply_date) 
            VALUES ('$jobname', NOW())";
    mysqli_query($con, $sql);

    return true;
}

function getApplyHistory() {
    $con = getConnection();


    $sql = "SELECT jobname, apply_date FROM apply_history ORDER BY apply_date DESC";
    $result = mysqli_query($con, $sql);

    $history = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $history[] = $row;
        }
    }

    return $history;
}

function hasApplied($jobname) {
    $con = getConnection();

    $sql = "SELECT jobname FROM apply_history WHERE jobname = '$jobname' LIMIT 1";
    $result = mysqli_query($con, $sql);

    return ($result && mysqli_num_rows($result) > 0);
}
?>
