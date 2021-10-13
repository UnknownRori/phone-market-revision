<?php
    include_once "connect.php";
    if($_SESSION['admin'] == 1 || $_SESSION['superadmin'] == 1){
        $preparetype = $conn->prepare("
        SELECT * FROM type_notification
        ");
        $preparetype->execute();
        $data = $preparetype->get_result();
        $preparetype->close();
        if(isset($_POST['send'])){
            $_SESSION['preload-topic'] = $_POST['topic'];
            $_SESSION['preload-content'] = $_POST['content'];
			
            $preparecheck = $conn->prepare("
			SELECT *
            FROM type_notification WHERE notification_name=?
			");
			$preparecheck->bind_param("s", $notification_name);
			$notification_name = $_POST['type'];
            $preparecheck->execute();
			$result = $preparecheck->get_result();
            $datacheck = $result->fetch_assoc();
			$preparecheck->close();
            if($datacheck['notification_name'] == $_POST['type']){
                $checkusertarget = $conn->prepare("
                SELECT users.username, users.id FROM users WHERE username=?
                ");
                $checkusertarget->bind_param("s", $target);
                $target = $_POST['touser'];
                $checkusertarget->execute();
                $result = $checkusertarget->get_result();
                $checkuser = $result->fetch_assoc();
                $checkusertarget->close();
                $_SESSION['preload-touser'] = $_POST['touser'];
                if($checkuser['username'] == $_SESSION['username']){
                    MsgReport("Cannot send notification to yourself!", "warning", "msgonly");
                }else if($checkuser['username'] === $_POST['touser']){
                    $prepsend = $conn->prepare("
                    INSERT INTO notification
                    (fromuser, touser, notificationtype, topic, content)
                    VALUE (?, ?, ?, ?, ?)
                    ");
                    $prepsend->bind_param("iiiss", $fromuser, $touser, $datacheck['id'], $topic, $content);
                    $fromuser = $_SESSION['users_id'];
                    $touser = $checkuser['id'];
                    $topic = $_POST['topic'];
                    $content = $_POST['content'];
                    $prepsend->execute();
                    $prepsend->close();

                    $checkresult =$conn->prepare("
                    SELECT * FROM notification WHERE touser=? AND fromuser=? AND notificationtype=? AND topic=? AND content=?
                    ");
                    $checkresult->bind_param("iiiss", $touser, $fromuser, $datacheck['id'], $topic, $content);
                    $checkresult->execute();
                    $result = $checkresult->get_result();
                    $check = $result->fetch_assoc();
                    $checkresult->close();
                    if($check['topic'] == $topic){
                        MsgReport("Notification successfully sended", "success", "notificationlist.php");
                    }else{
                        MsgReport("Sending notification failed", "error", "msgonly");
                    }
                }else{
                    MsgReport("Username not found!", "error", "msgonly");
                }
            }else{
                MsgReport("Why u edit this form?", "error", "msgonly");
            }
        }
    }else{
        MsgReport("You do not have privilege over this feature!", "error", "");
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
        <link rel="stylesheet" href="../resource/css/style-notification.css">
        <link rel="icon" href="../resource/image/favicon.jpg">
        <?php PageTitle("Notification Form") ?>
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
        <div class="container extend">
            <div class="col-12">
                <h3 class="text-center">

                </h3>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <select class="form-control" name="type" title="Notification Type">
                            <?php foreach($data as $row): ?>
                                <option name="type" value="<?php echo htmlspecialchars($row['notification_name']) ?>" id="<?php echo htmlspecialchars($row['type']) ?>"><?php echo htmlspecialchars($row['notification_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="touser" type="text" placeholder="To which user" value="<?php if(isset($_SESSION['preload-touser'])){echo htmlspecialchars($_SESSION['preload-touser']);} ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="topic" type="text" placeholder="Topic Notification" value="<?php if(isset($_SESSION['preload-topic'])){echo htmlspecialchars($_SESSION['preload-topic']);} ?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="content" id="" cols="30" rows="10" placeholder="Notification Content" ><?php if(isset($_SESSION['preload-content'])){echo htmlspecialchars($_SESSION['preload-content']);} ?></textarea>
                    </div>
                    <div class="form-group float-right">
                        <input type="submit" class="btn btn-primary" value="Send" name="send">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        error_msg();
    </script>
    <script src="../resource/js/main-js-notificationform.js"></script>
</html>