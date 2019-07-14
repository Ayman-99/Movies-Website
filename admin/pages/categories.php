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
                    All Categories
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Categories</li>
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
                        <h3 class="box-title">Categories Details</h3>
                    </div>
                    <!-- /.box-header -->
                    Search based on name: <input type="text" onkeyup="searchData('<?php echo $current; ?>', this.value)"/> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
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
                        <h3 class="box-title">Add/Edit category</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php
                        $id = $cat = "";
                        if(isset($_GET['id']) && isset($_GET['name'])){
                            $id = validation_input($_GET['id']);
                            $cat = validation_input($_GET['name']);
                        }
                        ?>
                        <form id="edit_add_category" action="<?php echo $current; ?>" role="form" method="POST">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Category ID</label>
                                <input name="cat_id" type="text" class="form-control" value="<?php echo $id; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input name="cat_name" type="text" class="form-control" placeholder="Enter Name" value="<?php echo $cat; ?>" required="">
                                <font id='category_name_error' color='red'></font>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" name="update_data" type="submit" class="form-control" value="Add/Edit">
                            </div>
                        </form>
                    </div>
                    <!-- /.box-footer-->
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php include './includes/footer.php'; ?>
