<?php
    require_once 'connect.php';
    if(isset($_SESSION['login']) == 0){
        MsgReport("User must log in first", "warning", "login.php");
    } 
    $preparedata = $conn->prepare("
    SELECT notification.*, users.id, users.username FROM notification
    INNER JOIN users on notification.fromuser = users.id
    WHERE notification.touser = ?;
    ");
    $preparedata->bind_param("i", $id);
    $id = $_SESSION['users_id'];
    $preparedata->execute();
    $data = $preparedata->get_result();
    $preparedata->close();
    if(isset($_POST['delete'])){
        echo '<script>alert("cat")</script>';
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
                            <a href="manageuser.php" class="nav-link">Manage Users</a>
                        </li>
                        ';
                    }
                    if(($_SESSION['vendor'])){
                    echo '
                    <li class="nav-item">
                        <a href="manageproduct.php" class="nav-link">Manage Product</a>
                    </li>
                    <li class="nav-item spacing">
                        <a class="btn btn-primary" href="editproduct.php" class="nav-link">Create Product</a>
                    </li>
                    ';
                    }
                    if($_SESSION['admin'] == 1){
                        echo '
                        <li class="nav-item">
                            <a href="sendnotificationform.php" title="Send notification to another user" class="btn btn-primary spacing">
                                <span class="glyphicon glyphicon-envelope">&#x25b6</span>
                            </a>
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
                        <a class="navbar-brand" href="user.php?users=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '
                            <img class="profile" src="../resource/image/profile/' . $_SESSION['username'] . '.jpg" alt="">
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
                <td>Notification Type</td>
                <td>Topic</td>
                <td>Content</td>
                <td>From</td>
                <td>Action</td>
            </tr>
            <?php foreach($data as $row): ?>
            <tr id="contentTable">
                <td>
                    <?php echo htmlspecialchars($row['notificationtype']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['topic']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['content']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['username']); ?>
                </td>
                <td>
                    <a class="btn btn-primary spacing" href="notification.php?id=<?php echo $row['id'] ?>" >Detail</a>
                    <a class="btn btn-danger spacing" href="deletenotification.php?id=<?php echo $row['id'] ?>">Delete</a>
                    <!-- <form action="" method="post">
                        <a class="btn btn-primary spacing" href="notification.php?id=<?php echo $row['id'] ?>" >Detail</a>
                        <input type="number" value="<?= $row['id']?> " hidden>
                        <input type="submit" class="btn btn-danger spacing" value="Delete" name="delete">
                    </form> -->
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
    error_msg(2);
</script>
</html>