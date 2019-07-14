<?php
include '../../config/db.php';
include '../../function.php';

if (isset($_GET['getData'])) {
    switch ($_GET['getData']) {
        case 'Movies':
            $result = mysqli_query($con, "select count(movie_id) as result from movies;");
            $row = mysqli_fetch_array($result);
            echo $row['result'];
            break;
        case 'Users':
            $row = mysqli_fetch_array(mysqli_query($con, "select count(user_id) as result from users;"));
            echo $row['result'];
            break;
        case 'Likes':
            $row = mysqli_fetch_array(mysqli_query($con, "select count(review_id) as result from reviews;"));
            echo $row['result'];
            break;
        case 'Comments':
            $row = mysqli_fetch_array(mysqli_query($con, " select count(comment_id) as result from comments;"));
            echo $row['result'];
            break;
        default : echo 0;
    }
}
