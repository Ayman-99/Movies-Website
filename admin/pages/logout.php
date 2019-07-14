<?php
include 'config/init.php';
mysqli_query($con, "update users set user_online='Offline' where user_name='{$_SESSION['username']}'");
unset($_SESSION['role']);
unset($_SESSION['username']);
header("Location: ../../index.php");
exit();
