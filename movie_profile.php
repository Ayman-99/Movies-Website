<?php
include './includes/head.php';
if (!isset($_GET['id'])) {
    header("Location: index.php");
}
?>
<body>
    <?php
    include './includes/header.php';
    $id = validation_input($_GET['id']);
    increaseMovieView($id);
    $movieObj = new Movie($con, $id);
    ?>
    <section class="main-content amy-movie single-movie layout-full has-banner" style="background: #04111f;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-content">
                        <div id="post-81" class="post-81 amy_movie type-amy_movie status-publish amy_genre-western amy_actor-alexander-cattly amy_actor-greta-garbo amy_director-mae-west">
                            <div class="row amy-single-movie" style="margin-top:1%;">
                                <div class="col-md-4 col-sm-4">
                                    <div class="entry-thumb">
                                        <img width="264" height="396" src="img/tv/<?php echo $movieObj->getMoveiImage(); ?>" class="attachment-360x618 size-360x618" alt="" srcset="img/tv/<?php echo $movieObj->getMoveiImage(); ?> 264w, img/tv/<?php echo $movieObj->getMoveiImage(); ?> 200w" sizes="(max-width: 264px) 100vw, 264px" />		
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <div class="entry-info">
                                        <h1 class="entry-title p-name" itemprop="name headline"><a rel="bookmark" class="u-url url"><?php echo $movieObj->getMovieName(); ?></a></h1>
                                        <div class="entry-pg">
                                            <span class="pg">G</span>
                                            <span class="duration">
                                                <i class="fa fa-clock-o"></i>
                                                <?php echo $movieObj->getMovieLength(); ?> HH:MM	
                                            </span>
                                        </div>
                                        <ul class="info-list">
                                            <li>
                                                <label>Director:</label>
                                                <span><?php echo $movieObj->getMovieDirector(); ?></span>
                                            </li>

                                            <li>
                                                <label>Release:</label>
                                                <span><?php echo $movieObj->getReleaseDate(); ?></span>
                                            </li>

                                            <li>
                                                <label>Language:</label>
                                                <span><?php echo $movieObj->getMovieLanguage(); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="entry-action">
                                        <div class="mrate">
                                            <form id='rating_form' class="rating" method='POST'>
                                                <?php
                                                $rate = $movieObj->getRating();
                                                $rate = round($rate);
                                                ?>
                                                <label>
                                                    <input id='val_1' type="radio" name="stars" value="1" <?php echo ($rate == 1) ? "checked " : " "; ?>/>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input id='val_2' type="radio" name="stars" value="2" <?php echo ($rate == 2) ? "checked " : " "; ?>/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input id='val_3' type="radio" name="stars" value="3" <?php echo ($rate == 3) ? "checked " : " "; ?>/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>   
                                                </label>
                                                <label>
                                                    <input id='val_4' type="radio" name="stars" value="4" <?php echo ($rate == 4) ? "checked " : " "; ?>/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input id='val_5' type="radio" name="stars" value="5" <?php echo ($rate == 5) ? "checked " : " "; ?>/>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                            </form>
                                            <span id='movingRate' class="rate"></span>
                                            <p id='rateResult' class="comment-notes"></p>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['username']) && !empty($loggedIn)) {
                                            ?>
                                            <br>
                                            <button id="likebtn" class="btn like btn-primary"><span class="fa fa-thumbs-up" aria-hidden="true"></span> <span class="likes" id="likesSpan">0</span></button>
                                            <button id="dislikebtn" class="btn dislike btn-danger"><span class="fa fa-thumbs-down" aria-hidden="true"></span> <span class="dislikes" id="dislikeSpan">0</span></button>
                                            <p id='review_result' class="comment-notes"></p>
                                            <script>
                                                function getLikesCount(id) {
                                                    $.get("includes/handlers/movie-handler.php" + "?mov_id=" + id + "&type=like", function (data) {
                                                        $("#likesSpan").html(data);
                                                    });
                                                }
                                                function getDisLikesCount(id) {
                                                    $.get("includes/handlers/movie-handler.php" + "?mov_id=" + id + "&type=dislike", function (data) {
                                                        $("#dislikeSpan").html(data);
                                                    });
                                                }
                                                $('#likebtn').click(function () {
                                                    $.get("includes/handlers/movie-handler.php" + "?mov_id=<?php echo validation_input($_GET['id']); ?>&action=like&name=<?php echo $loggedIn; ?>", function (data) {
                                                        $("#review_result").html(data);
                                                        getLikesCount(<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>);
                                                    });
                                                });
                                                $('#dislikebtn').click(function () {
                                                    $.get("includes/handlers/movie-handler.php" + "?mov_id=<?php echo validation_input($_GET['id']); ?>&action=dislike&name=<?php echo $loggedIn; ?>", function (data) {
                                                        $("#review_result").html(data);
                                                        getDisLikesCount(<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>);
                                                    });
                                                });
                                                getLikesCount(<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>);
                                                getDisLikesCount(<?php echo (isset($_GET['id'])) ? validation_input($_GET['id']) : 0 ?>);

                                            </script>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="entry-content e-content" itemprop="description articleBody">
                                        <h3 class="info-name amy-title">Description</h3>
                                        <p style='justify-content: flex-start;'>
                                            <?php echo $movieObj->getMovieDesc(); ?>
                                        </p>
                                    </div>			
                                </div>
                            </div>

                            <div class="container" style='margin-left: 3%;'>
                                <h2>Servers</h2>
                                <p>Choose the server that suits you</p>

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">Server 1</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <iframe src="<?php echo $movieObj->getMovieURL(); ?>" scrolling="OFF" allowfullscreen="" width="100%" height="460" frameborder="0"> </iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="detailBox">
                                <div class="titleBox">
                                    <h2>Comment Section</h2>
                                </div>
                                <div class="commentBox">
                                    <p class="taskDescription">Please avoid insulting other users or using bad words or you might get ban</p>
                                </div>
                                <div class="actionBox">
                                    <ul id="commentsBox" class="commentList"></ul>
                                    <?php
                                    //If user not logged in he can't comment
                                    if (isset($_SESSION['username']) && isset($_SESSION['role']) && (is_Premium($_SESSION['username']) || is_Moderator($_SESSION['username']) || is_Developer($_SESSION['username']))) {
                                        ?>
                                        <form id="CommentForm" class="form-inline" method="POST">
                                            <div class="form-group">
                                                <input name="comment_input" class="form-control" type="text" placeholder="Your comments" />
                                            </div>
                                            <div class="form-group">
                                                <button id="addComment" class="btn btn-default" type="submit">Add</button>
                                            </div>
                                            <span><font id="resultMessage" color="red"></font></span>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include './includes/footer.php'; ?>
