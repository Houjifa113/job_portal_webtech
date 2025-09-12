<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password0 = $_REQUEST['password0'];
    $password1 = $_REQUEST['password1'];
    $password2 = $_REQUEST['password2'];

    if ($password0 === '' || $password1 === '' || $password2 === '') {
        $msg = 'All fields are required.';
    } elseif ($password0 !== '7892') {
        $msg = 'Old password is incorrect.';
    } elseif ($password1 !== $password2) {
        $msg = 'New passwords do not match.';
    } else {
        //db ops
        $msg = 'okay';
    }
}
header('location: ../view/updatePassword.php?msg=' . $msg);