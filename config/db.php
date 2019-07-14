<?php
ob_start(); //Turns on output buffering for redirecting
session_start(); // Starting session
if (isset($_COOKIE['db_name'])) {
    $db['db_host'] = $_COOKIE['db_host'];
    $db['db_user'] = $_COOKIE['db_user'];
    $db['db_pass'] = isset($_COOKIE['db_pass']) ? $_COOKIE['db_pass'] : "";
    $db['db_name'] = $_COOKIE['db_name'];
    foreach ($db as $key => $value) {
        define(strtoupper($key), $value);
    }
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$con) {
        die(mysqli_connect_error($con));
    }
} else {
    die("You must initialize the database by <a href='installer.php'>installer</a>!");
}
