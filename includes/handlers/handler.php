<?php

include '../../config/db.php';
if (isset($_POST['offIt'])) {
    mysqli_query($con, "Update settings set setting_status='OFF' where setting_id=1");
}
?>
