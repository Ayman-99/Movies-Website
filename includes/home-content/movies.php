<script>
    window.onload = function () {
        document.getElementById("autoClick").click(); //hide premium
    }
</script>
<article class="premium-tv" id="menu_movies">
    <div class="container">
        <h2 class="animated" data-animation="fadeInUp" data-animation-delay="200">Movies List</h2>
        <h6 class="animated" data-animation="fadeInUp" data-animation-delay="400">You will find almost all the movies you might look for below. ENJOY</h6>
        <div class="filters">
            <?php
            //show premium movies to specifc users
            if (is_Premium($loggedIn) || is_Moderator($loggedIn) || is_Developer($loggedIn)) {
                $sql = "select * from categories";
            } else {
                $sql = "select * from categories where category_name != 'Premium'";
            }

            $result = mysqli_query($con, $sql);
            confirmQuery($result);
            ?>
            <a id="autoClick" href="#" class="btn btn-filter active animated" data-animation="bounceIn" data-animation-delay="200" data-filter=".common">Show All</a>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <a href="#" class="btn btn-filter animated" data-animation="bounceIn" data-animation-delay="300" data-filter=".<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></a>
                <?php
            }
            ?>
        </div>
        <div class = "premium-tv-grid">
            <?php
            $movies = mysqli_query($con, "select * from movie_info");
            confirmQuery($movies);
            //Use 225 px width x 315 px height for movie
            while ($row = mysqli_fetch_array($movies)) {
                ?>
                <div class="<?php echo ($row['category_name'] !== "Premium") ? "common" : "" ?> premium-tv-item <?php echo $row['category_name'] ?>">
                    <figure class="item-thumbnail">
                        <img src="img/tv/<?php echo $row['movie_image'] ?>" alt="//">
                        <span class="overthumb"></span>
                        <div class="icons"><a href="movie_profile.php?id=<?php echo $row['movie_id'] ?>" data-toggle="modal"><i class="icon-play"></i></a></div>
                    </figure>
                    <h3><?php echo $row['movie_Name'] ?></h3>
                    <p><?php echo $row['category_name'] ?></p>
                    <p><span><?php echo $row['movie_views']; ?></span> views</p>
                    <?php
                    $rating = mysqli_query($con, "SELECT round(avg(vote_hit),1) as rating FROM votes WHERE vote_on = '{$row['movie_id']}'");
                    $row = mysqli_fetch_array($rating);
                    if ($row['rating'] == "") {
                        ?>
                        <strong><em><i class="icon-star"></i></em></strong>
                        <?php
                    } else {
                        echo "<strong>";
                        $count = $row['rating'];
                        for ($i = 1; $i <= $row['rating']; $i++) {
                            ?>
                            <em><i class="icon-star"></i></em>
                            <?php
                        }
                        echo "</strong>";
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="form-group has-feedback has-search" style="width: 30%;">
            <span class="fa fa-search form-control-feedback"></span>
            <input onkeyup="showResult(this.value);" type="text" class="form-control" placeholder="Search">
        </div>
        <div id="movies_list">

        </div>
        <script>
            function showResult(str) {
                if (str.length === 0) {
                    $("#movies_list").html("");
                    return
                } else {
                    $.get("includes/handlers/movie-handler.php?q=" + str, function (data) {
                        $("#movies_list").html(data);
                    });
                }
            }
        </script>
    </div>
</article>

<article class="premium-tv">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div>
                    <h2 style="text-align: center;">Coming soon -> <span style="color: #00ca6d">MOVIE-NAME</span></h2>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row time-countdown justify-content-center">
                    <div id="clock" class="time-count">
                        <div class="time-entry days"><span id="DD">%-D</span> Days</div>
                        <div class="time-entry hours"><span id="HH">%H</span> Hours</div>
                        <div class="time-entry minutes"><span id="MM">%M</span> Minutes</div>
                        <div class="time-entry seconds"><span id="SS">%S</span> Seconds</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<script>
// Set the date we're counting down to
    var countDownDate = new Date("Jan 5, 2025 12:00:00").getTime();

// Update the count down every 1 second
    var x = setInterval(function () {

        var now = new Date().getTime();

        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("DD").innerHTML = days;
        document.getElementById("HH").innerHTML = hours;
        document.getElementById("MM").innerHTML = minutes;
        document.getElementById("SS").innerHTML = seconds;

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("DD").innerHTML = -1;
            document.getElementById("HH").innerHTML = -1;
            document.getElementById("MM").innerHTML = -1;
            document.getElementById("SS").innerHTML = -1;
        }
    }, 1000);
</script>
