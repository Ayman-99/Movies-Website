<?php
include 'config/db.php';
include 'function.php';
include './includes/classes/User.php';
$loggedIn = "";
if (isset($_SESSION['username'])) {
    $loggedIn = $_SESSION['username'];
    if (!is_Developer($loggedIn) && !is_Moderator($loggedIn)) {
        header("Location: ../../index.php");
        exit();
    }
}
$moderator = new Person($con, $loggedIn);

$error_array = array(); //Holds error messages
$username = $_SESSION['username'];
$_SESSION['lockscreen'] = "on";

if (isset($_POST["login"])) {
    $password = md5($_POST['pass']);
    $check_database_query = mysqli_query($con, "SELECT user_name,user_type FROM users WHERE user_name='$username' AND user_password='$password'");
    $check_login_query = mysqli_num_rows($check_database_query);
    if ($check_login_query == 1) {
        $row = mysqli_fetch_array($check_database_query);
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['role'] = $row['user_type'];
        unset($_SESSION['lockscreen']);
        header("Location: dashboard.php");
    } else {
        array_push($error_array, "Password is incorrect<br>");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Your Movies</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/style.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/style.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-logo">
                <a href="../../index.php"><b>YourMovies</b></a>
            </div>
            <!-- User name -->
            <div class="lockscreen-name"><?php echo $moderator->getUserName(); ?></div>

            <!-- START LOCK SCREEN ITEM -->
            <div class="lockscreen-item">
                <!-- lockscreen image -->
                <div class="lockscreen-image">
                    <img src="../../img/profile/<?php echo $moderator->getUserPic(); ?>" alt="User Image">
                </div>
                <!-- /.lockscreen-image -->

                <!-- lockscreen credentials (contains the form) -->
                <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method='POST' class="lockscreen-credentials">
                    <div class="input-group">
                        <input name='pass' type="password" class="form-control" placeholder="password">

                        <div class="input-group-btn">
                            <button name="login" type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                        </div>
                    </div>
                </form>
                <!-- /.lockscreen credentials -->
            </div>
            <!-- /.lockscreen-item -->
            <div class="help-block text-center">
                <?php if (in_array("Password is incorrect<br>", $error_array)) echo "<font color='red'>Password is incorrect</font><br>"; ?>

                Enter your password to retrieve your session and to access control panel
            </div>
            <div class="lockscreen-footer text-center">

                <strong>Copyright &copy; 2019 || Developed By: <a href="http://aymanblog.000webhostapp.com/">Ayman Hunjul</a></strong>
            </div>
        </div>
        <!-- /.center -->

        <!-- jQuery 3 -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../dist/js/demo.js"></script>

    </body>
</html>
