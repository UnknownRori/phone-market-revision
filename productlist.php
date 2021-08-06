<?php
    require_once 'php\connect.php';
    $preparedata = $conn->prepare("SELECT product.*, users.id, users.username FROM product INNER JOIN users ON product.user_id = users.id");
    $preparedata->execute();
    $data = $preparedata->get_result();
    $preparedata->close();
    if(isset($_POST['search_product'])){
        if($_POST['search_product'] != null){
            $data = NULL;
            $searchengine = $conn->prepare("SELECT product.*, users.id, users.username FROM product INNER JOIN users ON product.user_id = users.id WHERE product.product_name LIKE ?  OR users.username LIKE ? ");
            $searchengine->bind_param("ss", $searchterm, $searchterm);
            $searchterm = '%' . $_POST['search_product'] . '%';
            $searchengine->execute();
            $data = $searchengine->get_result();
            $searchengine->close();
        }else{
            echo '<script>
            sessionStorage.setItem("msg", "Cannot search empty query!");
            sessionStorage.setItem("msg_type", "error");
            </script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="resource/js/jquery-3.5.1.js"></script>
    <script src="resource/js/main.js"></script>
    <script src="resource/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="resource/css/style.css">
    <link rel="stylesheet" href="resource/css/bootstrap.min.css">
    <link rel="icon" href="resource/image/favicon.jpg">
    <title>Product List</title>
</head>
<body id="home">
    <div class="msg fixed-top text-center">
        <span id="msg"></span>
    </div>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top">
        <a class="navbar-brand" href="#home">
            <img src="resource\image\Apple.png" class="navbar-brand-image" alt="Brand"> Store
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
                    <a href="productlist.php" class="nav-link active">Product</a>
                </li>
                <li class="nav-item">
                    <a href="contactus.php" class="nav-link">Contact us</a>
                </li>
                <?php
                if(isset($_SESSION['admin'])){
                    echo '
                    <li class="nav-item">
                        <a href="php/manageuser.php" class="nav-link">Manage Users</a>
                    </li>
                    ';
                }
                if(isset($_SESSION['vendor'])){
                    echo '
                    <li class="nav-item">
                        <a href="php/manageproduct.php" class="nav-link">Manage Product</a>
                    </li>
                    ';
                }
                ?>
                <li class="nav-item">
                    <!-- search engine input -->
                    <form class="form-inline" action="" method="post">
                        <div class="form-group">
                            <input type="text" name="search_product" placeholder="Search Product" class="form-control">
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['username'])){
                    echo '
                    <div>
                        <a href="php/notification.php" id="notification">
                            <span class="glyphicon">&#x2709;</span>
                        </a>
                        <a class="navbar-brand" href="./php/user.php?users=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '
                            <img class="profile" src="resource/image/profile/' . $_SESSION['username'] . '.jpg" alt="">
                        </a>
                    </div>
                    ';
                    echo '<a href=".\php\logout.php" class="btn btn-danger">Log out</a>';
                }else{
                    echo '<a href=".\php\login.php" class="btn btn-info">Log in</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div id="extend" class="container" style="margin-top: 90px; margin-bottom: 30px;">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr class="text-center">
                        <td>#</td>
                        <td>Product name</td>
                        <td>Price</td>
                        <td>Stock</td>
                        <td>Vendor</td>
                        <td>Action</td>
                    </tr>
                    <?php $i=1; foreach($data as $row):?>
                    <tr class="text-center">
                        <td>
                            <?php echo $i;?>
                        </td>
                        <td>
                            <?php echo $row['product_name']; ?>
                        </td>
                        <td>
                            <?php echo $row['price']; ?>
                        </td>
                        <td>
                            <?php echo $row['stock']; ?>
                        </td>
                        <td>
                            <?php
                                echo $row['username'];
                            ?>
                        </td>
                        <td>
                            <?php
                                echo '<a class="btn btn-primary" href="#" style="margin-right: 4px; margin-left: 4px; margin-top: 2px; margin-bottom: 2px;" href="#.php?id=' . $row['id'] .'">Detail</a>';
                                if(isset($_SESSION['login'])){
                                    if(($_SESSION['admin'])){
                                    echo '<a class="btn btn-warning" style="margin-right: 4px; margin-left: 4px; margin-top: 2px; margin-bottom: 2px;" href="./php/#.php?id='. $row['id'] . '">Issue Warning</a>';
                                    }
                                    if(($_SESSION['users_id']) == $row['user_id'] || $_SESSION['admin']){
                                        echo '<a class="btn btn-danger" style="margin-right: 4px; margin-left: 4px; margin-top: 2px; margin-bottom: 2px;" href="./php/#.php?id=' . $row['id'] . '">Delete</a>';
                                    }else if($_SESSION['vendor']){
                                        echo '<a class="btn btn-danger disabled" style="margin-right: 4px; margin-left: 4px; margin-top: 2px; margin-bottom: 2px;" href="./php/#.php?id=' . $row['id'] . '">Delete</a>';
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                <?php $i++;endforeach;?>
            </table>
            </div>
        </div>
    </div>
    <div class="footer fixed-bottom img-small-opacity floating-bottom">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="resource/image/contactus/github.png" alt="github">
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
    getcurrentpage();
</script>
</html>