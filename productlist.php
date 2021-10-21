<?php
    require_once 'php\connect.php';
    if(!empty($_GET['page'])) {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    }else{
        $page = 1;
    }
    $offset = ($page - 1) * 6;
    $prepare_data = $conn->prepare("
    SELECT product.prod_id, product.product_name, product.photo_name, product.price, product.warned_status,
    SUBSTRING(product.product_name, 1, 20) AS substring_product_name,
    SUBSTRING(product.price, 1, 20) AS substring_product_price,
    users.id, users.username
    FROM product
    INNER JOIN users ON product.user_id = users.id
    LIMIT ". $offset .", 6
    ");
    $prepare_data->execute();
    $result = $prepare_data->get_result();
    $prepare_data->close();
    if(isset($_GET['search'])){
        if($_GET['search'] != null){
            // BasicSearchEngineAlgorithm:
            $data = NULL;
            $searchengine = $conn->prepare("
            SELECT product.prod_id, product.product_name, product.photo_name, product.price, product.warned_status,
            users.id, users.username,
            SUBSTRING(product.product_name, 1, 20) AS substring_product_name,
            SUBSTRING(product.price, 1, 20) AS substring_product_price
            FROM product
            INNER JOIN users ON product.user_id = users.id
            WHERE
            product.product_name LIKE ?  OR users.username LIKE ? OR product.prod_id LIKE ? OR product.keyword LIKE ?
            ");
            $searchengine->bind_param("ssss", $searchterm, $searchterm, $searchterm, $searchterm);
            $searchterm = '%' . $_GET['search'] . '%';
            $searchengine->execute();
            $result = $searchengine->get_result();
            $searchengine->close();
            //AdvancedSearchEngineAlgorithm:
            //Todo: add ProductNameOnly Tag, VendorOnly Tag, SpecificCharacter Tag
        }else{
            MsgReport("Cannot search empty query!", "error", "msgonly");
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
    <link rel="stylesheet" href="resource/css/style-profile.css">
    <link rel="stylesheet" href="resource/css/style-productlist.css">
    <link rel="stylesheet" href="resource/css/bootstrap.min.css">
    <link rel="icon" href="resource/image/favicon.jpg">
    <?php PageTitle("Product"); ?>
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
                    <!-- search engine input -->
                    <form class="form-inline" action="" method="get">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="Search Product" class="form-control spacing">
                            <a href="advanced-search-product.php" class="btn btn-info spacing">Advanced Search</a>
                        </div>
                    </form>
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
    <div id="extend" class="container height-185vh">
        <div class="text-center">
            <a href="productlist.php?page=<?php echo $page - 1 ?>" class="btn btn-info">Back</a>
            <a href="productlist.php?page=<?php echo $page + 1 ?>" class="btn btn-info">Next</a>
        </div>
        <?php foreach($result as $row):?>
        <div style="width: 300px!important; margin: 20px;" class="float-left">
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
            <div style="margin-top: 10px; padding: 5px;">
                <form action="php/confirmationform.php" method="POST">
                <div class="form-group float-left">
                        <?php $_SESSION['command'] = "product" ?>
                        <input type="number" name="id" value="<?php echo $row['prod_id'] ?>" hidden>
                        <a href="php/product.php?id=<?php echo $row['prod_id']; ?>" class="btn btn-primary">Detail</a>
                        <?php
                            if(isset($_SESSION['login'])){
                                if(($_SESSION['admin'])){
                                    echo '<input type="submit" value="Delete" name="delete" class="btn btn-danger spacing">';
                                    if($row['warned_status'] == 1){
                                        echo '<input type="submit" value="Issue Warning" class="btn btn-warning spacing" title="Already Warned" disabled>';
                                    }else{
                                        if($row['username'] == $_SESSION['username']){
                                            echo '<input type="submit" value="Issue Warning" class="btn btn-warning spacing" title="Cannot send warning on yourself" disabled>';
                                        }else{
                                            echo '<input type="submit" value="Issue Warning" name="warning" class="btn btn-warning spacing">';
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <div class="text-center" style="margin-top: 10px; margin-bottom: 40px;">
        <a href="productlist.php?page=<?php echo $page - 1 ?>" class="btn btn-info">Back</a>
        <a href="productlist.php?page=<?php echo $page + 1 ?>" class="btn btn-info">Next</a>
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
    error_msg();
    getcurrentpage();
</script>
</html>