<footer class="main-footer">
    <strong>Copyright &copy; 2019 || Developed By: <a href="http://aymanblog.000webhostapp.com/" target="_blank">Ayman Hunjul</a>.</strong>
</footer>

<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<!-- ChartJS -->
<script src="../bower_components/chart.js/Chart.js"></script>

<!-- page script -->
<script>
    $(function () {
        //  $('#example2').DataTable()
        $('#example1').DataTable({
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': false,
            'info': true,
            'autoWidth': true
        });
    });
    //Tables handling
    getData("<?php echo $current; ?>");
    function setUserChanges(action, source, id) {
        var path = "includes/form_handler/handler.php" + "?action=" + action + "&id=" + id + "&source=" + source;
        $.get(path, function (data) {
            displaySucc();
            getData(source);
        });
    }
    function getData(source) {
        $.get("includes/form_handler/handler.php" + "?getData=" + source, function (data) {
            $("#users-table").html(data);
        });
    }
    function searchData(source, key) {
        if (key.length === 0) {
            getData(source);
        } else {
            $.get("includes/form_handler/handler.php" + "?search_source=" + source + "&key=" + key, function (data) {
                $("#users-table").html(data);
            });
        }
    }
    //add or edit category form
    $("#edit_add_category").submit(function (evt) {
        evt.preventDefault();

        var postData = $(this).serialize();
        var source = $(this).attr('action');
        var url = "includes/form_handler/handler.php";
        $.post(url, postData, function (data) {
            if (data !== "Only characters are allowed") {
                displaySucc();
                getData(source);
                $("#category_name_error").html("");
            } else {
                $("#category_name_error").html(data);
            }
        });
    });

    //Edit settings
    $("#edit_settings").submit(function (evt) {
        evt.preventDefault();
        var postData = $(this).serialize();
        var url = "includes/form_handler/handler.php";
        var source = $(this).attr('action');
        var editserialize = decodeURIComponent(postData.replace(/%2F/g, " "));
        $.post(url, editserialize, function (data) {
            displaySucc();
            getData(source);
        });
    });

    $("#edit_add_movie").submit(function (evt) {
        displaySucc();
    });
    function displaySucc() {
        $("#myElem").removeClass("hide");
        $('#myElem').fadeIn('slow', function () {
            $('#myElem').delay(1200).fadeOut();
        });
    }
    function displaySuccForm() {
        $("#succForm").removeClass("hide");
        $('#succForm').fadeIn('slow', function () {
            $('#succForm').delay(1200).fadeOut();
        });
    }
    function getMoviesCount() {
        $.get("includes/form_handler/home-handler.php" + "?getData=Movies", function (data) {
            $("#movies_count").html(data);
        });
    }
    function getLikes() {
        $.get("includes/form_handler/home-handler.php" + "?getData=Likes", function (data) {
            $("#likes_count").html(data);
        });
    }
    function getUsers() {
        $.get("includes/form_handler/home-handler.php" + "?getData=Users", function (data) {
            $("#users_count").html(data);
        });
    }
    function getComments() {
        $.get("includes/form_handler/home-handler.php" + "?getData=Comments", function (data) {
            $("#comment_count").html(data);
        });
    }
    setInterval(function () {
        getMoviesCount();
        getUsers();
        getComments();
        getLikes();

    }, 2000);

</script>
</body>
</html>



































































































































