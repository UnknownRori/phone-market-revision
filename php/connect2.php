<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "phone-market-revision");
    if($conn->connect_error){
        die("Connection Failed : " . $conn->connect_error);
    }
    // make multithreading msgreport
    function MsgReportV2(){
        $_SESSION['msgreport'] = $your_array;
    }

    function MsgReport($msgcontent, $msgtype, $location){      
        if($location === ""){
            echo '
            <script>
                var total = sessionStorage.getItem("msg_total") + 1;
                sessionStorage.setItem("msg_total", "total");
                sessionStorage.setItem("msg", "' . $msgcontent . '");
                sessionStorage.setItem("msg_type", "' . $msgtype .'");
                window.location = sessionStorage.getItem("last_url");
            </script>';
        }else if($location === "msgonly"){
            echo '
            <script>
                var total = sessionStorage.getItem("msg_total") + 1;
                sessionStorage.setItem("msg_total", "total");
                sessionStorage.setItem("msg", "' . $msgcontent . '");
                sessionStorage.setItem("msg_type", "' . $msgtype .'");
            </script>';
        }else{
            echo '
             <script>
                var total = sessionStorage.getItem("msg_total") + 1;
                sessionStorage.setItem("msg_total", "total");
                sessionStorage.setItem("msg", "' . $msgcontent . '");
                sessionStorage.setItem("msg_type", "' . $msgtype .'");
                window.location = "' . $location . '";
             </script>';
        }
    }
    // i am not sure if this is worth it or not so i will drop this code here
    // function Footer($copyright){
    //     echo '
    //     <div class="footer bg-light fixed-bottom" style="background-color: #f8f9fa80 !important">
    //         <div class="container">
    //             <div class="text-center">
    //                 <p class="">
    //                 <script>
    //                     var n = new Date();
    //                     document.write(n.getFullYear());
    //                 </script>
    //                 &copy;<b>' . $copyright .'</b>
    //                 </p>
    //             </div>
    //         </div>
    //     </div>
    //     ';
    // }
?>