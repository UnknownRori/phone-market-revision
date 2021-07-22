<?php
    session_start();
    if(isset($_SESSION['login'])){
      session_destroy();
      echo '<script>
      sessionStorage.setItem("msg_type", "success");
      sessionStorage.setItem("msg", "Log out successfully!");
      window.location = sessionStorage.getItem("last_url");
      </script>';
    }else{
      echo '<script>
      sessionStorage.setItem("msg_type", "error");
      sessionStorage.setItem("msg", "Bad User!");
      window.location = sessionStorage.getItem("last_url");
      // window.location="../../phone-market-revision";
      </script>';
    }
?>