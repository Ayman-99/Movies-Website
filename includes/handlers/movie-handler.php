<?php
include '../../config/db.php';
include '../../config/function.php';
if (isset($_GET['target'])) {
    $id = validation_input($_GET['target']);
    $result = mysqli_query($con, "SELECT round(avg(vote_hit),1) as rating FROM votes WHERE vote_on = $id;");
    $row = mysqli_fetch_array($result);
    if ($row['rating'] == "") {
        echo 0;
    } else {
        echo $row['rating'];
    }
}
if (isset($_GET['val']) && isset($_GET['name']) && isset($_GET['on'])) {
    if (empty($_GET['name'])) {
        echo "You need to login";
        return;
    }
    $val = validation_input($_GET['val']);
    $on = validation_input($_GET['on']);
    $by = validation_input($_GET['name']);
    if (!userRated($by, $on, $con)) {
        $result = mysqli_query($con, "INSERT INTO `votes` VALUES (null,'$by','$on','$val',NOW())");
        confirmQuery($result);
        echo "yes";
    } else {
        echo "You rated already. You can't rate twice";
    }
}
//getting comments
if (isset($_GET['comments']) && $_GET['comments'] == "get") {
    $id = validation_input($_GET['id']);
    $sql = "Select * from comments_view where movie_id=$id ORDER BY comment_id DESC";
    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <li>
            <div class="commentText">
                <p style="font-size: 20px;">
                    <?php
                    //only moderator and premium user can check other uses' profile
                    if (isset($_SESSION['username'])) {
                        if (is_Developer($_SESSION['username']) || is_Moderator($_SESSION['username']) || is_Premium($_SESSION['username'])) {
                            ?>
                            <a href="profile.php?target=<?php echo $row['user_name']; ?>"><?php echo $row['user_FName'] . " " . $row['user_LName']; ?></a>
                            <?php
                        } else {
                            echo $row['user_FName'] . " " . $row['user_LName'];
                        }
                    } else {
                        echo $row['user_FName'] . " " . $row['user_LName'];
                    }
                    ?>
                </p>
                <p style="color: white; font-size: 18px;"><?php echo $row['comment_content']; ?></p> <span class="date sub-text"><?php echo $row['comment_date']; ?></span>
            </div>
        </li>
        <?php
    }
}
// insert comment
if (isset($_POST['target']) && isset($_POST['content']) && isset($_POST['from'])) {
    $name = validation_input($_POST['from']);
    $target = validation_input($_POST['target']);
    $content = validation_input($_POST['content']);
    echo $content;
    confirmQuery(mysqli_query($con, "insert into comments values (null,'$name','$content',NOW(),'$target')"));
}
// TO get reviews count for movie
if (isset($_GET['type']) && isset($_GET['mov_id'])) {
    switch ($_GET['type']) {
        case "dislike":
            $result = mysqli_query($con, "call get_review('dislike','{$_GET['mov_id']}');");
            confirmQuery($result);
            $row = mysqli_fetch_array($result);
            echo $row['result'];
            mysqli_close($con);
            break;
        case "like":
            $result = mysqli_query($con, "call get_review('like','{$_GET['mov_id']}');");
            confirmQuery($result);
            $row = mysqli_fetch_array($result);
            echo $row['result'];
            mysqli_close($con);
            break;
    }
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
if (isset($_GET['action']) && isset($_GET['name'])) {
    $name = validation_input($_GET['name']);
    $id = validation_input($_GET['mov_id']);
    switch ($_GET['action']) {
        case "dislike":
            $result = mysqli_query($con, "call insert_review('$name', '$id','dislike')");
            confirmQuery($result);
            $row = mysqli_fetch_array($result);
            if ($row['result'] == "You already reviewed") {
                echo "You can't review twice";
            } else {
                echo "Review has been added";
            }
            mysqli_close($con);
            break;
        case "like":
            $result = mysqli_query($con, "call insert_review('$name', '$id','like')");
            confirmQuery($result);
            $row = mysqli_fetch_array($result);
            if ($row['result'] == "You already reviewed") {
                echo "You can't review twice";
            } else {
                echo "Review has been added";
            }
            mysqli_close($con);
            break;
    }
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

if (isset($_GET['q'])) {

    $name = validation_input($_GET['q']);
    $movies = mysqli_query($con, "select * from movie_info where movie_Name like '%$name%' AND category_name != 'Premium'");
    confirmQuery($movies);
    //Use 225 px width x 315 px height for movie
    if ($row = mysqli_fetch_array($movies)) {
        ?>
        <div class="premium-tv-item">
            <figure class="item-thumbnail">
                <img src="img/tv/<?php echo $row['movie_image'] ?>" alt="//">
                <span class="overthumb"></span>
                <div class="icons"><a href="movie_profile.php?id=<?php echo $row['movie_id'] ?>" data-toggle="modal"><i class="icon-play"></i></a></div>
            </figure>
            <h3><?php echo $row['movie_Name'] ?></h3>
            <p><?php echo $row['category_name'] ?></p>
            <p><span><?php echo $row['movie_views']; ?></span> views</p>
            <?php
            $rating = mysqli_query($con, "SELECT round(avg(vote_hit),1) as rating FROM votes WHERE vote_on = '{$row['movie_id']}'");
            $row = mysqli_fetch_array($rating);
            if ($row['rating'] == "") {
                ?>
                <strong><em><i class="icon-star"></i></em></strong>
                <?php
            } else {
                echo "<strong>";
                $count = $row['rating'];
                for ($i = 1; $i <= $row['rating']; $i++) {
                    ?>
                    <em><i class="icon-star"></i></em>
                        <?php
                    }
                    echo "</strong>";
                }
                ?>
        </div>
        <?php
    } else {
        echo "Movie doesn't exist";
    }
}

//checking if user rated or not
function userRated($username, $movie_id, $con) {
    $result = mysqli_query($con, "select vote_id from votes where vote_by='$username' AND vote_on='$movie_id'");
    confirmQuery($result);
    $row = mysqli_num_rows($result);
    if ($row > 0) {
        return true;
    } else {
        return false;
    }
}
