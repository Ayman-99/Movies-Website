<?php
include './includes/head.php';

//if user logged in, redirect him to home page
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<link rel="stylesheet" href="css/register.css" />
<body>
    <?php include './includes/header.php'; ?>

    <!-- begin Content -->
    <section>
        <div class="main-w3layouts wrapper">
            <h1>Sign Up</h1>
            <div class="main-agileinfo">
                <div class="agileits-top">
                    <form id="register-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="needs-validation" novalidate>
                        <label for="validationTooltip01">First name</label>
                        <input id="validationTooltip01" name="fname" class="text" type="text" placeholder="First Name" required="" value="<?php echo $fname; ?>">
                        <div class="valid-tooltip redColor <?php echo (in_array("Error11", $error_array) || in_array("Error12", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("Error11", $error_array)) {
                                echo "Error your first name must contains Letters only";
                            } else if ("Error12") {
                                echo "Error your first name must be between 5 and 20";
                            }
                            ?>
                        </div>  
                        <label for="validationTooltip02">Last name</label>
                        <input id='validationTooltip02' name="lname" class="text" type="text" placeholder="Last Name" required="" value="<?php echo $lname; ?>">
                        <div class="valid-tooltip redColor <?php echo (in_array("Error21", $error_array) || in_array("Error22", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("Error21", $error_array)) {
                                echo "Error your last name must contains Letters only";
                            } else if ("Error22") {
                                echo "Error your last name must be between 5 and 20";
                            }
                            ?>
                        </div>
                        <label for="validationTooltip03">Password</label>
                        <input id='validationTooltip03' name="password" class="text" type="password" placeholder="Password" required="" value="<?php echo $pass; ?>">
                        <div class="valid-tooltip redColor <?php echo (in_array("Error41", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("Error41", $error_array)) {
                                echo "Error password must be between 8 and 22 and contains at least 1 character";
                            }
                            ?>
                        </div>
                        <label for="validationTooltip04">Email</label>
                        <input id='validationTooltip04' name="email" class="text" type="email" placeholder="Email" required="" value="<?php echo $regEmail; ?>">
                        <div class="valid-tooltip redColor <?php echo (in_array("Error31", $error_array) || in_array("Error32", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("Error32", $error_array)) {
                                echo "Error email already registered";
                            } else if ("Error31") {
                                echo "Error your email is invalid";
                            }
                            ?>
                        </div>
                        <div class="wthree-text">
                            <div class="clear"> </div>
                        </div>
                        <input name="register_user" type="submit" value="SIGNUP">
                        <div style="color: #14C800;" class="valid-tooltip <?php echo (in_array("You're all set! Go ahead and login!", $error_array)) ? "" : "hidden"; ?>">
                            <?php
                            if (in_array("You're all set! Go ahead and login!", $error_array)) {
                                echo "You're all set! Go ahead and login!";
                            }
                            ?>
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

    <?php include './includes/footer.php'; ?>

