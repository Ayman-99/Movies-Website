<?php
session_start();
$flag = 0;
$db_schema_sucess = $db_create_success = "";
if (isset($_POST['confirm'])) {
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];
    setcookie("db_name", $_POST['db_name'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_user", $_POST['db_user'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_pass", $_POST['db_pass'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("db_host", $_POST['db_host'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("em_add", $_POST['email_address'], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("em_pass", $_POST['email_pass'], time() + (10 * 365 * 24 * 60 * 60));
    $con = mysqli_connect($db_host, $db_user, $db_pass);
    if (!$con) {
        $db_con_error = "Failed to connect: " . mysqli_connect_error($con);
        die($db_con_error);
    } else {
        $flag = 1;
    }
    if ($flag == 1) {
        if (!mysqli_query($con, "create database " . $db_name)) {
            $db_create_error = "Failed to create the db " . mysqli_error($con);
        } else {
            $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
            $db_create_success = "Database has been created successfully";
        }
        $sql = "
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
);
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_date` date NOT NULL,
  `comment_topic` int(11) NOT NULL
) ;
CREATE TABLE `comments_view` (
`comment_id` int(11)
,`comment_content` text
,`comment_date` date
,`user_pic` text
,`user_name` varchar(255)
,`user_FName` varchar(255)
,`user_LName` varchar(255)
,`movie_id` int(11)
);
CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `msg_from` varchar(255) NOT NULL,
  `msg_to` varchar(255) NOT NULL,
  `msg_body` text,
  `msg_date` date NOT NULL
);
CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_Name` varchar(255) NOT NULL,
  `movie_URL` text NOT NULL,
  `movie_image` varchar(255) NOT NULL,
  `movie_director` varchar(255) NOT NULL,
  `movie_length` varchar(10) NOT NULL,
  `movie_release_date` date NOT NULL,
  `movie_language` varchar(255) NOT NULL,
  `movie_description` text NOT NULL,
  `movie_views` int(11) NOT NULL,
  `movie_added_by` varchar(255) NOT NULL,
  `movie_category_id` int(11) DEFAULT NULL
);
CREATE TABLE `movie_info` (
`movie_id` int(11)
,`movie_views` int(11)
,`movie_Name` varchar(255)
,`movie_image` varchar(255)
,`category_name` varchar(255)
);
CREATE TABLE `notifications` (
  `notfiy_id` int(11) NOT NULL,
  `notfiy_from` varchar(255) NOT NULL,
  `notfiy_content` text
);
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `review_author` varchar(255) NOT NULL,
  `review_on` int(11) NOT NULL,
  `review_type` enum('like','dislike') DEFAULT NULL
);
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_type` varchar(255) DEFAULT NULL,
  `setting_status` enum('ON','OFF') DEFAULT NULL,
  `setting_period` datetime DEFAULT NULL
);
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_pic` text NOT NULL,
  `user_FName` varchar(255) NOT NULL,
  `user_LName` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_type` enum('Developer','Moderator','Premium','Regular') DEFAULT 'Regular',
  `user_status` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive',
  `user_online` enum('Online','Offline') NOT NULL,
  `user_session` varchar(255) DEFAULT NULL,
  `user_token` varchar(255) DEFAULT NULL
);
INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_pic`, `user_FName`, `user_LName`, `user_email`, `user_type`, `user_status`, `user_online`, `user_session`, `user_token`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', 'avatar5.png', 'Root1', 'Root2', 'root@gmail.com', 'Developer', 'Active', 'Online', 'hom8ukce57bn964os9am3t67ca', 'a95cfb7e3475090cfbfa728010d2b0b19205fb4d03f9e0ec98b4af80418d9d9e47b2981a5ea4726af764f175a039922cea80');
CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `vote_by` varchar(255) NOT NULL,
  `vote_on` int(11) NOT NULL,
  `vote_hit` int(11) NOT NULL,
  `vote_date` date NOT NULL
);
CREATE TABLE `warnings` (
  `warn_id` int(11) NOT NULL,
  `warn_content` varchar(255) NOT NULL,
  `warn_by` varchar(255) NOT NULL,
  `warn_to` varchar(255) NOT NULL,
  `warn_date` date NOT NULL
);
DROP TABLE IF EXISTS `comments_view`;
CREATE VIEW `comments_view`  AS  select `comments`.`comment_id` AS `comment_id`,`comments`.`comment_content` AS `comment_content`,`comments`.`comment_date` AS `comment_date`,`users`.`user_pic` AS `user_pic`,`users`.`user_name` AS `user_name`,`users`.`user_FName` AS `user_FName`,`users`.`user_LName` AS `user_LName`,`movies`.`movie_id` AS `movie_id` from ((`comments` join `users` on((`comments`.`comment_author` = `users`.`user_name`))) join `movies` on((`comments`.`comment_topic` = `movies`.`movie_id`))) ;
DROP TABLE IF EXISTS `movie_info`;
CREATE VIEW `movie_info`  AS  select `movies`.`movie_id` AS `movie_id`,`movies`.`movie_views` AS `movie_views`,`movies`.`movie_Name` AS `movie_Name`,`movies`.`movie_image` AS `movie_image`,`categories`.`category_name` AS `category_name` from (`movies` join `categories` on((`movies`.`movie_category_id` = `categories`.`category_id`))) ;
;
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_aut_fk` (`comment_author`),
  ADD KEY `comment_mov_id` (`comment_topic`);
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `messages_to_1` (`msg_to`),
  ADD KEY `messages_from_2` (`msg_from`);
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD KEY `movie_added_by` (`movie_added_by`),
  ADD KEY `movie_category_id` (`movie_category_id`);
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notfiy_id`),
  ADD KEY `notfiy_from` (`notfiy_from`);
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_author` (`review_author`),
  ADD KEY `review_on` (`review_on`);
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD KEY `like_author_fk` (`vote_by`),
  ADD KEY `movie_id_fk` (`vote_on`);
ALTER TABLE `warnings`
  ADD PRIMARY KEY (`warn_id`),
  ADD KEY `warn_fk_1` (`warn_by`),
  ADD KEY `warn_fk_2` (`warn_to`);
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `notifications`
  MODIFY `notfiy_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `warnings`
  MODIFY `warn_id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_aut_fk` FOREIGN KEY (`comment_author`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_mov_id` FOREIGN KEY (`comment_topic`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_2` FOREIGN KEY (`msg_from`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_to_1` FOREIGN KEY (`msg_to`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`movie_added_by`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movies_ibfk_2` FOREIGN KEY (`movie_category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`notfiy_from`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`review_author`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`review_on`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `votes`
  ADD CONSTRAINT `like_author_fk` FOREIGN KEY (`vote_by`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movie_id_fk` FOREIGN KEY (`vote_on`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `warnings`
  ADD CONSTRAINT `warn_fk_1` FOREIGN KEY (`warn_by`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `warn_fk_2` FOREIGN KEY (`warn_to`) REFERENCES `users` (`user_name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;";
        if (!mysqli_multi_query($con, $sql)) {
            $db_schema_error = "Database objects have not been created successfully , " . mysqli_error($con);
        } else {
            $db_schema_sucess = "Database schema has been created successfully";
        }
		mysqli_close($con);
		$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        $sql = "CREATE PROCEDURE `get_review`(IN `type` VARCHAR(255), IN `target` VARCHAR(10))
   NO SQL
BEGIN
declare
 result int;
if type LIKE 'like' THEN
 select count(review_id) into result from reviews where     review_on=target AND review_type='like';
ELSEIF type LIKE 'dislike' THEN
 select count(review_id) into result from reviews where     review_on=target AND review_type='dislike';
END IF;
select result;
END";
        if (!mysqli_multi_query($con, $sql)) {
            $db_schema_error = "Database objects have not been created successfully , " . mysqli_error($con);
        } else {
            $db_schema_sucess = "Database schema has been created successfully";
        }
		mysqli_close($con);
		$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        $sql = "CREATE PROCEDURE `insert_review`(IN `author` VARCHAR(255), IN `target` VARCHAR(10), IN `type` VARCHAR(255))
   NO SQL
BEGIN
declare
 flag int;
if type LIKE 'like' THEN
 select count(review_id) into flag from reviews where     review_on=target AND review_author=author;
ELSEIF type LIKE 'dislike' THEN
 select count(review_id) into flag from reviews where     review_on=target AND review_author=author;
END IF;
if flag > 0 THEN
 select 'You already reviewed' as result;
else
 insert into reviews values (null, author, target, type);
 select 'Review added' as result;
end if;
END";
        if (!mysqli_multi_query($con, $sql)) {
            $db_schema_error = "Database objects have not been created successfully , " . mysqli_error($con);
        } else {
            $db_schema_sucess = "Database schema has been created successfully";
        }
		mysqli_close($con);
		$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        $sql = "CREATE PROCEDURE `login`(IN `u_email` VARCHAR(255), IN `u_pass` VARCHAR(255), IN `u_session` TEXT)
   NO SQL
BEGIN
declare
 em varchar(255);
DECLARE
 pass varchar(255);
DECLARE
 role varchar(255);
DECLARE
 username varchar(255);
DECLARE
 stat varchar(255);
 
 select user_email, user_password, user_name, user_type, user_status INTO
 em, pass,username, role, stat from users where user_email=u_email AND user_password=u_pass;
  if ISNULL(em) AND ISNULL(pass) THEN
     SET username = 'NAN';
  ELSEIF stat = 'Active' THEN
   update users SET user_online='Online', user_session=u_session            where user_name=username;
  ELSE
     set stat = 'Account is inactive';
  END IF;
         select username,role,stat;
END";
        if (!mysqli_multi_query($con, $sql)) {
            $db_schema_error = "Database objects have not been created successfully , " . mysqli_error($con);
        } else {
            $db_schema_sucess = "Database schema has been created successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>SkyFall</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <style>
            body{ 
                margin-top:40px; 
            }
            .stepwizard-step p {
                margin-top: 10px;
            }
            .stepwizard-row {
                display: table-row;
            }
            .stepwizard {
                display: table;
                width: 100%;
                position: relative;
            }
            .stepwizard-step button[disabled] {
                opacity: 1 !important;
                filter: alpha(opacity=100) !important;
            }
            .stepwizard-row:before {
                top: 14px;
                bottom: 0;
                position: absolute;
                content: " ";
                width: 100%;
                height: 1px;
                background-color: #ccc;
                z-order: 0;
            }
            .stepwizard-step {
                display: table-cell;
                text-align: center;
                position: relative;
            }
            .btn-circle {
                width: 30px;
                height: 30px;
                text-align: center;
                padding: 6px 0;
                font-size: 12px;
                line-height: 1.428571429;
                border-radius: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="installer.php">
                <div class="row setup-content" id="step-1">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 1 (Database information)</h3>
                            <div class="form-group">
                                <label class="control-label">Database Host</label>
                                <input id="db_host" name='db_host'  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB Host"  />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Username</label>
                                <input id="db_user" name='db_user' maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB username" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Password</label>
                                <input id="db_pass" name='db_pass' maxlength="100" type="text" class="form-control" placeholder="Enter DB password (leave blank if username don't have password)" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Database Name</label>
                                <input id="db_name" name='db_name' maxlength="100" type="text" required="required" class="form-control" placeholder="Enter DB name" />
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 2 (Email information `OPTIONAL`)</h3>
                            <h6>Gmail emails used by default. This email can be used to send emails to clients and help them in recovery their password<br>
                                you can add it later on by editing "contact.php"</h6>
                            <div class="form-group">
                                <label class="control-label">Email address</label>
                                <input id="em_address" name='email_address' maxlength="200" type="email" class="form-control" placeholder="Enter Email" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email password</label>
                                <input id="em_pass" name='email_pass' maxlength="200" type="password" class="form-control" placeholder="Enter Password"  />
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 3 (Confirmation)</h3>
                            <input name='confirm' class="btn-success btn-lg pull-left" type="submit" value='Finish!'>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if ($flag == 1) {
                ?>
                <div class="col-md-12">
                    <h3> Notes</h3>
                    <ul>
                        <?php echo isset($db_con_error) ? "<li style='color: red'>$db_con_error</li>" : ""; ?>
                        <?php echo isset($db_create_error) ? "<li style='color: red'>$db_create_error</li>" : ""; ?>
                        <?php echo isset($db_schema_error) ? "<li style='color: red'>$db_schema_error</li>" : ""; ?>
                        <li style="color: green"><?php echo $db_create_success; ?></li>
                        <li style="color: green"><?php echo $db_schema_sucess; ?></li>
                        <li>Default account details:<br> Email : root@gmail.com  <br> password : root</li>
                        <br>
                        <li>If you want to change database connection, check db.php files. By default the data you entered are stored in cookies... <a id="home-page" href="index.php">Website home page</a></li>
                    </ul>

                </div>
                <?php
            }
            ?>
        </div>
    </body>
</html>
<script>
    $(document).ready(function () {
        $('#home-page').click(function (e) {
            $.get("installer.php?remove=1", function (data) {
                //Do something
            });
        });
        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');
        allWells.hide();
        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);
            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });
        allNextBtn.click(function () {
            var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url']"),
                    isValid = true;
            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }
            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });
        $('div.setup-panel div a.btn-primary').trigger('click');
    });
</script>
<?php
if (isset($_GET['remove'])) {
    unlink("installer.php");
}
?>
