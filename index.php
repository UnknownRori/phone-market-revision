<?php
    require_once 'php\connect.php';
    // this is only reserved for preview
    $getpreview = $conn->prepare("
    SELECT product.prod_id, product.product_name, product.photo_name, product.price, product.warned_status,
    SUBSTRING(product.product_name, 1, 20) AS substring_product_name,
    SUBSTRING(product.price, 1, 20) AS substring_product_price
    FROM product
    LIMIT 3
    ");
    $getpreview->execute();
    $data = $getpreview->get_result();
    $getpreview->close();
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
    <link rel="stylesheet" href="resource/css/style-index.css">
    <link rel="stylesheet" href="resource/css/style-profile.css">
    <link rel="stylesheet" href="resource/css/style.css">
    <link rel="stylesheet" href="resource/css/bootstrap.min.css">
    <link rel="icon" href="resource/image/favicon.jpg">
    <?php PageTitle("Home"); ?>
</head>
<body id="home">
    <div class="msg fixed-top text-center">
        <span id="msg"></span>
    </div>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
        <a class="navbar-brand" id="id" href="#home">
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
                if(isset($_SESSION['login'])){
                    if($_SESSION['admin'] == 1){
                        echo '
                        <li class="nav-item">
                            <a href="php/manageuser.php" class="nav-link">Manage Users</a>
                        </li>
                        ';
                    }
                    if(($_SESSION['vendor'])){
                    echo '
                    <li class="nav-item">
                        <a href="php/manageproduct.php" class="nav-link">Manage Product</a>
                    </li>
                    ';
                    }
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
                <?php if(isset($_SESSION['username'])){
                    echo '
                    <div>
                        <a href="php/notificationlist.php" id="notification">
                            <span class="glyphicon">&#x2709;</span>
                        </a>
                        <a class="navbar-brand" href="php/user.php?users=' . htmlspecialchars($_SESSION['fullusername']) . '">' . htmlspecialchars($_SESSION['username']) . '
                            <img class="profile" src="resource/image/profile/' . htmlspecialchars($_SESSION['fullusername']) . '.jpg" alt="">
                        </a>
                        <a href=".\php\logout.php" class="btn btn-danger">Log out</a>
                    </div>
                    ';
                }else{
                    echo '<a href=".\php\login.php" class="btn btn-info">Log in</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div class="intro">
        <div class="container">
            <div class="text-center">
                <img class="width-200px" src="resource\image\Apple.png" alt="Apple">
            </div>
            <h3 id="intro" class="text-center"></h3>
            <h6 id="intro-secondary" class="text-center"></h6>
        </div>
    </div>
    <div class="container color-custom-1">
        <section id="about" class="about">
            <div class="row d-flex flex-row-reverse">
                <div class="col-6">
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
                <div class="col-6">
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
        </section>
        <section id="preview">
            <?php foreach($data as $row):?>
            <div class="float-left preview-image">
                <div class="text-center" style="border: 1px solid black" title="<?php echo htmlspecialchars($row['product_name']); ?>">
                    <?php
                        if($row['photo_name']){
                            echo '
                            <a href="php/product.php?id=' . $row['prod_id'] .'">
                                <img src="resource/image/product/' . htmlspecialchars($row['photo_name']) .'" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }else{
                            echo '
                            <a href="php/product.php?id=' . $row['prod_id'] .'">
                                <img src="resource/image/404imgnotfound.png" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }
                    ?>
                </div>
                <div>
                    <table class="table" style="margin-top: 10px;">
                        <tr>
                            <td>
                                <b>
                                    Product
                                </b>
                            </td>
                            <td>:</td>
                            <td title="<?php echo htmlspecialchars($row['product_name']); ?>">
                                <b>
                                    <?php echo htmlspecialchars($row['substring_product_name']); ?>
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Price</b>
                            </td>
                            <td>
                                :
                            </td>
                            <td title="<?php echo '$ ' . $row['price']; ?>">
                                <b style="color: red;">
                                    $ <?php echo $row['substring_product_price']; ?>
                                </b>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </div>
    <div class="footer fixed-bottom img-small-opacity hidden floating-bottom">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="resource/image/contactus/github.png" alt="github">
        </a>
    </div>
    <div class="footer fixed-bottom bg-light">
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
        error_msg();
        getcurrentpage();
    </script>
    <script src="resource/js/main-js-index.js"></script>
</body>
</html>