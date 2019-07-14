<?php
include './includes/head.php';
include './includes/handlers/forgot_handler.php';
if (!isset($_GET['id'])) {
     header("Location: index.php");
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
                    <form id="register-form" action="forgot.php?id=<?php echo uniqid(); ?>" method="post" class="needs-validation">
                        <label for="validationTooltip04">Email</label>
                        <input id='validationTooltip04' name="email" class="text" type="email" placeholder="Email" required="" value="<?php echo $email; ?>">
                        <div class="valid-tooltip redColor <?php echo (in_array("Invalid email format<br>", $error_array) || in_array("Email doesn't exists<br>", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("Invalid email format<br>", $error_array)) {
                                echo "Invalid email format";
                            } else if (in_array("Email doesn't exists<br>", $error_array)) {
                                echo "Email doesn't exists";
                            }
                            ?>
                        </div>
                        <div class="wthree-text">
                            <div class="clear"> </div>
                        </div>
                        <input name="forgot_pass" type="submit" value="RESET PASSWORD">
                        <div style="color: #14C800;" class="valid-tooltip <?php echo (in_array("Message has been sent, check your inbox<br>", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            echo "Message has been sent, check your inbox<br>";
                            ?>
                        </div>
                        <br>
                        <div style="color: #14C800;" class="valid-tooltip">
                            <a style="color: blue;" href="index.php">Back to home page</a>
                        </div>
                    </form>
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
