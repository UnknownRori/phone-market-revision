<?php
    require_once 'connect.php';
    if(isset($_SESSION['login']) == 1){
        if($_SESSION['admin'] == 0){
            MsgReport("You do not have privilege over this product", "error", "");
        }
    }else{
        MsgReport("User must log in first", "warning", "login.php");
    }
    $prepare_data = $conn->prepare("
    SELECT *, SUBSTRING(username, 1, 15) AS substring_username FROM users
    ");
    $prepare_data->execute();
    $result = $prepare_data->get_result();
    $prepare_data->close();
    if(isset($_GET['search'])){
        if($_GET['search'] != null){
            $data = NULL;
            $searchengine = $conn->prepare("

            ");
            $searchengine->bind_param("", );

            $searchengine->execute();
            $data = $searchengine->get_result();
            $searchengine->close();
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
    <script src="../resource/js/jquery-3.5.1.js"></script>
    <script src="../resource/js/main.js"></script>
    <script src="../resource/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../resource/css/style.css">
    <link rel="stylesheet" href="../resource/css/style-profile.css">
    <link rel="stylesheet" href="../resource/css/style-notification.css">
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <?php PageTitle("Notification") ?>
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
                            <input type="text" name="search" placeholder="Search" class="form-control spacing">
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
                }?>
            </ul>
        </div>
    </nav>
    <div class="container extend">
        <table class="table table-hover">
            <tr>
                <td>User ID</td>
                <td>Username</td>
                <td>User Type</td>
                <td>Created at</td>
                <td>Last Login</td>
                <td>Status</td>
                <td>Action</td>
            </tr>
            <?php foreach($result as $row): ?>
                <td>
                    <?php echo $row['id'] ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['username']) ?>">
                    <?php echo htmlspecialchars($row['substring_username']) ?>
                </td>
                <td>
                    <?php
                        if($row['vendor'] && $row['admin'] && $row['super_admin']){
                            echo 'Administrator';
                        }else if($row['vendor'] && $row['admin'] && !$row['super_admin']){
                            echo 'Staff';
                        }else if($row['admin'] && !$row['vendor'] && !$row['super_admin']){
                            echo 'Deputy Administrator';
                        }else if($row['vendor'] && !$row['admin'] && !$row['super_admin']){
                            echo 'Vendor';
                        }else if(!$row['vendor'] && !$row['admin'] && !$row['super_admin']){
                            echo 'User';
                        }else{
                            echo 'ERROR';
                        }
                    ?>
                </td>
                <td>
                    <?php echo $row['create_time'] ?>
                </td>
                <td>
                    <?php echo $row['last_login'] ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['status']) ?>">
                    <?php echo htmlspecialchars(substr($row['status'], 0, 10)) ?>
                </td>
                <td>
                    <form action="" method="post">
                        <a href="user.php?id=<?php echo $row['id'] ?>" class="btn btn-primary">Details</a>
                        <input title="<?php if($_SESSION['admin'] && !$_SESSION['super_admin']){echo 'send report to Main Administrator for further review';} ?>" type="submit" name="report" value="Report" class="btn btn-warning">
                        <?php
                            if($_SESSION['super_admin']){
                                echo '
                                <input title="" type="submit" name="delete" value="Delete" class="btn btn-danger">
                                ';
                            }
                        ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
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