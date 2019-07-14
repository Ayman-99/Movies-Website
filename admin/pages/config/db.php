<?php

ob_start(); //Turns on output buffering for redirecting
session_start(); // Starting session

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'skyfallv2';
foreach ($db as $key => $value) { //assoc array
    define(strtoupper($key), $value);
}
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    echo "Failed to connect: " . mysqli_connect_error($connection);
}
