<?php
    require_once 'connect.php';
    if(isset($_SESSION['login'])){
      session_destroy();
      MsgReport("Log out successfully!", "success", "");
    }else{
      MsgReport("Bad User", "error", "");
    }
?>