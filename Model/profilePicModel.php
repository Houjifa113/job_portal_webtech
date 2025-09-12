<?php
    require_once('db.php');
    function updateProfilePic($id, $picName){
        $con=getConnection();
        $sql = "SELECT id,location FROM profilePic WHERE id={$id}";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            $oldPicName = $row['location'];
            if(file_exists('../upload/'.$oldPicName)){
                unlink('../upload/'.$oldPicName);
            }
            $sql = "UPDATE profilePic SET location='{$picName}' WHERE id={$id}";
            if(mysqli_query($con, $sql)){
                return true;
            }else{
                return false;
            }
        }
        else{
            $sql = "INSERT INTO profilePic (id, location) VALUES ({$id}, '{$picName}')";
            if(mysqli_query($con, $sql)){
                return true;
            }else{
                return false;
            }
        }
    }
    function getProfilePic($id){
        $con=getConnection();
        $sql = "SELECT location FROM profilePic WHERE id={$id}";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            return $row['location'];
        }
        else{
        return null;
        }
    }