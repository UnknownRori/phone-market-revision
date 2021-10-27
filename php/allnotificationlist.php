<?php
    require_once 'connect.php';
    if(isset($_SESSION['login']) == 1){
        if($_SESSION['super_admin'] == 1){

        }else{
            MsgReport("You do not have privilege over this feature!", "error", "");
        }
    }else{
        MsgReport("User must log in first", "error", "login.php");
    }
    $preparedata = $conn->prepare("
    SELECT notification.*, notification.id AS notify_id, type_notification.*, users.id AS userfromid, users.username AS userfrom,
    SUBSTRING(notification.topic, 1, 25) AS substring_topic,
    SUBSTRING(notification.content, 1, 25) AS substring_content,
    SUBSTRING(users.username, 1, 15) AS substring_userfrom,
    SUBSTRING(type_notification.notification_name, 1, 18) AS substring_notification_name
    FROM notification
    INNER JOIN users on notification.fromuser = users.id
    LEFT JOIN type_notification on notification.notificationtype = type_notification.id
    ");
    $preparedata->execute();
    $data = $preparedata->get_result();
    $preparedata->close();
    if(isset($_GET['search'])){
        if($_GET['search'] != null){
            $data = NULL;
            $searchengine = $conn->prepare("
            SELECT notification.*, type_notification.*, users.id AS userfromid, users.username AS userfrom,
            SUBSTRING(notification.topic, 1, 25) AS substring_topic,
            SUBSTRING(notification.content, 1, 25) AS substring_content,
            SUBSTRING(users.username, 1, 15) AS substring_userfrom,
            SUBSTRING(type_notification.notification_name, 1, 18) AS substring_notification_name
            FROM notification
            INNER JOIN users on notification.fromuser = users.id
            LEFT JOIN type_notification on notification.notificationtype = type_notification.id
            type_notification.notification_type LIKE ? OR notification.topic LIKE ? OR notification.content LIKE ?
            GROUP BY notification.fromuser
            ");
            $searchengine->bind_param("isss", $user, $searchterm, $searchterm, $searchterm);
            $user = $_SESSION['users_id'];
            $searchterm = '%' . $_GET['search'] . '%';
            $searchengine->execute();
            $data = $searchengine->get_result();
            $searchengine->close();
            MsgReport($_SESSION['users_id'], "success", "msgonly");
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
    <?php PageTitle("Notification All List") ?>
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
                    if($_SESSION['super_admin'] == 1){
                        echo '
                        <li class="nav-item">
                            <a href="allnotificationlist.php" title="View all notification traffic" class="nav-link active">
                                List
                            </a>
                        </li>
                        ';
                    }
                    if($_SESSION['admin'] == 1){
                        echo '
                        <li class="nav-item">
                            <a href="sendnotificationform.php" title="Send notification to another user" class="btn btn-primary spacing">
                                Send
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
                <td>Notification Type</td>
                <td>Topic</td>
                <td>Content</td>
                <td>From</td>
                <td>To</td>
                <td>Action</td>
            </tr>
            <?php foreach($data as $row): ?>
            <tr id="<?php echo htmlspecialchars($row['type']); ?>">
                <td title="<?php echo htmlspecialchars($row['notification_name']); ?>">
                    <?php echo htmlspecialchars($row['substring_notification_name']); ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['topic']); ?>">
                    <?php echo htmlspecialchars($row['substring_topic']); ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['content']); ?>">
                    <?php echo htmlspecialchars($row['substring_content']); ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['userfrom']); ?>">
                    <?php echo htmlspecialchars($row['substring_userfrom']); ?>
                </td>
                <td title="<?php echo htmlspecialchars($row['touser']); ?>">
                    <?php echo htmlspecialchars($row['touser']); ?>
                </td>
                <td>
                    <form action="confirmationform.php" method="POST">
                        <?php $_SESSION['command'] = "notification" ?>
                        <a class="btn btn-primary spacing" href="notification.php?id=<?php echo $row['notify_id'] ?>" >Detail</a>
                        <input type="number" name="id" value="<?= $row['notify_id']?>" hidden>
                        <input type="submit" class="btn btn-danger spacing" value="Delete" name="delete">
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