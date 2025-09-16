<?php
    function getConnection() {
        static $con = null;
        if ($con === null) {
            $con = mysqli_connect('127.0.0.1', 'root', '', 'job_portal');
        }
        return $con;
    }
?>