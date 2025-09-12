<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = 1;

    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $src = $_FILES['profilePicture']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png'];
        
        if (!in_array($ext, $allowedExt)) {
            header('location: ../view/changePicture.php?msg=invalid_type');
            exit();
        }

        if ($_FILES['profilePicture']['size'] > 5 * 1024 * 1024) {
            header('location: ../view/changePicture.php?msg=size_exceeded');
            exit();
        }

        $name = $id . "." . $ext;
        $des = '../upload/' . $name;

        if (move_uploaded_file($src, $des)) {
            header('location: ../view/changePicture.php?msg=success');
            exit();
        } else {
            header('location: ../view/changePicture.php?msg=error');
            exit();
        }
    } else {
        header('location: ../view/changePicture.php?msg=no_file');
        exit();
    }
}
