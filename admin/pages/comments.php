<?php include './includes/head.php'; ?>

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
                    All Users
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Users</li>
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
                    Search based on comment author: <input type="text" onkeyup="searchData('<?php echo $current; ?>', this.value)"/> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Comment ID</th>
                                    <th>Comment Author</th>
                                    <th>Comment Content</th>
                                    <th>Comment Date</th>
                                    <th>Comment Topic</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
