<?php 
    include '../assets/php/database.php';
    include 'assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
    if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS']==='on'){ $server_name="https://".$_SERVER['SERVER_NAME'];}else{ $server_name="http://".$_SERVER['SERVER_NAME'];}
    $parse = parse_url($server_name);
    $server_name = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" integrity="sha512-JApjWRnfonFeGBY7t4yq8SWr1A6xVYEJgO/UMIYONxaR3C9GETKUg0LharbJncEzJF5Nmiv+Pr5QNulr81LjGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.3/dataTables.bootstrap4.min.css" integrity="sha512-+RecGjm1x5bWxA/jwm9sqcn5EV0tNej3Xxq5HtIOLM9YM9VgI2LbhEDn099Xhxg6HuvrmsXR0J6JQxL7tLHFHw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.7/responsive.bootstrap4.min.css" integrity="sha512-+TJckkeGxlxMsXzzgiOzPP98YRd+4BiK4B6n/8T4ls+LHSVtwLNvidIXKHL0OkzwBz8iG5YNwcKO6U2mWgoHDQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/1.7.0/buttons.bootstrap4.min.css" integrity="sha512-0LpZpPhy5gC20rXCT9HfsYz0gF+wRD62I/MCY+d1tDgK7xKpvd0hQLMBqyXS9BYdzyis/BdIW2iMIBK8e+0o+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css" integrity="sha512-ClXpwbczwauhl7XC16/EFu3grIlYTpqTYOwqwAi7rNSqxmTqCpE8VS3ovG+qi61GoxSLnuomxzFXDNcPV1hvCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.css" integrity="sha512-vE1vuJehUqVW9CvtimaOOJ+vgfv5o/d5Z7uBorSX5ASYxi18F3wO7H+IK0G2i5TqHCwQ/XOZGXzx3dne9a9AhA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> 
    <?php } ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css" integrity="sha512-RPxGl20NcAUAq1+Tfj8VjurpvkZaep2DeCgOfQ6afXSEgcvrLE6XxDG2aacvwjdyheM/bkwaLVc7kk82+mafkQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Analytics</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Analytics</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="mb-3">
                        <a href="javascript:void(0)" class="btn btn-primary " id="pensioner_button"><i class="nav-icon fas fa-users"></i> Pensioners</a>
                        <a href="javascript:void(0)" class="btn btn-outline-primary" id="sms_button"><i class="nav-icon fas fa-comment-alt"></i> SMS</a>
                        <a href="javascript:void(0)" class="btn btn-outline-primary" id="website_views_button"><i class="fas fa-street-view"></i> Website Views</a>
                    </div>
                    <div id="pensioner">
                        <!-- Applicants -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-file-alt"></i> Applicants</h5>
                                <div class="card-tools row ml-auto">
                                    <div class="col-auto">
                                        <select class="form-control p-0" id="applicantsChart_day">
                                            <option value="Today">Today</option>
                                            <option value="Weekly">Daily(Week)</option>
                                            <option value="Monthly">Daily(Month)</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Yearly">Monthly</option>
                                            <option value="All" selected>All</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-control p-0" id="applicantsChart_look">
                                            <option value="line">Line Chart</option>
                                            <option value="bar">Bar Chart</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="chart-responsive applicants_container">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_applicants" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-3">
                                        <?php 
                                            $total = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants'));
                                            $applicants = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Applicant"'));
                                            $active = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Active"'));
                                            $deceased = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Deceased"'));
                                            $rejected = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Rejected"'));
                                            $deleted = mysqli_num_rows(mysqli_query($con, 'SELECT appl_id FROM tbl_applicants WHERE appl_status = "Deleted"'));
                                        ?>
                                        <div class="progress-group">
                                            <span class="progress-text">Applicants</span>
                                            <span class="float-right"><b><?php echo $applicants; ?></b>/<?php echo $total; ?></span>
                                            <div class="progress" style="height:20px">
                                                <div class="progress-bar bg-primary" style="width: <?php echo ($applicants/$total)*100 . '%';?>"><?php echo round(($applicants/$total)*100, 2) . '%';?></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Pensioners</span>
                                            <span class="float-right"><b><?php echo $active; ?></b>/<?php echo $total; ?></span>
                                            <div class="progress" style="height:20px">
                                                <div class="progress-bar bg-success" style="width: <?php echo ($active/$total)*100 . '%';?>"><?php echo round(($active/$total)*100, 2) . '%';?></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Deceased Pensioners</span>
                                            <span class="float-right"><b><?php echo $deceased; ?></b>/<?php echo $total; ?></span>
                                            <div class="progress" style="height:20px">
                                                <div class="progress-bar bg-warning" style="width: <?php echo ($deceased/$total)*100 . '%';?>"><?php echo round(($deceased/$total)*100, 2) . '%';?></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Rejected Applicants</span>
                                            <span class="float-right"><b><?php echo $rejected; ?></b>/<?php echo $total; ?></span>
                                            <div class="progress" style="height:20px">
                                                <div class="progress-bar bg-danger" style="width: <?php echo ($rejected/$total)*100 . '%';?>"><?php echo round(($rejected/$total)*100, 2) . '%';?></div>
                                            </div>
                                        </div>
                                        <div class="progress-group">
                                            <span class="progress-text">Deleted Applicants</span>
                                            <span class="float-right"><b><?php echo $deleted; ?></b>/<?php echo $total; ?></span>
                                            <div class="progress" style="height:20px">
                                                <div class="progress-bar bg-<?php if($acc['acc_darkmode'] == 1){echo 'light';}else{echo 'dark';} ?>" style="width: <?php echo ($deleted/$total)*100 . '%';?>"><?php echo round(($deleted/$total)*100, 2) . '%';?></div>
                                            </div>
                                        </div>
                                        <div class="chart-responsive ">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="applicantsPieChart" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Barangay -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center border-0">
                                        <label><i class="fas fa-street-view"></i> Barangay(Active Pensioner)</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_municipality" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pension Recieved per Barangay -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center border-0">
                                        <label><i class="fas fa-money-bill-wave"></i> Total Pension Recieved</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_pension" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Expenses of Pensioners -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center border-0">
                                        <label><i class="fas fa-shopping-cart"></i> Total Expenses of Pensioners</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_expense" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                    </div>
                                    <div class="col-lg-6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- Civil Status -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center border-0">
                                        <label><i class="fas fa-user-tag"></i> Civil Status(Active Pensioner)</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_civilstatus" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Gender -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center border-0">
                                        <label><i class="fas fa-venus-mars"></i> Gender(Active Pensioner)</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="canvas_gender" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pensioner with most Recieved Pension -->
                                <div class="card">
                                    <div class="card-header border-0">
                                        <label><i class="fas fa-money-bill-wave"></i> MOST RECIEVED PENSION</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table m-0 table-borderless table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Barangay</th>
                                                        <th>Pension</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $count = 1;
                                                        $query = mySQLi_query($con, "SELECT appl_firstname, appl_lastname, appl_barangay, SUM(appl_pension_recieved) as recieved_sum
                                                            FROM tbl_applicants
                                                            WHERE appl_status = 'Active' 
                                                            GROUP BY appl_id 
                                                            DESC LIMIT 5") 
                                                            or die(mySQLi_error($con));
                                                        while($fetch=mySQLi_fetch_assoc($query)){
                                                    ?>
                                                    <tr>
                                                        <td><b><?php echo $count; ?></b></td>
                                                        <td><?php echo $fetch['appl_firstname']. ' ' .$fetch['appl_lastname'] ?></td>
                                                        <td><?php echo $fetch['appl_barangay'] ?></td>
                                                        <td><?php echo $fetch['recieved_sum'] ?></td>
                                                    </tr>
                                                    <?php 
                                                            $count += 1;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Pensioner with most Expense -->
                                <div class="card">
                                    <div class="card-header border-0">
                                        <label><i class="fas fa-shopping-cart"></i> MOST SPENT</label>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table m-0 table-borderless table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Barangay</th>
                                                        <th>Spent</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $count = 1;
                                                        $query = mySQLi_query($con, "SELECT SUM(tbl_purchases.pur_amount) AS pur_amount_sum, appl_firstname, appl_lastname, appl_barangay
                                                            FROM tbl_accounts, tbl_purchases, tbl_applicants
                                                            WHERE tbl_accounts.acc_id = tbl_purchases.acc_id AND tbl_applicants.appl_id = tbl_accounts.acc_appl_id
                                                            GROUP BY tbl_purchases.acc_id ASC 
                                                            LIMIT 5;") 
                                                            or die(mySQLi_error($con));
                                                        while($fetch=mySQLi_fetch_assoc($query)){
                                                    ?>
                                                    <tr>
                                                        <td><b><?php echo $count; ?></b></td>
                                                        <td><?php echo $fetch['appl_firstname']. ' ' .$fetch['appl_lastname'] ?></td>
                                                        <td><?php echo $fetch['appl_barangay'] ?></td>
                                                        <td><?php echo $fetch['pur_amount_sum'] ?></td>
                                                    </tr>
                                                    <?php 
                                                            $count += 1;
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Deceased -->
                                <div class="card">
                                    <div class="card-header border-0">
                                        <label><i class="fas fa-chart-pie"> </i> Deceased Pensioner</label>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="areaChart" class="chartjs-render-monitor"></canvas>
                                            <ul class="chart-legend clearfix" id="areaChartLabels"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sms">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-comment-dollar"></i> Spent on SMS</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- SMS Chart -->
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="smsSpentCanvas" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                    <!-- Info Box -->
                                    <div class="col-lg-4 px-3">
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
                                        <div class="info-box my-3 bg-primary">
                                            <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                                            <div class="info-box-content">
                                                <div class="row justify-content-between px-1">
                                                    <span class="info-box-text">Today</span>
                                                    <span class="info-box-text"><?php echo date('l');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo $sms_today;?></span>
                                                        <span class="info-box-text">Total Sent SMS</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo "₱ ".$sms_today*0.5;?></span>
                                                        <span class="info-box-text">Worth</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                            <div class="info-box-content">
                                                <div class="row justify-content-between px-1">
                                                    <span class="info-box-text">This Month</span>
                                                    <span class="info-box-text"><?php echo date('F');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo $sms_month;?></span>
                                                        <span class="info-box-text">Total Sent SMS</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo "₱ ".$sms_month*0.5;?></span>
                                                        <span class="info-box-text">Worth</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-info">
                                            <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                            <div class="info-box-content">
                                                <div class="row justify-content-between px-1">
                                                    <span class="info-box-text">This Year</span>
                                                    <span class="info-box-text"><?php echo date('Y');?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo $sms_year;?></span>
                                                        <span class="info-box-text">Total Sent SMS</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo "₱ ".$sms_year*0.5;?></span>
                                                        <span class="info-box-text">Worth</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-<?php if($acc['acc_darkmode'] == 1){echo 'light';}else{echo 'dark';} ?>">
                                            <span class="info-box-icon"><i class="far fa-calendar-check"></i></span>
                                            <div class="info-box-content">
                                                <div class="row justify-content-between px-1">
                                                    <span class="info-box-text">All Time</span>
                                                    <span class="info-box-text"><?php if($sms_start != 0){echo date("Y", strtotime($sms_start)).' - ';}?>Present</span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo $sms_all;?></span>
                                                        <span class="info-box-text">Total Sent SMS</span>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <span class="info-box-number"><?php echo "₱ ".$sms_all*0.5;?></span>
                                                        <span class="info-box-text">Worth</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SMS History -->
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
                    <div id="website_views">
                        <!-- Map(views) -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-street-view"></i> Website Visitors</h3>
                                <!-- <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div> -->
                            </div>
                            <div class="card-body p-0">
                                <div class="d-md-flex">
                                    <div class="p-1 flex-fill" style="overflow: hidden">
                                        <div id="vmap" style="width: 100%; height: 400px;"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6><i class="fas fa-info-circle"></i> Click a place to view data</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="float-md-right" id="unknown_visits"></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-pane-right shadow pt-2 pb-2 pl-4 pr-4" style="min-width: 25%;">
                                        <div class="mb-4">
                                            <h4><b>Total Website Visits</b></span>
                                            <h1 class="text-center"><b id="total_views"></b></h1>
                                            <h6><i class="fas fa-info-circle"></i> All website visit</h6>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <h4><b>Organic Visits</b></span>
                                            <span class="row">
                                                <h2 class="col-6 text-center"><b id="organic_views"></b></h2>
                                                <h2 class="col-6 text-center"><b id="organic_percentage"></b></h2>
                                            </span>
                                            <h6><i class="fas fa-info-circle"></i> Visits that does not come from other site.</h6>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <h4><b>Referrals Visits</b></span>
                                            <span class="row">
                                                <h2 class="col-6 text-center"><b id="referral_views"></b></h2>
                                                <h2 class="col-6 text-center"><b id="referral_percentage"></b></h2>
                                            </span>
                                            <h6><i class="fas fa-info-circle"></i> Visits that comes from other sites</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Right -->
                            <div class="col-lg-8">
                                <!-- Website Views(date) -->
                                <div class="card">
                                    <div class="card-header d-flex align-items-center">
                                        <h3 class="card-title"><i class="fas fa-chart-line"></i> Website Views</h3> 
                                        <div class="card-tools row ml-auto">
                                            <div class="col-auto">
                                                <select class="form-control p-0" id="viewsChart_day">
                                                    <option value="Today">Today</option>
                                                    <option value="Weekly">Daily(Week)</option>
                                                    <option value="Monthly">Daily(Month)</option>
                                                    <option value="Quarterly">Quarterly</option>
                                                    <option value="Yearly">Monthly</option>
                                                    <option value="All" selected>All</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <select class="form-control p-0" id="viewsChart_look">
                                                    <option value="line">Line Chart</option>
                                                    <option value="bar">Bar Chart</option>
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-responsive viewsChart-parent">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="viewsChart" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Platform -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-mobile-alt"></i> Platform</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="platformCanvas" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Page(views) -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-pager"></i> Page Views</h3>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table m-0 table-borderless table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Page</th>
                                                                <th>Organic</th>
                                                                <th>Referral</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $query=mySQLi_query($con, "SELECT vis_url,vis_referred,COUNT(vis_url) AS dev_count from tbl_visitor GROUP BY vis_url ORDER BY dev_count DESC") or die(mySQLi_error($con));
                                                                while($vis=mySQLi_fetch_assoc($query)){
                                                                    $organic = mysqli_num_rows(mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_url = "'.$vis['vis_url'].'"'));
                                                                    $referred = mysqli_num_rows(mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%" AND vis_url = "'.$vis['vis_url'].'"'));
                                                            ?>
                                                                <tr>
                                                                    <td><b><?php 
                                                                        $url = explode("/", $vis['vis_url']);
                                                                        $page = end($url);
                                                                        if($page==''){ echo 'Home';}
                                                                        else{ echo ucfirst($page);}
                                                                    ?></b></td>
                                                                    <td><?php echo $organic ?></td>
                                                                    <td><?php echo $referred ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- Top Country(views) -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Top Countries</h3>      
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table m-0 table-borderless table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Country</th>
                                                                <th>Views</th>
                                                                <th>Percentage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                $count = 1;
                                                                $query=mySQLi_query($con, "SELECT vis_country,COUNT(vis_country) AS dev_count, SUM(COUNT(vis_country)) OVER() AS total_count FROM tbl_visitor GROUP BY vis_country ORDER BY dev_count DESC LIMIT 9") or die(mySQLi_error($con));
                                                                while($vis=mySQLi_fetch_assoc($query)){
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $count; $count += 1; ?></td>
                                                                    <td><b><?php
                                                                        if($vis['vis_country'] == ''){
                                                                            echo 'Unknown';
                                                                        }else{
                                                                            echo ucfirst($vis['vis_country']);
                                                                        }
                                                                    ?></b></td>
                                                                    <td><?php echo round($vis['dev_count'], 2) ?></td>
                                                                    <td><?php echo round(($vis['dev_count']/$vis['total_count'])*100, 2).'%'; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <center><a href="javascript:void(0)" data-toggle="modal" data-target="#allCountryDetailsModal">View all</a></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Left -->
                            <div class="col-lg-4">
                                <!-- Browser Usage -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-columns"></i> Browser Usage</h3> 
                                        <!-- <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="chart-responsive">
                                                    <div class="chartjs-size-monitor">
                                                        <div class="chartjs-size-monitor-expand">
                                                            <div class=""></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink">
                                                            <div class=""></div>
                                                        </div>
                                                    </div>
                                                    <canvas id="pieChart" class="chartjs-render-monitor"></canvas>
                                                </div>
                                                <ul class="chart-legend clearfix" id="browser_name"></ul>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Device -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-mobile-alt"></i> Device</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chart-responsive">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                                <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                            </div>
                                            <canvas id="deviceCanvas" class="chartjs-render-monitor"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- Referral(views) -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-share-square"></i> Referrals</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table m-0 table-borderless table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Domain</th>
                                                        <th>Views</th>
                                                        <th>Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $query=mySQLi_query($con, "SELECT vis_referred,COUNT(vis_referred) AS dev_count, SUM(COUNT(vis_referred)) OVER() AS total_count FROM tbl_visitor WHERE (vis_referred != '' AND vis_referred NOT LIKE '%".$server_name."%') GROUP BY vis_referred ORDER BY dev_count DESC") or die(mySQLi_error($con));
                                                        while($vis=mySQLi_fetch_assoc($query)){
                                                    ?>
                                                        <tr>
                                                            <td><b><?php 
                                                                // $url = explode(".", $vis['vis_referred']);
                                                                // $page = $url[1];
                                                                // if($page==''){ echo 'Home';}
                                                                // else{ echo ucfirst($page);}
                                                                echo $vis['vis_referred'];
                                                            ?></b></td>
                                                            <td><?php echo round($vis['dev_count'], 2) ?></td>
                                                            <td><?php echo round(($vis['dev_count']/$vis['total_count'])*100, 2).'%'; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
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

    <!-- Map -->
    <div class="modal fade" id="countryDetailsModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0">
                    <h4 class="modal-title" id="countryDetailsModalTitle"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="countryDetailsModalBody">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="chart-responsive regionChart-parent">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand"><div class=""></div></div>
                                    <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
                                </div>
                                <canvas id="regionChart" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-3" id="regionSideBar">
                            <div class="mb-4">
                                <h4><b>Total Website Visits</b>
                                </h4><h1 class="text-center"><b id="region_total_views"></b></h1>
                                <h6><i class="fas fa-info-circle"></i> All website visit</h6>
                            </div>
                            <hr>
                            <div class="mb-4">
                                <h4><b>Organic Visits</b>
                                <span class="row">
                                    <h2 class="col-6 text-center"><b id="region_organic_views"></b></h2>
                                    <h2 class="col-6 text-center"><b id="region_organic_percentage"></b></h2>
                                </span>
                                </h4><h6><i class="fas fa-info-circle"></i> Visits that does not come from other site.</h6>
                            </div>
                            <hr>
                            <div class="mb-4">
                                <h4><b>Referrals Visits</b>
                                <span class="row">
                                    <h2 class="col-6 text-center"><b id="region_referral_views"></b></h2>
                                    <h2 class="col-6 text-center"><b id="region_referral_percentage"></b></h2>
                                </span>
                                </h4><h6><i class="fas fa-info-circle"></i> Visits that comes from other sites</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All Country -->
    <div class="modal fade" id="allCountryDetailsModal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0">
                    <h4 class="modal-title">All Countries</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="allCountryDetailsModalBody">
                    <div class="table-responsive">
                        <table class="table m-0 table-borderless table-hover" style="overflow: scroll;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Country</th>
                                    <th>Organic</th>
                                    <th>Referral</th>
                                    <th>Views</th>
                                    <th>Views Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $count = 1;
                                    $query = mySQLi_query($con, "SELECT vis_country,COUNT(vis_country) AS dev_count, SUM(COUNT(vis_country)) OVER() AS total_count FROM tbl_visitor GROUP BY vis_country ORDER BY dev_count DESC") or die(mySQLi_error($con));
                                    while($vis=mySQLi_fetch_assoc($query)){
                                        $query_organic = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred = "" OR vis_referred LIKE "%'.$server_name.'%") AND vis_country = "'.$vis['vis_country'].'"');
                                        $numrow_organic = mysqli_num_rows($query_organic);

                                        $query_referral = mysqli_query($con, 'SELECT vis_id FROM tbl_visitor WHERE (vis_referred != "" AND vis_referred NOT LIKE "%'.$server_name.'%") AND vis_country = "'.$vis['vis_country'].'"');
                                        $numrow_referral = mysqli_num_rows($query_referral);
                                ?>
                                    <tr>
                                        <td><?php echo $count; $count += 1; ?></td>
                                        <td><b><?php
                                            if($vis['vis_country'] == ''){
                                                echo 'Unknown';
                                            }else{
                                                echo ucfirst($vis['vis_country']);
                                            }
                                        ?></b></td>
                                        <td><?php echo $numrow_organic ?></td>
                                        <td><?php echo $numrow_referral ?></td>
                                        <td><?php echo round($vis['dev_count'], 2) ?></td>
                                        <td><?php echo round(($vis['dev_count']/$vis['total_count'])*100, 2).'%'; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js" integrity="sha512-5R3ngaUdvyhXkQkIqTf/k+Noq3phjmrqlUQyQYbgfI34Mzcx7vLIIYTy/K1VMHkL33T709kfh5y6R9Xy/Cbt7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js" integrity="sha512-Zk7h8Wpn6b9LpplWXq1qXpnzJl8gHPfZFf8+aR4aO/4bcOD5+/Si4iNu9qE38/t/j1qFKJ08KWX34d2xmG0jrA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js" integrity="sha512-MY25HCukIs0J/mkXQ5qrPYzipNwn96U2B/MSJohB0XAkVay4g39nwDuy3EMepg18QShbS6lvhNWdnl1YQimclQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //-------------
            // - MAP -
            //-------------
            $('#vmap').on('wheel', function(e){
                e.preventDefault();
                var delta = e.originalEvent.deltaY;

                if (delta < 0) $('#vmap').vectorMap('zoomIn');
                else $('#vmap').vectorMap('zoomOut');
            })
            //-----------------
            // - LINE CHART -
            //-----------------
            document.querySelectorAll("#viewsChart_look, #viewsChart_day").forEach((element) => {
                element.addEventListener("change", function (event) {
                    event.preventDefault();
                    line(document.getElementById('viewsChart_look').value, document.getElementById('viewsChart_day').value);
                });
            });
            //-----------------
            // - CONTAINER -
            //-----------------
            $('#website_views_button').on('click', function(e){
                $('#pensioner_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#website_views_button').addClass('btn-primary').removeClass('btn-outline-primary');
                $('#sms_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#pensioner').hide();
                $('#sms').hide();
                $('#website_views').show();
            })
            $('#pensioner_button').on('click', function(e){
                $('#pensioner_button').addClass('btn-primary').removeClass('btn-outline-primary');
                $('#website_views_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#sms_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#website_views').hide();
                $('#sms').hide();
                $('#pensioner').show();
            })
            $('#sms_button').on('click', function(e){
                $('#pensioner_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#website_views_button').addClass('btn-outline-primary').removeClass('btn-primary');
                $('#sms_button').addClass('btn-primary').removeClass('btn-outline-primary');
                $('#website_views').hide();
                $('#sms').show();
                $('#pensioner').hide();
            })
            //-----------------
            // - APPLICANTS -
            //-----------------
            document.querySelectorAll("#applicantsChart_look, #applicantsChart_day").forEach((element) => {
                element.addEventListener("change", function (event) {
                    event.preventDefault();
                    applicants(document.getElementById('applicantsChart_day').value, document.getElementById('applicantsChart_look').value);
                });
            });
        });
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
        //-------------
        // - MAP -
        //-------------
        function unknown() {
            $.ajax({
                url:"assets/php/analytics_crud.php",
                method:"POST",
                data:{action:'unknown'},
                dataType:"JSON",
                success:function(dataUnknown){
                    $('#total_views').html(dataUnknown.total_views);
                    $('#unknown_visits').html(dataUnknown.unknown);
                    $('#organic_views').html(dataUnknown.organic_total);
                    $('#organic_percentage').html(dataUnknown.organic_percentage + '%');
                    $('#referral_views').html(dataUnknown.referrals_total);
                    $('#referral_percentage').html(dataUnknown.referrals_percentage + '%');
                }
            })
        };unknown();
        $('#vmap').vectorMap({
            map: 'world_en',
            backgroundColor: 'transparent',
            borderColor: '#818181',
            borderOpacity: 0.25,
            borderWidth: 1,
            color: 'gray',
            enableZoom: true,
            hoverColor: '#343a40',
            hoverOpacity: null,
            // hoverOpacity: 0.7,
            normalizeFunction: 'linear',
            // scaleColors: ['#b6d6ff', '#005ace'],
            selectedColor: '#343a40',
            selectedRegions: null,
            showTooltip: true,
            // values: sample_data,
            onLabelShow: function(event, label, code) {
                var region = $(label).text();
                if(region == 'United States of America'){
                    region = 'United States';
                }else if(region == 'Russian Federation'){
                    region = 'Russia';
                }
                // $(label).html(region);
                $.ajax({
                    url:"assets/php/analytics_crud.php",
                    method:"POST",
                    data:{action:'labelshow',region:region},
                    // dataType:"JSON",
                    success:function(data){
                        $(label).css({"position":"absolute","left":"100px","top":"150px;"});
                        $(label).html(data);
                    }
                })
            },
            onRegionClick: function(event, code, region){
                $('#regionChart').remove();
                $('.regionChart-parent').append('<canvas id="regionChart" class="chartjs-render-monitor"></canvas>');

                if(region == 'United States of America'){
                    region = 'United States';
                }else if(region == 'Russian Federation'){
                    region = 'Russia';
                }
                $('#countryDetailsModalTitle').html(region);
                $.ajax({
                    url:"assets/php/analytics_crud.php",
                    method:"POST",
                    data:{action:'countryDetails',region:region},
                    dataType:"JSON",
                    success:function(data){
                        var label = [];
                        var all = [];
                        var organic = [];
                        var referral = [];
                        var region_total = [];
                        var region_organic = [];
                        var region_referral = [];

                        for(var count = 0; count < data.length; count++){
                            label.push(data[count].label);
                            all.push(data[count].all);
                            organic.push(data[count].organic);
                            referral.push(data[count].referral);
                            region_total.push(data[count].region_total_views);
                            region_organic.push(data[count].region_organic_views);
                            region_referral.push(data[count].region_referral_views);
                        }
                        
                        var config = {
                            type: 'line',
                            data: {
                                labels: label,
                                datasets: [{
                                    label: 'All',
                                    backgroundColor: 'rgb(54, 162, 235)',
                                    borderColor:'rgb(54, 162, 235)',
                                    data: all,
                                    fill: false,
                                }, {
                                    label: 'Organic',
                                    fill: false,
                                    backgroundColor: 'rgb(72, 184, 184)',
                                    borderColor: 'rgb(72, 184, 184)',
                                    data: organic,
                                }, {
                                    label: 'Referral',
                                    fill: false,
                                    backgroundColor: 'rgb(255, 99, 132)',
                                    borderColor: 'rgb(255, 99, 132)',
                                    data: referral,
                                }]
                            },
                            options: {
                                responsive: true,
                                tooltips: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                hover: {
                                    mode: 'nearest',
                                    intersect: true
                                },
                                scales: {
                                    xAxes: [{
                                        display: true,
                                        fontColor: "#808080"
                                    }],
                                    yAxes: [{
                                        display: true,
                                        beginAtZero: true,
                                        fontColor: "#808080"
                                    }]
                                },
                                plugins: {
                                    datalabels: {
                                        color: 'gray'
                                    }
                                }
                            }
                        };

                        canvas = document.querySelector('#regionChart')
                        ctx = canvas.getContext('2d');
                        window.myLine = new Chart(ctx, config);

                        var total = region_total[region_total.length - 1];
                        if(total == null){ total = 0 }
                        var organic = region_organic[region_organic.length - 1];
                        var organic_percent = (total / organic) * 100;
                        if(organic == null){ organic = 0; organic_percent = 0; }
                        var referral = region_referral[region_referral.length - 1];
                        var referral_percent = (referral / organic) * 100;
                        if(referral == null){ referral = 0; referral_percent = 0; }

                        $('#region_total_views').html(total);
                        $('#region_organic_views').html(organic);
                        $('#region_organic_percentage').html(parseFloat(organic_percent).toFixed(2) + '%');
                        $('#region_referral_views').html(referral);
                        $('#region_referral_percentage').html(parseFloat(referral_percent).toFixed(2) + '%');

                        $('#countryDetailsModal').modal('show');
                    },
                    error:function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }
        });
        //-------------
        // - PIE CHART -
        //-------------
        $.ajax({
            url:"assets/php/analytics_crud.php",
            method:"POST",
            data:{action:'doughnut'},
            dataType:"JSON",
            success:function(dataDoughnut){
                var browser_name = [];
                var totalviews = [];
                var backgroundColor = [];
                var total = [];
                var percentage = [];

                for(var count = 0; count < dataDoughnut.length; count++){
                    browser_name.push(dataDoughnut[count].browser_name);
                    totalviews.push(dataDoughnut[count].totalviews);
                    backgroundColor.push(dataDoughnut[count].backgroundColor);
                    total.push(dataDoughnut[count].total);
                    percentage.push(dataDoughnut[count].percentage);
                }
                
                var pieData = {
                    labels: browser_name,
                    datasets: [{
                        data: totalviews,
                        backgroundColor: backgroundColor,
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                }
                var pieOptions = {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    plugins: {
                        datalabels: {
                            formatter: (value, pieChartCanvas) => {
                                let datasets = pieChartCanvas.chart.data.datasets;
                                if (datasets.indexOf(pieChartCanvas.dataset) === datasets.length - 1) {
                                    let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / sum) * 100);
                                    
                                    if (!Number.isInteger(percentage)) {
                                        percentage = parseFloat(percentage).toFixed(2);
                                    }

                                    return percentage + '%';
                                } else {
                                    return percentage + '%';
                                }
                            },
                            anchor: 'end',
                            align: 'start',
                            offset: 10,
                            color: '#fff'
                        }
                    }
                }

                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                })
                var count = 0;
                $.each(browser_name, function( index, value ){
                    $('#browser_name').append('<li><div class="row d-flex justify-content-between"><div class="col-auto"><i class="fas fa-circle" style="color: '+backgroundColor[count]+';"></i> '+value+'</div><div class="col-auto">'+percentage[count]+'</div></div></li>');
                    count += 1;
                });
                
            },
            error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        //-----------------
        // - LINE CHART -
        //-----------------
        function line(type, day) {
            $('#viewsChart').remove();
            $('.viewsChart-parent').append('<canvas id="viewsChart" class="chartjs-render-monitor"></canvas>');

            if(type == 'bar'){
                var color = '#fff';
            }else{
                var color = 'gray';
            }

            $.ajax({
                url:"assets/php/analytics_crud.php",
                method:"POST",
                data:{action:'line',day:day},
                dataType:"JSON",
                success:function(dataLine){
                    var label = [];
                    var all = [];
                    var organic = [];
                    var referral = [];

                    for(var count = 0; count < dataLine.length; count++){
                        label.push(dataLine[count].label);
                        all.push(dataLine[count].all);
                        organic.push(dataLine[count].organic);
                        referral.push(dataLine[count].referral);
                    }

                    var config = {
                        type: type,
                        data: {
                            labels: label,
                            datasets: [{
                                label: 'Referral',
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                fill: true,
                                data: referral,
                            },{
                                label: 'Organic',
                                backgroundColor: 'rgb(72, 184, 184)',
                                borderColor: 'rgb(72, 184, 184)',
                                fill: true,
                                data: organic
                            }, {
                                label: 'All',
                                backgroundColor: 'rgba(52, 152, 219)',
                                borderColor: 'rgba(52, 152, 219)',
                                fill: true,
                                data: all
                            }]
                        },
                        options: {
                            responsive: true,
                            // title: {
                            //     display: true,
                            //     text: 'Chart.js Line Chart'
                            // },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    beginAtZero: true,
                                    fontColor: "#808080"
                                    // scaleLabel: {
                                    //     display: true,
                                    //     labelString: 'Month'
                                    // }
                                }],
                                yAxes: [{
                                    display: true,
                                    beginAtZero: true,
                                    fontColor: "#808080"
                                    // scaleLabel: {
                                    //     display: true,
                                    //     labelString: 'View Count'
                                    // }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: color
                                }
                            }
                        }
                    };

                    canvas = document.querySelector('#viewsChart')
                    ctx = canvas.getContext('2d');
                    window.myLine = new Chart(ctx, config);
                },
                error:function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        };
        line('line', document.getElementById('viewsChart_day').value);
        //-----------------
        // - BAR CHART HORIZONTAL -
        //-----------------
        // Device
        $.ajax({
            url:"assets/php/analytics_crud.php",
            method:"POST",
            data:{action:'horizontalLineDevice'},
            dataType:"JSON",
            success:function(dataHorizontalLineDevice){
                var label = [];
                var total = [];
                var color = [];

                for(var count = 0; count < dataHorizontalLineDevice.length; count++){
                    label.push(dataHorizontalLineDevice[count].label);
                    total.push(dataHorizontalLineDevice[count].total);
                    color.push(dataHorizontalLineDevice[count].color);
                }

                var config = {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [{
                            // label: 'Computer',
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1,
                            color: '#fff',
                            data: total
                        }]
                    },
                    options: {
                        // Elements options apply to all of the options unless overridden in a dataset
                        // In this case, we are setting the border of each horizontal bar to be 2px wide
                        elements: {
                            rectangle: {
                                borderWidth: 1,
                            }
                        },
                        responsive: true,
                        legend: {
                            display: false,
                            position: 'top',
                        },
                        plugins: {
                            datalabels: {
                                color: '#fff'
                            }
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#808080"
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontColor: "#808080"
                                }
                            }]
                        }
                    }
                };

                var deviceCanvas = document.getElementById('deviceCanvas').getContext('2d');
                window.myHorizontalBarDevice = new Chart(deviceCanvas, config);
            },error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        // Platform
        $.ajax({
            url:"assets/php/analytics_crud.php",
            method:"POST",
            data:{action:'horizontalLinePlatform'},
            dataType:"JSON",
            success:function(dataHorizontalLinePlatform){
                var label = [];
                var total = [];
                var color = [];

                for(var count = 0; count < dataHorizontalLinePlatform.length; count++){
                    label.push(dataHorizontalLinePlatform[count].label);
                    total.push(dataHorizontalLinePlatform[count].total);
                    color.push(dataHorizontalLinePlatform[count].color);
                }

                var config = {
                    type: 'horizontalBar',
                    data: {
                        labels: label,
                        datasets: [{
                            // label: 'Computer',
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1,
                            color: '#fff',
                            data: total
                        }]
                    },
                    options: {
                        // Elements options apply to all of the options unless overridden in a dataset
                        // In this case, we are setting the border of each horizontal bar to be 2px wide
                        elements: {
                            rectangle: {
                                borderWidth: 1,
                            }
                        },
                        responsive: true,
                        legend: {
                            display: false,
                            position: 'top'
                        },
                        plugins: {
                            datalabels: {
                                color: '#fff'
                            }
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#808080"
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontColor: "#808080"
                                }
                            }]
                        }
                    }
                };

                var platformCanvas = document.getElementById('platformCanvas').getContext('2d');
                window.myHorizontalBarPlatform = new Chart(platformCanvas, config);
            },error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        //-----------------
        // - CONTAINER -
        //-----------------
        $('#website_views').hide();
        $('#sms').hide();
        //-----------------
        // - PENSIONER BAR -
        //-----------------
        // Active
        function pensioner(data, type) {
            if(data == 'municipality'){
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'municipality'},
                    dataType:"JSON",
                    success:function(municipalitydata){
                        var barangay = [];
                        var totalactive = [];
                        var totaldeceased = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < municipalitydata.length; count++){
                            barangay.push(municipalitydata[count].barangay);
                            totalactive.push(municipalitydata[count].totalactive);
                            totaldeceased.push(municipalitydata[count].totaldeceased);
                            backgroundColor.push(municipalitydata[count].backgroundColor);
                            borderColor.push(municipalitydata[count].borderColor);
                        }

                        var municipalityData = {
                            labels: barangay,
                            datasets: [{
                                data: totalactive,
                                backgroundColor: backgroundColor,
                                borderWidth: 1,
                                hoverOffset: 10,
                                color: '#fff'
                            }]
                        }
                        var municipalityOptions = {
                            legend: {
                                display: false
                            },
                            tooltips: {
                                enabled: true
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: "#808080"
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        fontColor: "#808080"
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: '#fff'
                                }
                            }
                        }
                        var canvas_municipality = $('#canvas_municipality').get(0).getContext('2d')
                        var pieChart = new Chart(canvas_municipality, {
                            type: type,
                            data: municipalityData,
                            options: municipalityOptions
                        })

                        var areaChartData = {
                            labels: barangay,
                            datasets: [{
                                data: totaldeceased,
                                backgroundColor: backgroundColor,
                                borderWidth: 0,
                                hoverOffset: 10
                            }]
                        }
                        var areaChartOptions = {
                            legend: {
                                display: false
                            },
                            tooltips: {
                                enabled: true
                            },
                            plugins: {
                                datalabels: {
                                    formatter: (value, areaChart) => {
                                        let datasets = areaChart.chart.data.datasets;
                                        if (datasets.indexOf(areaChart.dataset) === datasets.length - 1) {
                                            let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                            let percentage = ((value / sum) * 100);
                                            
                                            if (!Number.isInteger(percentage)) {
                                                percentage = parseFloat(percentage).toFixed(2);
                                            }

                                            if(percentage == 0){
                                                return '';
                                            }else if(percentage > 0){
                                                return percentage + '%';
                                            }
                                        } else {
                                            if(percentage == 0){
                                                return '';
                                            }else if(percentage > 0){
                                                return percentage + '%';
                                            }
                                        }
                                    },
                                    anchor: 'end',
                                    align: 'start',
                                    offset: 10,
                                    color: '#fff'
                                }
                            }
                        }
                        var areaChart = $('#areaChart').get(0).getContext('2d')
                        var group_chart2 = new Chart(areaChart, {
                            type: 'pie',
                            data: areaChartData,
                            options: areaChartOptions
                        })
                        var count = 0;
                        $.each(barangay, function( index, value ){
                            if(totaldeceased[count] != 0){
                                $('#areaChartLabels').append('<li><div class="row d-flex justify-content-between"><div class="col-auto"><i class="fas fa-circle" style="color: '+backgroundColor[count]+';"></i> '+value+'</div><div class="col-auto">'+totaldeceased[count]+'</div></div></li>');
                            }
                            count += 1;
                        });
                    },error:function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }else if(data == 'gender'){
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'gender'},
                    dataType:"JSON",
                    success:function(genderdata){
                        var gender = [];
                        var total = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < genderdata.length; count++){
                            gender.push(genderdata[count].gender);
                            total.push(genderdata[count].total);
                            backgroundColor.push(genderdata[count].backgroundColor);
                            borderColor.push(genderdata[count].borderColor);
                        }

                        var municipalityData = {
                            labels: gender,
                            datasets: [{
                                data: total,
                                backgroundColor: backgroundColor,
                                borderWidth: 0,
                                hoverOffset: 10,
                                color: '#fff'
                            }]
                        }
                        var municipalityOptions = {
                            legend: {
                                display: true
                            },
                            tooltips: {
                                enabled: true
                            },
                            plugins: {
                                datalabels: {
                                    formatter: (value, pieChartCanvas) => {
                                        let datasets = pieChartCanvas.chart.data.datasets;
                                        if (datasets.indexOf(pieChartCanvas.dataset) === datasets.length - 1) {
                                            let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                            let percentage = ((value / sum) * 100);
                                            
                                            if (!Number.isInteger(percentage)) {
                                                percentage = parseFloat(percentage).toFixed(2);
                                            }

                                            if(percentage != 0){
                                                return percentage + '%';
                                            }else{
                                                return '';
                                            }
                                        } else {
                                            return percentage + '%';
                                        }
                                    },
                                    color: '#fff'
                                }
                            }
                        }
                        var canvas_gender = $('#canvas_gender').get(0).getContext('2d')
                        var graph1 = new Chart(canvas_gender, {
                            type: type,
                            data: municipalityData,
                            options: municipalityOptions
                        })
                    },error:function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }else if(data == 'civilstatus'){
                $.ajax({
                    url:"assets/php/chart_data.php",
                    method:"POST",
                    data:{action:'fetch', status:'civilstatus'},
                    dataType:"JSON",
                    success:function(civilstatusdata){
                        var civilstatus = [];
                        var total = [];
                        var backgroundColor = [];
                        var borderColor = [];

                        for(var count = 0; count < civilstatusdata.length; count++){
                            civilstatus.push(civilstatusdata[count].civilstatus);
                            total.push(civilstatusdata[count].total);
                            backgroundColor.push(civilstatusdata[count].backgroundColor);
                            borderColor.push(civilstatusdata[count].borderColor);
                        }

                        var municipalityData = {
                            labels: civilstatus,
                            datasets: [{
                                data: total,
                                backgroundColor: backgroundColor,
                                borderWidth: 1,
                                hoverOffset: 10,
                                color: '#fff'
                            }]
                        }
                        var municipalityOptions = {
                            legend: {
                                display: false
                            },
                            tooltips: {
                                enabled: true
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontColor: "#808080"
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        fontColor: "#808080"
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: '#fff'
                                }
                            }
                        }
                        var canvas_civilstatus = $('#canvas_civilstatus').get(0).getContext('2d')
                        var graph1 = new Chart(canvas_civilstatus, {
                            type: type,
                            data: municipalityData,
                            options: municipalityOptions
                        })
                    },error:function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            }
        };
        pensioner('municipality', 'horizontalBar');
        pensioner('gender', 'pie');
        pensioner('civilstatus', 'bar');
        // Applicants
        function applicants(time, type) {
            $('#canvas_applicants').remove();
            $('.applicants_container').append('<canvas id="canvas_applicants" class="chartjs-render-monitor"></canvas>');

            if(type == 'bar'){
                var color = '#fff';
            }else{
                var color = 'gray';
            }

            $.ajax({
                url:"assets/php/chart_data.php",
                method:"POST",
                data:{action:'fetch', status:'applicant', day:time},
                dataType:"JSON",
                success:function(applicantsData){
                    var label = [];
                    var applicant = [];
                    var accepted = [];
                    var rejected = [];

                    for(var count = 0; count < applicantsData.length; count++){
                        label.push(applicantsData[count].label);
                        applicant.push(applicantsData[count].applicant);
                        accepted.push(applicantsData[count].accepted);
                        rejected.push(applicantsData[count].rejected);
                    }

                    var config = {
                        type: type,
                        data: {
                            labels: label,
                            datasets: [{
                                label: 'Rejected',
                                fill: true,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: rejected,
                            }, {
                                label: 'Accepted',
                                fill: true,
                                backgroundColor: 'rgb(72, 184, 184)',
                                borderColor: 'rgb(72, 184, 184)',
                                data: accepted,
                            }, {
                                label: 'Applicant',
                                fill: true,
                                backgroundColor: 'rgb(52, 152, 219)',
                                borderColor:'rgb(52, 152, 219)',
                                data: applicant,
                            }]
                        },
                        options: {
                            responsive: true,
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    beginAtZero: true,
                                    fontColor: "#808080",
                                    gridLines: {
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    beginAtZero: true,
                                    fontColor: "#808080",
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            },
                            plugins: {
                                datalabels: {
                                    color: color
                                }
                            }
                        }
                    };

                    var canvas_applicants = document.getElementById('canvas_applicants').getContext('2d');
                    window.myHorizontalBarPlatform = new Chart(canvas_applicants, config);
                },error:function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        };
        applicants(document.getElementById('applicantsChart_day').value, document.getElementById('applicantsChart_look').value);
        // Applicants Pie
        $.ajax({
            url:"assets/php/chart_data.php",
            method:"POST",
            data:{action:'fetch', status:'applicantsPie'},
            dataType:"JSON",
            success:function(applicantsData){
                var label = [];
                var color = [];
                var data = [];

                for(var count = 0; count < applicantsData.length; count++){
                    label.push(applicantsData[count].label);
                    color.push(applicantsData[count].color);
                    data.push(applicantsData[count].data);
                }

                var config = {
                    type: 'pie',
                    data: {
                        labels: label,
                        datasets: [{
                            data: data,
                            backgroundColor: color,
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        tooltips: {
                            enabled: true
                        },
                        plugins: {
                            datalabels: {
                                formatter: (value, applicantsPieChartCanvas) => {
                                    let datasets = applicantsPieChartCanvas.chart.data.datasets;
                                    if (datasets.indexOf(applicantsPieChartCanvas.dataset) === datasets.length - 1) {
                                        let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                                        let percentage = ((value / sum) * 100);
                                        
                                        if (!Number.isInteger(percentage)) {
                                            percentage = parseFloat(percentage).toFixed(2);
                                        }

                                        if(percentage != 0){
                                            return percentage + '%';
                                        }else{
                                            return '';
                                        }
                                    } else {
                                        return percentage + '%';
                                    }
                                },
                                anchor: 'end',
                                align: 'start',
                                offset: 10,
                                color: 'black'
                            }
                        }
                    }
                };

                var applicantsPieChartCanvas = document.getElementById('applicantsPieChart').getContext('2d');
                window.myHorizontalBarPlatform = new Chart(applicantsPieChartCanvas, config);
            },error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        // Pension
        $.ajax({
            url:"assets/php/chart_data.php",
            method:"POST",
            data:{action:'fetch', status:'pension'},
            dataType:"JSON",
            success:function(pensiondata){
                var barangay = [];
                var sum = [];
                var color = [];

                for(var count = 0; count < pensiondata.length; count++){
                    barangay.push(pensiondata[count].barangay);
                    sum.push(pensiondata[count].sum);
                    color.push(pensiondata[count].color);
                }

                var municipalityData = {
                    labels: barangay,
                    datasets: [{
                        data: sum,
                        backgroundColor: color,
                        borderWidth: 1,
                        hoverOffset: 10,
                        color: '#fff'
                    }]
                }
                var municipalityOptions = {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#808080"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#808080"
                            }
                        }]
                    },
                    plugins: {
                        datalabels: {
                            color: '#fff'
                        }
                    }
                }
                var canvas_pension = $('#canvas_pension').get(0).getContext('2d')
                var graph1 = new Chart(canvas_pension, {
                    type: 'bar',
                    data: municipalityData,
                    options: municipalityOptions
                })
            },error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        // Expense
        $.ajax({
            url:"assets/php/chart_data.php",
            method:"POST",
            data:{action:'fetch', status:'expense'},
            dataType:"JSON",
            success:function(pensiondata){
                var barangay = [];
                var sum = [];
                var color = [];

                for(var count = 0; count < pensiondata.length; count++){
                    barangay.push(pensiondata[count].barangay);
                    sum.push(pensiondata[count].sum);
                    color.push(pensiondata[count].color);
                }

                var municipalityData = {
                    labels: barangay,
                    datasets: [{
                        data: sum,
                        backgroundColor: color,
                        borderWidth: 1,
                        hoverOffset: 10,
                        color: '#fff'
                    }]
                }
                var municipalityOptions = {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#808080"
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: "#808080"
                            }
                        }]
                    },
                    plugins: {
                        datalabels: {
                            color: '#fff'
                        }
                    }
                }
                var canvas_expense = $('#canvas_expense').get(0).getContext('2d')
                var graph1 = new Chart(canvas_expense, {
                    type: 'bar',
                    data: municipalityData,
                    options: municipalityOptions
                })
            },error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
        //-----------------
        // - SMS -
        //-----------------
        // Spent on SMS (Line)
        $.ajax({
            url:"assets/php/analytics_crud.php",
            method:"POST",
            data:{action:'smsSpent'},
            dataType:"JSON",
            success:function(dataSmsSpent){
                var label = [];
                var data = [];

                for(var count = 0; count < dataSmsSpent.length; count++){
                    label.push(dataSmsSpent[count].label);
                    data.push(dataSmsSpent[count].data);
                }

                var config = {
                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [{
                            backgroundColor: 'rgb(52, 152, 219)',
                            borderColor: 'rgb(52, 152, 219)',
                            fill: true,
                            data: data,
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                beginAtZero: true,
                                fontColor: "#808080"
                            }],
                            yAxes: [{
                                display: true,
                                beginAtZero: true,
                                fontColor: "#808080"
                            }]
                        }
                    }
                };

                var smsSpentCanvas = $('#smsSpentCanvas').get(0).getContext('2d')
                var graph1 = new Chart(smsSpentCanvas, config)
            },
            error:function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    </script>
</body>
</html>