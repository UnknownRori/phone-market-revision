<?php
    require_once 'connect.php';
    if($_SESSION['login'] == 1){
        $prepdelete = $conn->prepare("
        SELECT product.user_id, product.product_name, product.warned_status, users.id, users.username
        FROM product
        INNER JOIN users ON users.id = product.user_id
        WHERE prod_id=?
        ");
        $prepdelete->bind_param("i", $productid);
        $productid = $_POST['id'];
        $prepdelete->execute();
        $getdata = $prepdelete->get_result();
        $data = $getdata->fetch_assoc();
        $prepdelete->close();
        if(isset($_SESSION['vendor']) == 1 || $_SESSION['admin'] == 1 || $_SESSION['super_admin'] == 1){
            if(isset($_POST['warningconfirm'])){
                $warncommand = $conn->prepare("UPDATE product SET warned_status='1' WHERE prod_id=?");
                $warncommand->bind_param("i", $productid);
                $warncommand->execute();
                $warncommand->close();
                MsgReport("Product successfully warned", "success", "");
            }
            if(isset($_POST['deleteconfirm'])){
                $deletecommand = $conn->prepare("DELETE FROM product WHERE prod_id=?");
                $deletecommand->bind_param("i", $productid);
                $deletecommand->execute();
                $deletecommand->close();
                MsgReport("Product successfully deleted", "success", "");
            }
            if($_SESSION['admin'] == 1 || $_SESSION['super_admin'] == 1){
                if($data['warned_status'] === 0){
                    MsgReport("Make sure you already issue warning to owner of the product!", "warning", "msgonly");
                }
            }else if($_SESSION['users_id'] == $data['user_id']){
                MsgReport("Make sure you know what are you doing", "warning", "msgonly");
            }else{
                MsgReport("You do not have privilege over this product!", "error", "");
            }
        }else{
            MsgReport("You do not have privilege over this product", "error", "");
        }
        
    }else{
        MsgReport("User must log in first", "warning", "login.php");
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
        if(isset($_POST['warning'])){
            PageTitle("Warning Confirmation - " . $data['product_name']) . " - " . $data['username'];
        }else if(isset($_POST['delete'])){
            PageTitle("Delete Confirmation - " . $data['product_name'] . " - "  .$data['username']);
        }else{
            PageTitle("No command");
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
                    <a href="../../phone-market-revision" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../product.php" class="nav-link">Product</a>
                </li>
                <li class="nav-item">
                    <a href="../contactus.php" class="nav-link">Contact us</a>
                </li>
                <?php
                if(isset($_SESSION['admin'])){
                    echo '
                    <li class="nav-item">
                        <a href="manageuser.php" class="nav-link">Manage Users</a>
                    </li>
                    ';
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
                        <a class="navbar-brand" href="user.php?username=' . htmlspecialchars($_SESSION['fullusername']) . '">' . htmlspecialchars($_SESSION['username']) . '
                            <img class="profile" src="../resource/image/profile/' . htmlspecialchars($_SESSION['fullusername']) . '.jpg" alt="">
                        </a>
                    </div>
                    ';
                    echo '<a href="logout.php" class="btn btn-danger spacing">Log out</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top: 180px;">
        <div class="row">
            <div class="col-9" style="margin-left: 13%;">
                <h1 class="text-center"><?php if(isset($_POST['warning'])){echo 'Warning Confirmation';}else if(isset($_POST['delete'])){echo 'Delete Confirmation';} ?></h1>
                <h2 class="text-center"><?php echo $data['product_name'] ?></h2>
                <form action="" method="POST" id="confirmationform">
                    <input type="number" name="id" value="<?php echo $_POST['id'] ?>" hidden>
                    <div class="form-group">
                        <input title="Confirmation Code" id="confirmationcode" type="text" name="randomconfirmationcode" class="form-control" placeholder="Why you delete this" value="Generating Code ..." disabled>
                    </div>
                    <div class="form-group">
                        <input title="What are you waiting for?" id="confirmationbox" type="text" name="confirmation" class="form-control" placeholder="Please re-enter the confirmation code" value="" disabled onkeyup="manage(this)">
                    </div>
                    <div class="form-group">
                        <input title="Confirmation Checkbox" id="confirmationcheckbox" type="checkbox" name="ready" class="" id="form-checkbox">
                        <label for="form-checkbox">
                            <b>I understand the risk</b>
                        </label>
                    </div>
                    <div class="form-group float-left">
                        <?php
                            if(isset($_POST['warning'])){
                                echo '
                                    <input title="Just Do It!" id="confirmationsubmit" type="submit" class="btn btn-warning" value="Confirm" name="warningconfirm" disabled>
                                ';
                            }else if(isset($_POST['delete'])){
                                echo '
                                    <input title="Just Do It!" id="confirmationsubmit" type="submit" class="btn btn-danger" value="Confirm" name="deleteconfirm" disabled>
                                ';
                            }
                        ?>
                    </div>
                </form>
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
    error_msg(2);
    $(document).ready(function(){
        setTimeout(function () {
            var r = (Math.random() + 1).toString(36).substring(2);
            console.log("random", r);
            document.getElementById('confirmationcode').value = r;
    
            $(document).ready(function() {
            $('#confirmationbox').keyup(function() {
                if($(this).val() == r) {
                    $('#confirmationsubmit').prop('disabled', false);
                }else{
                    $('#confirmationsubmit').prop('disabled', true);
                }
            });
        }, 5000);
    });
    $('#confirmationcheckbox').click(function () {
        if ($(this).is(':checked')) {
            sessionStorage.setItem("msg", "Warning this action irreversible!");
            sessionStorage.setItem("msg_type", "warning");
            error_msg(2);
            $('#confirmationbox').removeAttr('disabled');
            document.getElementById('confirmationbox').value = '';
        } else {
            $('#confirmationbox').attr('disabled', true);
            document.getElementById('confirmationbox').value = '';
        }
    });
 });
</script>
</html>