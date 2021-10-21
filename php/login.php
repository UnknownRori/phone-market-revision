<?php
    require_once 'connect.php';
    if(isset($_SESSION['login'])){
        MsgReport("User already log in!", "error", "");
    }
    if(isset($_POST['login'])){
        $_SESSION['preload-login-username'] = $_POST['username_1'];
        $check_user = $conn->prepare("
        SELECT id, SUBSTRING(username, 1, 15) AS substring_username,
        username, password, vendor, admin, super_admin
        FROM users WHERE username=?
        ");
        $check_user->bind_param("s", $username);

        $username = $_POST['username_1'];

        $check_user->execute();
        $result = $check_user->get_result();
        $users = $result->fetch_assoc();
        $check_user->close();
        if($users['username'] == null){
            MsgReport("Incorrect Username!", "error", "login.php");
        }
        if($check_user == TRUE){
            $password = $_POST['password_1'];
            if(password_verify($password, $users['password'])){
                $update_user_status = $conn->prepare("UPDATE users SET password=?, last_login=CURRENT_TIMESTAMP WHERE id=?");
                $update_user_status->bind_param("si", $newpassword, $id);
                $newpassword = password_hash($password, PASSWORD_DEFAULT);
                $id = $users['id'];
                $update_user_status->execute(); 
                $update_user_status->close();
                $_SESSION['users_id'] = $users['id'];
                $_SESSION['username'] = $users['substring_username'];
                $_SESSION['fullusername'] = $users['username'];
                $_SESSION['vendor'] = $users['vendor'];
                $_SESSION['admin'] = $users['admin'];
                $_SESSION['super_admin'] = $users['super_admin'];
                $_SESSION['login'] = 1;
                if(isset($_POST["remember_me"])){
                    // cache login
                }
                MsgReport("Log in successfully!", "success", "");
            }else{
                MsgReport("Incorrect Password!", "error", "login.php");
            }
        }else{
            MsgReport("Fatal Error!", "error", "msgonly");
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
    <link rel="stylesheet" href="../resource/css/bootstrap.min.css">
    <link rel="icon" href="../resource/image/favicon.jpg">
    <?php PageTitle("Login") ?>
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
        <div class="collapse navbar-collapse justify-content-betwen" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="../../phone-market-revision" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="../productlist.php" class="nav-link">Product</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="createusers.php" class="btn btn-info">Create Account</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top: 200px;">
        <div class="row">
            <div class="col-9" style="margin-left: 13%;">
                <h3 class="text-center">Login</h3>
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="username_1" class="form-control" placeholder="Enter Username" value="<?php if(isset($_SESSION['preload-login-username'])){echo htmlspecialchars($_SESSION['preload-login-username']);} ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_1" class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="#remember_me">Remember me!</label>
                    </div>
                    <div class="form-group float-left">
                        <input type="submit" class="btn btn-primary" value="Log in" name="login">
                    </div>
                </form>
            </div>
        </div>
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
    <div class="footer fixed-bottom img-small-opacity floating-bottom">
        <a href="https://github.com/UnknownRori/phone-market-revision" target="_blank" title="Source Code">
            <img src="../resource/image/contactus/github.png" alt="github">
        </a>
    </div>
</body>
<script>
    error_msg();
</script>
</html>