<?php
/*
 * Errors tags/notations:
 * 
 * Error11 : first name must contains Letters only
 * Error12 : first name must be between 5 and 20
 * Error21 : last name must contains Letters only
 * Error22 : last name must be between 5 and 20
 */

include './includes/head.php';
?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include './includes/header.php'; ?>

        <?php
        include './includes/side-nav.php';
        $currentObj = "";
        $userObj = "";
        $success = "";
        if (isset($_GET['target'])) {
            $user = validation_input($_GET['target']);
            $userObj = new Person($con, $user);
            $currentObj = $userObj;
        } else {
            $currentObj = $moderator;
        }
        $username = $profile_img = $pass = $email = $fname = $lname = "";
        $profile_img = $currentObj->getUserPic();
        //no check if email exists validation. Can make function in the db, Pass need to be encrypted
        $error_array = array();
        if (isset($_POST['save_user_data'])) {
            $flag1 = $flag2 = false; //$flag2 one for pass, flag 1 for img
            $sql = "";
            $username = validation_input($_POST['username']);
            $email = validation_input($_POST['Email']);
            $fname = validation_input($_POST['FirstName']);
            $lname = validation_input($_POST['LastName']);

            if (!ctype_alpha($fname)) {
                array_push($error_array, "Error11");
            }
            if (strlen($fname) < 5 || strlen($fname) > 20) {
                array_push($error_array, "Error12");
            }

            if (!ctype_alpha($lname)) {
                array_push($error_array, "Error21");
            }
            if (strlen($lname) < 5 || strlen($lname) > 20) {
                array_push($error_array, "Error22");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($error_array, "Error your email is invalid");
            } else if ($currentObj->getEmail() !== $email) {
                //Check if email is for the acc owner or not
                if (emailExists($email)) {
                    array_push($error_array, "Error email already registered");
                }
            }
            if ($_FILES['profile_img']['error'] !== 4) {
                $profile_img = $_FILES['profile_img']['name'];
                $profile_image_temp = $_FILES['profile_img']['tmp_name'];
                $error_array = valdiate_upload($profile_img, $profile_image_temp, "../../img/profile/$profile_img");
                $flag1 = true;
            }

            if (!empty($_POST['pass'])) {
                if (strlen($_POST['pass']) < 8 || strlen($_POST['pass']) > 22) {
                    array_push($error_array, "Error password must be between 8 and 22");
                } else {
                    $pass = validation_input($_POST['pass']);
                    $pass = md5($pass);
                    $flag2 = true;
                }
            } else {
                
            }
            if ($flag1 && $flag2) {
                $sql = "UPDATE `users` SET `user_pic`='$profile_img',`user_password`='$pass',`user_FName`='$fname',`user_LName`='$lname',`user_email`='$email' WHERE user_name='$username'";
            } else if ($flag1) {
                $sql = "UPDATE `users` SET `user_pic`='$profile_img',`user_FName`='$fname',`user_LName`='$lname',`user_email`='$email' WHERE user_name='$username'";
            } else if ($flag2) {
                $sql = "UPDATE `users` SET `user_password`='$pass',`user_FName`='$fname',`user_LName`='$lname',`user_email`='$email' WHERE user_name='$username'";
            } else {
                $sql = "UPDATE `users` SET `user_FName`='$fname',`user_LName`='$lname',`user_email`='$email' WHERE user_name='$username'";
            }
            if (empty($error_array)) {
                confirmQuery(mysqli_query($con, $sql));
                //as new info updated we update current object if its mod or dev we make new moderator class else Person
                if (is_Moderator($username) || is_Developer($username)) {
                    $currentObj = new Moderator($con, $username);
                } else {
                    $currentObj = new Person($con, $username);
                }
                $success = "Updated";
            }
        }
        ?>
        <style>
            .marginLeft{
                margin-left: 18%;
                color: red;
            }
        </style>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    User Profile
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Profile</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php
                                //to load either target user pic or current user
                                if (is_object($userObj)) {
                                    ?>
                                    <img class="profile-user-img img-responsive img-circle" src="../../img/profile/<?php echo $currentObj->getUserPic(); ?>" alt="Profile">

                                    <h3 class="profile-username text-center"><?php echo $currentObj->getUserName(); ?></h3>

                                    <p class="text-muted text-center"><?php echo $currentObj->getUserType(); ?></p>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Number of warnings</b> <a class="pull-right"><?php echo $currentObj->getNumOfWarnings(); ?> </a>
                                        </li>
                                    </ul>
                                    <?php
                                } else {
                                    ?>
                                    <img class="profile-user-img img-responsive img-circle" src="../../img/profile/<?php echo $currentObj->getUserPic(); ?>" alt="Profile">

                                    <h3 class="profile-username text-center"><?php echo $currentObj->getUserName(); ?></h3>

                                    <p class="text-muted text-center"><?php echo $currentObj->getUserType(); ?></p>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Number of issued warnings</b> <a class="pull-right"><?php echo $currentObj->getNumberOfIssuedWarning(); ?> </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Number of added movies</b> <a class="pull-right"><?php echo $currentObj->getUserInsertedMovies(); ?> </a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-pane" id="settings">
                                <form action="<?php echo (is_object($userObj)) ? $_SERVER['PHP_SELF'] . "?target={$currentObj->getUserName()}" : $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="userName" class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input name='username' type="text" class="form-control" id="userName" placeholder="Enter Username" value="<?php echo $currentObj->getUserName(); ?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="passWord" class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-10">
                                            <input name='pass' type="password" class="form-control" id="passWord" placeholder="Enter Password" value="">
                                        </div>
                                        <div class="marginLeft  <?php echo (in_array("Error password must be between 8 and 22", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error password must be between 8 and 22", $error_array)) {
                                                echo "Error password must be between 8 and 22";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input name='Email' type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo $currentObj->getEmail(); ?>" required="">
                                        </div>
                                        <div class="marginLeft  <?php echo (in_array("Error email already registered", $error_array) || in_array("Error your email is invalid", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error email already registered", $error_array)) {
                                                echo "Error email already registered";
                                            } else if (in_array("Error your email is invalid")) {
                                                echo "Error your email is invalid";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-left: 10%;">
                                        <label>Profile Picture</label>
                                        <input style="display: inline; padding-left: 3px;" type="file" name="profile_img">
                                        <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="FName" class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input name='FirstName' type="text" class="form-control" id="FName" placeholder="Enter First Name" value="<?php echo $currentObj->getFName(); ?>" required="">
                                        </div>
                                        <div class="marginLeft <?php echo (in_array("Error11", $error_array) || in_array("Error12", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error11", $error_array)) {
                                                echo "Error your first name must contains Letters only";
                                            } else if ("Error12") {
                                                echo "Error your first name must be between 5 and 20";
                                            }
                                            ?>
                                        </div>  
                                    </div>
                                    <div class="form-group">
                                        <label for="LName" class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input name='LastName' type="text" class="form-control" id="LName" placeholder="Enter Last Name" value="<?php echo $currentObj->getLName(); ?>" required="">
                                        </div>
                                        <div class="vmarginLeft <?php echo (in_array("Error21", $error_array) || in_array("Error22", $error_array)) ? "" : "hidden"; ?>">
                                            <?php
                                            if (in_array("Error21", $error_array)) {
                                                echo "Error your last name must contains Letters only";
                                            } else if ("Error22") {
                                                echo "Error your last name must be between 5 and 20";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10" style="margin-left: 17%;">
                                            <input name="save_user_data" type="submit" class="btn btn-primary" value="Save Data">
                                        </div>
                                    </div>
                                    <p class='marginLeft'><?php echo $success; ?></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php
        include './includes/footer.php';
        ?>















































































































































































