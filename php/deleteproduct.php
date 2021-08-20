<?php
    require_once 'connect.php';
    if(isset($_SESSION['vendor'])){
        $prepdelete = $conn->prepare("SELECT user_id, product_name, warned_status FROM product WHERE prod_id=?");
        $prepdelete->bind_param("i", $productid);
        $productid = $_GET['id'];
        $prepdelete->execute();
        $getdata = $prepdelete->get_result();
        $data = $getdata->fetch_assoc();
        $prepdelete->close();
        if($_SESSION['users_id'] == $data['user_id']){
            
        }else if($_SESSION['admin'] == 1){
            echo '
            <script>
            sessionStorage.setItem("msg", "Make sure you already issue warning to owner product!");
            sessionStorage.setItem("msg_type", "warning");
            </script>
            ';
        }else{
            echo '
            <script>
            sessionStorage.setItem("msg", "You do not have privilege over this product!");
            sessionStorage.setItem("msg_type", "error");
            window.location = sessionStorage.getItem("last_url");
            </script>
            ';
        }

        if(isset($_POST['delete'])){
            $deletecommand = $conn->prepare("DELETE FROM product WHERE prod_id=?");
            $deletecommand->bind_param("i", $prodid);
            $prodid = $_GET['id'];
            $deletecommand->execute();
            if($prepare == TRUE){
                echo '<script>alert("Product Successfully Deleted!");window.location="../product.php"</script>';
            }
            $deletecommand->close();
        }
    }else{
        echo '<script>
            sessionStorage.setItem("msg", "User must log in first!");
            sessionStorage.setItem("msg_type", "warning");
            window.location = "login.php";
        </script>';
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <title>Delete Confirmation</title>
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
                    <a href="../product.php" class="nav-link active">Product</a>
                </li>
                <li class="nav-item">
                    <a href="../contactus.php" class="nav-link">Contact us</a>
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
    <div class="container" style="margin-top: 180px;">
        <div class="row">
            <div class="col-9" style="margin-left: 13%;">
                <h1 class="text-center">Confirm Deletetion</h1>
                <h2 class="text-center"><?php echo $data['product_name'] ?></h2>
                <form action="" method="POST" id="confirmationform">
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
                        <input title="Just Do It!" id="confirmationsubmit" type="submit" class="btn btn-danger" value="Delete" name="delete" disabled>
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
        }, 1000);
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