<?php
    require_once('db.php');
    function updateResume($id, $resumeName){
        $con=getConnection();
        $sql = "SELECT id,location FROM resume WHERE id={$id}";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            $oldResumeName = $row['location'];
            if(file_exists('../upload/'.$oldResumeName)){
                unlink('../upload/'.$oldResumeName);
            }
            $sql = "UPDATE resume SET location='{$resumeName}' WHERE id={$id}";
            if(mysqli_query($con, $sql)){
                return true;
            }else{
                return false;
            }
        }
        else{
            $sql = "INSERT INTO resume (id, location) VALUES ({$id}, '{$resumeName}')";
            if(mysqli_query($con, $sql)){
                return true;
            }else{
                return false;
            }
        }
    }
    function getResume($id){
        $con=getConnection();
        $sql = "SELECT location FROM resume WHERE id={$id}";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            return $row['location'];
        }
        return null;
    }