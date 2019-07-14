<?php

function confirmQuery($query) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    if (!$query) {
        die("QUERY FAILED" . " " . mysqli_error($con));
    }
}

function validation_input($data) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data); //Remove html tags
    $data = mysqli_real_escape_string($con, $data);
    return $data;
}

function is_Developer($username) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $query = "SELECT user_type FROM users WHERE user_name ='$username'";
    $result = mysqli_query($con, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_type'] == 'Developer') {
        return true;
    } else {
        return false;
    }
}

function is_Moderator($username) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $query = "SELECT user_type FROM users WHERE user_name ='$username'";
    $result = mysqli_query($con, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_type'] == 'Moderator') {
        return true;
    } else {
        return false;
    }
}

function is_Premium($username) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $query = "SELECT user_type FROM users WHERE user_name ='$username'";
    $result = mysqli_query($con, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_type'] == 'Premium') {
        return true;
    } else {
        return false;
    }
}

function valdiate_upload($name, $tmp_path, $path) {
    $error_array = array(); //Holds error messages

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        array_push($error_array, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }
    if (empty($error_array)) {
        move_uploaded_file($tmp_path, $path);
    } else {
        array_push($error_array, "Sorry, there was an error uploading your file.");
    }
    return $error_array;
}

function emailExists($email) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $result = mysqli_query($con, "select user_id from users where user_email='$email'");
    confirmQuery($result);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}
function increaseMovieView($id) {
    global $con;
    if (!$con) {
        include 'config/db.php';
    }
    $result = mysqli_query($con, "update movies set movie_views = movie_views + 1 where movie_id=$id");
    confirmQuery($result);
}
