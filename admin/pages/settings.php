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
                    Settings features
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Settings</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div id="myElem" class="alert alert-success hide">
                    <strong>Success!</strong> The action has performed successfully .
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Settings</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Setting ID</th>
                                    <th>Setting Type</th>
                                    <th>Setting status</th>
                                    <th>Setting Period</th>
                                    <th>Set status</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Settings</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form id="edit_settings" action="<?php echo $current; ?>" role="form" method="POST">
                            <input name='date' type='date' max='2020-12-28' min='<?php echo date("Y-m-d") ?>' required=""/>
                            <input name='time' type='time' required=""/>
                            <input value='add' name='setSettings' type='submit'/>
                        </form>
                    </div>
                    <!-- /.box-footer-->
                </div>
            </section>

        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
