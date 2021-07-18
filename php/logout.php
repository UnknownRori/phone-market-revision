<?php
    session_start();
    if(isset($_SESSION['login'])){
      session_destroy();
      echo '<script>window.location="../../phone-market-revision"</script>';
    }else{
      echo '<script>
      sessionStorage.setItem("msg_type", "error");
      sessionStorage.setItem("msg", "Bad User!");
      window.location="../../phone-market-revision"</script>';
    }
?>