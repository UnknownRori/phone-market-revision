<?php
    require_once 'connect.php';
    if(isset($_SESSION['vendor'])){

    }else{
        echo '<script>
            sessionStorage.setItem("msg", "User must log in first!");
            sessionStorage.setItem("msg_type", "warning");
            window.location = "login.php";
        </script>';
    }
?>