<?php
include '../../config/db.php';
include '../../function.php';

if (isset($_POST['to'])) {
    $name = validation_input($_POST['to']);
    $target = validation_input($_POST['from']);
    $result = mysqli_query($con, "select * from messages where msg_to='$name' AND msg_from='$target' OR msg_to='$target' AND msg_from='$name'order by msg_id DESC");

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['msg_from'] == $name) {
            ?>
            <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right"><?php echo $name; ?></span>
                </div>
                <img width="128" height="128" class="direct-chat-img" src="https://www.w3schools.com/w3images/avatar2.png" alt="message user image">
                <div class="direct-chat-text pull-right">
                    <?php echo $row['msg_body']; ?>
                </div>
            </div> 
            <?php
        } else {
            ?>
            <div class="direct-chat-msg left">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left"><?php echo $target; ?></span>
                </div>
                <img width="128" height="128" class="direct-chat-img" src="https://www.w3schools.com/w3images/avatar2.png" alt="message user image">
                <div class="direct-chat-text pull-left">
                    <?php echo $row['msg_body']; ?>
                </div>
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


