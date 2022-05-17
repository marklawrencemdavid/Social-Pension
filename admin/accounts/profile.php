<?php 
    include '../../assets/php/database.php';
    include '../assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile | <?php echo $pages['page_website_title'];?></title>

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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if($acc['acc_darkmode'] == 1){echo 'dark-mode';} ?>" id="bodytag" style="overflow-x: hidden;">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/assets/img/uploads/<?php echo $pages['page_website_icon']?>" alt="AdminLTELogo" height="100" width="100">
        </div>

        <!-- Navbar -->
        <?php include '../header.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Profile</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Accounts</li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h5 class="text-center"><?php echo $acc['acc_role'] ?></h5>
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="/assets/img/account_picture/<?php echo $acc['acc_picture'] ?>" 
                                        alt="" style="background-color: #777777; width: 200px; height: 200px; border: 0; padding: 0;">
                                    </div><br>
                                    <h6 class="text-center mb-0 text-wrap"><?php echo $acc['acc_firstname'] . ' ' . $acc['acc_lastname'] ?></h6>
                                    <p class="text-center text-muted"><?php echo $acc['acc_username'] ?></p>
                                    <div class="text-center">
                                        <p class="text-center mb-0"><i class="fas fa-envelope"> </i>  <?php echo $acc['acc_email'] ?></p>
                                        <p class="text-center"><i class="fas fa-phone-alt"> </i>  <?php echo $acc['acc_contactno'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" href="/admin/accounts/profile">
                                            <i class="fas fa-clock"></i> Activity Log
                                        </a>
                                        <a class="nav-link" href="/admin/accounts/profile_settings">
                                            <i class="fas fa-cog"></i> Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <h5><i class="fas fa-clock"></i> Activity Log</h5>
                                    <hr>
                                    <div class="timeline">
                                        <?php 
                                            $query = mySQLi_query($con, 'SELECT * from tbl_activitylog where log_author = '.$_SESSION['acc_id'].' AND log_action != "SMS Send" order by log_id DESC') or die(mySQLi_error($con));
                                            $log_date = '';
                                            while($log = mySQLi_fetch_assoc($query)){
                                                $log_date_new = date("M d, Y", strtotime($log['log_date']));
                                                // ActLog is Pensioner
                                                if ($log['log_action'] == 'Pensioner Applicant' || $log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Rejected' || $log['log_action'] == 'Pensioner Deleted') {
                                                    $query_appl = mysqli_query($con, " SELECT * from tbl_applicants where appl_id = '".$log['log_data_id']."' ");
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
                                                // ActLog is Pensioner Bulk
                                                else if ($log['log_action'] == 'Pensioner Applicant Bulk' || $log['log_action'] == 'Pensioner Active Bulk' || $log['log_action'] == 'Pensioner Deceased Bulk' || $log['log_action'] == 'Pensioner Rejected Bulk' || $log['log_action'] == 'Pensioner Deleted Bulk') {
                                                    $log_data_id_explode = explode(',',$log['log_data_id']);
                                                    $log_data_id_bulk_count = count($log_data_id_explode);
                                                } 
                                                // ActLog is Account
                                                else if ($log['log_action'] == 'Account Create' || $log['log_action'] =='Account Delete' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Inactive' 
                                                    || $log['log_action'] == 'Account Username Update' || $log['log_action'] == 'Account Password Update') {
                                                    $query_acc = mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$log['log_data_id']."' ");
                                                    if(mysqli_num_rows($query_acc) == 1){
                                                        $acc2 = mySQLi_fetch_assoc($query_acc);
                                                    }else{
                                                        $acc2['acc_username'] = 'deleted account';
                                                        $acc2['acc_picture'] = 'profile.svg';
                                                        $acc2['acc_lastname'] = 'Someone';
                                                        $acc2['acc_firstname'] = 'a deleted account.';
                                                        $acc2['acc_role'] = 'account';
                                                        $acc2['acc_appl_id'] = 0;
                                                    }
                                                }
                                                // ActLog is Account Bulk
                                                else if ($log['log_action'] =='Account Deleted Bulk' || $log['log_action'] == 'Account Super Admin Bulk' || $log['log_action'] == 'Account Admin Bulk' || $log['log_action'] == 'Account Staff Bulk' || $log['log_action'] == 'Account Active Bulk' || $log['log_action'] == 'Account Inactive Bulk') {
                                                    $log_data_id_explode = explode(',',$log['log_data_id']);
                                                    $log_data_id_bulk_count = count($log_data_id_explode);
                                                }
                                                // ActLog is Website
                                                else if ($log['log_action'] == 'Page General' || $log['log_action'] == 'Page Mission Vision' || $log['log_action'] == 'Page Officials' || $log['log_action'] == 'Page Register' || $log['log_action'] == 'Page Settings') {
                                                    $page = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_pages where page_id = '1' "));
                                                }
                                                // ActLog is Website Report
                                                else if ($log['log_action'] == 'Page Report Deleted' || $log['log_action'] == 'Page Report Insert Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Update Published' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Trashed') {
                                                    if(!($report = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_reports where rep_id = '".$log['log_data_id']."' ")))){
                                                        $report['rep_title'] = ' Item unavailable';
                                                        $report['rep_notes'] = ' Report is already deleted';
                                                    }
                                                }
                                                // Purchase
                                                else if ($log['log_action'] == 'Pensioner Purchase' || $log['log_action'] == 'Pensioner Purchase Pending' || $log['log_action'] == 'Pensioner Purchase Approve' || $log['log_action'] == 'Pensioner Purchase Rejected') {
                                                    $pur = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_purchases where pur_id = '".$log['log_data_id']."' "));
                                                }
                                                // Purchase Bulk
                                                else if ($log['log_action'] == 'Pensioner Purchase Pending Bulk' || $log['log_action'] == 'Pensioner Purchase Approve Bulk' || $log['log_action'] == 'Pensioner Purchase Rejected Bulk') {
                                                    $log_data_id_explode = explode(',',$log['log_data_id']);
                                                    $log_data_id_bulk_count = count($log_data_id_explode);
                                                }
                                                // Portfolio
                                                else if ($log['log_action'] == 'Page Portfolio Insert Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Update Published' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Deleted') {
                                                    if(!($port = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_portfolios where port_id = '".$log['log_data_id']."' ")))){
                                                        $port['port_title'] = ' Item unavailable';
                                                        $port['port_notes'] = ' Portfolio activity is already deleted';
                                                    }
                                                }
                                                // FAQs
                                                else if ($log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted'){
                                                    if(!($faq = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_faqs where faq_id = '".$log['log_data_id']."' ")))){
                                                        $faq['faq_question'] = ' Item unavailable';
                                                        $faq['faq_answer'] = ' Question is already deleted';
                                                    }
                                                }
                                                // Subscriber
                                                else if ($log['log_action'] == 'Subscriber') {
                                                    if(!($subs = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$log['log_data_id']."' ")))){
                                                        $subs['subs_email'] = ' A deleted subscriber';
                                                    }
                                                }
                                                
                                                // ActLog Author
                                                if($log['log_author'] == $_SESSION['acc_id']){
                                                    $name = 'You';
                                                }else if($log['log_author'] == 'Auto'){
                                                    $name = '';
                                                }else if($log['log_author'] != 'Someone'){
                                                    if($log['log_action'] == 'Delete Account'){
                                                        $name = 'Someone';
                                                    }elseif($log['log_action'] == 'Subscriber'){
                                                        if($log_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_subscribers where subs_id = '".$log['log_author']."' "))){
                                                            $name = $log_author['subs_email'];
                                                        }else{
                                                            $name = 'A deleted subscriber';
                                                        }
                                                    }else{
                                                        if($log_author = mySQLi_fetch_assoc(mysqli_query($con, " SELECT * from tbl_accounts where acc_id = '".$log['log_author']."' "))){
                                                            $name = $log_author['acc_username'];
                                                        }else{
                                                            $name = 'A deleted account';
                                                        }
                                                    }
                                                }else{
                                                    $name = 'Someone';
                                                }
                                        ?>
                                            <?php if($log_date != $log_date_new){ $log_date = $log_date_new ?>
                                                <div class="time-label">
                                                    <span class="bg-primary"><?php echo $log_date_new ?></span>
                                                </div>
                                            <?php } ?>
                                            <div>
                                                <!-- Icon -->
                                                <?php if($log['log_action']=='Pensioner Applicant' || $log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Rejected' || $log['log_action'] == 'Pensioner Deleted' 
                                                        || $log['log_action'] == 'Pensioner Applicant Bulk' || $log['log_action'] == 'Pensioner Active Bulk' || $log['log_action'] == 'Pensioner Deceased Bulk' || $log['log_action'] == 'Pensioner Rejected Bulk' || $log['log_action'] == 'Pensioner Deleted Bulk')
                                                        {echo '<i class="fas fa-file-alt bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Account Create' || $log['log_action'] == 'Account Deleted' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Inactive'
                                                        || $log['log_action'] == 'Account Deleted Bulk' || $log['log_action'] == 'Account Super Admin Bulk' || $log['log_action'] == 'Account Admin Bulk' || $log['log_action'] == 'Account Staff Bulk' || $log['log_action'] == 'Account Active Bulk' || $log['log_action'] == 'Account Inactive Bulk'
                                                        || $log['log_action'] == 'Profile Password' || $log['log_action'] == 'Profile Details' || $log['log_action'] == 'Account Username Update' || $log['log_action'] == 'Account Password Update'
                                                        || $log['log_action'] == 'Delete Account')
                                                        {echo '<i class="fas fa-user bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Page General' || $log['log_action'] == 'Page Mission Vision' || $log['log_action'] == 'Page Officials' || $log['log_action'] == 'Page Register' || $log['log_action'] == 'Page Settings'
                                                        || $log['log_action'] == 'Page Report Insert Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Update Published' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Trashed' || $log['log_action'] == 'Page Report Deleted')
                                                        {echo '<i class="fas fa-book bg-gray"></i>';}
                                                    else if($log['log_action'] == 'To Do Delete' || $log['log_action'] == 'To Do Update' || $log['log_action'] == 'To Do Create')
                                                        {echo '<i class="fas fa-clipboard bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Login'){echo '<i class="fas fa-sign-in-alt bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Logout'){echo '<i class="fas fa-sign-out-alt bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Backup'){echo '<i class="fas fa-hdd bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Backup Upload'){echo '<i class="fas fa-upload bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Restore'){echo '<i class="fas fa-undo-alt bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Backup Days'){echo '<i class="fas fa-calendar-check bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Pensioner Purchase' || $log['log_action'] == 'Pensioner Purchase Pending' || $log['log_action'] == 'Pensioner Purchase Approve' || $log['log_action'] == 'Pensioner Purchase Rejected' || $log['log_action'] == 'Pensioner Purchase Pending Bulk' || $log['log_action'] == 'Pensioner Purchase Approve Bulk' || $log['log_action'] == 'Pensioner Purchase Rejected Bulk')
                                                        {echo '<i class="fas fa-receipt bg-gray"></i>';}
                                                    else if ($log['log_action'] == 'Page Portfolio Insert Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Update Published' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Deleted')
                                                        {echo '<i class="fas fa-folder bg-gray"></i>';}
                                                    else if ($log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted')
                                                        {echo '<i class="fas fa-question-circle bg-gray"></i>';}
                                                    else if($log['log_action'] == 'Subscriber')
                                                        {echo '<i class="fas fa-plus bg-gray"></i> ';}
                                                ?>
                                                    
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> <?php echo date("h:i a", strtotime($log['log_date'])) ?></span>
                                                    <h3 class="timeline-header <?php if($log['log_action'] == 'Login' || $log['log_action'] == 'Logout' || $log['log_action'] == 'To Do Create' || $log['log_action'] == 'To Do Update' || $log['log_action'] == 'To Do Delete' || $log['log_action'] == 'Profile Details' || $log['log_action'] == 'Profile Password'
                                                            || $log['log_action'] == 'Account Deleted Bulk'|| $log['log_action'] == 'Account Deleted' || $log['log_action'] == 'Pensioner Deleted Bulk' || $log['log_action'] == 'Pensioner Deleted' 
                                                            || $log['log_action'] == 'Backup' || $log['log_action'] == 'Backup Upload' || $log['log_action'] == 'Restore' || $log['log_action'] == 'Backup Days'
                                                            || $log['log_action'] == 'Pensioner Purchase' || $log['log_action'] == 'Pensioner Purchase Pending' || $log['log_action'] == 'Pensioner Purchase Approve' || $log['log_action'] == 'Pensioner Purchase Rejected' 
                                                            || $log['log_action'] == 'Pensioner Purchase Pending Bulk' || $log['log_action'] == 'Pensioner Purchase Approve Bulk' || $log['log_action'] == 'Pensioner Purchase Rejected Bulk' 
                                                            || $log['log_action'] == 'Page Report Deleted' || $log['log_action'] == 'Page Portfolio Deleted' || $log['log_action'] == 'Account Username Update' || $log['log_action'] == 'Account Password Update'
                                                            || $log['log_action'] == 'Subscriber' || $log['log_action'] == 'Delete Account'
                                                        )
                                                            {echo 'border-0';}?>">
                                                        <strong class="text-primary"><?php if($log['log_author'] != 'Someone'){echo $name;} ?></strong> 
                                                        <?php // Action Pensioner Solo
                                                        if($log['log_action']=='Pensioner Applicant'){if($log['log_author'] == 'Someone'){echo 'New applicant.';}else{echo ' added a new applicant.';}}
                                                        else if($log['log_action'] == 'Pensioner Active'){echo ' approved pensioner.';}
                                                        else if($log['log_action'] == 'Pensioner Deceased'){echo ' set a pensioner as deceased.';}
                                                        else if($log['log_action'] == 'Pensioner Rejected'){echo ' rejected an applicant.';}
                                                        else if($log['log_action'] == 'Pensioner Deleted'){echo ' deleted an applicant data.';}
                                                        // Action Pensioner Bulk
                                                        else if($log['log_action'] == 'Pensioner Applicant Bulk'){echo ' added '.$log_data_id_bulk_count.' new applicants.';}
                                                        else if($log['log_action'] == 'Pensioner Active Bulk'){echo ' approved '.$log_data_id_bulk_count.' pensioners.';}
                                                        else if($log['log_action'] == 'Pensioner Deceased Bulk'){echo ' set '.$log_data_id_bulk_count.' pensioners as deceased.';}
                                                        else if($log['log_action'] == 'Pensioner Rejected Bulk'){echo ' rejected '.$log_data_id_bulk_count.' applicants.';}
                                                        else if($log['log_action'] == 'Pensioner Deleted Bulk'){echo ' deleted '.$log_data_id_bulk_count.' applicant data.';}
                                                        // Action Account
                                                        else if($log['log_action'] == 'Account Create'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($log['log_action'] == 'Account Deleted'){echo ' deleted an account';}
                                                        else if($log['log_action'] == 'Account Super Admin'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($log['log_action'] == 'Account Admin'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($log['log_action'] == 'Account Staff'){echo ' added a new '.$acc2['acc_role'];}
                                                        else if($log['log_action'] == 'Account Active'){echo ' set '.$acc2['acc_username'].' as Active.';}
                                                        else if($log['log_action'] == 'Account Inactive'){echo ' set '.$acc2['acc_username'].' as Inactive';}
                                                        // Action Account Bulk
                                                        else if($log['log_action'] == 'Account Deleted Bulk'){echo ' deleted '.$log_data_id_bulk_count.' accounts.';}
                                                        else if($log['log_action'] == 'Account Super Admin Bulk'){echo ' set '.$log_data_id_bulk_count.' accounts as Super Admin.';}
                                                        else if($log['log_action'] == 'Account Admin Bulk'){echo ' set '.$log_data_id_bulk_count.' accounts as Admin.';}
                                                        else if($log['log_action'] == 'Account Staff Bulk'){echo ' set '.$log_data_id_bulk_count.' accounts as Staff.';}
                                                        else if($log['log_action'] == 'Account Active Bulk'){echo ' set '.$log_data_id_bulk_count.' accounts as Active.';}
                                                        else if($log['log_action'] == 'Account Inactive Bulk'){echo ' set '.$log_data_id_bulk_count.' accounts as Inactive.';}
                                                        // Action Website
                                                        else if($log['log_action'] == 'Page General'){echo ' updated website\'s general information.';}
                                                        else if($log['log_action'] == 'Page Mission Vision'){echo ' update website\'s mission and vision page.';}
                                                        else if($log['log_action'] == 'Page Officials'){echo ' updated website\'s officails page.';}
                                                        else if($log['log_action'] == 'Page Register'){echo ' updated website\'s social pension registration page.';}
                                                        else if($log['log_action'] == 'Page Settings'){echo ' updated website information.';}
                                                        // Action Website Report
                                                        else if($log['log_action'] == 'Page Report Insert Published'){echo ' created and published a new report .';}
                                                        else if($log['log_action'] == 'Page Report Insert Draft'){echo ' created and drafted a new report.';}
                                                        else if($log['log_action'] == 'Page Report Update Published'){echo ' updated and published a report.';}
                                                        else if($log['log_action'] == 'Page Report Update Draft'){echo ' updated and drafted a report.';}
                                                        else if($log['log_action'] == 'Page Report Update Trashed'){echo ' move a report to trash.';}
                                                        else if($log['log_action'] == 'Page Report Deleted'){echo ' deleted a report.';}
                                                        // Profile
                                                        else if($log['log_action'] == 'Profile Details'){echo ' updated ';if($name == 'You'){echo'your';}else{echo'their';} echo ' account details.';}
                                                        else if($log['log_action'] == 'Profile Password'){echo ' updated ';if($name == 'You'){echo'your';}else{echo'their';} echo ' account password.';}
                                                        // To Do
                                                        else if($log['log_action'] == 'To Do Create'){echo ' created a to do item.';}
                                                        else if($log['log_action'] == 'To Do Update'){echo ' updated a to do item.';}
                                                        else if($log['log_action'] == 'To Do Delete'){echo ' deleted a to do item.';}
                                                        // Login | Logout
                                                        else if($log['log_action'] == 'Login'){echo ' logged in.';}
                                                        else if($log['log_action'] == 'Logout'){echo ' logged out.';}
                                                        // Backup/Restore
                                                        else if($log['log_action'] == 'Backup'){echo ' performed a backup.';}
                                                        else if($log['log_action'] == 'Backup Upload'){echo ' uploaded a backup.';}
                                                        else if($log['log_action'] == 'Restore'){echo ' performed a data restoration.';}
                                                        else if($log['log_action'] == 'Backup Days'){echo ' updated the backup schedule.';}
                                                        // Purchase
                                                        else if($log['log_action'] == 'Pensioner Purchase'){echo ' added new purchase item.';}
                                                        else if($log['log_action'] == 'Pensioner Purchase Pending'){echo ' set an purchase item as pending.';}
                                                        else if($log['log_action'] == 'Pensioner Purchase Approve'){echo ' approved an purchase item.';}
                                                        else if($log['log_action'] == 'Pensioner Purchase Rejected'){echo ' rejected an purchase item.';}
                                                        // Purchase Bulk
                                                        else if($log['log_action'] == 'Pensioner Purchase Pending Bulk'){echo ' set '.$log_data_id_bulk_count.' purchase item as pending.';}
                                                        else if($log['log_action'] == 'Pensioner Purchase Approve Bulk'){echo ' approved '.$log_data_id_bulk_count.' purchase item.';}
                                                        else if($log['log_action'] == 'Pensioner Purchase Rejected Bulk'){echo ' rejected '.$log_data_id_bulk_count.' purchase item.';}
                                                        // Action Website Portfolio
                                                        else if($log['log_action'] == 'Page Portfolio Insert Published'){echo ' created and published a new portfolio activity.';}
                                                        else if($log['log_action'] == 'Page Portfolio Insert Draft'){echo ' created and drafted a new portfolio activity.';}
                                                        else if($log['log_action'] == 'Page Portfolio Update Published'){echo ' updated and published an portfolio activity.';}
                                                        else if($log['log_action'] == 'Page Portfolio Update Draft'){echo ' updated and drafted an portfolio activity.';}
                                                        else if($log['log_action'] == 'Page Portfolio Update Trashed'){echo ' move an portfolio activity to trash.';}
                                                        else if($log['log_action'] == 'Page Portfolio Deleted'){echo ' deleted an portfolio activity.';}
                                                        // Account Update
                                                        else if($log['log_action'] == 'Account Username Update'){echo ' updated ';if($name == 'You'){echo'your';}else{echo'their';}echo ' username.';}
                                                        else if($log['log_action'] == 'Account Password Update'){echo ' updated ';if($name == 'You'){echo'your';}else{echo'their';}echo ' password.';}
                                                        // FAQs
                                                        else if($log['log_action'] == 'Page FAQ Insert Published'){echo ' created and published a new faq item.';} 
                                                        else if($log['log_action'] == 'Page FAQ Insert Draft'){echo ' created and drafted a new faq item.';} 
                                                        else if($log['log_action'] == 'Page FAQ Updated Published'){echo ' updated and published an faq item.';}
                                                        else if($log['log_action'] == 'Page FAQ Updated Draft'){echo ' updated and drafted an faq item.';} 
                                                        else if($log['log_action'] == 'Page FAQ Updated Trashed'){echo ' move an faq item to trash.';}
                                                        else if($log['log_action'] == 'Page FAQ Deleted'){echo ' deleted an faq item.';}
                                                        // Subscriber
                                                        else if($log['log_action'] == 'Subscriber'){echo ' Someone subscribed to the newsletter.';}
                                                        // Delete Account
                                                        else if($log['log_action'] == 'Delete Account'){echo ' deleted their account.';}
                                                        ?>
                                                    </h3>
                                                    <?php if($log['log_action'] == 'Page Report Update Trashed' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Insert Published'
                                                            || $log['log_action'] == 'Account Inactive' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Create'
                                                            || $log['log_action'] == 'Pensioner Rejected' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Active' || $log['log_action']=='Pensioner Applicant'
                                                            || $log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Insert Published'
                                                            || $log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted'
                                                        ){ ?>
                                                        <div class="timeline-body">
                                                            <?php if($log['log_action'] == 'Page Report Update Trashed' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Insert Published'){ ?>
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
                                                            <?php }elseif($log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Insert Published'){ ?>
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
                                                            <?php }elseif($log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted'){ ?>
                                                                <table>
                                                                    <tr>
                                                                        <td class="text-bold d-flex align-items-starts">Question: </td>
                                                                        <td class="h5"><?php echo $faq['faq_question']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-bold d-flex align-items-starts">Answer: </td>
                                                                        <td class="h6"><?php
                                                                                if(strlen($faq['faq_answer']) < 100){
                                                                                    echo $faq['faq_answer'];
                                                                                }else{
                                                                                    $faq_answer = $faq['faq_answer']." ";
                                                                                    $faq_answer = substr($faq_answer,0,100);
                                                                                    $faq_answer = substr($faq_answer,0,strrpos($faq_answer,' '));
                                                                                    $faq_answer = $faq_answer."...";
                                                                                    echo $faq_answer;
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            <?php }else{ ?>
                                                                <div class="row">
                                                                    <!-- Image -->
                                                                    <img src="<?php if($log['log_action'] == 'Pensioner Applicant' || $log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Rejected')
                                                                            {echo '/assets/img/applicant_picture/'.$appl['appl_picture'];}
                                                                        else if($log['log_action'] == 'Account Create' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Inactive')
                                                                            {if($acc2['acc_appl_id'] == 0){echo '/assets/img/account_picture/'.$acc2['acc_picture'];}else{echo '/assets/img/applicant_picture/'.$acc2['acc_picture'];}}?>" 
                                                                        alt="Picture" class="img-circle img-responsive mr-3 shadow" style="width: 60px; height: 60px;background: gray;">
                                                                    <div>
                                                                        <!-- Name -->
                                                                        <h5><?php if($log['log_action'] == 'Pensioner Applicant' || $log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Rejected')
                                                                            {echo $appl['appl_lastname'].', '.$appl['appl_firstname'];}
                                                                            else if($log['log_action'] == 'Account Create' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Inactive')
                                                                            {echo $acc2['acc_lastname'].', '.$acc2['acc_firstname'];}?>
                                                                        </h5>
                                                                        <!-- Address || Role -->
                                                                        <p><?php if($log['log_action'] == 'Pensioner Applicant' || $log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Rejected')
                                                                            {echo 'From '.$appl['appl_barangay'].', '.$appl['appl_municipality'].'.';}
                                                                            else if($log['log_action'] == 'Account Create' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Inactive')
                                                                            {if($acc2['acc_role'] == 'Admin'){echo 'An ';}else{echo 'A ';}echo $acc2['acc_role'].'.';}?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if($log['log_action'] != 'Login' && $log['log_action'] != 'Logout' && $log['log_action'] != 'To Do Create' && $log['log_action'] != 'To Do Update' && $log['log_action'] != 'To Do Delete' && $log['log_action'] != 'Profile Details' && $log['log_action'] != 'Profile Password'
                                                        && $log['log_action'] != 'Account Deleted Bulk'&& $log['log_action'] != 'Account Deleted' && $log['log_action'] != 'Pensioner Deleted Bulk' && $log['log_action'] != 'Pensioner Deleted'
                                                        && $log['log_action'] != 'Backup' && $log['log_action'] != 'Backup Upload' && $log['log_action'] != 'Restore' && $log['log_action'] != 'Backup Days'
                                                        && $log['log_action'] != 'Pensioner Purchase' && $log['log_action'] != 'Pensioner Purchase Pending' && $log['log_action'] != 'Pensioner Purchase Approve' && $log['log_action'] != 'Pensioner Purchase Rejected' 
                                                        && $log['log_action'] != 'Pensioner Purchase Pending Bulk' && $log['log_action'] != 'Pensioner Purchase Approve Bulk' && $log['log_action'] != 'Pensioner Purchase Rejected Bulk' 
                                                        && $log['log_action'] != 'Page Report Deleted' && $log['log_action'] != 'Page Portfolio Deleted' && $log['log_action'] != 'Account Username Update' && $log['log_action'] != 'Account Password Update'
                                                        && $log['log_action'] != 'Subscriber' && $log['log_action'] != 'Delete Account'
                                                        ){ ?>
                                                        <div class="timeline-footer">
                                                            <a href="<?php if($log['log_action'] == 'Page Report Insert Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Update Trashed' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Published')
                                                                    {echo '/admin/website_pages/pages_accomplishment_reports';}
                                                                else if($log['log_action'] == 'Page Settings'){echo '/admin/settings/defaults';}
                                                                else if($log['log_action'] == 'Page Register'){echo '/admin/website_pages/register_for_social_pension';}
                                                                else if($log['log_action'] == 'Page Officials'){echo '/admin/website_pages/officials';}
                                                                else if($log['log_action'] == 'Page Mission Vision'){echo '/admin/website_pages/mission_and_vision';}
                                                                else if($log['log_action'] == 'Page General'){echo '/admin/website_pages/general';}
                                                                else if($log['log_action'] == 'Account Inactive Bulk' || $log['log_action'] == 'Account Active Bulk' || $log['log_action'] == 'Account Staff Bulk' || $log['log_action'] == 'Account Admin Bulk' || $log['log_action'] == 'Account Super Admin Bulk'
                                                                    || $log['log_action'] == 'Account Inactive' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Create')
                                                                    {echo '/admin/accounts/all_accounts';}
                                                                else if($log['log_action']=='Pensioner Applicant' || $log['log_action']=='Pensioner Applicant Bulk'){echo '/admin/applicants/applicants';}
                                                                else if($log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Active Bulk'){echo '/admin/pensioners/active';}
                                                                else if($log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Deceased Bulk'){echo '/admin/pensioners/deceased';}
                                                                else if($log['log_action'] == 'Pensioner Rejected' || $log['log_action'] == 'Pensioner Rejected Bulk'){echo '/admin/applicants/rejected';}
                                                                else if($log['log_action'] == 'Page Portfolio Insert Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Published')
                                                                    {echo '/admin/website_pages/portfolio';}
                                                                else if($log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted')
                                                                    {echo '/admin/website_pages/frequently-asked-questions';}
                                                                ?>" 
                                                                ><button class="btn btn-default btn-sm">
                                                                Go to 
                                                                <?php if($log['log_action'] == 'Page Report Insert Published' || $log['log_action'] == 'Page Report Insert Draft' || $log['log_action'] == 'Page Report Update Trashed' || $log['log_action'] == 'Page Report Update Draft' || $log['log_action'] == 'Page Report Update Published')
                                                                    {echo 'reports';}
                                                                else if($log['log_action'] == 'Page Settings'){echo 'defaults';}
                                                                else if($log['log_action'] == 'Page Register'){echo 'register';}
                                                                else if($log['log_action'] == 'Page Officials'){echo 'officials';}
                                                                else if($log['log_action'] == 'Page Mission Vision'){echo 'mission & vision';}
                                                                else if($log['log_action'] == 'Page General'){echo 'general';}
                                                                else if($log['log_action'] == 'Account Inactive Bulk' || $log['log_action'] == 'Account Active Bulk' || $log['log_action'] == 'Account Staff Bulk' || $log['log_action'] == 'Account Admin Bulk' || $log['log_action'] == 'Account Super Admin Bulk'
                                                                    || $log['log_action'] == 'Account Inactive' || $log['log_action'] == 'Account Active' || $log['log_action'] == 'Account Staff' || $log['log_action'] == 'Account Admin' || $log['log_action'] == 'Account Super Admin' || $log['log_action'] == 'Account Create')
                                                                    {echo 'accounts';}
                                                                else if ($log['log_action']=='Pensioner Applicant' || $log['log_action']=='Pensioner Applicant Bulk'){echo 'applicants';}
                                                                else if ($log['log_action'] == 'Pensioner Active' || $log['log_action'] == 'Pensioner Active Bulk'){echo 'active pensioners';}
                                                                else if ($log['log_action'] == 'Pensioner Deceased' || $log['log_action'] == 'Pensioner Deceased Bulk'){echo 'deceased pensioners';}
                                                                else if ($log['log_action'] == 'Pensioner Rejected' || $log['log_action'] == 'Pensioner Rejected Bulk'){echo 'rejected applicants';}
                                                                else if($log['log_action'] == 'Page Portfolio Insert Published' || $log['log_action'] == 'Page Portfolio Insert Draft' || $log['log_action'] == 'Page Portfolio Update Trashed' || $log['log_action'] == 'Page Portfolio Update Draft' || $log['log_action'] == 'Page Portfolio Update Published')
                                                                    {echo 'portfolio';}
                                                                else if($log['log_action'] == 'Page FAQ Insert Published' || $log['log_action'] == 'Page FAQ Insert Draft' || $log['log_action'] == 'Page FAQ Updated Published' || $log['log_action'] == 'Page FAQ Updated Draft' || $log['log_action'] == 'Page FAQ Updated Trashed' || $log['log_action'] == 'Page FAQ Deleted')
                                                                    {echo 'FAQs';}
                                                                ?> page
                                                                </button>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <!-- timeline time label start -->
                                        <div>
                                            <i class="fas fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" integrity="sha512-BHDCWLtdp0XpAFccP2NifCbJfYoYhsRSZOUM3KnAxy2b/Ay3Bn91frud+3A95brA4wDWV3yEOZrJqgV8aZRXUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
</body>
</html>
