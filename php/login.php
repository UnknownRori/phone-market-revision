<?php
    require_once 'connect.php';


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
    <title>Login</title>
</head>
<body>
    <div class="error-msg">
        <span id="error-msg" class="color-danger"></span>
    </div>
    <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top">
        <a class="navbar-brand" href="../phone-market-revision">
            <img src="..\resource\image\Apple.png" class="navbar-brand-image" alt="Brand"> Store
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-betwen" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="../../phone-market-revision" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="..\product.php" class="nav-link">Product</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="createusers.php" class="btn btn-info">Create Account</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top: 10%;">
        <div class="row">
            <div class="col-9" style="border: 2px outset black; border-radius: 5px; margin-left: 13%;">
                <h3 class="text-center">Login</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="username_1" class="form-control" placeholder="Enter Username">
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
    <div class="footer fixed-bottom img-small-opacity">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="../resource/image/contactus/github.png" alt="github">
        </a>
    </div>
</body>
</html>