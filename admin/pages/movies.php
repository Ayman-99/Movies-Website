<?php include './includes/head.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php include './includes/header.php'; ?>
        <!-- =============================================== -->
        <!-- Left side column. contains the sidebar -->
        <?php include './includes/side-nav.php'; ?>
        <!-- =============================================== -->
        <?php
        $error_array = array();
        $succ = "";
        $id = $movie_name = $movie_URL = $movie_image = $movie_director = $movie_length = $movie_release_date = $movie_language = $movie_description = $movie_category_id = "";
        if (isset($_POST['movie_name'])) {
            $id = validation_input($_POST['movie_id']);
            $movie_name = validation_input($_POST['movie_name']);
            $movie_URL = validation_input($_POST['movie_url']);

            if ($id == "") {
                $movie_image = $_FILES['movie_image']['name'];
                $movie_image_temp = $_FILES['movie_image']['tmp_name'];
                $error_array = valdiate_upload($movie_image, $movie_image_temp, "../../img/tv/$movie_image");
            }

            $movie_director = validation_input($_POST['movie_director']);
            $movie_length = validation_input($_POST['movie_length']);
            $movie_release_date = validation_input($_POST['movie_date']);
            $movie_language = validation_input($_POST['movie_lang']);
            $movie_description = validation_input($_POST['movie_desc']);
            $movie_category_id = validation_input($_POST['movie_cate']);
            $movie_added_by = $_SESSION['username'];
            $sql = "";
            if ($id == "") {
                $sql = "INSERT INTO `movies` VALUES (null,'$movie_name','$movie_URL','$movie_image','$movie_director','$movie_length'"
                        . ",'$movie_release_date','$movie_language','$movie_description','0','$movie_added_by','$movie_category_id');";
                $sql .= "INSERT INTO notifications values (null, '$movie_added_by','added movie');";
            } else {
                $sql = "UPDATE `movies` SET `movie_Name`='$movie_name',`movie_URL`='$movie_URL',"
                        . "`movie_director`='$movie_director',`movie_length`='$movie_length',"
                        . "`movie_release_date`='$movie_release_date',`movie_language`='$movie_language',`movie_description`='$movie_description',"
                        . "`movie_category_id`='$movie_category_id' WHERE movie_id='$id';";
                $sql .= "INSERT INTO notifications values (null, '$movie_added_by','updated movie');";
            }

            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $movie_URL)) {
                array_push($error_array, "Invalid URL");
            }
//            if (!preg_match("/[1-9][:]/g", $movie_length)) {
//                array_push($error_array, "Length must be in this format HH:MM");
//            }
            if (empty($error_array)) {
                confirmQuery(mysqli_multi_query($con, $sql));
                $succ = "T";
            }
        }
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    All Movies
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Movies</li>
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
                    Search based on movie name: <input type="text" onkeyup="searchData('<?php echo $current; ?>', this.value)"/> 
                    <div class="box-body">
                        <table id="example1" class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Movie ID</th>
                                    <th>Movie Name</th>
                                    <th>Movie URL</th>
                                    <th>Movie Image</th>
                                    <th>Movie Director</th>
                                    <th>Movie Length</th>
                                    <th>Movie Release Date</th>
                                    <th>Movie Language</th>
                                    <th>Movie Description</th>
                                    <th>Movie Views</th>
                                    <th>Movie Added By</th>
                                    <th>Movie Category</th>
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
                        <h3 class="box-title">Add/Edit Movie</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <?php
                    if (isset($_GET['id'])) {
                        $id = validation_input($_GET['id']);
                        $result = mysqli_query($con, "Select * from movies where movie_id='$id'");
                        $row = mysqli_fetch_array($result);
                        $movie_name = $row['movie_Name'];
                        $movie_URL = $row['movie_URL'];
                        $movie_image = $row['movie_image'];
                        $movie_director = $row['movie_director'];
                        $movie_length = $row['movie_length'];
                        $movie_release_date = $row['movie_release_date'];
                        $movie_language = $row['movie_language'];
                        $movie_description = $row['movie_description'];
                        $movie_category_id = $row['movie_category_id'];
                    }
                    ?>
                    <div class="box-body">
                        <div id="succForm" class="alert alert-success <?php echo ($succ == "T") ? '' : 'hide' ?>">
                            <strong>Success!</strong> The action has performed successfully .
                        </div>
                        <form id="edit_add_movie" action="<?php echo $current; ?>" method="POST" enctype="multipart/form-data">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Movie ID</label>
                                <input name="movie_id" type="text" class="form-control" value="<?php echo $id; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Movie Name</label>
                                <input name="movie_name" type="text" class="form-control" placeholder="Enter Name" value="<?php echo $movie_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Movie URL</label>
                                <input name="movie_url" type="text" class="form-control" placeholder="Enter URL" value="<?php echo $movie_URL; ?>" required>
                                <?php echo (in_array("Invalid URL", $error_array)) ? "<font color='red'>Invalid URL</font>" : ''; ?>
                            </div>
                            <?php
                            if ($movie_image != "") {
                                ?>
                                <div class="form-group">
                                    <img width="100" height="100" src="../../img/tv/<?php echo $movie_image ?>">
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label>Movie Image</label>
                                    <input name="movie_image" type="file">
                                </div>
                                <?php echo (in_array("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", $error_array)) ? "<font color='red'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</font>" : ''; ?>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <label>Movie Director</label>
                                <input name="movie_director" type="text" class="form-control" placeholder="Enter Director" value="<?php echo $movie_director; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Movie Length</label>
                                <input name="movie_length" type="text" class="form-control" placeholder="Enter Length eg: 2:30 (2 hours and 30 mins)" value="<?php echo $movie_length; ?>" required>
                                <?php echo (in_array("Length must be in this format HH:MM", $error_array)) ? "<font color='red'>Length must be in this format HH:MM</font>" : ''; ?>
                            </div>
                            <div class="form-group">
                                <label>Movie Release Date</label>
                                <input name="movie_date" type="date" class="form-control"  value="<?php echo $movie_release_date; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Movie Language</label>
                                <input name="movie_lang" type="text" class="form-control" placeholder="Enter Language" value="<?php echo $movie_language; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Movie Description</label>
                                <textarea name="movie_desc" type="text" class="form-control" placeholder="Enter Desc" required><?php echo $movie_description; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Movie Category</label>
                                <select name="movie_cate" class="form-control" required>
                                    <?php
                                    //getting categories
                                    $result = mysqli_query($con, "select * from categories");
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <option value='<?php echo $row['category_id'] ?>' <?php echo $row['category_id'] == $movie_category_id ? 'selected' : ''; ?>><?php echo $row['category_name'] ?></option>";
                                        <?php
                                    }
                                    ?>
                                </select>
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
