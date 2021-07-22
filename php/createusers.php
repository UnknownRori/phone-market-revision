<?php
    require_once 'connect.php';
    if(isset($_SESSION['login'])){
        echo '<script>
            sessionStorage.setItem("msg", "User already log in!");
            sessionStorage.setItem("msg_type", "warning");
            window.location = sessionStorage.getItem("last_url");
        </script>';
    }

    if(isset($_POST['signup'])){
        $_SESSION['preload-create-username'] = $_POST['username_1'];
        $checkusers = $conn->prepare("SELECT id, username, password FROM users WHERE username=? ");
        $checkusers->bind_param("s", $username);
        $username = $_POST['username_1'];
        $checkusers->execute();
        $result = $checkusers->get_result();
        $users = $result->fetch_assoc();
        $checkusers->close();
        if(($_POST['username_1']) != $users['username']){
            if(($_POST['password_1']) == ($_POST['password_2'])){
                $addusers = $conn->prepare("INSERT INTO users (username, password, admin, vendor) VALUE (?, ?, ?, ?)");
                $addusers->bind_param("ssbb", $username, $password, $admin, $vendor);
        
                $username  = $_POST['username_1'];
                $password  = password_hash($_POST['password_1'], PASSWORD_DEFAULT);
                $admin     = false;
                $vendor    = false;
        
                $addusers->execute();
                $addusers->close();
                $_SESSION['users_id'] = $users['id'];
                $_SESSION['username'] = $username;
                $_SESSION['login'] = 1;
                sessionStorage.setItem("msg", "Account successfully created!");
                sessionStorage.setItem("msg_type", "success");
                echo '<script>window.location = sessionStorage.getItem("last_url");</script>';
            }else{
                echo '<script>
                    sessionStorage.setItem("msg", "Please re-enter your password correctly!");
                    sessionStorage.setItem("msg_type", "error");
                    </script>';
            }
        }else{
            echo '<script>
            sessionStorage.setItem("msg", "Usersname already in use!");
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
    <title>Sign up</title>
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
                    <a href="..\product.php" class="nav-link">Product</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="login.php" class="btn btn-info">Log in</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top: 200px;">
        <div class="row">
            <div class="col-9" style="margin-left: 13%;">
                <h3 class="text-center">Sign Up</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="username_1" class="form-control" placeholder="Enter Username" value="<?php if(isset($_SESSION['preload-create-username'])){echo $_SESSION['preload-create-username'];}?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_1" class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_2" class="form-control" placeholder="Please re-enter the Password">
                    </div>
                    <div class="form-group float-left">
                        <input type="submit" class="btn btn-primary" value="Sign up" name="signup">
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