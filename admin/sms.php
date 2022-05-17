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
    <title>SMS | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.3/dataTables.bootstrap4.min.css" integrity="sha512-+RecGjm1x5bWxA/jwm9sqcn5EV0tNej3Xxq5HtIOLM9YM9VgI2LbhEDn099Xhxg6HuvrmsXR0J6JQxL7tLHFHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.css" integrity="sha512-+TJckkeGxlxMsXzzgiOzPP98YRd+4BiK4B6n/8T4ls+LHSVtwLNvidIXKHL0OkzwBz8iG5YNwcKO6U2mWgoHDQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/1.7.0/buttons.bootstrap4.min.css" integrity="sha512-0LpZpPhy5gC20rXCT9HfsYz0gF+wRD62I/MCY+d1tDgK7xKpvd0hQLMBqyXS9BYdzyis/BdIW2iMIBK8e+0o+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css" integrity="sha512-z13ghwce5srTmilJxE0+xd80zU6gJKJricLCq084xXduZULD41qpjRE9QpWmbRyJq6kZ2yAaWyyPAgdxwxFEAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> 
    <?php } ?>
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

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>SMS</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">SMS</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php if(isset($pages['page_sms_shortcode']) && trim($pages['page_sms_shortcode']) == '' && isset($pages['page_sms_appid']) && trim($pages['page_sms_appid']) == '' &&
                        isset($pages['page_sms_appsecret']) && trim($pages['page_sms_appsecret']) == ''){ ?>
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <form id="sms_codes" class="needs-validation" novalidate>
                                    <div>
                                        <h5 class="font-weight-bold">The system is using Globelabs API for sms.</h5>
                                        <p>In order to use sms, you need to provide the the following information of your Globelabs App.</p>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <div class="col-3 col-title">
                                            <label>SMS</label>
                                        </div>
                                        <div class="col-9">
                                            <div class="col-xl-9 col-lg-12 col-input">
                                                <div>For Automatic SMS to take effect please do the steps specified below.</div>
                                                <div><b>Step 1:</b> Go to <a target="_blank" href="https://developer.globelabs.com.ph/users/login">https://developer.globelabs.com.ph/users/login</a>.</div>
                                                <div><b>Step 2:</b> If you don't have an account, register for an account, otherwise go ahead and log in.</div>
                                                <div><b>Step 3:</b> After setting up your account, on Globelab's Dashboard, click the "CREATE APPS" button.</div>
                                                <div><b>Step 4:</b> Fill out the form and paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/services/register.php";?></u> on the "Redirect URL" field.</div>
                                                <div><b>Step 5:</b> Click Submit.</div>
                                                <div><b>Step 6:</b> Lastly, copy and paste the values needed below.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <div class="col-3 col-title">
                                            <label>SHORT CODE <br>(Last 4 numbers)</label>
                                        </div>
                                        <div class="col-9 col-input">
                                            <div class="col-xl-9 col-lg-12">
                                                <input name="page_sms_shortcode" onkeypress="return onlyNumberInput(event)" minlength="4" maxlength="4" type="text" class="form-control" value="<?php echo $pages['page_sms_shortcode']; ?>"  required>
                                                <div class="invalid-feedback">Please your app's last 4 number of Short Code.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <div class="col-3 col-title">
                                            <label>APP ID</label>
                                        </div>
                                        <div class="col-9 col-input">
                                            <div class="col-xl-9 col-lg-12">
                                                <input name="page_sms_appid" type="text" class="form-control" value="<?php echo $pages['page_sms_appid']; ?>"  required>
                                                <div class="invalid-feedback">Please your app's App ID.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12 mb-3">
                                        <div class="col-3 col-title">
                                            <label>APP SECRET</label>
                                        </div>
                                        <div class="col-9 col-input">
                                            <div class="col-xl-9 col-lg-12">
                                                <input name="page_sms_appsecret" type="text" class="form-control" value="<?php echo $pages['page_sms_appsecret']; ?>"  required>
                                                <div class="invalid-feedback">Please your app's App Secret.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-12">
                                        <div class="col-3 col-title"></div>
                                        <div class="col-9 col-input">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="sms_div">
                            <div class="row">
                                <div class="col-12 row pr-0">
                                    <?php 
                                        $Active_count = mysqli_num_rows(mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Active'"));
                                        $sms_today = $sms_month = $sms_year = $sms_all = $sms_start = 0;
                                        $query_today = mysqli_query($con, "SELECT * FROM tbl_sms WHERE DAY(`sms_date`) = DAY(CURRENT_DATE())");
                                        while($today = mysqli_fetch_assoc($query_today)){
                                            $sms_today += $today['sms_receiver_total'];
                                        }
                                        $query_month = mysqli_query($con, "SELECT * FROM tbl_sms WHERE MONTH(`sms_date`) = MONTH(CURRENT_DATE())");
                                        while($month = mysqli_fetch_assoc($query_month)){
                                            $sms_month += $month['sms_receiver_total'];
                                        }
                                        $query_year = mysqli_query($con, "SELECT * FROM tbl_sms WHERE YEAR(`sms_date`) = YEAR(CURRENT_DATE())");
                                        while($year = mysqli_fetch_assoc($query_year)){
                                            $sms_year += $year['sms_receiver_total'];
                                        }
                                        $query_all = mysqli_query($con, "SELECT * FROM tbl_sms");
                                        while($all = mysqli_fetch_assoc($query_all)){
                                            if($sms_start != 0){$sms_start =  $all['sms_date'];}
                                            $sms_all += $all['sms_receiver_total'];
                                        } 
                                    ?>
                                    <div class="col-lg-3 col-md-6 pr-0">
                                        <div class="card bg-primary">
                                            <div class="card-body">
                                                <div class="row justify-content-between">
                                                    <h5>Today</h5>
                                                    <span class="text-muted"><?php echo date('l');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo $sms_today;?></h1>
                                                        <h6 class="m-0">Total Sent SMS</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo "₱ ".$sms_today*0.5;?></h1>
                                                        <h6 class="m-0">Worth</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 pr-0">
                                        <div class="card bg-success">
                                            <div class="card-body">
                                                <div class="row justify-content-between">
                                                    <h5>This Month</h5>
                                                    <span class="text-muted"><?php echo date('F');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo $sms_month;?></h1>
                                                        <h6 class="m-0">Total Sent SMS</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo "₱ ".$sms_month*0.5;?></h1>
                                                        <h6 class="m-0">Worth</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 pr-0">
                                        <div class="card bg-info">
                                            <div class="card-body">
                                                <div class="row justify-content-between">
                                                    <h5>This Year</h5>
                                                    <span class="text-muted"><?php echo date('Y');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo $sms_year;?></h1>
                                                        <h6 class="m-0">Total Sent SMS</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo "₱ ".$sms_year*0.5;?></h1>
                                                        <h6 class="m-0">Worth</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 pr-0">
                                        <div class="card bg-<?php if($acc['acc_darkmode'] == 1){echo 'light';}else{echo 'dark';} ?>">
                                            <div class="card-body">
                                                <div class="row justify-content-between">
                                                    <h5>All Time</h5>
                                                    <span class="text-muted"><?php if($sms_start != 0){echo date("Y", strtotime($sms_start)).' - ';}?>Present</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo $sms_all;?></h1>
                                                        <h6 class="m-0">Total Sent SMS</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h1 class="m-0"><?php echo "₱ ".$sms_all*0.5;?></h1>
                                                        <h6 class="m-0">Worth</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-body pb-0">
                                            <h2><i class="fas fa-envelope"></i> Compose Message</h2>
                                            <form id="send_sms" class="needs-validation" novalidate>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <!-- <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" id="sendMessageRadio" name="r1" checked>
                                                                <label for="sendMessageRadio">Send Message</label>
                                                            </div>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" id="scheduleMessageRadio" name="r1">
                                                                <label for="scheduleMessageRadio">Schedule Pension Message</label>
                                                            </div>
                                                            <button type="button" class="btn btn-tool" id="scheduleMessageInstruction" data-toggle="modal" data-target="#pensionSchedule_Instruction">
                                                                <i class="fas fa-exclamation-circle"></i> In order for this to work, please view the instruction here
                                                            </button>
                                                        </div> -->
                                                        <!-- <div id="sendMessageInput">
                                                            <select name="reciever[]" id="reciever" class="form-control selectpicker shadow mb-3" title="Select reciever/s" data-style="form-control" data-size="10" data-actions-box="true" data-selected-text-format="count > 10" multiple data-live-search="true">
                                                                <?php 
                                                                    $query = mysqli_query($con, "SELECT * FROM tbl_applicants WHERE appl_status = 'Active'");
                                                                    while($data = mysqli_fetch_assoc($query)){
                                                                ?>
                                                                    <option value="<?php echo $data['appl_id']?>" data-tokens="<?php echo $data['appl_contactno'].' '.$data['appl_lastname'].','.$data['appl_firstname'].' '.$data['appl_middlename'];?>" data-subtext="<?php echo $data['appl_barangay'];?>"><?php echo $data['appl_lastname'].','.$data['appl_firstname'].' '.$data['appl_middlename']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="row" id="scheduleMessageInput">
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
                                                        </div> -->
                                                    </div>
                                                    <div class="col-md-8 order-2 order-md-1">
                                                        <textarea class="form-control shadow h-100 sidebar mt-0" name="message" id="message" placeholder="Write something..." style="overflow-x:auto;"></textarea>
                                                        <!-- <textarea class="form-control shadow h-100 sidebar mt-0" name="schedule_message" id="schedule_message" placeholder="Write your message here..." required style="overflow-x:auto;"><?php if($pages['page_pension_message'] != ''){echo $pages['page_pension_message'];}; ?></textarea> -->
                                                    </div>
                                                    <div class="col-md-4 order-1 order-md-2">
                                                        <table class="table table-sm table-borderless">
                                                                <thead>
                                                                    <tr><th scope="col">Barangay</th>
                                                                    <th scope="col">Pensioner per Barangay</th></tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="icheck-primary my-0">
                                                                                <input type="checkbox" id="all" value="all">
                                                                                <label class="mb-0" for="all">All Barangay</label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <b><?php echo $Active_count; ?></b>
                                                                        </td>
                                                                    </tr>
                                                            <?php 
                                                            $page_barangay = explode(',',$pages['page_barangay']);
                                                            $count = 1;
                                                            foreach($page_barangay as $barangay){
                                                                $count = mysqli_num_rows(mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Active' AND appl_barangay = '".$barangay."'"));
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="icheck-primary my-0">
                                                                            <input name="barangay[]" class="barangay" type="checkbox" id="<?php echo $barangay; ?>" value="<?php echo $barangay; ?>">
                                                                            <label for="<?php echo $barangay; ?>"><?php echo $barangay; ?></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <b><?php echo $count; ?></b>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-8 d-flex justify-content-between">
                                                        <span>Count: <span id="count">0</span></span>
                                                        <div id="btn_send">
                                                            <button class="btn btn-primary" type="submit" id="sendMessageButton"><i class="fas fa-paper-plane"></i> Send Message</button>
                                                        </div>
                                                        <!-- <div id="btn_sched">
                                                            <?php if($pages['page_pension_value']==''){ ?>
                                                                <button type="submit" class="btn btn-primary col-12" id="schedule_submit"><i class="fas fa-calendar-day"></i> Save Schedule</button>
                                                            <?php }else{ ?>
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        <button type="submit" class="btn btn-primary col-12" id="schedule_update"><i class="fas fa-calendar-day"></i> Update Schedule</button>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <button type="submit" class="btn btn-danger col-12" id="schedule_delete"><i class="fas fa-trash"></i> Delete Schedule</button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div> -->
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-body">
                                        <h2><i class="fas fa-history"></i> SMS History</h2>
                                        <table class="table table-hover" id="tblDataTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sender</th>
                                                    <th scope="col">Message</th>
                                                    <th scope="col">Receiver(Total)</th>
                                                    <th scope="col">Worth</th>
                                                    <th scope="col">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $query = mysqli_query($con, "SELECT * FROM tbl_sms ORDER BY sms_id DESC");
                                                    while($sms = mysqli_fetch_assoc($query)){
                                                        $sender = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_username FROM tbl_accounts WHERE acc_id = '".$sms['sms_sender_id']."' "));
                                                ?>
                                                <tr id="view_sms_info" data-id="<?php echo $sms['sms_id'];?>" data-toggle="modal" data-target="#sms_info_modal">
                                                    <th scope="row" style="white-space: nowrap;">
                                                        <?php if(isset($sender['acc_username'])){ echo $sender['acc_username'];}else{echo 'Pension Status Message';};?>
                                                    </th>
                                                    <td><?php
                                                        if(strlen ($sms['sms_message']) >200){ 
                                                            $str=substr ($sms['sms_message'], 0, 200 - 3); 
                                                            echo (substr ($str, 0, strrpos ($str, ' ')).'...');
                                                        }else{echo $sms['sms_message'];}
                                                    ?></td>
                                                    <td style="white-space: nowrap;"><?php echo $sms['sms_receiver_total'];?></td>
                                                    <td style="white-space: nowrap;"><?php echo "₱ ".$sms['sms_receiver_total']*0.50;?></td>
                                                    <td style="white-space: nowrap;"><?php echo date("M d, Y - h:i a", strtotime($sms['sms_date']));?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>
    </div>
    <!-- ./wrapper -->
    
    <div class="modal fade" id="sms_info_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="sms_info">
                
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

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js" integrity="sha512-CJXg3iK9v7yyWvjk2npXkQjNQ4C1UES1rQaNB7d7ZgEVX2a8/2BmtDmtTclW4ial1wQ41cU34XPxOw+6xJBmTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- InputMask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.3/dataTables.bootstrap4.min.js" integrity="sha512-9o2JT4zBJghTU0EEIgPvzzHOulNvo0jq2spTfo6mMmZ6S3jK+gljrfo0mKDAxoMnrkZa6ml2ZgByBQ5ga8noDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive/2.2.7/dataTables.responsive.min.js" integrity="sha512-4ecidd7I1XWwmLVzfLUN0sA0t2It86ti4qwPAzXW7B0/yIScpiOj7uyvFgu/ieGTEFjO5Ho98RZIqt75+ZZhdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.js" integrity="sha512-OiHNq9acGP68tNJIr1ctDsYv7c2kuEVo2XmB78fh4I+3Wi0gFtZl4lOi9XIGn1f1SHGcXGhn/3VHVXm7CYBFNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/dataTables.buttons.min.js" integrity="sha512-EzaqIDcdBg8g037o9E12U69oY/mfHffJJzUtB6dgd67AB4IXkMi1/7WY6og4fKSVXtqqt35S/R5ClqNHjSIH4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/1.7.0/buttons.bootstrap4.min.js" integrity="sha512-D4MloW0hy9XtYnqtvwfg2T2WZRn0dB8Ir0KcPrDX7S/gVE05JotZQHirzd9vMSIT8ViKyntOOZl1muHii0spUA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js" integrity="sha512-uVSVjE7zYsGz4ag0HEzfugJ78oHCI1KhdkivjQro8ABL/PRiEO4ROwvrolYAcZnky0Fl/baWKYilQfWvESliRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js" integrity="sha512-HLbtvcctT6uyv5bExN/qekjQvFIl46bwjEq6PBvFogNfZ0YGVE+N3w6L+hGaJsGPWnMcAQ2qK8Itt43mGzGy8Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.min.js" integrity="sha512-VIF8OqBWob/wmCvrcQs27IrQWwgr3g+iA4QQ4hH/YeuYBIoAUluiwr/NX5WQAQgUaVx39hs6l05cEOIGEB+dmA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.html5.min.js" integrity="sha512-ehHOosb2HF/KK/7kZSGFaOijR+smIS5PvSPBG0He69iTEQe30Q+g0NLJYQUmySpqGrol1frtzE1Re2a9AebxiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.print.min.js" integrity="sha512-kYpyIzqFmlPX1c3EhpL4+8AajeawkvGies2wVJcpMZJ/7zupZ/KcHa8QsDng8rtFUn2yPk/0MZolkz3pTqhsPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/1.7.0/js/buttons.colVis.min.js" integrity="sha512-ll1/he+7pNOn7mpHZxOpCdV6HB+BNYs9rcDeHZSTV33/JHJIET2HCSjbCXREbl0LteZVQpg+zgpAlIABGXL/ow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        /* ---------------------------------------------- /*
        * Table Functions
        /* ---------------------------------------------- */
        // Div Width
        var divWidth = "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        // Adding Datatable Functions to Tables
        $('#tblDataTable').DataTable({
            "dom": divWidth,
            "responsive": true, "lengthChange": false, "autoWidth": false, "bSort": false,
            "lengthMenu": [
                [ 10, 25, 50, 100, -1 ],
                [ '10 rows', '25 rows', '50 rows', '100 rows', 'Show all' ]
            ],
            "buttons": [
                // { extend: 'copy', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-copy"></i> Copy' },
                { extend: 'excel', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-file-excel"></i> Export Excel' },
                { extend: 'pdf', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-file-pdf"></i> Export PDF' },
                { extend: 'print', className: 'btn btn-default bg-transparent', text: '<i class="fas fa-print"></i> Print' },
                // { extend: 'colvis', className: 'btn btn-default', text: '<i class="fas fa-columns"></i> Column Visibility' },
                { extend: 'pageLength', className: 'btn btn-default bg-transparent' },
            ]
        }).buttons().container().appendTo('#tblDataTable_wrapper .col-md-8:eq(0)');
        // Send SMS
        $("#all").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        var pension_button='';
        $("body").on('click', '#schedule_submit', function(event){ pension_button=0;})
        $("body").on('click', '#schedule_update', function(event){ pension_button=1;})
        $("body").on('click', '#schedule_delete', function(event){ pension_button=2;})
        $("body").on('submit', '#send_sms', function(event){
            event.preventDefault();
            // if ($("#sendMessageRadio:checked").val()) {
                var barangay = '';
                var message = $('#message').val();
                if($.trim(message) != ''){
                    $("input:checkbox[class=barangay]:checked").each(function(){
                        if(barangay == ''){
                            barangay += $(this).val();
                        }else{
                            barangay += ', '+$(this).val();
                        }
                    });
                    if(barangay != ''){
                        Swal.fire({
                            title: 'Please check your available balance before sending sms to',
                            text: barangay+" pensioners?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Send'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "/admin/assets/php/sms_crud.php?id=1",
                                    method: "POST",
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    data: new FormData(this),
                                    success:function(response){
                                        if(response == 1){
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Message sent successfully.',
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true
                                            })
                                            $('#send_sms').removeClass('was-validated');
                                            // $("#reciever").val('default').selectpicker("refresh");
                                            $('#send_sms')[0].reset();
                                            $('#sms_div').load(location.href + " #sms_div")
                                        }else{
                                            Swal.fire({
                                                icon: 'error',
                                                title: response,
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
                    }else{
                        Swal.fire({
                            title: 'Oopss... No barangay is selected',
                            text: "Please select at least one barangay.",
                            icon: 'error',
                        })
                    }
                }else{
                    Swal.fire({
                        title: 'Oopss... No message detected',
                        text: "Messages that contains only spaces are prohibited.",
                        icon: 'error',
                    })
                }
            // }else if ($("#scheduleMessageRadio:checked").val()){
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
            // }   
        })

        $("body").on('submit', '#sms_codes', function(event){
            event.preventDefault();
            $.ajax({
                url: "/admin/assets/php/sms_crud.php?id=2",
                method: "POST",
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success:function(response){
                    if(response == 1){
                        location.reload();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: response,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        })
                    }
                }
            });
        })
        $("#message").keypress(function(){
            var count = $('#message').val().length;
            $("#count").html(count);
        })
        function onlyNumberInput(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
        $("body").on('click', '#view_sms_info', function(event){
            $('#sms_info_modal').modal();
            var sms_id = $(this).attr("data-id");
            $.ajax({
                url: "/admin/assets/php/sms_modal.php",
                method: "POST",
                data:{sms_id:sms_id},
                success:function(data){
                    $('#sms_info').html(data);
                    $('#sms_info_modal').modal('show');
                }
            });
        })

        // $("#sendMessageInput").show();
        // $("#scheduleMessageInput").hide();
        // $("#scheduleMessageInstruction").hide();
        // $("#schedule_message").hide();
        // $("#btn_sched").hide();
        // $('#schedule_date').not(this).prop("disabled",true);
        // $('#schedule_value').not(this).prop("disabled",true);

        // $("#sendMessageRadio").on( "click", function(){
        //     $("#scheduleMessageInput").hide();
        //     $('input:checkbox').not(this).prop("disabled",false);
        //     $("#scheduleMessageInstruction").hide();
        //     $("#message").show();
        //     $("#schedule_message").hide();
        //     $("#btn_send").show();
        //     $("#btn_sched").hide();
        //     $('#schedule_date').not(this).prop("disabled",true);
        //     $('#schedule_value').not(this).prop("disabled",true);
        // });
        // $("#scheduleMessageRadio").on( "click", function(){
        //     $('input:checkbox').not(this).prop('checked', false);
        //     $("#scheduleMessageInput").show();
        //     $('input:checkbox').not(this).prop("disabled",true);
        //     $("#scheduleMessageInstruction").show();
        //     $("#message").hide();
        //     $("#schedule_message").show();
        //     $("#btn_send").hide();
        //     $("#btn_sched").show();
        //     $('#schedule_date').not(this).prop("disabled",false);
        //     $('#schedule_value').not(this).prop("disabled",false);
        // });
    </script>
</body>
</html>