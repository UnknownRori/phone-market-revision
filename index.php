<?php
    session_start();
    require_once 'php\connect.php';
    // error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="resource/js/bootstrap.min.js"></script>
    <script src="resource/js/main.js"></script>
    <link rel="stylesheet" href="resource/css/main.css">
    <link rel="stylesheet" href="resource/css/bootstrap.min.css">
    <title>Home</title>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
        <a class="navbar-brand">
            <img src="resource\image\Apple.png" class="navbar-brand-image" alt="Brand"> Store
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-betwen" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">Home</a>
                </li>
                <li class="nav-item">
                    <a href="product.php" class="nav-link">Product</a>
                </li>
                <li class="nav-item">
                    <a href="product.php" class="nav-link">Contact us</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#preview" class="nav-link">Preview</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if($_SESSION['username'] == null){
                    echo '<a href=".\php\login.php" class="btn btn-info">Log in</a>';
                }else{
                    echo '<a class="navbar-brand" href="#">' . $_SESSION['username'] . '</a>';
                    echo '<a href=".\php\logout.php" class="btn btn-danger">Log out</a>';
                }?>
            </ul>
        </div>
    </nav>
    
</body>
</html>