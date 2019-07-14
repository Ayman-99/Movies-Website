<?php
include './includes/head.php';

if (!isset($_GET['email']) && !isset($_GET['token'])) {
    header("Location: index.php");
    exit;
}
$em = validation_input($_GET['email']);
$token = $_GET['token'];
$result = mysqli_query($con, "select user_token, user_email from users where user_email='$em'");
if (!$result) {
    die(mysqli_error($con));
}
$row = mysqli_fetch_array($result);

$user_email = $row['user_email'];
$user_token = $row['user_token'];

if ($em !== $user_email && $token !== $user_token) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['update_pass'])) {
    $pass1 = validation_input($_POST['new_pass']);
    if (strlen($pass1 > 22 || strlen($pass1) < 8)) {
        array_push($error_array, "Error password must be between 8 and 22");
    }
    if (empty($error_array)) {
        $pass1 = md5($pass1);
        $query_result = mysqli_query($con, "update users set user_password='$pass1' where user_email='$user_email'");
        if (!$query_result) {
            die(mysqli_error($con));
        }
        echo "<script>"
        . "alert('Password has been updated, you can login');"
                . "window.location.href = 'index.php'</script>";
        exit;
    }
}
?>
<link rel="stylesheet" href="css/register.css" />
<body>
    <!-- begin Content -->
    <section>
        <div class="main-w3layouts wrapper" style="height: 700px;">
            <h1>Forgot Password</h1>
            <div class="main-agileinfo">
                <div class="agileits-top">
                    <form action="reset.php?email=<?php echo $user_email; ?>&token=<?php echo $user_token; ?>" method="post">
                        <div class="form-group has-feedback">
                            <input name="new_pass" type="password" class="form-control" placeholder="New Password">
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button name="update_pass" type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                            </div>
                            <?php
                            if (in_array("Error password must be between 8 and 22", $error_array)) {
                                echo "<font color='red'>Error password must be between 8 and 22</font><br>";
                            }
                            ?>
                            <!-- /.col -->
                        </div>
                    </form>
                    <div style="color: #14C800;" class="valid-tooltip">
                        <a style="color: blue;" href="index.php">Back to home page</a>
                    </div>
                </div>
            </div>
            <ul class="colorlib-bubbles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </section>

    <!-- Custom -->
    <script src="js/script.js"  ></script>
