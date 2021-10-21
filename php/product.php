<?php
    require_once 'connect.php';
    if(isset($_GET['id'])){
        $get_product_data = $conn->prepare("
        SELECT prod_id, user_id, product_name, photo_name, price, stock, description
        FROM product
        WHERE prod_id=?
        ");
        $get_product_data->bind_param("i", $id);
        $id = $_GET['id'];
        $get_product_data->execute();
        $data = $get_product_data->get_result();
        $result = $data->fetch_assoc();
        $get_product_data->close();
        
        $get_product_data_feature = $conn->prepare("
        SELECT feature.* FROM feature where product_id=? LIMIT 10
        ");
        $get_product_data_feature->bind_param("i", $id);
        $get_product_data_feature->execute();
        $data = $get_product_data_feature->get_result();
        $result_feature = $data->fetch_assoc();
        $get_product_data_feature->close();
        if(isset($_POST['buy'])){
            if($_POST['quantity'] < 1){
                MsgReport("Cannot buy non existent quantity of product", "warning", "msgonly");
            }
        }
    }else{
        MsgReport('Error : no product can be retrived', "error", "../productlist.php");
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <?php
    if($result['product_name']){
        PageTitle($result['product_name']); 
    }else{
        PageTitle("No product selected");
    }
    ?>
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
                            <a href="../advanced-search-product.php" class="btn btn-info spacing">Advanced Search</a>
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
        <div class="row d-flex">
            <div class="col-6">
                <div class="text-center" style="border: 1px solid black; background-color:#8080803d; box-shadow: 2px 2px 2px 2px gray" title="<?php echo htmlspecialchars($result['product_name']); ?>">
                    <?php
                        if($result['photo_name']){
                            echo '
                            <a href="product.php?id=' . $result['prod_id'] .'">
                                <img src="../resource/image/product/' . htmlspecialchars($result['photo_name']) .'" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }else{
                            echo '
                            <a href="product.php?id=' . $result['prod_id'] .'">
                                <img src="../resource/image/404imgnotfound.png" alt="ERROR" class="img img-fluid">
                            </a>
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="col-6">
                <h4 class="text-center">
                    <?php echo htmlspecialchars($result['product_name']) ?>
                </h4>
                <div style="max-height: 120px; min-height: 100px; overflow:auto;">
                    <p>
                        <?php echo htmlspecialchars($result['description']) ?>
                    </p>
                </div>
                <?php
                    if(isset($_SESSION['login'])){
                        echo '
                        <div>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <div class="row d-flex">
                                        <div class="col-6">
                                            <input type="number" name="quantity" class="form-control" value="0">
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary" name="buy">Buy</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        ';
                    }
                ?>
            </div>
            <div class="container row">
                <div class="">
                    <ul>
                        <?php
                            if($result_feature){
                                foreach ($result_feature as $result_feature):
                                echo '<li>' . $result_feature .'</li>';
                                endforeach;
                            }else{
                                echo "This product doesnt have any noteable feature";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
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
        $('#addfeature').click(function(){
            sessionStorage.setItem("msg", "Warning this action irreversible!");
            sessionStorage.setItem("msg_type", "warning");
            error_msg();
        });
    });
</script>
</html>