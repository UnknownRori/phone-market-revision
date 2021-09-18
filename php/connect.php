<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "phone-market-revision");
    if($conn->connect_error){
        die("Connection Failed : " . $conn->connect_error);
    }
    function MsgReport($msgcontent, $msgtype, $location){      
        if($location === ""){
            echo '
            <script>
                sessionStorage.setItem("msg", "' . $msgcontent . '");
                sessionStorage.setItem("msg_type", "' . $msgtype .'");
                window.location = sessionStorage.getItem("last_url");
            </script>';
        }else if($location === "msgonly"){
            echo '
            <script>
                sessionStorage.setItem("msg", "' . $msgcontent . '");
                sessionStorage.setItem("msg_type", "' . $msgtype .'");
            </script>';
        }else{
            echo '
             <script>
                 sessionStorage.setItem("msg", "' . $msgcontent . '");
                 sessionStorage.setItem("msg_type", "' . $msgtype .'");
                 window.location = "' . $location . '";
             </script>';
        }
    }
?>