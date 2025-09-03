<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = 1;

        $src = $_FILES['resumeFile']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['resumeFile']['name'], PATHINFO_EXTENSION));
        $name = $id . "." . $ext;
        $des = '../upload/' . $name;
        if (!in_array($ext, ['pdf', 'doc', 'docx'])) {
            header('location: ../view/uploadResume.php?msg=invalid_type');
            exit();
        }
        if ($_FILES['resumeFile']['size'] > 5 * 1024 * 1024) {
            header('location: ../view/uploadResume.php?msg=size_exceeded');
            exit();
        }
        if (move_uploaded_file($src, $des)) {
            header('location: ../view/uploadResume.php?msg=success');
            exit();
        } else {
            echo "Error";
        }
    }