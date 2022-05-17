<?php 
    $curPageName = basename($_SERVER['PHP_SELF']);
    if ($curPageName == 'header.php') {header('location: dashboard');}
?>
<nav class="main-header navbar navbar-expand dropdown-legacy navbar-<?php if($acc['acc_darkmode'] == 1){echo 'dark';}else{echo 'white navbar-light';} ?>" id="headertag">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="/admin/website" class="nav-link">
                <i class="fas fa-desktop nav-icon"></i> 
                View Website
            </a>
        </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <?php if ($curPageName != 'multitab.php'){ ?>
        <li class="nav-item">
            <a class="nav-link glightbox" href="<?php echo $pages['page_demo_dashboard'];?>">
                <i class="fas fa-play-circle"></i> Demo
            </a>
        </li>
        <?php } ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" onclick="readNotif()">
                <i class="far fa-bell"></i>
                <span class="badge badge-primary navbar-badge" id="noti_number"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                <span class="dropdown-item dropdown-header" id="noti_number2">No New Notification</span>
                <div id="noti_dropdown" class="sidebar" style="max-height: 400px; overflow-y: auto; margin-top: 0; padding: 0;"><div class="dropdown-divider"></div>
                <div class="d-flex justify-content-center"><div class="text-center"><i class="fas fa-bell display-1"></i></div></div></div>
                <div class="dropdown-divider"></div>
                <a href="/admin/notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item ">
            <div class="btn-group">
                <a href="#" class="nav-link dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $acc['acc_username']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="/admin/accounts/profile" class="dropdown-item d-flex align-items-center overflow-hidden">
                        <img src="/assets/img/account_picture/<?php echo $acc['acc_picture'] ?>" alt="Picture" class="img-fluid img-circle" style="width: 60px; height: 60px;">
                        <h5 class="dropdown-item m-0"><?php echo $acc['acc_username']; ?><br><small class="text-muted">Go to Profile</small></h5>
                    </a>
                    <a href="/admin/accounts/profile_settings" class="dropdown-item d-flex align-items-center">
                        <i class="fas fa-cog mr-2"></i>
                        <span> Account Settings</span>
                    </a>
                    <a href="/assets/php/logout" class="dropdown-item d-flex align-items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span> Log Out</span>
                    </a>
                </div>
            </div>
        </li>
    </ul>
</nav>