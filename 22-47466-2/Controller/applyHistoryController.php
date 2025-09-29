<?php
session_start();
require_once('../Model/applyHistoryModel.php');


$history = getApplyHistory();


$_SESSION['apply_history'] = $history;


header("Location: ../View/applyHistory.php");
exit();
?>
