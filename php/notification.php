<?php
    require_once 'connect.php';
    if(isset($_SESSION['login'])){
        $prepare_notification_content = $conn->prepare("
        SELECT notification.*, users.username FROM notification
        INNER JOIN users on users.id = notification.fromuser
        WHERE notification.id=?
        ");
        $prepare_notification_content->bind_param("i", $id);
        $id = $_GET['id'];
        $prepare_notification_content->execute();
        $get_result = $prepare_notification_content->get_result();
        $result = $get_result->fetch_assoc();
        if($_SESSION['users_id'] == $result['touser'] || $_SESSION['super_admin'] == 1){

        }else{
            MsgReport("You do not have privilege over this notification!", "error", "");
        }
    }else{
        MsgReport("Users must login first", "error", "login.php");
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
    <link rel="stylesheet" href="../resource/css/style-notification.css">
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <?php PageTitle("Notification - " . $result['topic']); ?>
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
                    <a href="../phone-market-revision" class="nav-link">Home</a>
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
                        <a href="notificationlist.php" id="notification">
                            <span class="glyphicon">&#x2709;</span>
                        </a>
                        <a class="navbar-brand" href="user.php?username=' . htmlspecialchars($_SESSION['fullusername']) . '">' . htmlspecialchars($_SESSION['username']) . '
                            <img class="profile" src="../resource/image/profile/' . htmlspecialchars($_SESSION['fullusername']) . '.jpg" alt="">
                        </a>
                    </div>
                    ';
                    echo '<a href="logout.php" class="btn btn-danger">Log out</a>';
                }?>
            </ul>
        </div>
    </nav>
    <div id="extend" class="container">
        <table class="table table-hover">
            <tr>
                <th colspan="3" class="text-center">
                    <?php
                        echo htmlspecialchars($result['topic'])
                    ?>
                </th>
            </tr>
            <tr>
                <td>
                    From
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php
                        echo htmlspecialchars($result['username'])
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Content
                </td>
                <td>
                    :
                </td>
                <td>
                    <textarea name="" id="" cols="30" rows="10" class="form-control" disabled>
                        <?php
                            echo htmlspecialchars($result['content'])
                        ?>
                    </textarea>
                </td>
            </tr>
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
    error_msg();
</script>
</html>