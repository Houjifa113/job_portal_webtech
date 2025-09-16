<?php
  require_once('../model/userModel.php');
  function getProfile($id) {
        return getUserById($id);
  }