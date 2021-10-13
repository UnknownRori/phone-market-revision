<?php
    require_once 'connect.php';
    $preparedata = $conn->prepare("
    SELECT product.*
    FROM product
    WHERE prod_id=?
    ");
    $preparedata->bind_param("i", $id);
    $id = $_GET['id'];
    $preparedata->execute();
    $data = $preparedata->get_result();
    $result = $data->fetch_assoc();
    $preparedata->close();
    $preparesecdata = $conn->prepare("
    SELECT feature.* FROM feature where product_id=? LIMIT 10
    ");
    $preparesecdata->bind_param("i", $id);
    $preparesecdata->execute();
    $data = $preparesecdata->get_result();
    $data2 = $data->fetch_assoc();
    $preparesecdata->close();
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <?php echo PageTitle("Product - " . $result['product_name']); ?>
</head>
<body id="home">
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
                    <a href="/../phone-market-revision" class="nav-link">Home</a>
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
                    if(($_SESSION['vendor'])){
                    echo '
                    <li class="nav-item">
                        <a href="manageproduct.php" class="nav-link">Manage Product</a>
                    </li>
                    ';
                    }
                }
                ?>
                <li class="nav-item">
                    <!-- search engine input -->
                    <form class="form-inline" action="" method="get">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="Search Product" class="form-control spacing">
                            <a href="#" class="btn btn-info spacing">Advanced Search</a> <!--temporary href=/php/advancedproduct.php-->
                        </div>
                    </form>
                </li>
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
        <div class="text-center">
            <?php
                if($result['photo_name']){
                    echo '
                    <a href="product.php?id=' . htmlspecialchars($result['prod_id']) .'">
                        <img src="../resource/image/product/' . htmlspecialchars($result['photo_name']) .'" alt="ERROR" class="img img-fluid">
                    </a>
                    ';
                }else{
                    echo '
                    <a href="product.php?id=' . htmlspecialchars($result['prod_id']) .'">
                        <img src="../resource/image/404imgnotfound.png" alt="ERROR" class="img img-fluid">
                    </a>
                    ';
                }
            ?>
            <h4>
                <?php echo htmlspecialchars($result['product_name']) ?>
            </h4>
        </div>
        <div style="margin-bottom: 20px">
            <h3>Feature List</h3>
            <?php
            foreach($data as $row):
                if(isset($_SESSION['login'])){
                    if($_SESSION['admin'] == 1 || $_SESSION['superadmin'] == 1 || $_SESSION['users_id'] == $result['user_id']){
                        echo '
                        <ul>
                            <li>
                                ' . htmlspecialchars($row['feature_name']) . ' | 
                                <a class="text-warning">Edit</a> | 
                                <a class="text-danger">Delete</a>
                            </li>
                        </ul>
                        ';
                    }else{
                        echo '
                        <ul>
                            <li>
                                ' . htmlspecialchars($row['feature_name']) . '
                            </li>
                        </ul>
                        ';
                    }
                }else{
                    echo '
                        <ul>
                            <li>
                                ' . htmlspecialchars($row['feature_name']) . '
                            </li>
                        </ul>
                    ';
                }
            endforeach;
            if($data2['feature_name'] == NULL){
                if(isset($_SESSION['login'])){
                    if($_SESSION['admin'] == 1 || $_SESSION['super_admin'] == 1 || $_SESSION['users_id'] == $result['user_id']){
                        echo '
                            This product doesnt have any feature yet
                            <button class="btn btn-primary" id="addfeature">Add Feature</button>
                        ';
                    }else{
                    echo '
                    <p>This product doesnt have any feature yet</p>
                    ';
                    }
                }else{
                echo '
                <p>This product doesnt have any feature yet</p>
                ';
                }
            }
            ?>
        </div>
        <div style="margin-top: 20px!important; margin-bottom: 50px!important;">
            <p>
                <h4>Product Description</h4>
                <?php echo htmlspecialchars($result['description']); ?>
            </p>
            <p>Keyword : <?php echo $result['keyword'] ?></p>
        </div>
        <?php
        if(isset($_SESSION['login'])){
            echo '
            <div>
            <h5>Buy Form</h5>
                <form action="" method="POST">
                    <input type="number" value="' . htmlspecialchars($result['prod_id']) . '" hidden>
                    <div class="form-group">
                        <input id="buyquantity" type="number" placeholder="How many product do you wish to buy" title="How many product do you wish to buy" name="buy_quantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <input id="confirmbuy" type="submit" value="Buy" name="buy" class="btn btn-primary spacing" disabled>
                    </div>
                </form>
            </div>
        </div>
            ';
        }
        ?>
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
    error_msg();
    getcurrentpage();
    $(document).ready(function(){
        $('#buyquantity').keyup(function() {
            if($(this).val() > 0) {
                $('#confirmbuy').prop('disabled', false);
            }else{
                $('#confirmbuy').prop('disabled', true);
            }
        });
        $('#addfeature').click(function(){
            sessionStorage.setItem("msg", "Warning this action irreversible!");
            sessionStorage.setItem("msg_type", "warning");
            error_msg();
        });
    });
</script>
</html>