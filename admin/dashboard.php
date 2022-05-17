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
    <title>Dashboard | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" integrity="sha512-JApjWRnfonFeGBY7t4yq8SWr1A6xVYEJgO/UMIYONxaR3C9GETKUg0LharbJncEzJF5Nmiv+Pr5QNulr81LjGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css" integrity="sha512-ClXpwbczwauhl7XC16/EFu3grIlYTpqTYOwqwAi7rNSqxmTqCpE8VS3ovG+qi61GoxSLnuomxzFXDNcPV1hvCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.css" integrity="sha512-vE1vuJehUqVW9CvtimaOOJ+vgfv5o/d5Z7uBorSX5ASYxi18F3wO7H+IK0G2i5TqHCwQ/XOZGXzx3dne9a9AhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" integrity="sha512-pDpLmYKym2pnF0DNYDKxRnOk1wkM9fISpSOjt8kWFKQeDmBTjSnBZhTd41tXwh8+bRMoSaFsRnznZUiH9i3pxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> 
    <?php } ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css" integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/admin/assets/css/admin_style.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
    <style>
        .visually-hidden{
            position:absolute!important;
            width:1px!important;
            height:1px!important;
            padding:0!important;
            margin:-1px!important;
            overflow:hidden!important;
            clip:rect(0,0,0,0)!important;
            white-space:nowrap!important;
            border:0!important
        }
    </style>
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Dashboard</li>
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
                        <!-- Right -->
                        <div class="col-lg-8">
                            <!-- CARDS -->
                            <div class="col-12 row pr-0">
                                <?php 
                                    $Applicant = mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Applicant'") or die(mySQLi_error($con)); 
                                    $Applicant_count = mysqli_num_rows($Applicant);
                                    $Active = mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Active'") or die(mySQLi_error($con)); 
                                    $Active_count = mysqli_num_rows($Active);
                                    $Active_acc = mySQLi_query($con, "SELECT * from tbl_accounts where acc_status = 'Active'") or die(mySQLi_error($con)); 
                                    $Active_acc_count = mysqli_num_rows($Active_acc);
                                ?>
                                <div class="col-lg-4 col-6 pr-0">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><?php echo $Applicant_count ?></h3>
                                            <p>Applicants</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-document-text"></i>
                                        </div>
                                        <a href="/admin/applicants/applicants" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-6 pr-0">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?php echo $Active_count ?></h3>
                                            <p>Active Pensioners</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-people"></i>
                                        </div>
                                        <a href="/admin/pensioners/active" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 pr-0">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                        <h3><?php echo $Active_acc_count ?></h3>
                                        <p>Active Accounts</p>
                                        </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="/admin/accounts/all_accounts" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- PENSION STATUS -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <h5 class="card-title"><span data-feather="credit-card"></span> Pensioner's Pension Status</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#update_pension_status"
                                            data-backdrop="static" data-keyboard="false">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                        <button type="button" class="btn btn-tool text-danger" id="reset_pension_status">
                                            <i class="fas fa-history"></i> Reset
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body overflow-auto">
                                    <?php 
                                        $status = explode('|',$pages['page_pension_status']);
                                        $expectedDate = $status[0];
                                        $confirmedDate = $status[1];
                                        $receivedVia = $status[2];
                                        $toReceived = $status[3];
                                    ?>
                                    <div class="steps">
                                        <progress id="progress" value=<?php if($toReceived!=''){echo '100';}elseif($receivedVia!=''){echo '70';}elseif($confirmedDate!=''){echo '35';}else{echo '0';}?>  max=100 ></progress>
                                        <div class="step-item">
                                            <button class="step-button text-center <?php if($expectedDate == ''){echo 'collapsed';}?> <?php if($confirmedDate != ''){echo 'done';}?>" type="button"
                                                aria-expanded="<?php if($expectedDate == '' || $confirmedDate != ''){echo 'false';}else{echo 'true';}?>">
                                                <span class="step-icon" data-feather="calendar"></span>
                                            </button>
                                            <div class="step-title">
                                                Expected Date
                                                <br>
                                                <small class="text-muted fw-bold"><?php if($expectedDate != ''){echo $expectedDate;}else{echo '...';} ?></small>
                                            </div>
                                        </div>
                                        <div class="step-item">
                                            <button class="step-button text-center <?php if($confirmedDate == ''){echo 'collapsed';}?> <?php if($receivedVia != ''){echo 'done';}?>" type="button"
                                                aria-expanded="<?php if($confirmedDate == '' || $receivedVia != ''){echo 'false';}else{echo 'true';}?>">
                                                <span class="step-icon" data-feather="check-square"></span>
                                            </button>
                                            <div class="step-title">
                                                Date Confirmed
                                                <br>
                                                <small class="text-muted fw-bold"><?php if($confirmedDate != ''){echo $confirmedDate;}else{echo '...';} ?></small>
                                            </div>
                                        </div>
                                        <div class="step-item">
                                            <button class="step-button text-center <?php if($receivedVia == ''){echo 'collapsed';}?> <?php if($toReceived != ''){echo 'done';}?>" type="button"
                                                aria-expanded="<?php if($receivedVia == '' || $toReceived != ''){echo 'false';}else{echo 'true';}?>">
                                                <span class="step-icon" data-feather="package"></span>
                                            </button>
                                            <div class="step-title">
                                                Recieved Via
                                                <br>
                                                <small class="text-muted fw-bold"><?php if($receivedVia != ''){echo $receivedVia;}else{echo '...';} ?></small>
                                            </div>
                                        </div>
                                        <div class="step-item">
                                            <button class="step-button text-center <?php if($toReceived == ''){echo 'collapsed';}?>" type="button"
                                                aria-expanded="<?php if($toReceived == ''){echo 'false';}else{echo 'true';}?>">
                                                <span class="step-icon" data-feather="dollar-sign"></span>
                                            </button>
                                            <div class="step-title">
                                                To Receive
                                                <br>
                                                <small class="text-muted fw-bold"><?php if($toReceived != ''){echo 'Today';}else{echo '...';} ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PENSION SCHEDULE -->
                            <!-- <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-calendar-day"></i> Pension Schedule</label>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#pensionSchedule_Instruction">
                                            <i class="fas fa-exclamation-circle"></i> In order for this to work, please view the instruction here
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="pension_schedule">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="schedule_value">How much will they recieve?</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text rounded-0 border-top-0 border-left-0 border-bottom border-secondary">Php</span>
                                                    </div>
                                                    <input type="text" name="schedule_value" id="schedule_value" class="form-control float-right" onpaste="return false;" onkeypress="return onlyNumberInput(event)" value="<?php if($pages['page_pension_value'] != ''){echo $pages['page_pension_value'];}; ?>" placeholder="ex. 500" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="schedule_date">When will the message send?</label>
                                                <input type="date" name="schedule_date" id="schedule_date" class="form-control mb-3" value="<?php if($pages['page_pension_value'] != ''){echo date('Y-m-d', strtotime($pages['page_pension_date']));}else{echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day'));} ?>" required>
                                            </div>
                                        </div>

                                        <label for="schedule_message">Message</label>
                                        <textarea name="schedule_message" id="schedule_message" cols="30" rows="10" class="form-control shadow mb-3" placeholder="Write your message here..." required><?php if($pages['page_pension_message'] != ''){echo $pages['page_pension_message'];}; ?></textarea>
                                        <?php 
                                            if($pages['page_pension_value'] == ''){
                                        ?>
                                        <button type="submit" class="btn btn-primary col-12" id="schedule_submit"><i class="fas fa-calendar-day"></i> Save Schedule</button>
                                        <?php }else{ ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-primary col-12" id="schedule_update"><i class="fas fa-calendar-day"></i> Update Schedule</button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-danger col-12" id="schedule_delete"><i class="fas fa-trash"></i> Delete Schedule</button>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div> -->
                            <!-- BAR CHART(Active Pensioner) -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-chart-bar"></i> Active Pensioners</label>
                                    <div class="card-tools"> 
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                <a href="#" id="ap_municipality" class="dropdown-item active">Municipality</a>
                                                <a href="#" id="ap_gender" class="dropdown-item">Gender</a>
                                                <a href="#" id="ap_civilstatus" class="dropdown-item">Civil Status</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="canvas_municipality" style="min-height: 303px; height: 303px; max-height: 303px; max-width: 100%;"></canvas>
                                        <canvas id="canvas_gender" style="min-height: 303px; height: 303px; max-height: 303px; max-width: 100%;"></canvas>
                                        <canvas id="canvas_civilstatus" style="min-height: 303px; height: 303px; max-height: 303px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- TABLE: LATEST APPLICANTS -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-users"></i> LATEST APPLICANTS</label>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="height: 517px;">
                                        <?php 
                                            $query=mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Applicant' order by appl_id DESC LIMIT 10") or die(mySQLi_error($con));
                                            if(mysqli_num_rows($query) > 0){
                                        ?>
                                            <table class="table table-striped" style="overflow-y: auto;">
                                                <thead>
                                                    <tr>
                                                        <th class="border-top-0">Name</th>
                                                        <th class="border-top-0">Address</th>
                                                        <th class="border-top-0">Contact No.</th>
                                                        <th class="border-top-0">Birthday</th>
                                                        <th class="border-top-0">Pensioner</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        while($appl=mySQLi_fetch_assoc($query)){
                                                    ?>
                                                        <!-- <tr class='clickable-row' data-href='index.php'> -->
                                                        <tr>
                                                            <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                                                <?php echo $appl['appl_lastname'] . ', ' . $appl['appl_firstname'] . ' ' . $appl['appl_middlename']; ?></td>
                                                            <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                                                <?php echo $appl['appl_houseno'] . ' ' . $appl['appl_barangay'] . ', ' . $appl['appl_municipality'] . ', ' . $appl['appl_province']; ?></td>
                                                            <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                                                <?php echo $appl['appl_contactno']; ?></td>
                                                            <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                                                <?php echo $appl['appl_birthdate']; ?></td>
                                                            <td class="view_data" data-toggle="modal" data-id="<?php echo $appl['appl_id']; ?>" data-target="#orderModal">
                                                                <?php echo $appl['appl_pensioner']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <div class="text-center">
                                                    <i class="fas fa-file-alt display-3"></i>
                                                    <h5>No data available.</h5>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- Left -->
                        <div class="col-lg-4">
                            <!-- TO DO -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-clipboard"></i> TO DO LIST</label>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#todo_create">
                                            <i class="fas fa-plus"></i> Add item
                                        </button>
                                    </div>
                                    <small>[Item will be deleted after its deadline]</small>
                                </div>
                                <div class="card-body">
                                        <div id="response"></div>
                                    <ul class="todo-list scrollbar" data-widget="todo-list" style="height: 298px; overflow-y: auto;">
                                        <?php
                                            $query = mySQLi_query($con, "SELECT * from tbl_todo where todo_acc_id = '".$_SESSION['acc_id']."' order by todo_date_due ASC") or die(mySQLi_error($con));
                                            if(mysqli_num_rows($query) > 0){
                                                while($todo=mySQLi_fetch_assoc($query)){
                                        ?>
                                            <li>
                                                <!-- checkbox -->
                                                <div  class="icheck-primary d-inline ml-2">
                                                    <input type="checkbox" onclick="todo_check('<?php echo $todo['todo_id']; ?>')" id="<?php echo $todo['todo_id']; ?>" <?php if($todo['todo_status'] == '1'){echo 'checked';}?>>
                                                    <label for="<?php echo $todo['todo_id']; ?>"></label>
                                                </div>
                                                <!-- Time label -->
                                                <?php if($todo['todo_date_due'] != date('Y-m-d')){ ?>
                                                    <small class="badge badge-default ml-0 bg-primary"><i class="far fa-clock"></i> <?php echo $todo['todo_date_due']; ?></small>
                                                <?php }else{ ?>
                                                    <small class="badge badge-default ml-0 bg-danger"><i class="far fa-clock"></i> <?php echo date('h:i a', strtotime($todo['todo_time_due'])); ?></small>
                                                <?php } ?>
                                                <!-- todo text -->
                                                <span class="text">
                                                    <?php
                                                        if (strlen($todo['todo_action']) <= 21) {
                                                            echo $todo['todo_action'];
                                                        }else { 
                                                            $todo_action = $todo['todo_action']." ";
                                                            $todo_action = substr($todo_action,0,21);
                                                            $todo_action = substr($todo_action,0,strrpos($todo_action,' '));
                                                            $todo_action = $todo_action."...";
                                                            echo $todo_action;
                                                        }
                                                    ?>
                                                </span>
                                                <!-- General tools such as edit or delete-->
                                                <div class="tools">
                                                    <a href="#" class="todo_edit" id="<?php echo $todo['todo_id']; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="todo_delete" id="<?php echo $todo['todo_id']; ?>">
                                                        <i class="fas fa-trash text-red"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php }}else{ ?>
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <div class="text-center">
                                                    <i class="fas fa-clipboard display-3"></i>
                                                    <h5>No data available.</h5>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- LATEST PENSIONER -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-users"></i> LATEST PENSIONERS</label>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="users-list clearfix" style="height: 322px; overflow-y: auto;">
                                        <?php
                                            $query = mySQLi_query($con, "SELECT * from tbl_accounts WHERE acc_role = 'Pensioner' AND acc_status = 'Active' order by acc_id DESC LIMIT 8") or die(mySQLi_error($con));
                                            if(mysqli_num_rows($query) > 0){
                                            while($acc2=mySQLi_fetch_assoc($query)){
                                        ?>
                                        <li>
                                            <img src="/assets/img/applicant_picture/<?php echo $acc2['acc_picture']; ?>" alt="User Image" style="background-color: gray; height: 100px;">
                                            <span class="users-list-name"><?php echo $acc2['acc_firstname'] . ' ' . $acc2['acc_lastname']; ?></span>
                                            <span class="users-list-date">
                                                <?php 
                                                    if (date("Y-m-d", strtotime($acc2['acc_date_created'])) == date("Y-m-d")) {
                                                        echo 'Today';
                                                    } else if ($acc2['acc_date_created'] == date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))))) {
                                                        echo 'Yesterday';
                                                    } else if (date('Y') == date('Y', strtotime($acc2['acc_date_created']))) {
                                                        echo date('d M', strtotime($acc2['acc_date_created']));
                                                    } else {
                                                        echo date('d M Y', strtotime($acc2['acc_date_created']));
                                                    }
                                                ?>
                                            </span>
                                        </li>
                                        <?php }}else{ ?>
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <div class="text-center">
                                                    <div class="display-3"><i class="fas fa-users"></i></div>
                                                    <h5>No data available.</h5>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- PIE CHART -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <label><i class="fas fa-chart-pie"> </i> Deceased Pensioner</label>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="areaChart" style="min-height: 403px; height: 403px; max-height: 403px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <!-- Modal To Do Create -->
    <div class="modal fade" id="todo_create">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div>
                        <h4 class="modal-title">Add item</h4>
                        <p><i class="fas fa-exclamation text-danger"></i> Item that's later than todays date and time will not be added.</p>
                    </div>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button> -->
                </div>
                <form id="insert_todo">
                    <div class="modal-body">
                        <div class="col-12 row mb-2">
                            <div class="col-3">
                                <label>Action <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <textarea name="todo_action" type="text" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-3">
                                <label>Due Date <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 row pr-0">
                                <div class="col-md-6 col-12 pr-0">
                                    <input name="todo_date_due" type="date" class="form-control" value="<?php echo date('Y-m-d')?>" required>
                                </div>
                                <div class="col-md-6 col-12 pr-0">
                                    <input name="todo_time_due" type="time" class="form-control" value="<?php echo date('H:i')?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button name="todo_create" type="submit" class="btn btn-primary">Save</button>
                        <button name="todo_create" type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal To Do Update || Delete -->
    <div class="modal fade" id="todo_update">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="todo_update_content">
                
            </div>
        </div>
    </div>
    <!-- Pension Schedule Instruction -->
    <div class="modal fade" id="pensionSchedule_Instruction">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-day"></i> Schedule Pension Instruction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>For Pension Schedule to work automatically please do the 5 steps specified below.</div>
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <td class="text-nowrap"><b>Step 1:</b></td>
                                <td>Go to <a target="_blank" href="https://cron-job.org">https://cron-job.org</a>.</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap"><b>Step 2:</b></td>
                                <td>If you don't have an account, sign up for an account, otherwise go ahead and log in.</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap"><b>Step 3:</b></td>
                                <td>On cron-job.org's Dashboard, click the "CREATE CRONJOB" button.</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap"><b>Step 4:</b></td>
                                <td>Paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/admin/assets/php/pension-schedule.php";?></u> on the URL field.</td>
                            </tr>
                            <tr>
                                <td class="text-nowrap"><b>Step 5:</b></td>
                                <td>Set the Execution schedule to "Every day at 7:00", you can change the time if you want, and click the Create button below.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Pension Status -->
    <div class="modal fade" id="update_pension_status">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h4 class="modal-title">Update Pension Status</h4>
                </div>
                <form action="/admin/assets/php/pension_status_crud.php" method="POST">
                <div class="modal-body">
                    <?php
                        $status = explode('|',$pages['page_pension_status']);
                        $expectedDate = $status[0];
                        $confirmedDate = $status[1];
                        $receivedVia = $status[2];
                        $toReceived = $status[3];
                        
                        if($expectedDate==''){ ?>
                            <label>Set expected date <span class="text-danger">*</span></label><br>
                            <small class="text-muted"> Date should be at least 1 day ahead of today's date.</small>
                            <input name="excpected_date" type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime("+1 day"));?>" required="">
                        <?php }elseif($confirmedDate==''){ ?>
                            <label>Set confirm date <span class="text-danger">*</span></label><br>
                            <small class="text-muted"> Date should be at least 1 day ahead of today's date.</small>
                            <input name="confirmed_date" type="date" class="form-control mb-3" value="<?php echo date('Y-m-d', strtotime('+1 day'));?>" required="">
                            <div class="form-check-inline mb-3">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="confirmed_date_radio" id="confirmed_date_radio">Set an scheduled message
                                </label>
                            </div>
                            <div class="confirmed_date_inputs visually-hidden">
                                <div class="col-12">
                                    <label for="schedule_value">How much will they recieve? <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-0 border-top-0 border-left-0 border-bottom border-secondary">Php</span>
                                        </div>
                                        <input type="text" name="schedule_value" id="schedule_value" class="form-control float-right" onpaste="return false;" onkeypress="return onlyNumberInput(event)" value="<?php if($pages['page_pension_value'] != ''){echo $pages['page_pension_value'];}; ?>" placeholder="ex. 500" disabled required>
                                    </div>
                                </div>
                                <label for="schedule_message">Message <span class="text-danger">*</span></label>
                                <textarea name="schedule_message" id="schedule_message" cols="30" rows="10" class="form-control shadow mb-3" placeholder="Write your message here..." disabled required><?php if($pages['page_pension_message'] != ''){echo $pages['page_pension_message'];}; ?></textarea>
                            
                                <div class="container-fluid">
                                    <div>For Pension Schedule to work automatically please do the 5 steps specified below.</div>
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap"><b>Step 1:</b></td>
                                                <td>Go to <a target="_blank" href="https://cron-job.org">https://cron-job.org</a>.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap"><b>Step 2:</b></td>
                                                <td>If you don't have an account, sign up for an account, otherwise go ahead and log in.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap"><b>Step 3:</b></td>
                                                <td>On cron-job.org's Dashboard, click the "CREATE CRONJOB" button.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap"><b>Step 4:</b></td>
                                                <td>Paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/admin/assets/php/pension-schedule.php";?></u> on the URL field.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap"><b>Step 5:</b></td>
                                                <td>Set the Execution schedule to "Every day at 7:00", you can change the time if you want, and click the Create button below.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php }elseif($receivedVia==''){ ?>
                            <label>Set recieving mode <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="recieving_mode" id="recieving_mode" class="form-control" required>
                                    <option value="Door to Door"> Door to Door</option>
                                    <option value="ATM/Bank"> ATM/Bank</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="recieving_mode_input visually-hidden row">
                                <label for="" class="col-lg-3 mb-0">If other please specify:</label>
                                <input name="recieving_mode_other" id="recieving_mode_other" type="text" class="form-control col-lg-8" value="" required="" disabled>
                            </div>
                            <hr>
                            <div class="col-12">
                                <label for="schedule_value">How much will they recieve? <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-top-0 border-left-0 border-bottom border-secondary">Php</span>
                                    </div>
                                    <input type="text" name="schedule_value" id="schedule_value" class="form-control float-right" onpaste="return false;" onkeypress="return onlyNumberInput(event)" value="<?php if($pages['page_pension_value'] != ''){echo $pages['page_pension_value'];}; ?>" placeholder="ex. 500" required>
                                </div>
                            </div>

                            <label for="schedule_message">Message <span class="text-danger">*</span></label>
                            <textarea name="schedule_message" id="schedule_message" cols="30" rows="10" class="form-control shadow mb-3" placeholder="Write your message here..." required><?php if($pages['page_pension_message'] != ''){echo $pages['page_pension_message'];}; ?></textarea>
                            
                            <div class="container-fluid">
                                <div>For Pension Schedule to work automatically please do the 5 steps specified below.</div>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 1:</b></td>
                                            <td>Go to <a target="_blank" href="https://cron-job.org">https://cron-job.org</a>.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 2:</b></td>
                                            <td>If you don't have an account, sign up for an account, otherwise go ahead and log in.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 3:</b></td>
                                            <td>On cron-job.org's Dashboard, click the "CREATE CRONJOB" button.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 4:</b></td>
                                            <td>Paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/admin/assets/php/pension-schedule.php";?></u> on the URL field.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 5:</b></td>
                                            <td>Set the Execution schedule to "Every day at 7:00", you can change the time if you want, and click the Create button below.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php }else{ ?>
                            <small class="text-muted"> Dates should be at least 1 day ahead of today's date.</small><br>
                            <label>Set expected date <span class="text-danger">*</span></label>
                            <input name="excpected_date_all" type="date" class="form-control mb-3" value="<?php echo date('Y-m-d', strtotime($expectedDate));?>" required="">
                            
                            <label>Set confirm date <span class="text-danger">*</span></label>
                            <input name="confirmed_date" type="date" class="form-control mb-3" value="<?php echo date('Y-m-d', strtotime($confirmedDate));?>" required="">
                            
                            <label>Set recieving mode <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select name="recieving_mode" id="recieving_mode" class="form-control" required>
                                    <option value="Door to Door" <?php if($receivedVia == 'Door to Door'){echo 'selected';}?>> Door to Door</option>
                                    <option value="ATM/Bank" <?php if($receivedVia == 'ATM/Bank'){echo 'selected';}?>> ATM/Bank</option>
                                    <option value="Other" <?php if($receivedVia != 'Door to Door' && $receivedVia != 'ATM/Bank'){echo 'selected';}?>>Other</option>
                                </select>
                            </div>
                            <div class="recieving_mode_input row <?php if($receivedVia == 'Door to Door' || $receivedVia == 'ATM/Bank'){echo 'visually-hidden';}?>">
                                <label for="" class="col-lg-3 mb-0">If other please specify:</label>
                                <input name="recieving_mode_other" id="recieving_mode_other" type="text" class="form-control col-lg-8" value="<?php echo $receivedVia;?>" required="" <?php if($receivedVia == 'Door to Door' || $receivedVia == 'ATM/Bank'){echo 'disabled';}?>>
                            </div>
                            <hr>
                            <div class="col-12">
                                <label for="schedule_value">How much will they recieve? <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0 border-top-0 border-left-0 border-bottom border-secondary">Php</span>
                                    </div>
                                    <input type="text" name="schedule_value" id="schedule_value" class="form-control float-right" onpaste="return false;" onkeypress="return onlyNumberInput(event)" value="<?php if($pages['page_pension_value'] != ''){echo $pages['page_pension_value'];}; ?>" placeholder="ex. 500" required>
                                </div>
                            </div>

                            <label for="schedule_message">Message <span class="text-danger">*</span></label>
                            <textarea name="schedule_message" id="schedule_message" cols="30" rows="10" class="form-control shadow mb-3" placeholder="Write your message here..." required><?php if($pages['page_pension_message'] != ''){echo $pages['page_pension_message'];}; ?></textarea>
                            
                            
                            <div class="container-fluid">
                                <div>For Pension Schedule to work automatically please do the 5 steps specified below.</div>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 1:</b></td>
                                            <td>Go to <a target="_blank" href="https://cron-job.org">https://cron-job.org</a>.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 2:</b></td>
                                            <td>If you don't have an account, sign up for an account, otherwise go ahead and log in.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 3:</b></td>
                                            <td>On cron-job.org's Dashboard, click the "CREATE CRONJOB" button.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 4:</b></td>
                                            <td>Paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/admin/assets/php/pension-schedule.php";?></u> on the URL field.</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap"><b>Step 5:</b></td>
                                            <td>Set the Execution schedule to "Every day at 7:00", you can change the time if you want, and click the Create button below.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js" integrity="sha512-+cXPhsJzyjNGFm5zE+KPEX4Vr/1AbqCUuzAS8Cy5AfLEWm9+UI9OySleqLiSQOQ5Oa2UrzaeAOijhvV/M4apyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js" integrity="sha512-5R3ngaUdvyhXkQkIqTf/k+Noq3phjmrqlUQyQYbgfI34Mzcx7vLIIYTy/K1VMHkL33T709kfh5y6R9Xy/Cbt7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        (function () {
            'use strict'
            feather.replace({ 'aria-hidden': 'true' })
        })()
        $(function() {
            $("#canvas_gender").hide();
            $("#canvas_civilstatus").hide();
            $("#canvas_municipality").show();
            $.ajax({
                url:"assets/php/chart_data.php",
                method:"POST",
                data:{action:'fetch',status:'municipality'},
                dataType:"JSON",
                success:function(data){
                    var barangay = [];
                    var totalactive = [];
                    var totaldeceased = [];
                    var backgroundColor = [];
                    var borderColor = [];

                    for(var count = 0; count < data.length; count++){
                        barangay.push(data[count].barangay);
                        totalactive.push(data[count].totalactive);
                        totaldeceased.push(data[count].totaldeceased);
                        backgroundColor.push(data[count].backgroundColor);
                        borderColor.push(data[count].borderColor);
                    }

                    var group_chart1 = $('#canvas_municipality');
                    new Chart(group_chart1, {
                        type:"bar",
                        data:{
                            labels:barangay,
                            datasets:[{
                                label               : 'Active Pensioners',
                                color               : '#fff',
                                backgroundColor     : backgroundColor,
                                borderColor         : borderColor,
                                pointRadius         : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data                : totalactive
                            }]
                        },
                        options: {
                            maintainAspectRatio : false,
                            responsive : true,
                            legend: {
                                display: false
                            },
                            scales: {
                                xAxes: [{
                                    gridLines : {
                                        display : false,
                                    }
                                }],
                                yAxes: [{
                                    gridLines : {
                                        display : false,
                                    },
                                    y: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });

                    var group_chart2 = $('#areaChart');
                    new Chart(group_chart2, {
                        type:"pie",
                        data:{
                            labels:barangay,
                            datasets:[{
                                label               : 'Deceased Pensioners',
                                color               : '#fff',
                                backgroundColor     : backgroundColor,
                                borderColor         : borderColor,
                                pointRadius         : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                                data                : totaldeceased
                            }]
                        }
                    });
                }
            })

            $("#ap_municipality").click(function(event){
                event.preventDefault();
                $(this).addClass( "active" );
                $('#ap_civilstatus').removeClass( "active" );
                $('#ap_gender').removeClass( "active" );
                $("#canvas_gender").hide();
                $("#canvas_civilstatus").hide();
                $("#canvas_municipality").show();
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'municipality'},
                    dataType:"JSON",
                    success:function(data){
                        var barangay = [];
                        var totalactive = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < data.length; count++){
                            barangay.push(data[count].barangay);
                            totalactive.push(data[count].totalactive);
                            backgroundColor.push(data[count].backgroundColor);
                            borderColor.push(data[count].borderColor);
                        }

                        var group_chart1 = $('#canvas_municipality').get(0).getContext('2d');
                        var graph1 = new Chart(group_chart1, {
                            type:"bar",
                            data:{
                                labels:barangay,
                                datasets:[{
                                    label               : 'Active Pensioners',
                                    color               : '#fff',
                                    backgroundColor     : backgroundColor,
                                    borderColor         : borderColor,
                                    pointRadius         : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : totalactive
                                }]
                            },
                            options: {
                                maintainAspectRatio : false,
                                responsive : true,
                                legend: {
                                    display: false
                                },
                                scales: {
                                    xAxes: [{
                                        gridLines : {
                                            display : false,
                                        }
                                    }],
                                    yAxes: [{
                                        gridLines : {
                                            display : false,
                                        },
                                        y: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    }
                })
            });

            $("#ap_gender").click(function(event){
                event.preventDefault();
                $(this).addClass( "active" );
                $('#ap_civilstatus').removeClass( "active" );
                $('#ap_municipality').removeClass( "active" );
                $("#canvas_gender").show();
                $("#canvas_civilstatus").hide();
                $("#canvas_municipality").hide();
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'gender'},
                    dataType:"JSON",
                    success:function(data){
                        var gender = [];
                        var total = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < data.length; count++){
                            gender.push(data[count].gender);
                            total.push(data[count].total);
                            backgroundColor.push(data[count].backgroundColor);
                            borderColor.push(data[count].borderColor);
                        }

                        var group_chart1 = $('#canvas_gender').get(0).getContext('2d');
                        var graph1 = new Chart(group_chart1, {
                            type:"bar",
                            data:{
                                labels:gender,
                                datasets:[{
                                    label               : 'Active Pensioners',
                                    color               : '#fff',
                                    backgroundColor     : backgroundColor,
                                    borderColor         : borderColor,
                                    pointRadius         : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : total
                                }]
                            },
                            options: {
                                maintainAspectRatio : false,
                                responsive : true,
                                legend: {
                                    display: false
                                },
                                scales: {
                                    xAxes: [{
                                        gridLines : {
                                            display : false,
                                        }
                                    }],
                                    yAxes: [{
                                        gridLines : {
                                            display : false,
                                        },
                                        y: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    }
                })
            });
            
            $("#ap_civilstatus").click(function(event){
                event.preventDefault();
                $(this).addClass( "active" );
                $('#ap_gender').removeClass( "active" );
                $('#ap_municipality').removeClass( "active" );
                $("#canvas_gender").hide();
                $("#canvas_civilstatus").show();
                $("#canvas_municipality").hide();
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'civilstatus'},
                    dataType:"JSON",
                    success:function(data){
                        var civilstatus = [];
                        var total = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < data.length; count++){
                            civilstatus.push(data[count].civilstatus);
                            total.push(data[count].total);
                            backgroundColor.push(data[count].backgroundColor);
                            borderColor.push(data[count].borderColor);
                        }

                        var group_chart1 = $('#canvas_civilstatus').get(0).getContext('2d');
                        var graph1 = new Chart(group_chart1, {
                            type:"bar",
                            data:{
                                labels:civilstatus,
                                datasets:[{
                                    label               : 'Active Pensioners',
                                    color               : '#fff',
                                    backgroundColor     : backgroundColor,
                                    borderColor         : borderColor,
                                    pointRadius         : false,
                                    pointColor          : '#3b8bba',
                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                    pointHighlightFill  : '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data                : total
                                }]
                            },
                            options: {
                                maintainAspectRatio : false,
                                responsive : true,
                                legend: {
                                    display: false
                                },
                                scales: {
                                    xAxes: [{
                                        gridLines : {
                                            display : false,
                                        }
                                    }],
                                    yAxes: [{
                                        gridLines : {
                                            display : false,
                                        },
                                        y: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    }
                })
            });
            
            // var pension_button='';
            // $("body").on('click', '#schedule_submit', function(event){ pension_button=0;})
            // $("body").on('click', '#schedule_update', function(event){ pension_button=1;})
            // $("body").on('click', '#schedule_delete', function(event){ pension_button=2;})
            // $("body").on('submit', '#pension_schedule', function(event){
                //     event.preventDefault();

                //     if(pension_button == 0){
                //         title = 'Do you really want to make this schedule?';
                //         confirmBtn = 'Yes';
                //     }else if(pension_button == 1){
                //         title = 'Do you really want to update this schedule?';
                //         confirmBtn = 'Update';
                //     }else if(pension_button == 2){
                //         title = 'Do you really want to delete this schedule?';
                //         confirmBtn = 'Delete';
                //     }

                //     Swal.fire({
                //         title: title,
                //         icon: 'question',
                //         showCancelButton: true,
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: confirmBtn
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //                 url: "/admin/assets/php/pension_schedule_crud.php?btn="+pension_button,
                //                 method: "POST",
                //                 processData: false,
                //                 contentType: false,
                //                 cache: false,
                //                 data: new FormData(this),
                //                 success:function(response){
                //                     if(response == 1){
                //                         Swal.fire({
                //                             icon: 'success',
                //                             title: 'Pension scheduled successfully.',
                //                             toast: true,
                //                             position: 'top-end',
                //                             showConfirmButton: false,
                //                             timer: 3000,
                //                             timerProgressBar: true
                //                         })
                //                         location.reload();
                //                     }else if(response == 2){
                //                         Swal.fire({
                //                             icon: 'success',
                //                             title: 'Pension schedule deleted successfully.',
                //                             toast: true,
                //                             position: 'top-end',
                //                             showConfirmButton: false,
                //                             timer: 3000,
                //                             timerProgressBar: true
                //                         })
                //                         location.reload();
                //                     }else{
                //                         Swal.fire({
                //                             icon: 'error',
                //                             title: response,
                //                             toast: true,
                //                             position: 'top-end',
                //                             showConfirmButton: false,
                //                             timer: 3000,
                //                             timerProgressBar: true
                //                         })
                //                     }
                //                 }
                //             });
                //         }
                //     })
            // })

            $("body").on('click', "#confirmed_date_radio", function() {
                if($(this).is(":checked")) {
                    // checkbox is checked -> do something
                    $('#schedule_value').prop('disabled', false);
                    $('#schedule_date').prop('disabled', false);
                    $('#schedule_message').prop('disabled', false);
                    $('.confirmed_date_inputs').removeClass('visually-hidden');
                } else {
                    // checkbox is not checked -> do something different
                    $('#schedule_value').prop('disabled', true);
                    $('#schedule_date').prop('disabled', true);
                    $('#schedule_message').prop('disabled', true);
                    $('.confirmed_date_inputs').addClass('visually-hidden');
                }
            });

            $("body").on('change', "#recieving_mode", function() {
                // alert(this.value);
                if(this.value == 'Other'){
                    $('.recieving_mode_input').removeClass('visually-hidden');
                    $('#recieving_mode_other').prop('disabled', false);
                }else{
                    $('.recieving_mode_input').addClass('visually-hidden');
                    $('#recieving_mode_other').prop('disabled', true);
                }
            });

            $("body").on('click', "#reset_pension_status", function() {
                Swal.fire({
                    title: 'Do you really want to reset the pension status?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/assets/php/pension_status_crud.php",
                            method: "POST",
                            // processData: false,
                            // contentType: false,
                            // cache: false,
                            data: {reset_pension_status: 'true'},
                            success:function(response){
                                if(response == 1){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pension scheduled reset successfully.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    })
                                    location.reload();
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Pension scheduled reset failed.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    })
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
</body>
</html>
