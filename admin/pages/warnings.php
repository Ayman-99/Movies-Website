<?php include './includes/head.php'; ?>
<?php
$error_array = array();
$succ = "";
$content = "";
if (isset($_POST['insert_warning'])) {
    $warn_content = validation_input($_POST['warn_content']);
    $warn_to = validation_input($_POST['warn_to']);

    if (strlen($warn_content) <= 10) {
        array_push($error_array, "Content must at least have 10 characters");
    }

    if (empty($error_array)) {
        confirmQuery(mysqli_query($con, "insert into warnings values (null,'$warn_content','$loggedIn','$warn_to',NOW())"));
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
                    All Warnings
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Warnings</li>
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
                                    <th>Warning ID</th>
                                    <th>Warning Content</th>
                                    <th>Warning By</th>
                                    <th>Warning To</th>
                                    <th>Warning Date</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Warning</h3>

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
                                    <label>Warning Content</label>
                                    <input name="warn_content" type="text" class="form-control" value="<?php echo $content; ?>" required="">
                                    <?php echo (in_array("Content must be between 5 and 200 chars only", $error_array)) ? "<font color='red'>Content must be between 5 and 200 chars only</font>" : ''; ?>
                                </div>
                                <div class="form-group">
                                    <label>Target</label>
                                    <select name="warn_to" class="form-control" required>
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
                                    <input class="btn btn-primary" name="insert_warning" type="submit" class="form-control" value="Add">
                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer-->
                    </div>
            </section>
        </div>

        <?php include './includes/footer.php'; ?>
