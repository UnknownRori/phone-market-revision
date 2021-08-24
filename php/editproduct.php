<?php
    require_once 'connect.php';
    if($_SESSION['vendor'] == 1 || $_SESSION['admin'] == 1){

        $getdata = $conn->prepare("SELECT * FROM product WHERE product_name=?");
        $getdata->bind_param("s", $product_name);
        $product_name = $_GET['product_name'];
        $getdata->execute();
        $data = $getdata->get_result();
        $result = $data->fetch_assoc();
        $getdata->close();
    }else{
        echo '
            <script>
            sessionStorage.setItem("msg", "Make sure you already issue warning to owner product!");
            sessionStorage.setItem("msg_type", "warning");
            </script>
            ';
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <title>
        Editing Product <?php echo $result['product_name']; ?>
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
                    <a href="../phone-market-revision" class="nav-link">Home</a>
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
        <div class="row col-6">
                <h3 class="text-center">Login</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="username_1" class="form-control" placeholder="Enter Username" value="<?php if(isset($_SESSION['preload-login-username'])){echo $_SESSION['preload-login-username'];} ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_1" class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="form-group float-left">
                        <input type="submit" class="btn btn-primary" value="Log in" name="login">
                    </div>
                </form>
        </div>
    </div>
</body>
</html>