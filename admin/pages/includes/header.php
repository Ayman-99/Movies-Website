<header class="main-header">
    <!-- Logo -->
    <a href="dashboard.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>F</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="font-family: serif"><b>Control</b> Panel </span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav  class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="logout.php">
                        LOG OUT
                    </a>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <?php
                if (is_Developer($moderator->getUserName())) {
                    ?>
                    <li class="dropdown notifications-menu">
                        <?php
                        $result = mysqli_query($con, "Select * from notifications order by notfiy_id DESC limit 7");
                        $count = mysqli_num_rows($result);
                        ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning"><?php echo $count; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have <?php echo $count; ?> notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-info text-aqua"></i> <?php echo $row['notfiy_from'] . " <b>" . $row['notfiy_content'] . "</b>"; ?> 
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="footer"><a href="notifications.php">View all</a></li>
                        </ul>
                    </li>
                    <?php
                };
                ?>
                <li class="user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../../img/profile/<?php echo $moderator->getUserPic(); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $moderator->getUserName(); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>






















