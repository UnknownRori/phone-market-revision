<?php
    require_once 'connect.php';
    if($_SESSION['vendor'] == 1 || $_SESSION['admin'] == 1){
        if(isset($_GET['id'])){
            $getdata = $conn->prepare("SELECT * FROM product WHERE prod_id=?");
            $getdata->bind_param("i", $id);
            $id = $_GET['id'];
            $getdata->execute();
            $data = $getdata->get_result();
            $result = $data->fetch_assoc();
            $getdata->close();

            if(isset($_POST['edit']) && $_GET['id']){
                $editdata = $conn->prepare("UPDATE product SET product_name=? , photo_name=? , price=? , stock=? , description=? WHERE prod_id=?");
                $editdata->bind_param("ssiisi", $product_name, $photo_name, $price, $stock, $description, $prod_id);
                $prod_id = $_GET['id'];
                $product_name = $_POST['product_name'];
                if($_POST['product_photo'] !== ""){
                    $photo_name = $_POST['product_photo'];
                }else{
                    $photo_name = $result['photo_name'];
                }
                $price = $_POST['price'];
                $stock = $_POST['stock'];
                $description = $_POST['product_description'];
                $editdata->execute();
                $editdata->close();
                MsgReport("Product successfully edited!", "success", "manageproduct.php");
            }
        }else{
            if(isset($_POST['create'])){
                if($_POST['product_name'] == null){
                    MsgReport("Product must have name!", "warning", "msgonly");
                }else if($_POST['price'] == null){
                    MsgReport("Product must have price!", "warning", "msgonly");
                }else{
                    $createdata = $conn->prepare("INSERT INTO product (user_id, product_name, photo_name, price, stock, description) value (?, ?, ?, ?, ?, ?)");
                    $createdata->bind_param("issiis", $prod_userid, $prod_name, $prod_photo, $prod_price, $prod_stock, $prod_desc);
                    $prod_userid = $_SESSION['users_id'];
                    $prod_name = $_POST['product_name'];
                    $prod_photo = $_POST['product_photo'];
                    $prod_price = $_POST['price'];
                    $prod_stock = $_POST['stock'];
                    $prod_desc = $_POST['product_description'];
                    $createdata->execute();
                    $createdata->close();
                    if($createdata == true){
                        MsgReport("Product successfully created!", "success", "manageproduct.php");
                    }else{
                        MsgReport("Product failed created!", "success", "manageproduct.php");
                    }
                }
            }
        }
    }else{
        MsgReport("Please log in first!", "warning", "login.php");
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
        <link rel="stylesheet" href="../resource/css/style-editproduct.css">
        <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
        <link rel="icon" href="../resource/image/favicon.jpg">
        <title>
            <?php
                if(isset($result['product_name'])){
                    echo "Editing Product" . "&nbsp" . $result['product_name'];
                }else{
                    echo "Creating New Product";
                }
                ?>
        </title>
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
        <div class="container extend">
            <div class="">
                <h3 class="text-center">
                    <?php
                        if(isset($_GET['id'])){
                            echo 'Editing' . "&nbsp" . $result['product_name'];
                        }else{
                            echo 'Creating New Product';
                        }
                        ?>
                </h3>
                <form method="POST" action="">
                    <table class="table table-hover">
                        <tr>
                            <td>Product Name</td>
                            <td>
                                <div class="form-group">
                                <?php
                                if(isset($_GET['id'])){
                                    echo '
                                        <input type="text" class="form-control" name="product_name" placeholder="Please Enter Product Name" value="' . $result['product_name'] . '">
                                    ';
                                }else{
                                    echo '
                                        <input type="text" class="form-control" name="product_name" placeholder="Please Enter Product Name">
                                    ';
                                }
                                ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Photo (300x300 only)</td>
                            <td>
                                <div class="form-group">
                                    <input type="file" class="form-control" name="product_photo">
                                    <?php
                                        if(isset($_GET['id'])){
                                            echo '
                                                <input type="text" class="form-control" value="' .$result['photo_name'] . '" placeholder="Empty" disabled>
                                            '; 
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <?php
                                        if(isset($_GET['id'])){
                                            echo '
                                                <input type="number" class="form-control" name="price" placeholder="Please Enter Product Price" value="' . $result['price'] .'">
                                            ';
                                        }else{
                                            echo '
                                                <input type="number" class="form-control" name="price" placeholder="Please Enter Product Price">
                                            ';
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Starting Stock</td>
                            <td>
                                <div class="form-group">
                                    <?php
                                        if(isset($_GET['id'])){
                                            echo '
                                                <input type="number" class="form-control" name="stock" placeholder="Please Enter Starting Stock" value="' . $result['stock'] .'">
                                            ';
                                        }else{
                                            echo '
                                                <input type="number" class="form-control" name="stock" placeholder="Please Enter Starting Stock">
                                            ';
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>
                                <div class="form-group">
                                    <?php
                                        if(isset($_GET['id'])){
                                            echo '
                                                <textarea class="form-control" name="product_description">' . $result['description'] . '</textarea>
                                            ';
                                        }else{
                                            echo '
                                                <textarea class="form-control" name="product_description"></textarea>
                                            ';
                                        }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group" style="float: right;">
                        <?php
                            if(isset($_GET['id'])){
                                echo '
                                    <input type="submit" class="btn btn-primary" value="Edit" name="edit">
                                ';
                            }else{
                                echo '
                                    <input type="submit" class="btn btn-primary" value="Create" name="create">
                                ';
                            }
                            ?>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        error_msg(2);
    </script>
</html>

