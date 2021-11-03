<?php
    require_once 'connect.php';
    function Check_Users_Update($conn, $username){
        $get_users_data = $conn->prepare("SELECT * FROM users WHERE username=?");
        $get_users_data->bind_param("s", $username);
        $get_users_data->execute();
        $result = $get_users_data->get_result();
        $users = $result->fetch_assoc();
        $get_users_data->close();
        if($users['username'] === $username){
            MsgReport("Account successfully created!", "success", "manageuser.php");
        }else{
            MsgReport("Account failed to created!", "error", "msgonly");
        }
    }
    if(isset($_SESSION['login'])){
        if($_SESSION['super_admin'] == 1 || $_SESSION['users_id'] == $_GET['id']){
            $get_privilege = $conn->prepare("SELECT * FROM privilege");
            $get_privilege->execute();
            $get_privilege_result = $get_privilege->get_result();
            $get_privilege->close();
            if(isset($_GET['id'])){
                $get_users_information = $conn->prepare("
                SELECT * FROM users WHERE id=?
                ");
                $get_users_information->bind_param("i", $id);
                $id = $_GET['id'];
                $get_users_information->execute();
                $users_info = $get_users_information->get_result();
                $result = $users_info->fetch_assoc();
                $get_users_information->close();
                if(isset($_POST['update'])){
                    if(password_verify($_POST['passverify1'], $result['password'])){
                        MsgReport("Good", "success", "msgonly");
                    }else{
                        MsgReport("Wrong Password", "error", "msgonly");
                    }
                }
            }else{
                if(isset($_POST['create'])){
                    if($_POST['username']){
                        $_SESSION['preload-create-username'] = $_POST['username'];
                        $verify_users = $conn->prepare("SELECT id, username, password FROM users WHERE username=? ");
                        $verify_users->bind_param("s", $username);
                        $username = $_POST['username'];
                        $verify_users->execute();
                        $result = $verify_users->get_result();
                        $users = $result->fetch_assoc();
                        $verify_users->close();
                        if($username != $users['username']){
                            if($_POST['passverify1'] == NULL){
                                MsgReport("Account cannot have empty password", "error", "msgonly");
                            }else if(($_POST['passverify1']) == ($_POST['passverify2'])){
                                $check_privilege = $conn->prepare("SELECT * FROM privilege WHERE privilege_name=?");
                                $check_privilege->bind_param("s", $Privilege);
                                $Privilege = $_POST['Privilege'];
                                $check_privilege->execute();
                                $result_privilege = $check_privilege->get_result();
                                $data_privilege = $result_privilege->fetch_assoc();
                                $check_privilege->close();
                                $add_users = $conn->prepare("INSERT INTO users (username, password, vendor, admin, super_admin) VALUE (?, ?, ?, ?, ?)");
                                $add_users->bind_param("ssiii", $username, $password, $vendor, $admin, $super_admin);
                                $password  = password_hash($_POST['passverify1'], PASSWORD_DEFAULT);
                                $vendor = $data_privilege['vendor'];
                                $admin = $data_privilege['admin'];
                                $super_admin = $data_privilege['super_admin'];
                                $target_dir = "../resource/image/profile/";
                                $target_file = $target_dir . basename($_FILES["product_photo"]["name"]);
                                $filetype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                // bug file always treated as non image even an image
                                if ($_FILES["product_photo"]["size"] > 500000) {
                                    $photo_name = null;
                                    MsgReport("Error : File size too large! size must below 500kb", "error", "editproduct.php?id=" . $_GET['id']);
                                }else if($filetype === "jpg" || $filetype === "png" || $filetype === "jpeg"){
                                    if(copy($_FILES["product_photo"]["tmp_name"],$target_file)){
                                        $photo_name = basename($_FILES["product_photo"]["name"]);
                                    }else{
                                        $photo_name = NULL;
                                        MsgReport("Error : Photo failed upload!", "error", "editusers.php");
                                    }
                                }else{
                                    $photo_name = NULL;
                                    MsgReport("Error : File must be an image!", "error", "editusers.php");
                                }
                                $add_users->execute();
                                $add_users->close();
                                Check_Users_Update($conn, $username);
                            }else{
                                MsgReport("Please re-enter the password correctly!", "success", "msgonly");
                            }
                        }else{
                            $_SESSION['preload-create-username'] = NULL;
                            MsgReport("Cannot use this username", "error", "msgonly");
                        }
                    }else{
                        MsgReport("Username cannot be empty", "error", "msgonly");
                    }
                }
            }
        }else{
            MsgReport("You do not have privilege over this Feature", "error", "");
        }
    }else{
        MsgReport("User must login first", "warning", "login.php");
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
        <link rel="icon" href="../resource/image/favicon.jpg">
        <?php
            if(isset($_GET['id'])){
                PageTitle("Editing User" . " - " . $result['username']);
            }else{
                PageTitle("Creating New User");
            }
        ?>
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
                                    <a href="manageuser.php" class="nav-link">Manage Users</a>
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
                            <a class="navbar-brand" href="user.php?users=' . htmlspecialchars($_SESSION['username']) . '">' . htmlspecialchars($_SESSION['username']) . '
                                <img class="profile" src="../resource/image/profile/' . htmlspecialchars($_SESSION['username']) . '.jpg" alt="">
                            </a>
                        </div>
                        ';
                        echo '<a href="logout.php" class="btn btn-danger spacing">Log out</a>';
                        }?>
                </ul>
            </div>
        </nav>
        <div class="container extend">
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="table table-hover text-center">
                    <tr>
                        <td colspan="3">
                            <h4>
                                <?php if(isset($_GET['id'])) echo 'Editing ' . $result['username']; else echo 'Create User'; ?>
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Username
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <input name="username" type="text" class="form-control" value="<?php if(isset($_GET['id'])) echo $result['username'] ?>" placeholder="enter desired username">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Upload Profile Photo
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <input name="photo" type="file" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if(isset($_GET['id'])) echo 'Current Password'; else echo 'Password'; ?>
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <input name="passverify1" type="password" class="form-control" placeholder="<?php if(isset($_GET['id'])) echo 'please enter before press confirm change'; else echo 'password'; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if(isset($_GET['id'])) echo 'New Password'; else echo 'Re-enter Password'; ?>
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <input name="passverify2" type="password" class="form-control" placeholder="<?php if(isset($_GET['id'])) echo 'fill this box if you want to change password'; else echo 'please re-enter password to confirm'; ?>">
                        </td>
                    </tr>
                    <?php
                        if(isset($_GET['id'])){
                            echo '
                                <tr>
                                    <td>
                                        Re-enter New Password
                                    </td>
                                    <td>
                                        :
                                    </td>
                                    <td>
                                        <input name="passverify3" type="password" class="form-control" placeholder="re-enter new password">
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                    <tr>
                        <td>
                            Privilege
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <select class="form-control" name="Privilege" id="">
                                <?php
                                    if(isset($_GET['id'])){
                                        if($result['vendor'] && $result['admin'] && $result['super_admin']){
                                            echo '
                                                <option value="Super Administrator">Super Administrator</option>
                                            ';
                                        }else if(!$result['vendor'] && $result['admin'] && !$result['super_admin']){
                                            echo '
                                                <option value="Administrator">Administrator</option>
                                            ';
                                        }else if($result['vendor'] && !$result['admin'] && !$result['super_admin']){
                                            echo '
                                                <option value="Vendor">Vendor</option>
                                            ';
                                        }else if(!$result['vendor'] && $result['admin'] && $result['super_admin']){
                                            echo '
                                                <option value="User Management">User Management</option>
                                            ';
                                        }else if($result['vendor'] && $result['admin'] && !$result['super_admin']){
                                            echo '
                                                <option value="Product Management">Product Management</option>
                                            ';
                                        }else if(!$result['vendor'] && !$result['admin'] && !$result['super_admin']){
                                            echo '
                                                <option value="User">User</option>
                                            ';
                                        }else{
                                            echo 'ERROR';
                                        }
                                    }else{
                                        echo '
                                            <option value=""></option>
                                        ';
                                    }
                                foreach($get_privilege_result as $row):
                                    echo '
                                        <option value="' . $row['privilege_name'] . '">' . $row['privilege_name'] . '</option>
                                    ';
                                endforeach;
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">
                            <?php
                            if(isset($_GET['id'])){
                                echo '
                                    <input id="confirm" type="submit" class="btn btn-primary" value="Update" name="update">
                                ';
                            }else{
                                echo '
                                    <input id="confirm" type="submit" class="btn btn-primary" value="Create" name="create">
                                ';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
    <script>
        error_msg();
    </script>
</html>

