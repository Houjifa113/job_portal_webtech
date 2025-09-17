<?php
require_once('dbConnection.php');

function saveSearch($user_id, $search_term, $status) {
    $con = getConnection();

    $sql = "INSERT INTO search_history (user_id, search_term, status, search_time) 
            VALUES ('$user_id', '$search_term', '$status', NOW())";

    mysqli_query($con, $sql);
}

function getSearchHistory($user_id) {
    $con = getConnection();

    $sql = "SELECT * FROM search_history 
            WHERE user_id = '$user_id' 
            ORDER BY search_time DESC";

    $result = mysqli_query($con, $sql);

    $history = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $history[] = $row;
        }
    }

    return $history;
}
?>
