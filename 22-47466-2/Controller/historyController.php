<?php

    session_start();
    require_once('../Model/searchHistoryModel.php');

     $history = getSearchHistory($_SESSION['user_id'] ?? 1);

     $_SESSION["history"] = $history;
     header('Location: ../View/searchHistory.php');

?>