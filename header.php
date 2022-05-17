<?php
    $curPageName = basename($_SERVER['PHP_SELF']);
    if($curPageName == 'header.php'){
        header('location: /');
    }else{
        if(session_status() == PHP_SESSION_NONE){session_start();}
    }
    if(isset($_SESSION['acc_id'])){
        $data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_accounts` WHERE acc_id='".$_SESSION["acc_id"]."' "));
    }
?>
<!-- ======= Top Bar ======= -->
<?php if ($curPageName == 'index.php') { ?>
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:<?php echo $pages['page_email']; ?>"><?php echo $pages['page_email']; ?></a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+63<?php echo $pages['page_contactno']; ?></span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <?php if ($pages['page_facebook'] != '') { ?>
                    <a href="<?php echo $pages['page_facebook']; ?>" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                <?php } ?>
                <?php if ($pages['page_instagram'] != '') { ?>
                    <a href="<?php echo $pages['page_instagram']; ?>" class="twitter" target="_blank"><i class="bi bi-instagram"></i></a>
                <?php } ?>
                <?php if ($pages['page_twitter'] != '') { ?>
                    <a href="<?php echo $pages['page_twitter']; ?>" class="instagram" target="_blank"><i class="bi bi-twitter"></i></a>
                <?php } ?>
                <?php if ($pages['page_skype'] != '') { ?>
                    <a href="<?php echo $pages['page_skype']; ?>" class="linkedin" target="_blank"><i class="bi bi-skype"></i></a>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center" <?php if ($curPageName != 'index.php'){echo ' style="top: 0px"'; } ?>>
    <div class="container d-flex align-items-center justify-content-between">
        <div class="row">
            <div class="col-auto">
                <!-- Use this if you prefer to use an image -->
                <a href="/" class="logo"><img src="/assets/img/uploads/<?php if($pages['page_website_icon']!=''){echo $pages['page_website_icon'];}?>" alt=""></a>
            </div>
            <div class="col-auto p-0">
                <!-- Use this if you prefer to use a text -->
                <h1 class="logo my-2"><a href="/"><?php echo $pages['page_website_title']; ?><span>.</span></a></h1>
            </div>
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto <?php if ($curPageName == 'index.php') { echo 'active';} ?>" href="/">Home</a></li>
                <?php if(!isset($_SESSION['acc_id'])){ ?>
                <li><a class="nav-link scrollto <?php if ($curPageName == 'register-for-social-pension.php') { echo 'active';} ?>" href="/register-for-social-pension">Register for Social Pension</a></li>
                <?php } ?>
                <li class="dropdown">
                    <a <?php if($curPageName == 'accomplishment-report.php' || $curPageName == 'portfolio.php'){echo'class="active"';}?> href="javascript:void(0);"><span>Transparency</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a class="<?php if($curPageName == 'portfolio.php'){echo'active';}?>" href="/transparency/portfolio">Portfolio</a></li>
                        <li><a class="<?php if($curPageName == 'accomplishment-report.php'){echo'active';}?>" href="/transparency/accomplishment-report">Accomplishment Report</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto <?php if ($curPageName == 'about-us.php') { echo 'active';} ?>" href="/about-us">About Us</a></li>
                <li><a class="nav-link scrollto <?php if ($curPageName == 'contact-us.php') { echo 'active';} ?>" href="/contact-us">Contact Us</a></li>
                <li><a class="nav-link scrollto <?php if ($curPageName == 'frequently-asked-questions.php') { echo 'active';} ?>" href="/frequently-asked-questions">FAQ</a></li>
                <?php if(isset($_SESSION['acc_id'])){ ?>
                    <li class="dropdown">
                        <a <?php if($curPageName == 'profile.php'){echo'class="active"';}?> href="javascript:void(0);"><span><?php echo $data['acc_username']; ?></span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <?php if($data['acc_role'] == 'Pensioner'){ ?>
                                <li><a class="<?php if($curPageName == 'profile.php'){echo'active';}?>" href="/profile">Profile</a></li>
                                <li><a href="/assets/php/logout">Logout</a></li>
                            <?php }else{ ?>
                                <li><a href="/admin/dashboard">Dashboard</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li><a class="nav-link scrollto <?php if ($curPageName == 'login.php') { echo 'active';} ?>" href="/login">Login</a></li>
                <?php } ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->