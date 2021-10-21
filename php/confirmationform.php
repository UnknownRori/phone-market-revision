<?php
    require_once 'connect.php';
    if($_SESSION['login'] == 1){
        if(isset($_SESSION['command']) == Null){
            error_reporting(1);
            if($_SESSION['vendor'] !== 1 || $_SESSION['admin'] !== 1 || $_SESSION['super_admin'] !== 1){
                MsgReport("You do not have privilege over this feature!", "error", "");
            }else{
                MsgReport("Whoa what are you doing there!", "error", "");
            }
        }else if($_SESSION['command'] == "product"){
            $prepdelete = $conn->prepare("
            SELECT product.user_id,
            SUBSTRING(product.product_name, 1, 20) AS name,
            product.warned_status, users.id
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
                    $_SESSION['command'] == Null;
                    MsgReport("Product successfully warned", "success", "");
                }
                if(isset($_POST['deleteconfirm'])){
                    $deletecommand = $conn->prepare("DELETE FROM product WHERE prod_id=?");
                    $deletecommand->bind_param("i", $productid);
                    $deletecommand->execute();
                    $deletecommand->close();
                    $_SESSION['command'] == Null;
                    MsgReport("Product successfully deleted", "success", "");
                }
                // fix this
                if($_SESSION['users_id'] !== $data['id'] && $_POST['warning'] == null && $_SESSION['admin'] || $_SESSION['super_admin']){
                    if($data['warned_status'] === 0){
                        MsgReport("Make sure you already issue warning to owner of the product!", "warning", "msgonly");
                    }
                }else if($_SESSION['users_id'] == $data['id']){
                    MsgReport("Make sure you know what are you doing", "warning", "msgonly");
                }else{
                    MsgReport("You do not have privilege over this product!", "error", "");
                }
            }else{
                MsgReport("You do not have privilege over this product", "error", "");
            }
        }else if($_SESSION['command'] == "notification"){
            $prepare_notify_data = $conn->prepare("
            SELECT id, SUBSTRING(topic, 1, 20) AS name, touser
            FROM notification
            WHERE id=?
            ");
            $prepare_notify_data->bind_param("i", $id);
            $id = $_POST['id'];
            $prepare_notify_data->execute();
            $getdata = $prepare_notify_data->get_result();
            $data = $getdata->fetch_assoc();
            $prepare_notify_data->close();
            if($data['touser'] == $_SESSION['users_id'] || $_SESSION['super_admin']){
                if(isset($_POST['deleteconfirm'])){
                    $prepare_delete_notify = $conn->prepare("
                    DELETE FROM notification WHERE id=?
                    ");
                    $prepare_delete_notify->bind_param("i", $id);
                    $prepare_notify_data->execute();
                    $prepare_delete_notify->close();
                    MsgReport("Notification  successfully deleted!", "success", "");
                    $_SESSION['command'] == Null;
                }
            }else{
                MsgReport("You do not have privilege over this notification!", "error", "");
            }
        }else if($_SESSION['command'] == "users"){

        }else{

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
        if(isset($_SESSION['command']) == "product"){
            if(isset($_POST['warning'])){
                PageTitle("Warning Product Confirmation - " . htmlspecialchars($data['name']));
            }else if(isset($_POST['delete'])){
                PageTitle("Delete Product Confirmation - " . htmlspecialchars($data['name']));
            }else{
                PageTitle("No command");
            }
        }else if($_SESSION['command'] == "notification"){
            if(isset($_POST['delete'])){
                PageTitle("Delete Notification Confirmation - " . htmlspecialchars($data['name']));
            }else{
                PageTitle("No Command");
            }
        }else{
            PageTitle("No Command");
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
                    <a href="../productlist.php" class="nav-link">Product</a>
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
                <h2 class="text-center"><?php echo $data['name'] ?></h2>
                <form action="" method="POST" id="confirmationform">
                    <input type="number" name="id" value="<?php echo $_POST['id'] ?>" hidden>
                    <div class="form-group">
                        <input title="Confirmation Code" id="confirmationcode" type="text" name="confirmationcode" class="form-control" placeholder="Why you delete this" value="Generating Code . . ." disabled>
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
    error_msg();
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
            }, 500);
        });
        $('#confirmationcheckbox').click(function () {
            if ($(this).is(':checked')) {
                sessionStorage.setItem("msg", "Warning this action irreversible!");
                sessionStorage.setItem("msg_type", "warning");
                error_msg();
                $('#confirmationbox').removeAttr('disabled');
                document.getElementById('confirmationbox').value = '';
            } else {
                $('#confirmationbox').attr('disabled', true);
                $('#confirmationsubmit').prop('disabled', true);
                document.getElementById('confirmationbox').value = '';
            }
        });
    });
</script>
</html>