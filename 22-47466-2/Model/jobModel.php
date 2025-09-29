<?php
    require_once('dbConnection.php');

    function getJobs() {
        $con = getConnection();
        $sql = "SELECT * FROM joblist";
        $result = mysqli_query($con, $sql);

        $jobs = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jobs[] = $row;
            }
        }

     
        return $jobs;
    }


?>