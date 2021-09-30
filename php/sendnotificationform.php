<?php
    include_once "connect.php";
    if($_SESSION['admin'] !== 1){
        MsgReport("You do not have privilege over this product!", "error", "");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../resource/js/jquery-3.5.1.js"></script>
        <script src="../resource/js/main.js"></script>
        <script src="../resource/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../resource/css/style.css">
        <link rel="stylesheet" href="../resource/css/style-profile.css">
        <link rel="stylesheet" href="../resource/css/style-editproduct.css">
        <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
        <link rel="icon" href="../resource/image/favicon.jpg">
        <title>
            
        </title>
    </head>
    <body>
        <div class="msg fixed-top text-center">
            <span id="msg"></span>
        </div>
        <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
            <a class="navbar-brand" href="#home">
            <img src="..\resource\image\Apple.png" class="navbar-brand-image" alt="Brand"> Store
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="../../phone-market-revision" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="../product.php" class="nav-link">Product</a>
                    </li>
                    <li class="nav-item">
                        <a href="../contactus.php" class="nav-link">Contact us</a>
                    </li>
                    <?php
                        if(isset($_SESSION['login'])){
                            if($_SESSION['admin'] == 1){
                                echo '
                                <li class="nav-item">
                                    <a href="php/manageuser.php" class="nav-link">Manage Users</a>
                                </li>
                                ';
                            }
                        }
                        if(isset($_SESSION['vendor'])){
                            echo '
                            <li class="nav-item">
                                <a href="manageproduct.php" class="nav-link">Manage Product</a>
                            </li>
                            ';
                        }
                        ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['username'])){
                        echo '
                        <div>
                            <a href="notificationlist.php" id="notification">
                                <span class="glyphicon">&#x2709;</span>
                            </a>
                            <a class="navbar-brand" href="user.php?username=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '
                                <img class="profile" src="../resource/image/profile/' . $_SESSION['username'] . '.jpg" alt="">
                            </a>
                        </div>
                        ';
                        echo '<a href="logout.php" class="btn btn-danger">Log out</a>';
                        }?>
                </ul>
            </div>
        </nav>
        <div class="container extend">
            <div class="">
                <h3 class="text-center">

                </h3>
                <form method="POST" action="" enctype="multipart/form-data">

                </form>
            </div>
        </div>
    </body>
    <script>
        error_msg(2);
    </script>
</html>