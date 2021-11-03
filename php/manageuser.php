<?php
    require_once 'connect.php';
    if(isset($_SESSION['login']) == 1){
        if(!$_SESSION['admin'] && !$_SESSION['super_admin']){
            MsgReport("You do not have privilege over this feature", "error", "");
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
            $result = NULL;
            $searchengine = $conn->prepare("
            SELECT *, SUBSTRING(username, 1, 15) AS substring_username FROM users WHERE username LIKE ?
            ");
            $searchengine->bind_param("s", $search_term);
            $search_term = '%' . $_GET['search'] . '%';
            $searchengine->execute();
            $result = $searchengine->get_result();
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
    <?php PageTitle("Manage Users") ?>
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
                    if($_SESSION['super_admin']){
                        echo '
                        <li class="nav-item">
                            <a href="editusers.php" title="Create new users" class="btn btn-info spacing">Create User</a>
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
                <td>ID</td>
                <td>Username</td>
                <td>User Type</td>
                <td>Created at</td>
                <td>Last Login</td>
                <td>Action</td>
            </tr>
            <?php foreach($result as $row): ?>
                <td>
                    <?php echo $row['id'] ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['username']) ?>">
                    <?php echo htmlspecialchars($row['substring_username']) ?>
                </td>
                <td title="<?php echo 'vendor : ' . $row['vendor'] . ' admin : ' . $row['admin'] .' super admin : ' . $row['super_admin'] ?>">
                    <?php
                        if($row['vendor'] && $row['admin'] && $row['super_admin']){
                            echo 'Super Administrator';
                        }else if(!$row['vendor'] && $row['admin'] && !$row['super_admin']){
                            echo 'Administrator';
                        }else if($row['vendor'] && !$row['admin'] && !$row['super_admin']){
                            echo 'Vendor';
                        }else if(!$row['vendor'] && $row['admin'] && $row['super_admin']){
                            echo 'User Management';
                        }else if($row['vendor'] && $row['admin'] && !$row['super_admin']){
                            echo 'Product Management';
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
                <td>
                    <form action="confirmationform.php" method="POST">
                        <input type="number" name="id" value="<?php echo $row['id'] ?>" hidden>
                        <a href="user.php?users=<?php echo htmlspecialchars($row['username']) ?>" class="btn btn-primary">Details</a>
                        <?php $_SESSION['command'] = "users" ?>
                        <?php
                            if($_SESSION['super_admin']){
                                echo '
                                    <a href="editusers.php?id=' . $row['id'] .'" title="Edit clicked users" class="btn btn-warning">Edit</a>
                                ';
                                if($row['id'] == $_SESSION['users_id']){
                                    echo '
                                        <input type="button" title="cannot send warning to yourself" class="btn btn-warning" name="warning" value="Warning" disabled>
                                    ';
                                }else{
                                    if($row['warned'] == 1){
                                        echo '
                                            <input type="button" title="cannot send warning twice" class="btn btn-warning" name="warning" value="Warning" disabled>
                                        ';
                                    }else{
                                        echo '
                                            <input type="submit" title="" class="btn btn-warning" name="warning" value="Warning">
                                        ';
                                    }
                                }
                            }else if($_SESSION['admin']){
                                if($row['id'] == $_SESSION['users_id']){
                                    echo '
                                        <input type="button" title="cannot send warning to yourself" class="btn btn-warning" name="report" value="Report" disabled>
                                    ';
                                }else{
                                    if($row['warned'] == 1){
                                        echo '
                                            <input title="cannot send report to already warned users" type="button" class="btn btn-warning" name="report" value="Report" disabled>
                                        ';
                                    }else{
                                        if($row['reported'] == 0){
                                            echo '
                                                <input type="submit" class="btn btn-warning" name="report" value="Report">
                                            ';
                                        }else{
                                            echo '
                                                <input title="cannot send another report" type="button" class="btn btn-warning" name="report" value="Report" disabled>
                                            ';
                                        }
                                    }
                                }
                            }
                        ?>
                        <?php
                            if($_SESSION['super_admin']){
                                if($row['id'] == $_SESSION['users_id']){
                                    echo '
                                        <input title="Beware this is your current account" type="submit" name="delete" value="Delete" class="btn btn-danger">
                                    ';
                                }else{
                                    echo '
                                        <input title="" type="submit" name="delete" value="Delete" class="btn btn-danger">
                                    ';
                                }
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