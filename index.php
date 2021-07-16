<?php
    require_once 'php\connect.php';
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="resource/js/jquery-3.5.1.js"></script>
    <script src="resource/js/main.js"></script>
    <script src="resource/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="resource/css/style.css">
    <link rel="stylesheet" href="resource/css/bootstrap.min.css">
    <link rel="icon" href="resource/image/favicon.jpg">
    <title>Home</title>
</head>
<body>
    <div class="error-msg">
        <span id="error-msg" class="color-danger"></span>
    </div>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top  hidnavbar">
        <a class="navbar-brand" href="../phone-market-revision">
            <img src="resource\image\Apple.png" class="navbar-brand-image" alt="Brand"> Store
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="../phone-market-revision" class="nav-link active">Home</a>
                </li>
                <li class="nav-item">
                    <a href="productlist.php" class="nav-link">Product</a>
                </li>
                <li class="nav-item">
                    <a href="contactus.php" class="nav-link">Contact us</a>
                </li>
                <?php
                if($_SESSION['username'] !== null){
                    echo '
                    <li class="nav-item">
                        <a href="/php/dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    ';
                }
                ?>
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
                    echo '
                    <div>
                        <a class="navbar-brand" href="' . $_SESSION['username'] . '">' . $_SESSION['username'] . '
                            <img src="' . $_SESSION['username'] . '" alt="">
                        </a>
                    </div>
                    ';
                    echo '<a href=".\php\logout.php" class="btn btn-danger">Log out</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div class="intro">
        <div class="container">
            <div class="text-center">
                <img src="resource\image\Apple.png" alt="Apple" style="width: 200px;">
            </div>
            <h3 id="intro" class="text-center"></h3>
        </div>
    </div>
    <div class="container color-custom-1">
        <section id="about" class="about">
            <div class="container">
            <div class="row d-flex flex-row-reverse">
                <div class="col-6 img-hover">
                    <img src="resource\image\teaser\nophone.png" alt="NoPhone" class="img-fluid">
                </div>
                <div class="col-6 text-left">
                <h1>Elegant Design</h1>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia
                                explicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque
                                impedit natus culpa!</p>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia
                explicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque
                impedit natus culpa!</p>
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-6 img-hover">
                    <img src="resource\image\teaser\nophone2.png" alt="No Phone" class='img img-fluid'>
                </div>
                <div class="col-6">
                <h1>Fit on your hand</h1>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia
                                explicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque
                                impedit natus culpa!</p>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam doloremque numquam autem enim quia
                explicabo, quisquam illo eius illum laborum minus maiores! Corrupti non ullam aspernatur neque
                impedit natus culpa!</p>
                </div>
            </div>
            </div>
        </section>
        <section id="preview">
        
        </section>
    </div>
    <div class="footer fixed-bottom img-small-opacity hid260">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="resource/image/contactus/github.png" alt="github">
        </a>
    </div>
    <div class="footer bg-light">
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
    <script>
        printLetterByLetter("intro", "A Fake Apple Store", 100);
    </script>
</body>
</html>