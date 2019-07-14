<?php

include 'config/db.php';
include 'function.php'; //includes helpful functions
include 'includes/classes/User.php'; // includes user class
$loggedIn = $_SESSION['username']; //global variable which holds online user
$currentObj = "";
$moderator = new Moderator($con, $loggedIn); //create object
if (!is_Developer($loggedIn) && !is_Moderator($loggedIn)) {
    header("Location: ../../index.php");
}
if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {
    header("Location: ../../index.php");
} else if (isset($_SESSION['lockscreen'])) {
    header("Location: lockscreen.php");
    exit();
}















