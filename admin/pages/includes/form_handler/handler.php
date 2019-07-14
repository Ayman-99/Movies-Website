<?php
/*
 * This handler for control panel pages, to get details from db and to update records      TABLE HANDLER
 */
include '../../config/db.php';
include '../../function.php';

/* for searching */
if (isset($_GET['search_source']) && isset($_GET['key'])) {
    $source = validation_input($_GET['search_source']);
    $key = validation_input($_GET['key']);
    switch ($source) {
        case "users.php":
            $result = mysqli_query($con, "Select * from users where user_type != 'Developer' AND user_name like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['user_id']; ?></th>
                    <th><a href="profile.php?target=<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></a></th>
                    <th><img src="../../img/profile/<?php echo $row['user_pic']; ?>" width="100" height="100"></th>
                    <th><?php echo $row['user_FName']; ?></th>
                    <th><?php echo $row['user_LName']; ?></th>
                    <th><?php echo $row['user_email']; ?></th>
                    <th><?php echo $row['user_type']; ?></th>
                    <th><?php echo $row['user_status']; ?></th>
                    <th><?php echo $row['user_online']; ?></th>
                    <th>
                        <a onclick="setUserChanges('active', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Active</a><br>
                        <a onclick="setUserChanges('inactive', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Inactive</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('online', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Online</a><br>
                        <a onclick="setUserChanges('offline', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Offline</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('moderator', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Moderator</a><br>
                        <a onclick="setUserChanges('premium', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Premium</a><br>
                        <a onclick="setUserChanges('regular', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Regular</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Delete</a><br>
                    </th>
                </tr>
                <?php
            }
            break;
        case "messages.php":
            $query = "select * from messages where msg_body like '%{$key}%'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['msg_id']; ?></td>
                    <td><?php echo $row['msg_from']; ?></td>
                    <td><?php echo $row['msg_to']; ?> </td>
                    <td><?php echo $row['msg_body']; ?> </td>
                    <td><?php echo $row['msg_date']; ?> </td>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['msg_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;
        case "movies.php":
            $result = mysqli_query($con, "Select * from movies "
                    . "inner join categories on movies.movie_category_id=categories.category_id where movies.movie_name like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['movie_id']; ?></th>
                    <th><?php echo $row['movie_Name']; ?></th>
                    <th><?php echo substr($row['movie_URL'], 0, 20) . "..."; ?></th>
                    <th><img src="../../img/tv/<?php echo $row['movie_image']; ?>" width="100" height="100"></th>
                    <th><?php echo $row['movie_director']; ?></th>
                    <th><?php echo $row['movie_length']; ?></th>
                    <th><?php echo $row['movie_release_date']; ?></th>
                    <th><?php echo $row['movie_language']; ?></th>
                    <th><?php echo substr($row['movie_description'], 0, 40) . "..."; ?></th>
                    <th><?php echo $row['movie_views']; ?></th>
                    <th><?php echo $row['movie_added_by']; ?></th>
                    <th><?php echo $row['category_name']; ?></th>
                    <th>
                        <a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['movie_id']; ?>')">Delete</a><br>
                    </th>
                    <th>
                        <a href="<?php echo $source . "?id=" . $row['movie_id'] ?>">Edit</a><br>
                    </th>
                </tr>
                <?php
            }
            break;

        case "categories.php":
            $result = mysqli_query($con, "Select * from categories where category_name like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['category_id']; ?></th>
                    <th><?php echo $row['category_name']; ?></th>
                    <th><a href="<?php echo $source . "?id={$row['category_id']}&name={$row['category_name']}"; ?>">Edit</a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['category_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "comments.php":
            $result = mysqli_query($con, "Select comments.comment_id, comments.comment_author, comments.comment_content,comments.comment_date, movies.movie_Name, movies.movie_id "
                    . "from comments inner join movies on comments.comment_topic=movies.movie_id where comments.comment_author like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['comment_id']; ?></th>
                    <th><?php echo $row['comment_author']; ?></th>
                    <th><?php echo $row['comment_content']; ?></th>
                    <th><?php echo $row['comment_date']; ?></th>
                    <th><a href='../../movie_profile.php?id=<?php echo $row['movie_id']; ?>'><?php echo $row['movie_Name']; ?></a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['comment_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "notifications.php":
            $result = mysqli_query($con, "Select * from notifications where notfiy_content like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['notfiy_id']; ?></th>
                    <th><?php echo $row['notfiy_from']; ?></th>
                    <th><?php echo $row['notfiy_content']; ?></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['notfiy_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "reviews.php":
            $result = mysqli_query($con, "Select reviews.review_id, reviews.review_author, reviews.review_type, movies.movie_name "
                    . "from reviews inner join movies on reviews.review_on=movies.movie_id where reviews.review_author like '%{$key}%'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['review_id']; ?></th>
                    <th><?php echo $row['review_author']; ?></th>
                    <th><?php echo $row['movie_name']; ?></th>
                    <th><?php echo $row['review_type']; ?></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['review_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "settings.php":
            $query = "select * from settings";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['setting_id']; ?></td>
                    <td><?php echo $row['setting_type']; ?></td>
                    <td><?php echo $row['setting_status']; ?> </td>
                    <td><?php echo $row['setting_period']; ?> </td>
                    <td>
                        <a onclick="setUserChanges('on', '<?php echo $source; ?>', '<?php echo $row['setting_id']; ?>')">ON</a><br>
                        <a onclick="setUserChanges('off', '<?php echo $source; ?>', '<?php echo $row['setting_id']; ?>')">OFF</a><br>
                    </td>
                </tr>
                <?php
            }
            break;

        case "warnings.php":
            $query = "select * from warnings where warn_content like '%{$key}%'";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['warn_id']; ?></td>
                    <td><?php echo $row['warn_content']; ?></td>
                    <td><?php echo $row['warn_by']; ?> </td>
                    <td><?php echo $row['warn_to']; ?> </td>
                    <td><?php echo $row['warn_date']; ?> </td>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['warn_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;
    }
}
/* for getting data to tables*/
if (isset($_GET['getData'])) {
    $source = validation_input($_GET['getData']);
    switch ($source) {
        case "users.php":
            $result = mysqli_query($con, "Select * from users where user_type != 'Developer'");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['user_id']; ?></th>
                    <th><a href="profile.php?target=<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></a></th>
                    <th><img src="../../img/profile/<?php echo $row['user_pic']; ?>" width="100" height="100"></th>
                    <th><?php echo $row['user_FName']; ?></th>
                    <th><?php echo $row['user_LName']; ?></th>
                    <th><?php echo $row['user_email']; ?></th>
                    <th><?php echo $row['user_type']; ?></th>
                    <th><?php echo $row['user_status']; ?></th>
                    <th><?php echo $row['user_online']; ?></th>
                    <th>
                        <a onclick="setUserChanges('active', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Active</a><br>
                        <a onclick="setUserChanges('inactive', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Inactive</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('online', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Online</a><br>
                        <a onclick="setUserChanges('offline', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Offline</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('moderator', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Moderator</a><br>
                        <a onclick="setUserChanges('premium', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Premium</a><br>
                        <a onclick="setUserChanges('regular', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Regular</a>
                    </th>
                    <th>
                        <a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['user_id']; ?>')">Delete</a><br>
                    </th>
                </tr>
                <?php
            }
            break;
        case "messages.php":
            $query = "select * from messages";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['msg_id']; ?></td>
                    <td><?php echo $row['msg_from']; ?></td>
                    <td><?php echo $row['msg_to']; ?> </td>
                    <td><?php echo $row['msg_body']; ?> </td>
                    <td><?php echo $row['msg_date']; ?> </td>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['msg_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;
            break;
        case "movies.php":
            $result = mysqli_query($con, "Select * from movies "
                    . "inner join categories on movies.movie_category_id=categories.category_id");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['movie_id']; ?></th>
                    <th><?php echo $row['movie_Name']; ?></th>
                    <th><?php echo substr($row['movie_URL'], 0, 20) . "..."; ?></th>
                    <th><img src="../../img/tv/<?php echo $row['movie_image']; ?>" width="100" height="100"></th>
                    <th><?php echo $row['movie_director']; ?></th>
                    <th><?php echo $row['movie_length']; ?></th>
                    <th><?php echo $row['movie_release_date']; ?></th>
                    <th><?php echo $row['movie_language']; ?></th>
                    <th><?php echo substr($row['movie_description'], 0, 40) . "..."; ?></th>
                    <th><?php echo $row['movie_views']; ?></th>
                    <th><?php echo $row['movie_added_by']; ?></th>
                    <th><?php echo $row['category_name']; ?></th>
                    <th>
                        <a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['movie_id']; ?>')">Delete</a><br>
                    </th>
                    <th>
                        <a href="<?php echo $source . "?id=" . $row['movie_id'] ?>">Edit</a><br>
                    </th>
                </tr>
                <?php
            }
            break;

        case "categories.php":
            $result = mysqli_query($con, "Select * from categories");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['category_id']; ?></th>
                    <th><?php echo $row['category_name']; ?></th>
                    <th><a href="<?php echo $source . "?id={$row['category_id']}&name={$row['category_name']}"; ?>">Edit</a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['category_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "comments.php":
            $result = mysqli_query($con, "Select comments.comment_id, comments.comment_author, comments.comment_content,comments.comment_date, movies.movie_Name, movies.movie_id "
                    . "from comments inner join movies on comments.comment_topic=movies.movie_id");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['comment_id']; ?></th>
                    <th><?php echo $row['comment_author']; ?></th>
                    <th><?php echo $row['comment_content']; ?></th>
                    <th><?php echo $row['comment_date']; ?></th>
                    <th><a href='../../movie_profile.php?id=<?php echo $row['movie_id']; ?>'><?php echo $row['movie_Name']; ?></a></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['comment_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "notifications.php":
            $result = mysqli_query($con, "Select * from notifications");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['notfiy_id']; ?></th>
                    <th><?php echo $row['notfiy_from']; ?></th>
                    <th><?php echo $row['notfiy_content']; ?></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['notfiy_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "reviews.php":
            $result = mysqli_query($con, "Select reviews.review_id, reviews.review_author, reviews.review_type, movies.movie_name "
                    . "from reviews inner join movies on reviews.review_on=movies.movie_id");
            confirmQuery($result);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th><?php echo $row['review_id']; ?></th>
                    <th><?php echo $row['review_author']; ?></th>
                    <th><?php echo $row['movie_name']; ?></th>
                    <th><?php echo $row['review_type']; ?></th>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['review_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;

        case "settings.php":
            $query = "select * from settings";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['setting_id']; ?></td>
                    <td><?php echo $row['setting_type']; ?></td>
                    <td><?php echo $row['setting_status']; ?> </td>
                    <td><?php echo $row['setting_period']; ?> </td>
                    <td>
                        <a onclick="setUserChanges('on', '<?php echo $source; ?>', '<?php echo $row['setting_id']; ?>')">ON</a><br>
                        <a onclick="setUserChanges('off', '<?php echo $source; ?>', '<?php echo $row['setting_id']; ?>')">OFF</a><br>
                    </td>
                </tr>
                <?php
            }
            break;

        case "warnings.php":
            $query = "select * from warnings";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['warn_id']; ?></td>
                    <td><?php echo $row['warn_content']; ?></td>
                    <td><?php echo $row['warn_by']; ?> </td>
                    <td><?php echo $row['warn_to']; ?> </td>
                    <td><?php echo $row['warn_date']; ?> </td>
                    <th><a onclick="setUserChanges('delete', '<?php echo $source; ?>', '<?php echo $row['warn_id']; ?>')">Delete</a></th>
                </tr>
                <?php
            }
            break;
    }
}
/*
 * perform actions on the source page could be users.php or movies.php etc    TABLE HANDLER
 */
if (isset($_GET['action'])) {
    $source = validation_input($_GET['source']);
    switch ($source) {
        case "users.php":
            switch ($_GET['action']) {
                case "active":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_status='Active' where user_id={$id}"));
                    break;

                case "inactive":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_status='Inactive' where user_id={$id}"));
                    break;
                case "online":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_online='Online' where user_id={$id}"));
                    break;
                case "offline":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_online='Offline' where user_id={$id}"));
                    break;

                case "moderator":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_type='Moderator' where user_id={$id}"));
                    $_SESSION['role'] = "Moderator";
                    break;

                case "premium":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_type='Premium' where user_id={$id}"));
                    $_SESSION['role'] = "Premium";
                    break;

                case "regular":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update users set user_type='Regular' where user_id={$id}"));
                    $_SESSION['role'] = "Regular";
                    break;

                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from users where user_id={$id}"));
                    break;
            }
            break;


        case "categories.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from categories where category_id={$id}"));
                    break;
            }
            break;

        case "movies.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from movies where movie_id={$id}"));
                    break;
            }
            break;

        case "comments.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from comments where comment_id={$id}"));
                    break;
            }
            break;

        case "notifications.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from notifications where notfiy_id={$id}"));
                    break;
            }
            break;

        case "reviews.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from reviews where review_id={$id}"));
                    break;
            }
            break;

        case "settings.php":
            switch ($_GET['action']) {
                case "on":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update settings set setting_status='ON' where setting_id={$id}"));
                    break;
                case "off":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "Update settings set setting_status='OFF' where setting_id={$id}"));
                    break;
            }
            break;

        case "warnings.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from warnings where warn_id={$id}"));
                    break;
            }
            break;
        case "messages.php":
            switch ($_GET['action']) {
                case "delete":
                    $id = validation_input($_GET['id']);
                    confirmQuery(mysqli_query($con, "delete from messages where msg_id={$id}"));
                    break;
            }
            break;
    }
}

/*
 * FORM HANDLER
 */
if (isset($_POST['cat_name'])) {
    $id = validation_input($_POST['cat_id']);
    $name = validation_input($_POST['cat_name']);
    $sql = "";
    if ($id == "") {
        $sql = "insert into categories values (null, '$name')";
    } else {
        $sql = "update categories set category_name='$name' where category_id='$id'";
    }
    if (ctype_alpha($name)) {
        confirmQuery(mysqli_query($con, $sql));
    } else {
        echo "Only characters are allowed";
    }
}
if (isset($_POST['date']) && isset($_POST['time'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $time_in_24_hour_format = date("H:i:s", strtotime($time));
    $date = new DateTime("$date" . " " . "$time_in_24_hour_format");
    $date = $date->format('Y-m-d H:i:s');
    confirmQuery(mysqli_query($con, "Update settings set setting_period='{$date}' where setting_id=1"));
}
