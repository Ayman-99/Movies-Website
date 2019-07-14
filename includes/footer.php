<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-lg-8">
                <nav class="navbar" role="navigation">
                    <ul class="nav navbar-nav menu-effect">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="index.php#menu_movies">Movies</a></li>
                        <li><a href="index.php#menu_price">Price</a></li>
                    </ul>			
                </nav>
            </div>
            <div style="margin: 2%;" class="pull-right margin">
                <font style="font-size: 15px;" color="white">Developed by:</font>
                <a target="_blank" style="color:#d6b92c;font-size: 20px;" href="http://aymanblog.000webhostapp.com/"> Ayman Hunjul</a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer --> 



<!-- Modal -->
<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Register to See the Movies</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="register" action="registration.php" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label class="no">Name</label>
                        <input type="text" class="form-control" placeholder="Enter a valid name" name="name"/>
                    </div>
                    <div class="form-group">
                        <label class="no">Email</label>
                        <input type="email" class="form-control" placeholder="Enter a valid email" name="email"/>
                    </div>
                    <div class="form-group">
                        <label class="no">Phone</label>
                        <input type="text" class="form-control" placeholder="Enter a valid phone number" name="phone">
                    </div>
                    <button type="submit" class="btn btn-default">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->


<!-- ******************************************************************** -->
<!-- ************************* Javascript Files ************************* -->
<!-- jQuery -->
<!-- Respond.js media queries for IE8 -->
<script src="js/vendors/respond.min.js"></script>

<!-- Bootstrap-->
<script src="js/vendors/bootstrap.min.js" ></script>

<!-- One Page Scroll -->
<script src="js/vendors/jquery/jquery.nav.js" ></script>
<script src="js/vendors/jquery/jquery.sticky.js" ></script>

<!-- Isotope -->
<script src="js/vendors/jquery/jquery.isotope.min.js" ></script>

<!-- Carousel -->
<script src="js/vendors/owl-carousel/owl.carousel.js"></script>

<!-- Appear -->
<script src="js/vendors/jquery/jquery.appear.js" ></script>

<!-- Custom -->
<script src="js/script.js"  ></script>
<script>
    $("#CommentForm").submit(function (evt) {
        evt.preventDefault();
        var postData = $(this).serialize();
        var editserialize = decodeURIComponent(postData.replace(/%2F/g, " "));
        editserialize = editserialize.substr(14); //number of input
        var url = "includes/handlers/movie-handler.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: {target: "<?php echo validation_input($_GET['id']); ?>", content: editserialize,
                from: "<?php echo $loggedIn; ?>"},
            success: function (show_messages) {
                if (!show_messages.error) {
                    document.getElementById("resultMessage").innerHTML = "";
                } else {
                    document.getElementById("resultMessage").innerHTML = "you have to enter some text";
                }
            }
        });
    }
    );
</script>
<script>
    function getMoviesCount() {
        $.get("includes/handlers/home-handler.php" + "?getData=Movies", function (data) {
            $("#movies_count").html(data);
        });
    }
    function getOnlineUsers() {
        $.get("includes/handlers/home-handler.php" + "?getData=Online", function (data) {
            $("#online_users").html(data);
        });
    }
    function getLikes() {
        $.get("includes/handlers/home-handler.php" + "?getData=Likes", function (data) {
            $("#likes_count").html(data);
        });
    }
    function getComments() {
        $.get("includes/handlers/home-handler.php" + "?getData=Comments", function (data) {
            $("#comment_count").html(data);
        });
    }
    //get User's warnings edit this to get name by Session (logged in user)
    function getProfileWarnings() {
        $.get("includes/handlers/profile-handler.php?username=<?php echo $loggedIn; ?>", function (data) {
            $("#load-warnings").html(data);
        });
    }
    /* rating */
    function getRating(id) {
        $.get("includes/handlers/movie-handler.php" + "?target=" + id, function (data) {
            $("#movingRate").html(data);
        });
    }
    //Sending rate val to handler
    $('input:radio[name="stars"]').change(
            function () {
                if ($(this).is(':checked')) {
                    var path = "includes/handlers/movie-handler.php?val=" +
                            $(this).val() + "&on=<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>" +
                            "&name=<?php echo $loggedIn; ?>";
                    $.get(path, function (data) {
                        if (data === "yes") {
                            $('#rateResult').html("Rated");
                        } else {
                            $('#rateResult').html(data);
                        }
                    });
                }
            }
    );
    //Comments section  commentsBox
    function getCommentsBox() {
        $.get("includes/handlers/movie-handler.php?comments=get&id=" +<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>, function (data) {
            $("#commentsBox").html(data);
        });
    }
    getProfileWarnings();
    setInterval(function () {
        getMoviesCount();
        getOnlineUsers();
        getLikes();
        getComments();
        getCommentsBox();
        getRating(<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>);
    }, 2000);
</script>
<!-- *********************** End Javascript Files *********************** -->
<!-- ******************************************************************** -->
</body>
</html>
