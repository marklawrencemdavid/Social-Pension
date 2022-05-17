<?php 
    include '../assets/php/database.php';
    include 'assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifications | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/admin/assets/css/admin_style.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if($acc['acc_darkmode'] == 1){echo 'dark-mode';} ?>" id="bodytag">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/assets/img/uploads/<?php echo $pages['page_website_icon']?>" alt="AdminLTELogo" height="100" width="100">
        </div>

        <!-- Navbar -->
        <?php include 'header.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Notifications</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Notifications</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2">
                            <form action="assets/php/notification_crud" method="post">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <button type="submit" class="nav-link btn col-12 <?php if(!isset($_SESSION['queryNotificationButton'])){echo 'text-primary';}?>" name="noti_all">
                                            <div class="float-left">
                                                <i class="far fa-bell"></i> All
                                            </div>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <Button class="nav-link btn col-12 navbar-toggle <?php if(isset($_SESSION['queryNotificationButton']) && ($_SESSION['queryNotificationButton']=='Pensioner Applicant' || $_SESSION['queryNotificationButton']=='Pensioner Rejected')){echo 'text-primary';}else{echo 'collapsed';}?>" 
                                            type="button" Data-target="#sample" data-toggle="collapse">
                                            <div class="float-left">
                                                <i class="far fa-file-alt"></i> Applicants
                                            </div>
                                            <div class="float-right">
                                                <i class="fas fa-angle-down"></i>
                                            </div>
                                        </Button>
                                        <div id="sample" role="tabpanel"
                                            class="collapse <?php if(isset($_SESSION['queryNotificationButton']) && ($_SESSION['queryNotificationButton']=='Pensioner Applicant' || $_SESSION['queryNotificationButton']=='Pensioner Rejected')){echo 'show';}?>" >
                                            <ul class="nav nav-pills flex-column">
                                                <Button class="nav-link btn col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Pensioner Applicant'){echo 'text-primary';}?>" 
                                                    type="submit" name="noti_pensioner_application">
                                                    <div class="float-left offset-1">
                                                        Applicant
                                                    </div>
                                                </Button>
                                                <Button class="nav-link btn col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Pensioner Rejected'){echo 'text-primary';}?>" 
                                                    type="submit" name="noti_pensioner_rejected">
                                                    <div class="float-left offset-1">
                                                        Rejected
                                                    </div>
                                                </Button>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <Button class="nav-link btn col-12 navbar-toggle <?php if(isset($_SESSION['queryNotificationButton']) && ($_SESSION['queryNotificationButton']=='Pensioner Purchase' || $_SESSION['queryNotificationButton']=='Pensioner Active' || $_SESSION['queryNotificationButton']=='Pensioner Deceased')){echo 'text-primary';}else{echo 'collapsed';}?>" 
                                            type="button" Data-target="#sample1" data-toggle="collapse">
                                            <div class="float-left">
                                                <i class="fas fa-users"></i> Pensioners
                                            </div>
                                            <div class="float-right">
                                                <i class="fas fa-angle-down"></i>
                                            </div>
                                        </Button>
                                        <div id="sample1" role="tabpanel"
                                            class="collapse <?php if(isset($_SESSION['queryNotificationButton']) && ($_SESSION['queryNotificationButton']=='Pensioner Purchase' || $_SESSION['queryNotificationButton']=='Pensioner Active' || $_SESSION['queryNotificationButton']=='Pensioner Deceased')){echo 'show';}?>" >
                                            <ul class="nav nav-pills flex-column">
                                                <Button class="nav-link btn btn-in col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Pensioner Active'){echo 'text-primary';}?>" 
                                                    type="submit" name="noti_pensioner_active">
                                                    <div class="float-left offset-1">
                                                        Active
                                                    </div>
                                                </Button>
                                                <Button class="nav-link btn btn-in col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Pensioner Purchase'){echo 'text-primary';}?>" 
                                                    type="submit" name="noti_purchase">
                                                    <div class="float-left offset-1">
                                                        Purchases
                                                    </div>
                                                </Button>
                                                <Button class="nav-link btn col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Pensioner Deceased'){echo 'text-primary';}?>" 
                                                    type="submit" name="noti_pensioner_deceased">
                                                    <div class="float-left offset-1">
                                                        Deceased
                                                    </div>
                                                </Button>
                                            </ul>
                                        </div>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <button type="submit" class="nav-link btn col-12 <?php //if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Email'){echo 'text-primary';}?>" name="noti_email">
                                            <div class="float-left">
                                                <i class="fas fa-envelope"></i> Email<span class="text-red">*</span>
                                            </div>
                                        </button>
                                    </li> -->
                                    <li class="nav-item">
                                        <button type="submit" class="nav-link btn col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Website'){echo 'text-primary';}?>" name="noti_website">
                                            <div class="float-left">
                                                <i class="fas fa-file"></i> Website
                                            </div>
                                        </button>
                                    </li>
                                    <?php if ($acc['acc_role'] != 'Staff'){ ?>
                                    <li class="nav-item">
                                        <button type="submit" class="nav-link btn col-12 <?php if(isset($_SESSION['queryNotificationButton']) && $_SESSION['queryNotificationButton']=='Account'){echo 'text-primary';}?>" name="noti_account">
                                            <div class="float-left">
                                                <i class="fas fa-user"></i> Account
                                            </div>
                                        </button>
                                    </li>
                                    <?php } ?>
                                </ul>   
                            </form>
                        </div>
                        <div class="col-md-10">
                            <div class="shadow mb-2 p-0 text-center" id="noti_new_div" style="display: none;">
                                <a href="notifications">
                                    <button class="btn btn-primary m-0 p-2 col-12" id="noti_new_detected"></button>
                                </a>
                            </div>
                            <?php
                                if ( isset( $_SESSION['queryNotification'] ) ) {
                                    $query = mySQLi_query($con, $_SESSION['queryNotification']) or die(mySQLi_error($con));
                                } else {
                                    if ($acc['acc_role'] != 'Staff') {
                                        // Super Admin and Admin
                                        $query = mySQLi_query($con, "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' order by noti_id DESC") or die(mySQLi_error($con));
                                    } else {
                                        // Staff
                                        $query = mySQLi_query($con, "SELECT * from tbl_notifications where noti_author != '".$_SESSION['acc_id']."' and noti_date_created > '".$acc['acc_date_created']."' and 
                                        (noti_action = 'Pensioner Applicant' or noti_action = 'Pensioner Active' or noti_action = 'Pensioner Deceased' or noti_action = 'Pensioner Rejected' or noti_action = 'Pensioner Deleted'
                                        or noti_action = 'Pensioner Applicant Bulk' or noti_action = 'Pensioner Active Bulk' or noti_action = 'Pensioner Deceased Bulk' or noti_action = 'Pensioner Rejected Bulk' or noti_action = 'Pensioner Deleted Bulk'
                                        or noti_action = 'Email' 
                                        or noti_action = 'Account Create' or noti_action = 'Account Delete' or noti_action = 'Account Super Admin' or noti_action = 'Account Admin' or noti_action = 'Account Staff' or noti_action = 'Account Active' or noti_action = 'Account Inactive'
                                        or noti_action = 'Account Delete Bulk' or noti_action = 'Account Super Admin Bulk' or noti_action = 'Account Admin Bulk' or noti_action = 'Account Staff Bulk' or noti_action = 'Account Active Bulk' or noti_action = 'Account Inactive Bulk'
                                        or noti_action = 'Page General' or noti_action = 'Page Mission Vision' or noti_action = 'Page Officials' or noti_action = 'Page Register'  or noti_action = 'Page Report Deleted'
                                        or noti_action = 'Page Report Insert Published' or noti_action = 'Page Report Insert Draft' or noti_action = 'Page Report Update Published' or noti_action = 'Page Report Update Draft' or noti_action = 'Page Report Update Trashed'
                                        or noti_action = 'Pensioner Purchase' or noti_action = 'Pensioner Purchase Aprroved' or noti_action = 'Pensioner Purchase Rejected' 
                                        or noti_action = 'Pensioner Purchase Approved Bulk' or noti_action = 'Pensioner Purchase Rejected Bulk' 
                                        or noti_action = 'Page Portfolio Insert Published' or noti_action = 'Page Portfolio Insert Draft' or noti_action = 'Page Portfolio Update Published' or noti_action = 'Page Portfolio Update Draft' or noti_action = 'Page Portfolio Update Trashed' or noti_action = 'Page Portfolio Deleted'
                                        ) order by noti_id DESC") or die(mySQLi_error($con));
                                    }
                                }
                                while($noti = mySQLi_fetch_assoc($query)){
                                    $noti_read = explode(',',$noti['noti_read']);
                                    $read = 0;
                                    foreach ($noti_read as $index => $value) {
                                        if ($value == $_SESSION['acc_id']) {
                                            $read = 1;
                                        }
                                    }
                                    // Update noti_read to Read
                                    if ($read == 0) {
                                        if ($noti['noti_read'] != '') {
                                            $noti_read = implode(',',$noti_read).','.$_SESSION['acc_id'];
                                        } else {
                                            $noti_read = $_SESSION['acc_id'];
                                        }
                                        mysqli_query($con, " UPDATE tbl_notifications SET noti_read = '$noti_read' WHERE noti_id = '".$noti['noti_id']."' ");
                                    }
                                    // Notif is Pensioner
                                    if ($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action'] == 'Pensioner Deleted') {
                                        $query_appl = mysqli_query($con, " SELECT * from tbl_applicants where appl_id = '".$noti['noti_data_id']."' ");
                                        if(mysqli_num_rows($query_appl) == 1){
                                            $appl = mySQLi_fetch_assoc($query_appl);
                                        }else{
                                            $appl['appl_picture'] = 'profile.svg';
                                            $appl['appl_lastname'] = 'Someone';
                                            $appl['appl_firstname'] = 'a deleted pensioner';
                                            $appl['appl_barangay'] = '...';
                                            $appl['appl_municipality'] = '...';
                                        }
                                    } 
                                    // Notif is Pensioner Bulk
                                    else if ($noti['noti_action'] == 'Pensioner Applicant Bulk' || $noti['noti_action'] == 'Pensioner Active Bulk' || $noti['noti_action'] == 'Pensioner Deceased Bulk' || $noti['noti_action'] == 'Pensioner Rejected Bulk' || $noti['noti_action'] == 'Pensioner Deleted Bulk') {
                                        $noti_data_id_explode = explode(',',$noti['noti_data_id']);
                                        $noti_data_id_bulk_count = count($noti_data_id_explode);
                                    } 
                                    // Notif is Account
                                    else if ($noti['noti_action'] == 'Account Create' || $noti['noti_action'] =='Account Delete' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive') {
                                        $query_acc = mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$noti['noti_data_id']."' ");
                                        if(mysqli_num_rows($query_acc) == 1){
                                            $acc2 = mySQLi_fetch_assoc($query_acc);
                                        }else{
                                            $acc2['acc_picture'] = 'profile.svg';
                                            $acc2['acc_lastname'] = 'Someone';
                                            $acc2['acc_firstname'] = 'a deleted account.';
                                            $acc2['acc_role'] = 'account';
                                            $acc2['acc_appl_id'] = 0;
                                        }
                                    }
                                    // Notif is Account Bulk
                                    else if ($noti['noti_action'] =='Account Delete Bulk' || $noti['noti_action'] == 'Account Super Admin Bulk' || $noti['noti_action'] == 'Account Admin Bulk' || $noti['noti_action'] == 'Account Staff Bulk' || $noti['noti_action'] == 'Account Active Bulk' || $noti['noti_action'] == 'Account Inactive Bulk') {
                                        $noti_data_id_explode = explode(',',$noti['noti_data_id']);
                                        $noti_data_id_bulk_count = count($noti_data_id_explode);
                                    }
                                    // Notif is Website
                                    else if ($noti['noti_action'] == 'Page General' || $noti['noti_action'] == 'Page Mission Vision' || $noti['noti_action'] == 'Page Officials' || $noti['noti_action'] == 'Page Register' || $noti['noti_action'] == 'Page Settings') {
                                        $page = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_pages where page_id = '1' "));
                                    }
                                    // Notif is Website Report
                                    else if ($noti['noti_action'] == 'Page Report Deleted' || $noti['noti_action'] == 'Page Report Insert Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Trashed') {
                                        if(!($report = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_reports where rep_id = '".$noti['noti_data_id']."' ")))){
                                            $report['rep_title'] = ' Item unavailable';
                                            $report['rep_notes'] = ' Report is already deleted';
                                        }
                                    }
                                    // Purchase
                                    else if ($noti['noti_action'] == 'Pensioner Purchase' || $noti['noti_action'] == 'Pensioner Purchase Aprroved' || $noti['noti_action'] == 'Pensioner Purchase Rejected') {
                                        $pur = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_purchases where pur_id = '".$noti['noti_data_id']."' "));
                                    }
                                    // Purchase Bulk
                                    else if ($noti['noti_action'] == 'Pensioner Purchase Approved Bulk' || $noti['noti_action'] == 'Pensioner Purchase Rejected Bulk') {
                                        $log_data_id_explode = explode(',',$noti['noti_data_id']);
                                        $log_data_id_bulk_count = count($log_data_id_explode);
                                    }
                                    // Portfolio
                                    else if ($noti['noti_action'] == 'Page Portfolio Insert Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Deleted') {
                                        if(!($port = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_portfolios where port_id = '".$noti['noti_data_id']."' ")))){
                                            $port['port_title'] = ' Item unavailable';
                                            $port['port_notes'] = ' Portfolio activity is already deleted';
                                        }
                                    }
                                    // Subscriber
                                    else if ($noti['noti_action'] == 'Subscriber') {
                                        if(!($subs = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$noti['noti_data_id']."' ")))){
                                            $subs['subs_email'] = ' A deleted subscriber';
                                        }
                                    }

                                    // Notif Author
                                    if($noti['noti_author'] == $_SESSION['acc_id']){
                                        $name = 'You';
                                    }else if($noti['noti_author'] == 'Auto'){
                                        $name = '';
                                    }else if($noti['noti_author'] != 'Someone'){
                                        if($noti['noti_action'] != 'Subscriber'){
                                            if($noti_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$noti['noti_author']."' "))){
                                                $name = $noti_author['acc_username'];
                                            }else{
                                                $name = 'A deleted account';
                                            }
                                        }elseif($noti['noti_action'] == 'Subscriber'){
                                            if($noti_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$noti['noti_author']."' "))){
                                                $name = $noti_author['subs_email'];
                                            }else{
                                                $name = 'A deleted subscriber';
                                            }
                                        }
                                    }else{
                                        $name = 'Someone';
                                    }
                            ?>
                                        <div class="callout <?php if($read == 0){echo 'callout-info';}?> shadow mb-2 p-0">
                                            <div class="card p-0 m-0">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <!-- Icon -->
                                                        <?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action'] == 'Pensioner Deleted'
                                                            || $noti['noti_action'] == 'Pensioner Applicant Bulk' || $noti['noti_action'] == 'Pensioner Active Bulk' || $noti['noti_action'] == 'Pensioner Deceased Bulk' || $noti['noti_action'] == 'Pensioner Rejected Bulk' || $noti['noti_action'] == 'Pensioner Deleted Bulk')
                                                            {echo '<i class="fas fa-file-alt mr-2"></i> ';}
                                                        else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] =='Account Deleted' || $noti['noti_action'] == 'Account Delete' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive'
                                                            || $noti['noti_action'] =='Account Deleted Bulk' || $noti['noti_action'] == 'Account Super Admin Bulk' || $noti['noti_action'] == 'Account Admin Bulk' || $noti['noti_action'] == 'Account Staff Bulk' || $noti['noti_action'] == 'Account Active Bulk' || $noti['noti_action'] == 'Account Inactive Bulk')
                                                            {echo '<i class="fas fa-user mr-2"></i> ';}
                                                        else if($noti['noti_action'] == 'Page General' || $noti['noti_action'] == 'Page Mission Vision' || $noti['noti_action'] == 'Page Officials' || $noti['noti_action'] == 'Page Register' || $noti['noti_action'] == 'Page Settings' || $noti['noti_action'] == 'Page Report Deleted'
                                                            || $noti['noti_action'] == 'Page Report Insert Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Trashed')
                                                            {echo '<i class="fas fa-book mr-2"></i> ';}
                                                        else if($noti['noti_action'] == 'Backup'){echo '<i class="fas fa-hdd"></i> ';}
                                                        else if($noti['noti_action'] == 'Backup Upload'){echo '<i class="fas fa-upload"></i> ';}
                                                        else if($noti['noti_action'] == 'Restore'){echo '<i class="fas fa-undo-alt"></i> ';}
                                                        else if($noti['noti_action'] == 'Backup Days'){echo '<i class="fas fa-calendar"></i> ';}
                                                        else if($noti['noti_action'] == 'Backup Auto'){echo '<i class="fas fa-stopwatch"></i> ';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Pending' || $noti['noti_action'] == 'Pensioner Purchase' || $noti['noti_action'] == 'Pensioner Purchase Approved' || $noti['noti_action'] == 'Pensioner Purchase Rejected' || $noti['noti_action'] == 'Pensioner Purchase Approved Bulk' || $noti['noti_action'] == 'Pensioner Purchase Rejected Bulk')
                                                            {echo '<i class="fas fa-receipt"></i> ';}
                                                        else if ($noti['noti_action'] == 'Page Portfolio Insert Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Deleted')
                                                            {echo '<i class="fas fa-folder"></i> ';}
                                                        else if ($noti['noti_action'] == 'Subscriber')
                                                            {echo '<i class="fas fa-plus"></i> ';}
                                                        ?>
                                                        <!-- Author -->
                                                        <?php if($noti['noti_author'] != 'Someone'){?><span class="text-primary"><?php echo $name; ?></span><?php }?>
                                                        <!-- Action Pensioner Solo -->
                                                        <?php if($noti['noti_action']=='Pensioner Applicant'){if($noti['noti_author'] == 'Someone'){echo 'New applicant.';}else{echo ' added a new applicant.';}}
                                                        else if($noti['noti_action'] == 'Pensioner Active'){echo ' approved pensioner.';}
                                                        else if($noti['noti_action'] == 'Pensioner Deceased'){echo ' set a pensioner as deceased.';}
                                                        else if($noti['noti_action'] == 'Pensioner Rejected'){echo ' rejected an applicant.';}
                                                        else if($noti['noti_action'] == 'Pensioner Deleted'){echo ' deleted an applicant data.';}
                                                        // Action Pensioner Bulk
                                                        else if($noti['noti_action'] == 'Pensioner Applicant Bulk'){echo ' added '.$noti_data_id_bulk_count.' new applicants.';}
                                                        else if($noti['noti_action'] == 'Pensioner Active Bulk'){echo ' approved '.$noti_data_id_bulk_count.' pensioners.';}
                                                        else if($noti['noti_action'] == 'Pensioner Deceased Bulk'){echo ' set '.$noti_data_id_bulk_count.' pensioners as deceased.';}
                                                        else if($noti['noti_action'] == 'Pensioner Rejected Bulk'){echo ' rejected '.$noti_data_id_bulk_count.' applicants.';}
                                                        else if($noti['noti_action'] == 'Pensioner Deleted Bulk'){echo ' deleted '.$noti_data_id_bulk_count.' applicant data.';}
                                                        // Action Account
                                                        else if($noti['noti_action'] == 'Account Create'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($noti['noti_action'] == 'Account Deleted'){echo ' deleted an account';}
                                                        else if($noti['noti_action'] == 'Account Super Admin'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($noti['noti_action'] == 'Account Admin'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($noti['noti_action'] == 'Account Staff'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($noti['noti_action'] == 'Account Active'){echo ' set '.$acc2['acc_username'].' as Active.';}
                                                        else if($noti['noti_action'] == 'Account Inactive'){echo ' set '.$acc2['acc_role'].' as Inactive';}
                                                        // Action Account Bulk
                                                        else if($noti['noti_action'] == 'Account Deleted Bulk'){echo ' deleted '.$noti_data_id_bulk_count.' accounts.';}
                                                        else if($noti['noti_action'] == 'Account Super Admin Bulk'){echo ' set '.$noti_data_id_bulk_count.' accounts as Super Admin.';}
                                                        else if($noti['noti_action'] == 'Account Admin Bulk'){echo ' set '.$noti_data_id_bulk_count.' accounts as Admin.';}
                                                        else if($noti['noti_action'] == 'Account Staff Bulk'){echo ' set '.$noti_data_id_bulk_count.' accounts as Staff.';}
                                                        else if($noti['noti_action'] == 'Account Active Bulk'){echo ' set '.$noti_data_id_bulk_count.' accounts as Active.';}
                                                        else if($noti['noti_action'] == 'Account Inactive Bulk'){echo ' set '.$noti_data_id_bulk_count.' accounts as Inactive.';}
                                                        // Action Website
                                                        else if($noti['noti_action'] == 'Page General'){echo ' updated website\'s general information.';}
                                                        else if($noti['noti_action'] == 'Page Mission Vision'){echo ' update website\'s mission and vision page.';}
                                                        else if($noti['noti_action'] == 'Page Officials'){echo ' updated website\'s officails page.';}
                                                        else if($noti['noti_action'] == 'Page Register'){echo ' updated website\'s social pension registration page.';}
                                                        else if($noti['noti_action'] == 'Page Settings'){echo ' updated website information.';}
                                                        // Action Website Report
                                                        else if($noti['noti_action'] == 'Page Report Insert Published'){echo ' created and published a new report .';}
                                                        else if($noti['noti_action'] == 'Page Report Insert Draft'){echo ' created and drafted a new report.';}
                                                        else if($noti['noti_action'] == 'Page Report Update Published'){echo ' updated and published a report.';}
                                                        else if($noti['noti_action'] == 'Page Report Update Draft'){echo ' updated and drafted a report.';}
                                                        else if($noti['noti_action'] == 'Page Report Update Trashed'){echo ' move a report to trash.';}
                                                        else if($noti['noti_action'] == 'Page Report Deleted'){echo ' deleted a report.';}
                                                        // Backup/Restore
                                                        else if($noti['noti_action'] == 'Backup'){echo ' performed a backup.';}
                                                        else if($noti['noti_action'] == 'Backup Upload'){echo ' uploaded a backup.';}
                                                        else if($noti['noti_action'] == 'Restore'){echo ' performed a data restoration.';}
                                                        else if($noti['noti_action'] == 'Backup Days'){echo ' updated the backup schedule.';}
                                                        else if($noti['noti_action'] == 'Backup Auto'){echo ' System auto backup performed successfully.';}
                                                        // Purchase
                                                        else if($noti['noti_action'] == 'Pensioner Purchase'){echo ' added new purchase item.';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Pending'){echo ' set an purchase item as pending.';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Approved'){echo ' approved an purchase item.';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Rejected'){echo ' rejected an purchase item.';}
                                                        // Purchase Bulk
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Pending Bulk'){echo ' set '.$log_data_id_bulk_count.' purchase item as pending.';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Approved Bulk'){echo ' approved '.$log_data_id_bulk_count.' purchase item.';}
                                                        else if($noti['noti_action'] == 'Pensioner Purchase Rejected Bulk'){echo ' rejected '.$log_data_id_bulk_count.' purchase item.';}
                                                        // Action Website Portfolio
                                                        else if($noti['noti_action'] == 'Page Portfolio Insert Published'){echo ' created and published a new portfolio activity.';}
                                                        else if($noti['noti_action'] == 'Page Portfolio Insert Draft'){echo ' created and drafted a new portfolio activity.';}
                                                        else if($noti['noti_action'] == 'Page Portfolio Update Published'){echo ' updated and published an portfolio activity.';}
                                                        else if($noti['noti_action'] == 'Page Portfolio Update Draft'){echo ' updated and drafted an portfolio activity.';}
                                                        else if($noti['noti_action'] == 'Page Portfolio Update Trashed'){echo ' move an portfolio activity to trash.';}
                                                        else if($noti['noti_action'] == 'Page Portfolio Deleted'){echo ' deleted an portfolio activity.';}
                                                        // Subscriber
                                                        else if($noti['noti_action'] == 'Subscriber'){echo ' Someone subscribed to the newsletter.';}
                                                        ?>
                                                    </h3>
                                                    <div class="card-tools">
                                                        <small class="float-right"><i class="far fa-clock"></i> <?php echo $noti['noti_date_created'];?></small>
                                                    </div>
                                                </div>
                                                <?php if($noti['noti_action'] == 'Page Report Update Trashed' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Insert Published'
                                                    || $noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected' 
                                                    || $noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive'
                                                    || $noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Insert Published'
                                                    ){ ?>
                                                    <div class="card-body py-3">
                                                        <?php if($noti['noti_action'] == 'Page Report Update Trashed' || $noti['noti_action'] == 'Page Report Update Draft' || $noti['noti_action'] == 'Page Report Update Published' || $noti['noti_action'] == 'Page Report Insert Draft' || $noti['noti_action'] == 'Page Report Insert Published'){ ?>
                                                            <table>
                                                                <tr>
                                                                    <td class="text-bold">Title: </td>
                                                                    <td class="h5"><?php echo $report['rep_title']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-bold">Note: </td>
                                                                    <td class="h6"><?php 
                                                                            if(strlen($report['rep_notes']) < 100){
                                                                                echo $report['rep_notes'];
                                                                            }else{
                                                                                $port_notes = $report['rep_notes']." ";
                                                                                $port_notes = substr($port_notes,0,100);
                                                                                $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                                                                $port_notes = $port_notes."...";
                                                                                echo $port_notes;
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        <?php }elseif($noti['noti_action'] == 'Page Portfolio Update Trashed' || $noti['noti_action'] == 'Page Portfolio Update Draft' || $noti['noti_action'] == 'Page Portfolio Update Published' || $noti['noti_action'] == 'Page Portfolio Insert Draft' || $noti['noti_action'] == 'Page Portfolio Insert Published'){ ?>
                                                            <table>
                                                                <tr>
                                                                    <td class="text-bold d-flex align-items-starts">Title: </td>
                                                                    <td class="h5"><?php echo $port['port_title']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-bold d-flex align-items-starts">Text: </td>
                                                                    <td class="h6"><?php
                                                                        if(strlen($port['port_notes']) < 100){
                                                                            echo $port['port_notes'];
                                                                        }else{
                                                                            $port_notes = $port['port_notes']." ";
                                                                            $port_notes = substr($port_notes,0,100);
                                                                            $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                                                            $port_notes = $port_notes."...";
                                                                            echo $port_notes;
                                                                        }
                                                                    ?>
                                                                </td>
                                                                </tr>
                                                            </table>
                                                        <?php }else{ ?>
                                                            <div class="row">
                                                                <!-- Image -->
                                                                <img src="<?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected')
                                                                        {echo '/assets/img/applicant_picture/'.$appl['appl_picture'];}
                                                                    else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                                        {if($acc2['acc_appl_id'] == 0){echo '../assets/img/account_picture/'.$acc2['acc_picture'];}else{echo '../assets/img/applicant_picture/'.$acc2['acc_picture'];}}?>" 
                                                                    alt="Picture" class="img-circle img-responsive mr-3 shadow" style="width: 60px; height: 60px;background: gray;">
                                                                <div>
                                                                    <!-- Name -->
                                                                    <h5><?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected')
                                                                            {echo $appl['appl_lastname'].', '.$appl['appl_firstname'];}
                                                                        else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                                            {echo $acc2['acc_lastname'].', '.$acc2['acc_firstname'];}?>
                                                                    </h5>
                                                                    <!-- Address || Role -->
                                                                    <p><?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action'] == 'Pensioner Active' || $noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action'] == 'Pensioner Rejected')
                                                                            {echo 'From '.$appl['appl_barangay'].', '.$appl['appl_municipality'].'.';}
                                                                        else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                                        {if($acc2['acc_role'] == 'Admin'){echo 'An ';}else{echo 'A ';}echo $acc2['acc_role'].'.';}?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <!-- Go to Button -->
                                                        <a href="<?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action']=='Pensioner Applicant Bulk')
                                                                            {echo '/admin/applicants/applicants';}
                                                                        else if($noti['noti_action'] == 'Pensioner Active' || $noti['noti_action']=='Pensioner Active Bulk')
                                                                            {echo '/admin/pensioners/active';}
                                                                        else if($noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action']=='Pensioner Deceased Bulk')
                                                                            {echo '/admin/pensioners/deceased';}
                                                                        else if($noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action']=='Pensioner Rejected Bulk')
                                                                            {echo '/admin/applicants/rejected';}
                                                                        else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                                            {echo '/admin/accounts/all_accounts';}?>">
                                                            <button class="btn btn-default btn-sm mt-3">
                                                                Go to <?php if($noti['noti_action'] == 'Pensioner Applicant' || $noti['noti_action']=='Pensioner Applicant Bulk'){echo 'Applicants ';}
                                                                            else if($noti['noti_action'] == 'Pensioner Active' || $noti['noti_action']=='Pensioner Active Bulk'){echo 'Active ';}
                                                                            else if($noti['noti_action'] == 'Pensioner Deceased' || $noti['noti_action']=='Pensioner Deceased Bulk'){echo 'Deceased ';}
                                                                            else if($noti['noti_action'] == 'Pensioner Rejected' || $noti['noti_action']=='Pensioner Rejected Bulk'){echo 'Rejected ';}
                                                                            else if($noti['noti_action'] == 'Account Create' || $noti['noti_action'] == 'Account Super Admin' || $noti['noti_action'] == 'Account Admin' || $noti['noti_action'] == 'Account Staff' || $noti['noti_action'] == 'Account Active' || $noti['noti_action'] == 'Account Inactive')
                                                                            {echo 'Accounts ';}
                                                                        ?> page
                                                            </button>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                            <?php } // End While
                                // No notification
                                if (($noti = mysqli_num_rows($query)) == 0){ 
                            ?>
                                <div class="d-flex justify-content-center mt-5">
                                    <div class="text-center">
                                        <h1><i class="fas fa-bell display-1"></i></h1>
                                        <h1>No Notification</h1>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
</body>
</html>
