<?php
include '../../config/db.php';
include '../../config/function.php';

if (isset($_GET['username'])) {
    $name = validation_input($_GET['username']);
    $sql = "select * from warnings where warn_to='$name' order by warn_id DESC";
    $result = mysqli_query($con, $sql);
    confirmQuery($result);
    echo "<li class='list-group-item'>Your Warnings (count) after 8 warnings your account will be disabled</li>";
    
    while($row = mysqli_fetch_array($result)){
        echo "<li class='list-group-item list-group-item-warning'>{$row['warn_content']}</li>";
    }
}
