<?php

$email = $pass = $errorLogin = "";
if (isset($_POST['signIn'])) {
    $email = validation_input($_POST['user-email']);
    $pass = validation_input($_POST['user-pass']);
    $sess_id = session_id(); //getting session to update in db
    $pass = md5($pass);
    $result = mysqli_query($con, "call login('$email','$pass','$sess_id');");
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['username'] !== "NAN") {

        $status = $row['stat'];
        if ($status == "Account is inactive") {
            $errorLogin = "Account is blocked by staff. Use Live support";
        } else {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            //Save user's role whenever he logs in cookie so we can retrieve it to conditions in mainteance mode
            $cookie_name = "role";
            $cookie_value = $row['role'];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
            mysqli_close($con);
        }
    } else {
        $errorLogin = "Password or Email is incorrent";
    }
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
