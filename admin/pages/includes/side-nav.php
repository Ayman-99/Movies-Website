<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../img/profile/<?php echo $moderator->getUserPic(); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $moderator->getUserName(); ?></p>
                <a href="#"> <?php echo ($moderator->getUserOnline() == 'Online') ? "<i class='fa fa-circle text-success'></i>Online" : "<i class='fa fa-circle text-muted'></i>Offline"; ?></a>
            </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php
        $current = basename($_SERVER['PHP_SELF']);
        ?>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview menu-open">
            <li>
                <a href="../../index.php">
                    <i class="fa fa-dashboard"></i> <span>Back to website</span>
                </a>
            </li>
            <li class="<?php echo ($current == "dashboard.php") ? 'active' : '' ?>">
                <a href="../index.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php
            if (is_Developer($moderator->getUserName())) {
                ?>
                <li class="<?php echo ($current == "settings.php") ? 'active' : '' ?>">
                    <a href="settings.php"><i class="fa fa-circle-o"></i> 
                        Settings
                    </a>
                </li>
                <li class="<?php echo ($current == "users.php") ? 'active' : '' ?>">
                    <a href="users.php"><i class="fa fa-circle-o"></i> 
                        Users
                    </a>
                </li>
                <li class="<?php echo ($current == "categories.php") ? 'active' : '' ?>">
                    <a href="categories.php"><i class="fa fa-circle-o"></i> 
                        Categories
                    </a>
                </li>
                <li class="<?php echo ($current == "notifications.php") ? 'active' : '' ?>">
                    <a href="notifications.php"><i class="fa fa-circle-o"></i> 
                        Notifications
                    </a>
                </li>
                <li class="<?php echo ($current == "messages.php") ? 'active' : '' ?>">
                    <a href="messages.php"><i class="fa fa-circle-o"></i> 
                        Messages
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="<?php echo ($current == "movies.php") ? 'active' : '' ?>">
                <a href="movies.php"><i class="fa fa-circle-o"></i> 
                    Movies
                </a>
            </li>
            <li class="<?php echo ($current == "comments.php") ? 'active' : '' ?>">
                <a href="comments.php"><i class="fa fa-circle-o"></i> 
                    Comments
                </a>
            </li>
            <li class="<?php echo ($current == "reviews.php") ? 'active' : '' ?>">
                <a href="reviews.php"><i class="fa fa-circle-o"></i> 
                    Reviews
                </a>
            </li>
            <li class="<?php echo ($current == "warnings.php") ? 'active' : '' ?>">
                <a href="warnings.php"><i class="fa fa-circle-o"></i> 
                    Warnings
                </a>
            </li>
            <li class="<?php echo ($current == "profile.php") ? 'active' : '' ?>">
                <a href="profile.php"><i class="fa fa-circle-o"></i> 
                    Profile
                </a>
            </li>
            <li><a href="lockscreen.php"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
