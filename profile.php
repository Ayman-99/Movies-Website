<?php

/*
 * Errors tags/notations:
 * 
 * Error11 : first name must contains Letters only
 * Error12 : first name must be between 5 and 20
 * Error21 : last name must contains Letters only
 * Error22 : last name must be between 5 and 20
 * Error31 : email is invalid
 * Error32 : email already registered
 * Error41 : password must be between 8 and 22
 */
include './includes/head.php';
if (!isset($_SESSION['username'])) {
    //if user not logged in redirect him
    header("Location: index.php");
}
?>

<body style="background: linear-gradient(to top, #667f93, #667f93);">
    <?php include './includes/header.php'; ?>
    <?php
    //if target in url is set means user is viewing other user profile
    if (isset($_GET['target'])) {
        $name = validation_input($_GET['target']);
        $currentObj = new Person($con, $name);
    }
    /* Update profile handler */
    $succ = "yes";
    $fname = $lname = $email = $pass = "";
    $error_array = array();
    if (isset($_POST['savedata'])) {
        $fname = validation_input($_POST['first_name']);
        $lname = validation_input($_POST['last_name']);
        $email = validation_input($_POST['email']);
        $pass = validation_input($_POST['pass']);

        $sql = "";

        $flag = false; //falses means user didn't enter password, 3 inputs
        if ($pass == "") {
            $sql = "UPDATE `users` SET `user_FName`=?,`user_LName`=?,`user_email`=? WHERE user_name='{$currentObj->getUserName()}'";
        } else {
            $flag = true; //user entered password means 4 inputs
            $sql = "UPDATE `users` SET `user_FName`=?,`user_LName`=?,`user_email`=?,user_password=? WHERE user_name='{$currentObj->getUserName()}'";
        }

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

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //Check if email is for the acc owner or not
            if ($currentObj->getEmail() !== $email) {
                if (emailExists($email)) {
                    array_push($error_array, "Error32");
                }
            }
        } else {
            array_push($error_array, "Error31");
        }
        if ($pass !== "") {
            if (strlen($pass) < 8 || strlen($pass) > 22) {
                array_push($error_array, "Error41");
            }
        }
        if (empty($error_array)) {
            if ($flag) {
                $stmt = mysqli_prepare($con, $sql);
                $pass = md5($pass);
                mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $email, $pass);
                mysqli_stmt_execute($stmt);
            } else {
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $fname, $lname, $email);
                mysqli_stmt_execute($stmt);
            }
            $succ = "no";
            header("Location: profile.php");
        }
    }
    if (isset($_POST['uploadImg'])) {
        $movie_image = $_FILES['profile_image']['name'];
        $movie_image_temp = $_FILES['profile_image']['tmp_name'];
        $error_array = valdiate_upload($movie_image, $movie_image_temp, "img/profile/$movie_image");
        if (empty($error_array)) {
            confirmQuery(mysqli_query($con, "update users set user_pic='$movie_image' where user_name='$loggedIn'"));
            header("Location: " . $_SERVER['PHP_SELF']);
        }
    }
    ?>
    <div class="container bootstrap snippet">
        <div class="row">
            <div class="col-sm-10"><h1>User Profile</h1></div>
        </div>
        <div class="row">
            <div class="col-sm-3"><!--left col-->
                <div class="text-center">
                    <img width="192" height="192" src="img/profile/<?php echo $currentObj->getUserPic(); ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                    <?php
                    if (!isset($_GET['target'])) {
                        ?>
                        <h6>Upload a different photo...</h6>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <input type="file" name='profile_image' class="text-center center-block file-upload">
                            <button type="submit" name='uploadImg' class="btn btn-primary">upload</button>
                            <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>
                        </form>
                        <?php
                    }
                    ?>
                </div>
                <br>
                <ul class="list-group">
                    <li class="list-group-item text-muted">Info <i class="fa fa-dashboard fa-1x"></i></li>
                    <?php
                    //if premium user is viewing other user profile, we hide some information
                    if (isset($_GET['target']) && is_Premium($loggedIn)) {
                        ?>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>First Name</strong></span> <?php echo $currentObj->getFName(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>User role</strong></span> <?php echo $currentObj->getUserType(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Last Name</strong></span> <?php echo $currentObj->getLName(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>User Status</strong></span><?php echo $currentObj->getUserStatus(); ?></li>
                        <?php
                    } else {
                        ?>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Username</strong></span> <?php echo $currentObj->getUserName(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>User role</strong></span> <?php echo $currentObj->getUserType(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> <?php echo $currentObj->getEmail(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>First Name</strong></span> <?php echo $currentObj->getFName(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>Last Name</strong></span> <?php echo $currentObj->getLName(); ?></li>
                        <li class="list-group-item text-right"><span class="pull-left"><strong>User Status</strong></span><?php echo $currentObj->getUserStatus(); ?></li>
                        <?php
                    }
                    ?>
                </ul> 
                <hr>
                <ul class="list-group">
                    <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Reviews</strong></span> <?php echo $currentObj->getUserData("reviews"); ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Comments</strong></span> <?php echo $currentObj->getUserData("comments"); ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Warnings</strong></span> <?php echo $currentObj->getUserData("warnings"); ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong>Votes</strong></span> <?php echo $currentObj->getUserData("votes"); ?></li>
                </ul> 
            </div><!--/col-3-->
            <div class="col-sm-9">
                <ul class="nav nav-tabs">
                    <?php
                    $active = -1; //to load active tab, 1 Home + Chat, 2 Warnings
                    if (isset($_GET['target']) && (is_Premium($loggedIn) || is_Moderator($loggedIn))) {
                        ?>
                        <li class="active"><a data-toggle="tab" href="#warnings"style="color: #000;">Warnings</a></li>
                        <?php
                        $active = 2;
                    } else if (is_Premium($_SESSION['username']) || is_Moderator($_SESSION['username'])) {
                        ?>
                        <li id="homeTab" class="active" style="color: #000;"><a data-toggle="tab" href="#home">Home</a></li>
                        <li id="chatTab" class=""><a data-toggle="tab" href="#messages" style="color: #000;">Chat</a></li>
                        <li><a data-toggle="tab" href="#warnings"style="color: #000;">Warnings</a></li>
                        <?php
                        $active = 1;
                    } else {
                        ?>
                        <li id="homeTab" class="active" style="color: #000;"><a data-toggle="tab" href="#home">Home</a></li>
                        <li><a data-toggle="tab" href="#warnings"style="color: #000;">Warnings</a></li>
                        <?php
                        $active = 1;
                    }
                    ?>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane <?php echo ($active == 1) ? "active" : ""; ?>" id="home">
                        <hr>
                        <?php
                        if (!isset($_GET['target'])) {
                            ?>
                            <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class='row'>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="first_name"><h4>First name</h4></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="enter first name" title="enter your first name if any." required="" 
                                                   value="<?php echo (empty($fname)) ? $currentObj->getFName() : $fname; ?>">
                                            <div class="valid-tooltip redColor <?php echo (in_array("Error11", $error_array) || in_array("Error12", $error_array)) ? "" : "hidden"; ?>">
                                                <?php
                                                if (in_array("Error11", $error_array)) {
                                                    echo "Error your first name must contains Letters only";
                                                } else if ("Error12") {
                                                    echo "Error your first name must be between 5 and 20";
                                                }
                                                ?>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="last_name"><h4>Last name</h4></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="enter last name" title="enter your last name if any." required="" 
                                                   value="<?php echo (empty($lname)) ? $currentObj->getLName() : $lname; ?>">
                                            <div class="valid-tooltip redColor <?php echo (in_array("Error21", $error_array) || in_array("Error22", $error_array)) ? "" : "hidden"; ?>">
                                                <?php
                                                if (in_array("Error21", $error_array)) {
                                                    echo "Error your last name must contains Letters only";
                                                } else if ("Error22") {
                                                    echo "Error your last name must be between 5 and 20";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="email"><h4>Email</h4></label>
                                            <input type="email" class="form-control email" name="email" id="email" placeholder="enter email" title="enter your email number if any." required="" 
                                                   value="<?php echo (empty($email)) ? $currentObj->getEmail() : $email; ?>" <?php echo ($currentObj->getEmail() == "guest@gmail.com") ? "readonly" : "" ?>>
                                            <div class="valid-tooltip redColor <?php echo (in_array("Error31", $error_array) || in_array("Error32", $error_array)) ? "" : "hidden"; ?>">
                                                <?php
                                                if (in_array("Error32", $error_array)) {
                                                    echo "Error email already registered";
                                                } else if ("Error31") {
                                                    echo "Error your email is invalid";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="pass"><h4>Password</h4></label>
                                            <input type="password" class="form-control w3lpass" name="pass" id="pass" placeholder="enter password" title="enter your password" <?php echo ($currentObj->getEmail() == "guest@gmail.com") ? "readonly value='123456789'" : "" ?>>
                                            <div class="valid-tooltip redColor <?php echo (in_array("Error41", $error_array)) ? "" : "hidden"; ?>">
                                                <?php
                                                if (in_array("Error41", $error_array)) {
                                                    echo "Error password must be between 8 and 22.";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button name="savedata" class="btn btn-lg btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
                                        <button class="btn btn-lg" type="reset"><i class="fa fa-redo"></i> Reset</button>
                                    </div>
                                </div>
                            </form>
                            <?php
                        } else {
                            //if moderator is viewing other profiles he can update them from control panel
                            echo "<a class='btn btn-primary' href='admin/pages/profile.php?target={$currentObj->getUserName()}'> Edit </a>";
                        }
                        ?>
                        <hr>
                    </div><!--/tab-pane-->
                    <?php
                    if (!isset($_GET['target'])) {
                        ?>
                        <div class="tab-pane" id="messages">
                            <h2></h2>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="panel" style="background-color: transparent; border: none;">
                                            <div class="panel-heading">
                                                <span class="fa fa-comments"></span> Chat
                                                <div class="btn-group pull-right">
                                                    <span class="dropdown-toggle" data-toggle="dropdown" class="fa fa-caret-down">Contacts</span>
                                                    <ul class="dropdown-menu slidedown">
                                                        <?php
                                                        $query = "select user_name from users where user_type='Developer' AND user_name != '$loggedIn'";
                                                        $result = mysqli_query($con, $query);
                                                        confirmQuery($result);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            ?>
                                                            <li><a id="loadContact" href="profile.php?chat=<?php echo $row['user_name']; ?>"><span class="fa fa-user"></span><?php echo $row['user_name']; ?></a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="resultBox" class="panel-body" style="overflow: auto;">
                                                <div class="chat-container">
                                                    <p style="color: black;">Click on Contact > Click on user's picture > back here</p>
                                                </div>    
                                            </div>
                                            <form id="send-mes" action="includes/handlers/messages_handler.php" method="POST">
                                                <div class="panel-footer" style="background-color: transparent; border: none;">
                                                    <div class="input-group">
                                                        <input id="mess_input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." />
                                                        <span class="input-group-btn">
                                                            <span class="input-group-btn">
                                                                <input type="submit" class="btn btn-warning btn-sm" value="Send">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            <script>
                                                //chat functionality
                                                $(document).ready(function () {
    <?php
    if (isset($_GET['chat'])) {
        $target = validation_input($_GET['chat']);
        ?>
                                                        setInterval(function () {
                                                            $.get("includes/handlers/messages_handler.php" + "?to=<?php echo $loggedIn; ?>&from=<?php echo $target; ?>", function (data) {
                                                                $("#resultBox").html(data);
                                                            });
                                                        }, 1000);
        <?php
    }
    ?>
                                                    $("#send-mes").submit(function (evt) {
                                                        evt.preventDefault();
                                                        var postData = $(this).serialize();
                                                        var editserialize = decodeURIComponent(postData.replace(/%2F/g, " "));
                                                        editserialize = editserialize.substr(8);
                                                        var url = $(this).attr('action');
                                                        $.ajax({
                                                            url: url,
                                                            type: 'POST',
                                                            data: {from: "<?php echo $loggedIn; ?>", message: editserialize,
                                                                to: "<?php echo $target = validation_input($_GET['chat']); ?>"},
                                                            success: function (show_messages) {
                                                                if (!show_messages.error) {
                                                                    document.getElementById("mess_input").value = "";
                                                                }
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--/tab-pane-->
                        <?php
                    }
                    ?>
                    <div class="tab-pane <?php echo ($active == 2) ? "active" : ""; ?>" id="warnings">
                        <hr>
                        <ul id="load-warnings" class="list-group">

                        </ul>
                    </div>

                </div><!--/tab-pane-->
            </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
    <?php include './includes/footer.php'; ?>
