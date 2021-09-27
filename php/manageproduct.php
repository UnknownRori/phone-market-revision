<?php
    require_once 'connect.php';
    if(isset($_SESSION['vendor']) == 0){
        MsgReport("User must log in first", "warning", "login.php");
    } 
    $preparedata = $conn->prepare("
        SELECT product.*, buy_history.product_id, SUM(buy_history.total_requested) AS total_requested
        FROM product
        LEFT JOIN buy_history ON buy_history.product_id = product.prod_id
        WHERE product.user_id = ? GROUP BY product.prod_id;
        "
    );
    $preparedata->bind_param("i", $id);
    $id = $_SESSION['users_id'];
    $preparedata->execute();
    $data = $preparedata->get_result();
    $preparedata->close();
    if(isset($_POST['search-product'])){
        if($_POST['search-product'] != null){
            $data = NULL;
            // $searchengine = $conn->prepare("SELECT product.*, users.id FROM product INNER JOIN users ON product.user_id = users.id WHERE product.product_name LIKE ? OR product.user_id LIKE ?");
            $searchengine = $conn->prepare("
            SELECT product.*,users.id , buy_history.product_id, SUM(buy_history.total_requested) AS total_requested
            FROM product
            LEFT JOIN buy_history ON buy_history.product_id = product.prod_id
            RIGHT JOIN users ON users.id = product.user_id
            WHERE users.id=? AND product.product_name LIKE ? OR product.prod_id LIKE ? GROUP BY product.prod_id
            "
            );
            $searchengine->bind_param("iss", $user_id, $searchterm, $searchterm);
            $user_id = $_SESSION['users_id'];
            $searchterm = '%' . $_POST['search-product'] . '%';
            $searchengine->execute();
            $data = $searchengine->get_result();
            $searchengine->close();
        }else{
            MsgReport("Cannot search empty query!", "warning", "msgonly");
        }
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
    <title>Manage Product</title>
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
                    <a href="../../phone-market-revision" class="nav-link">Home</a>
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
                ?>
                <li class="nav-item">
                    <a href="manageproduct.php" class="nav-link active">Manage Product</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="editproduct.php" class="nav-link">Create Product</a>
                </li>
                <li class="nav-item" style="margin-left: 10px;">
                    <form class="form-inline" action="" method="post">
                        <div class="form-group">
                            <input type="text" name="search-product" placeholder="Search" class="form-control">
                        </div>
                    </form>
                </li>
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
    <div class="container extend" style="margin-bottom: 50px;">
        <table class="table table-hover">
            <tr>
                <!-- <td>#</td> -->
                <td>ID</td>
                <td>Name</td>
                <td>Photo</td>
                <td>Price</td>
                <td>Available</td>
                <td>Request</td>
                <td>Status</td>
                <td>Action</td>
            </tr>
            <?php foreach($data as $row):?>
            <tr>
                <!-- <td>
                    <?php echo $i;  ?>
                </td> -->
                <td>
                    <?php echo $row['prod_id']; ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['product_name']); ?>
                </td>
                <td>
                    <?php
                     if($row['photo_name'] !== ""){
                        echo '
                            <a href="../resource/image/product/' . $row['photo_name'] .'" target="_blank">' . $row['photo_name'] . '</a>
                        ';
                     }else{
                         echo '
                            
                         ';
                     }
                     ?>
                </td>
                <td>
                    <?php echo '$' . $row['price']; ?>
                </td>
                <td>
                    <?php echo $row['stock']; ?>
                </td>
                <td>
                    <?php
                        if($row['total_requested'] > 0){
                            echo $row['total_requested'];
                        }else{
                            echo '0';
                        }
                     ?>
                </td>
                <td>
                    <?php
                     if($row['warned_status'] !== 0){
                        echo '
                            <b>Warned</b>
                        ';
                     }
                     if($row['total_requested'] > $row['stock']){
                        echo '
                            <b>Not Enough Stock</b>
                        ';
                     }else if($row['stock'] > 0){
                         echo '
                            <b>Surplus Stock</b>
                         ';
                     }else if($row['stock'] == 0){
                        echo '
                            <b>Out of Stock</b>
                        ';
                     }
                     
                    ?>
                </td>
                <td>
                    
                    <?php
                      echo '
                        <a class="btn btn-primary spacing" href="product.php?id=' . $row['prod_id'] . '" >Detail</a>
                        <a class="btn btn-warning spacing" href="editproduct.php?id=' . $row['prod_id'] . '" >Edit</a>
                        <a class="btn btn-danger spacing" href="deleteproduct.php?id=' . $row['prod_id'] . '">Delete</a>
                      ';
                    ?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
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
    error_msg(2);
</script>
</html>