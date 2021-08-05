<?php
    require_once 'connect.php';
    if(isset($_SESSION['vendor']) == 0){
        echo '<script>
            sessionStorage.setItem("msg", "User must log in first!");
            sessionStorage.setItem("msg_type", "warning");
            window.location = "login.php";
        </script>';
    } 
    if(isset($_POST['Product_Name'])){
        if($_POST['Product_Name'] != null){
            echo '<script>
            sessionStorage.setItem("msg", "Sapi kuda terbang ke angkasa!");
            sessionStorage.setItem("msg_type", "success");
            </script>';
        }else{
            echo '<script>
            sessionStorage.setItem("msg", "Please enter your product name correctly!");
            sessionStorage.setItem("msg_type", "warning");
            window.location = "manageproduct.php";
            </script>';
        }
    }
    $preparedata = $conn->prepare("SELECT * FROM product WHERE user_id=?");
    $preparedata->bind_param("i", $user_id);
    $user_id = $_SESSION['users_id'];
    $preparedata->execute();
    $data = $preparedata->get_result();
    $preparedata->close();
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <title>Manage Product</title>
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
                    <a href="../phone-market-revision" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../productlist.php" class="nav-link">Product</a>
                </li>
                <li class="nav-item">
                    <a href="../contactus.php" class="nav-link">Contact us</a>
                </li>
                <?php
                if(isset($_SESSION['admin'])){
                    echo '
                    <li class="nav-item">
                        <a href="manageuser.php" class="nav-link">Manage Users</a>
                    </li>
                    ';
                }
                if(isset($_SESSION['vendor'])){
                    echo '
                    <li class="nav-item">
                        <a href="manageproduct.php" class="nav-link active">Manage Product</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Page Action
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" id="">Product</a>
                            <a class="dropdown-item" href="#" id="">Request</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <form class="form-inline" action="" method="post">
                            <div class="form-group">
                                <input type="text" name="Product_Name" placeholder="Create Product" class="form-control">
                            </div>
                        </form>
                    </li>
                    ';
                }
                ?>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['username'])){
                    echo '
                    <div>
                        <a href="notification.php" id="notification">
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
    <div class="container" style="border: 2px solid red; margin-top:90px;">

    </div>
    <div class="footer fixed-bottom img-small-opacity floating-bottom">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="../resource/image/contactus/github.png" alt="github">
        </a>
    </div>
    <div class="footer bg-light fixed-bottom">
        <div class="container">
            <div class="text-center">
                <p class="text-muted">
                <script>
                    var n = new Date();
                    document.write(n.getFullYear());
                </script>
                &copy;<b>UnknownRori</b>
                </p>
            </div>
        </div>
    </div>
</body>
<script>
    error_msg(2);
</script>
</html>