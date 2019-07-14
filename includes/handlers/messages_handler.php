<?php
include '../../config/db.php';
include '../../config/function.php';
if (isset($_GET['to'])) {
    $name = validation_input($_GET['to']);
    $target = validation_input($_GET['from']);
    $result = mysqli_query($con, "select * from messages where msg_to='$name' AND msg_from='$target' OR msg_to='$target' AND msg_from='$name'order by msg_id DESC");

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['msg_from'] == $name) {
            ?>
            <div class="chat-container">
                <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Avatar" style="width: 50px;">
                <p style="color: black;"><b><?php echo $name; ?></b> : <?php echo $row['msg_body']; ?></p>
            </div>
            <?php
        } else {
            ?>
            <div class="chat-container darker">
                <img src="https://dlgdxii3fgupk.cloudfront.net/static/images/comprofiler/gallery/operator/operator_m.png" alt="Avatar" style="width: 50px;">
                <p style="color: black;"><b><?php echo "Developer"; ?></b> : <?php echo $row['msg_body']; ?></p>
            </div>
            <?php
        }
    }
}
if (isset($_POST['message'])) {
    $message = validation_input($_POST['message']);
    $from = validation_input($_POST['from']);
    $to = validation_input($_POST['to']);
    confirmQuery(mysqli_query($con, "insert into messages values (null, '{$from}', '{$to}', '{$message}', NOW())"));
}
?>


