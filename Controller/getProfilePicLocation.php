<?php
require_once('../model/profilePicModel.php');
function getProfilePicLocation($id) {
    return "../upload/".getProfilePic($id);
}
