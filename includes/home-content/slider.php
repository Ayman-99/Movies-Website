<article class="home" id="menu_home">
    <div class="bg-cover"></div>
    <div id="slider-home" class="carousel slide animated" data-animation="fadeInDown" data-animation-delay="200" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <?php
            $flag = false;
            $sql = "select movie_Name, movie_id, category_name from movie_info limit 5";
            $result = mysqli_query($con, $sql);
            confirmQuery($result);

            while ($row = mysqli_fetch_array($result)) {
                //To set at least 1 as active
                if ($flag == false) {
                    $flag = true;
                    ?>
                    <div class='item active'>
                        <h2 class='animated' data-animation='fadeInDownBig' data-animation-delay='200'>
                            <b><?php echo $row['movie_Name']; ?></b>
                            <?php echo ($row['category_name'] == "Premium") ? "<br><font color='#d8d5be'> (Premium)</font>" : ""; ?>
                            <br /> <font color='green'>has been added</font>
                        </h2>
                        <?php
                        if ($row['category_name'] !== "Premium") {
                            ?>
                            <a href='movie_profile.php?id=<?php echo $row['movie_id']; ?>' class='btn btn-slider animated' data-animation='flipInY' data-animation-delay='500'>Click to view it</a>
                            <?php
                        } else if (is_Premium($loggedIn) || is_Moderator($loggedIn) || is_Developer($loggedIn)) {
                            ?>
                            <a href='movie_profile.php?id=<?php echo $row['movie_id']; ?>' class='btn btn-slider animated' data-animation='flipInY' data-animation-delay='500'>Click to view it</a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    continue;
                }
                ?>
                <div class='item'>
                    <h2 class='animated' data-animation='fadeInDownBig' data-animation-delay='200'>
                        <b><?php echo $row['movie_Name']; ?></b>
                        <?php echo ($row['category_name'] == "Premium") ? "<br><font color='#d8d5be'> (Premium)</font>" : ""; ?>
                        <br /> <font color='green'>has been added</font></h2>
                    <?php
                    if ($row['category_name'] !== "Premium") {
                        ?>
                        <a href='movie_profile.php?id=<?php echo $row['movie_id']; ?>' class='btn btn-slider animated' data-animation='flipInY' data-animation-delay='500'>Click to view it</a>
                        <?php
                    } else if (is_Premium($loggedIn) || is_Moderator($loggedIn)) {
                        ?>
                        <a href='movie_profile.php?id=<?php echo $row['movie_id']; ?>' class='btn btn-slider animated' data-animation='flipInY' data-animation-delay='500'>Click to view it</a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slider-home" data-slide="prev">
            <i class="icon-left-open-big"></i>
        </a>
        <a class="right carousel-control" href="#slider-home" data-slide="next">
            <i class="icon-right-open-big"></i>
        </a>
    </div>
</article>
