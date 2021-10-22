<?php
    require_once 'connect.php';
    if(isset($_GET['users'])){
        $get_users = $conn->prepare("SELECT * FROM users WHERE username=?");
        $get_users->bind_param("s", $username);
        $username = $_GET['users'];
        $get_users->execute();
        $users_data = $get_users->get_result();
        $result = $users_data->fetch_assoc();
        $get_users->close();
        if($result['username']){

            if(isset($result['vendor'])){
                // next : randomize featured product
                // add show more function
                $get_featured_product = $conn->prepare("
                SELECT product.prod_id, product.product_name, product.photo_name, product.price, product.warned_status,
                SUBSTRING(product.product_name, 1, 20) AS substring_product_name,
                SUBSTRING(product.price, 1, 20) AS substring_product_price,
                users.id, users.username
                FROM product
                INNER JOIN users ON product.user_id = users.id
                WHERE product.user_id=?
                LIMIT 3
                ");
                $get_featured_product->bind_param("i", $id);
                $id = $result['id'];
                $get_featured_product->execute();
                $result_data = $get_featured_product->get_result();
                $get_featured_product->close();
            }
        }else{
            MsgReport("Cannot retrive users profile", "error", "../index.php");
        }
    }else{
        MsgReport("Cannot retrive users profile", "error", "../index.php");
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
    <link rel="stylesheet" href="../resource/css/style-product-user.css">
    <link rel="stylesheet" href="../resource/css/style-image.css">
    <link rel="stylesheet" href="../resource/css/style-profile.css">
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <?php 
        echo '
        <link rel="icon" href="../resource/image/profile/' . htmlspecialchars($result['username']) .'.jpg">
        ';
        PageTitle(htmlspecialchars($result['username']));
    ?>
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
                    <a href="../productlist.php" class="nav-link">Product</a>
                </li>
                <li class="nav-item">
                    <a href="../contactus.php" class="nav-link">Contact us</a>
                </li>
                <?php
                if(isset($_SESSION['login'])){
                    if($_SESSION['admin'] == 1){
                        echo '
                        <li class="nav-item">
                            <a href="manageuser.php" class="nav-link">Manage Users</a>
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
                        <a class="navbar-brand" href="user.php?users=' . htmlspecialchars($_SESSION['fullusername']) . '">' . htmlspecialchars($_SESSION['username']) . '
                            <img class="profile" src="../resource/image/profile/' . htmlspecialchars($_SESSION['fullusername']) . '.jpg" alt="">
                        </a>
                        <a href="logout.php" class="btn btn-danger">Log out</a>
                    </div>
                    ';
                }else{
                    echo '<a href="login.php" class="btn btn-info">Log in</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div id="extend" class="container height-100vh">
        <div class="row d-flex">
            <div class="col-6">
                <div class="image-container border-2px-solid-black">
                    <a href="../resource/image/profile/<?php echo htmlspecialchars($result['username']) ?>.jpg">
                        <img src="../resource/image/profile/<?php echo htmlspecialchars($result['username']) ?>.jpg" alt="Profile" class="img img-fluid image">
                    </a>
                </div>
            </div>
            <div class="col-6">
                <h4 class="text-center">
                    <?php echo htmlspecialchars($result['username']) ?>
                </h4>
                <div class="description-box">
                    <p>
                        <?php echo htmlspecialchars($result['bio']) ?>
                    </p>
                </div>
            </div>
            <div class="margin-top-20">
            <h3>Featured Product</h3>
            <?php foreach($result_data as $row):?>
            <div class="float-left preview-image margin-30">
                <div class="text-center" style="border: 1px solid black" title="<?php echo htmlspecialchars($row['product_name']); ?>">
                    <?php
                        if($row['photo_name']){
                            echo '
                            <a href="product.php?id=' . $row['prod_id'] .'">
                                <img src="../resource/image/product/' . htmlspecialchars($row['photo_name']) .'" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }else{
                            echo '
                            <a href="product.php?id=' . $row['prod_id'] .'">
                                <img src="../resource/image/404imgnotfound.png" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }
                    ?>
                </div>
                <div>
                    <table class="table spacing">
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
        </div>
        </div>
    </div>
    <div class="footer fixed-bottom img-small-opacity floating-bottom" style="">
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
error_msg();
getcurrentpage();
</script>
</html>