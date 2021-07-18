<?php
    require_once 'connect.php';
    if(isset($_SESSION['login'])){
        echo '<script>
        sessionStorage.setItem("msg", "User already log in!");
        sessionStorage.setItem("msg_type", "warning");
        </script>';
        echo '<script>window.location="../../phone-market-revision";</script>';
    }
    if(isset($_POST['login'])){
        $_SESSION['preload-login-username'] = $_POST['username_1'];
        $prepare = $conn->prepare("SELECT id, username, password, admin, vendor FROM users WHERE username=? ");
        $prepare->bind_param("s", $username);

        $username = $_POST['username_1'];

        $prepare->execute();
        $result = $prepare->get_result();
        $users = $result->fetch_assoc();
        $prepare->close();
        if($users['username'] == null){
            echo '<script>
                sessionStorage.setItem("msg", "Incorrect Username!");
                sessionStorage.setItem("msg_type", "error");
                window.location="login.php";
                </script>';
        }
        if($prepare == TRUE){
            $password = $_POST['password_1'];
            if(password_verify($password, $users['password'])){
                $updatepassword = $conn->prepare("UPDATE users SET password=? WHERE id=?");
                $updatepassword->bind_param("si", $newpassword, $id);
                $newpassword = password_hash($password, PASSWORD_DEFAULT);
                $id = $users['id'];
                $updatepassword->execute(); 
                $updatepassword->close();
                $_SESSION['username'] = $users['username'];
                $_SESSION['admin'] = $users['admin'];
                $_SESSION['vendor'] = $users['vendor'];
                $_SESSION['login'] = 1;
                echo '<script>
                sessionStorage.setItem("msg", "Log in successfully!");
                sessionStorage.setItem("msg_type", "success");
                window.location="../../phone-market-revision";
                </script>';
            }else{
                echo '<script>
                sessionStorage.setItem("msg", "Incorrect password!");
                sessionStorage.setItem("msg_type", "error");
                </script>';
            }
        }else{
            echo '<script>
                sessionStorage.setItem("msg", "Fatal Error!");
                sessionStorage.setItem("msg_type", "error");
                </script>';
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
    <title>Login</title>
</head>
<body id="home">
    <div class="msg fixed-top text-center">
        <span id="msg" class="text-white"></span>
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
                    <a href="..\product.php" class="nav-link">Product</a>
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
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="username_1" class="form-control" placeholder="Enter Username" value="<?php if(isset($_SESSION['preload-login-username'])){echo $_SESSION['preload-login-username'];} ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_1" class="form-control" placeholder="Enter Password">
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
    error_msg(2);
</script>
</html>