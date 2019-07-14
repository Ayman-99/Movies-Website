<?php include './includes/head.php'; ?>
<?php
$error_array = array();
$succ = "";
$content = "";
if (isset($_POST['send_message'])) {
    $msg_content = validation_input($_POST['message_content']);
    $msg_to = validation_input($_POST['message_to']);

    if (empty($error_array)) {
        confirmQuery(mysqli_query($con, "insert into messages values (null,'{$_SESSION['username']}','$msg_to','$msg_content',NOW())"));
        $succ = "T";
    }
}
?>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include './includes/header.php'; ?>
        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php include './includes/side-nav.php'; ?>
        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    All Messages
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Messages</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- success action -->
                <div id="myElem" class="alert alert-success hide">
                    <strong>Success!</strong> The action has performed successfully .
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users Details</h3>
                    </div>
                    <!-- /.box-header -->
                    Search based on content: <input type="text" onkeyup="searchData('<?php echo $current; ?>', this.value)"/> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Message ID</th>
                                    <th>Message Content</th>
                                    <th>Message From</th>
                                    <th>Message To</th>
                                    <th>Message Date</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Message</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="succForm" class="alert alert-success <?php echo ($succ == "T") ? '' : 'hide' ?>">
                                <strong>Success!</strong> The action has performed successfully .
                            </div>
                            <form id="edit_add_movie" action="<?php echo $current; ?>" method="POST">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Message Content</label>
                                    <input name="message_content" type="text" class="form-control" value="<?php echo $content; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Target</label>
                                    <select name="message_to" class="form-control" required>
                                        <?php
                                        //getting categories
                                        $result = mysqli_query($con, "select user_name from users where user_type != 'Developer' AND user_type != 'Moderator'");
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value='<?php echo $row['user_name'] ?>' ><?php echo $row['user_name'] ?></option>";
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" name="send_message" type="submit" class="form-control" value="Add">
                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer-->
                    </div>
            </section>
        </div>

        <?php include './includes/footer.php'; ?>
