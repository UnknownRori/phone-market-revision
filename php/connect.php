<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "phone-market-revision");
    if($conn->connect_error){
        die("Connection Failed : " . $conn->connect_error);
    }
    function PageTitle($title){
        echo '
            <title>' . htmlspecialchars($title) . '&nbsp' . '| Phone Market Revision</title>
        ';
    }
    function MsgReport($msgcontent, $msgtype, $location){      
        if($location === ""){
            echo '
            <script>
                sessionStorage.setItem("msg", "' . htmlspecialchars($msgcontent) . '");
                sessionStorage.setItem("msg_type", "' . htmlspecialchars($msgtype) .'");
                window.location = sessionStorage.getItem("last_url");
            </script>';
            die;
        }else if($location === "msgonly"){
            echo '
            <script>
                sessionStorage.setItem("msg", "' . htmlspecialchars($msgcontent) . '");
                sessionStorage.setItem("msg_type", "' . htmlspecialchars($msgtype) .'");
            </script>';
        }else{
            echo '
             <script>
                 sessionStorage.setItem("msg", "' . ($msgcontent) . '");
                 sessionStorage.setItem("msg_type", "' . htmlspecialchars($msgtype) .'");
                 window.location = "' . $location . '";
             </script>';
             die;
        }
    }
?>