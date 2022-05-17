<?php
    include 'assets/php/authentication.php';
    include 'assets/php/database.php';
    include 'assets/php/visit.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $appl = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_applicants WHERE appl_id = '.$acc['acc_appl_id'].'') );
    $pur = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT SUM(pur_amount) as total from tbl_purchases WHERE pur_status = "Approved" AND acc_id = '.$acc['acc_id'].'') );
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile | <?php echo $pages['page_website_title']; ?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/css/bootstrap.min.css" integrity="sha512-SCpMC7NhtrwHpzwKlE1l6ks0rS+GbMJJpoQw/A742VaxdGcQKqVD8F/y/m9WLOfIPppy7mWIs/kS0bKgSI0Bfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" integrity="sha512-9a1QYep56cYgIPFq0JYfsh9xRYYmPBxKaD6/ZfVAtplQ6y9ZUSk7GxgC2dmwtxK9T2cGQOxCV6J2Ll51nrvP2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.css" integrity="sha512-FuMUgHw8jwC1ABBFQITwogq7Q3hdvZnRJcuITfmmnP5JMY81yuC4nojF0aD1fVdRb/CxNaggJtsDdUcQgK21hQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/profile.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>
    <main id="main" style="margin-top: 0;">
        <div class="container-fluid bg-white">
            <div class="row vh-100" style="padding-top: 70px;">
                <div class="col-md-3 bg-dark pt-3">
                    <div class="container text-center">
                        <img src="/assets/img/applicant_picture/<?php echo $appl['appl_picture'];?>" alt="" class="rounded-circle shadow" height="150px" width="150px">
                        <h5 class="mb-0"><?php echo $acc['acc_lastname'].', '.$acc['acc_firstname'];?></h5>
                        <h6 class="text-muted"><?php echo $acc['acc_username'] ?></h6>
                    </div>
                    <hr>
                    <div class="container">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#dashboard_main" id="dashboard_button">
                                <span data-feather="globe"></span> Dashboard </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#purchase_main" id="purchases_button">
                                <span data-feather="shopping-cart"></span> Purchases </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#sms_main" id="sms_button">
                                <span data-feather="mail"></span> SMS Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#profile_main" id="profile_button">
                                <span data-feather="user"></span> Profile Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#update">
                                <span data-feather="edit-3"></span> Update username or password</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 bg-white">
                    <div class="col-12">
                        <div class="container-fluid" id="dashboard_main">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                <h1 class="h2">Dashboard</h1>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <!-- PENSION STATUS -->
                                    <div class="card mb-3">
                                        <div class="card-body overflow-auto">
                                            <h5 class="card-title"><span data-feather="credit-card"></span> Pension Status</h5>
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
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <!-- Total Pension Received -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Pension Received</h5>
                                            <!-- <small class="text-muted"><?php echo date('F d, Y'); ?></small> -->
                                            <p class="text-center fs-2 fw-bold">Php <?php echo $appl['appl_pension_recieved'];?>.00</p>
                                            <h5 class="card-title">Total Spent</h5>
                                            <p class="text-center fs-2 fw-bold">Php <?php if($pur['total'] == ''){echo 0;}else{echo $pur['total'];}?>.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Pending Purchases -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title"><span data-feather="shopping-cart"></span> Pending Purchases</h5>
                                            <div class="table-responsive">
                                                <table id="tbl_purchase_dashboard" class="table table-striped table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Commodities</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $pur_query = mysqli_query($con, "SELECT * FROM `tbl_purchases` WHERE acc_id = '".$_SESSION['acc_id']."' AND pur_status = 'Pending' ORDER BY pur_id DESC LIMIT 10"); 
                                                            $count = 0;
                                                            while($pur = mysqli_fetch_assoc($pur_query)){ 
                                                            $count += 1;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td class="text-truncate"><?php
                                                                if(strlen($pur['pur_commodity']) <=11){ echo $pur['pur_commodity'];}
                                                                else{ echo substr($pur['pur_commodity'], 0, 11).'...';}
                                                            ?></td>
                                                            <td>Php <?php echo $pur['pur_amount'] ?></td>
                                                            <td><?php echo date('M d, Y', strtotime($pur['pur_date'])) ?></td>
                                                            <td><?php if($pur['pur_status'] == 'Pending'){echo '<span class="badge bg-warning">'.$pur['pur_status'].'</span>';}
                                                                elseif($pur['pur_status'] == 'Approved'){echo '<span class="badge bg-success">'.$pur['pur_status'].'</span>';}
                                                                elseif($pur['pur_status'] == 'Rejected'){echo '<span class="badge bg-danger">'.$pur['pur_status'].'</span>';} 
                                                            ?></td>
                                                            <td><a href="#" id="view_purchase" data-bs-toggle="modal" data-id="<?php echo $pur['pur_id']; ?>" data-bs-target="#updateModal">View</a></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <!-- SMS -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title"><span data-feather="mail"></span> SMS</h5>
                                            <div class="table-responsive">
                                                <table id="tbl_sms" class="table table-striped table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Message</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sms_query = mysqli_query($con, "SELECT * FROM `tbl_sms` ORDER BY sms_id DESC LIMIT 10");
                                                            $count = 1;
                                                            while($sms = mysqli_fetch_assoc($sms_query)){ 
                                                                if(strpos($sms['sms_receiver'], $appl['appl_contactno'])){
                                                            $count += 1;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><?php 
                                                                if(strlen ($sms['sms_message']) >200){ 
                                                                    $str=substr ($sms['sms_message'], 0, 200 - 3); 
                                                                    echo (substr ($str, 0, strrpos ($str, ' ')).'...');
                                                                }else{echo $sms['sms_message'];}
                                                            ?></td>
                                                            <td style="white-space: nowrap;"><?php echo $sms['sms_date'] ?></td>
                                                            <td><a href="#" id="view_sms" data-bs-toggle="modal" data-id="<?php echo $sms['sms_id']; ?>" data-bs-target="#smsViewModal">View</a></td>
                                                        </tr>
                                                        <?php }} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid" id="purchase_main">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                <h1 class="h2">Purchases</h1>
                                <div class="btn-toolbar mb-2 mb-md-0">
                                    <div class="btn-group me-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addModal"><span data-feather="plus-circle"></span> Add new purchase</button>
                                        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
                                    </div>
                                    <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                        <span data-feather="calendar"></span>
                                        This week
                                    </button> -->
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="tbl_purchase" class="table table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Commodities</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount of Purchase</th>
                                            <th scope="col">Name of Establishment</th>
                                            <th scope="col">Date of Purchase</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $pur_query = mysqli_query($con, "SELECT * FROM `tbl_purchases` WHERE acc_id = '".$_SESSION['acc_id']."' ORDER BY pur_id DESC"); 
                                            $count = 0;
                                            while($pur = mysqli_fetch_assoc($pur_query)){ 
                                            $count += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $pur['pur_commodity'] ?></td>
                                            <td><?php echo $pur['pur_quantity'] ?></td>
                                            <td>Php <?php echo $pur['pur_amount'] ?></td>
                                            <td><?php echo $pur['pur_establishment'] ?></td>
                                            <td><?php echo date('M d, Y', strtotime($pur['pur_date'])) ?></td>
                                            <td><?php if($pur['pur_status'] == 'Pending'){echo '<span class="badge bg-warning">'.$pur['pur_status'].'</span>';}
                                                elseif($pur['pur_status'] == 'Approved'){echo '<span class="badge bg-success">'.$pur['pur_status'].'</span>';}
                                                elseif($pur['pur_status'] == 'Rejected'){echo '<span class="badge bg-danger">'.$pur['pur_status'].'</span>';} 
                                            ?></td>
                                            <td><a href="#" id="view_purchase" data-bs-toggle="modal" data-id="<?php echo $pur['pur_id']; ?>" data-bs-target="#updateModal">View</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid" id="sms_main">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                <h1 class="h2">SMS Notifications</h1>
                                <!-- <div class="btn-toolbar mb-2 mb-md-0">
                                    <div class="btn-group me-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addModal"><span data-feather="plus-circle"></span> Add new purchase</button>
                                    </div>
                                </div> -->
                            </div>
                            <div class="table-responsive">
                                <table id="tbl_sms" class="table table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sms_query = mysqli_query($con, "SELECT * FROM `tbl_sms` ORDER BY sms_id DESC");
                                            $count = 0;
                                            while($sms = mysqli_fetch_assoc($sms_query)){ 
                                                if(strpos($sms['sms_receiver'], $appl['appl_contactno'])){
                                            $count += 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php 
                                                if(strlen ($sms['sms_message']) >200){ 
                                                    $str=substr ($sms['sms_message'], 0, 200 - 3); 
                                                    echo (substr ($str, 0, strrpos ($str, ' ')).'...');
                                                }else{echo $sms['sms_message'];}
                                            ?></td>
                                            <td style="white-space: nowrap;"><?php echo $sms['sms_date'] ?></td>
                                            <td><a href="#" id="view_sms" data-bs-toggle="modal" data-id="<?php echo $sms['sms_id']; ?>" data-bs-target="#smsViewModal">View</a></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid" id="profile_main">
                            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                <h1 class="h2">Profile Information</h1>
                            </div>
                            <div class="table-responsive">
                                <table id="tbl_sms" class="table table-borderless">
                                    <thead>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Profile Picture</b></td>
                                            <td><img class="rounded-circle shadow" src="/assets/img/applicant_picture/<?php echo $appl['appl_picture'];?>" alt="" height="150px" width="150px"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Username</b></td>
                                            <td><h6><?php echo $acc['acc_username'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Name</b></td>
                                            <td><h6><?php echo $appl['appl_lastname'].', '.$appl['appl_firstname'].' '.$appl['appl_middlename'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Address</b></td>
                                            <td><h6><?php echo $appl['appl_houseno'].' '.$appl['appl_barangay'].', '.$appl['appl_municipality'].', '.$appl['appl_province'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><h6><?php echo $appl['appl_email'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact Number</b></td>
                                            <td><h6><?php echo '0'.$appl['appl_contactno'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Birthday</b></td>
                                            <td><h6><?php echo $appl['appl_birthdate'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Plave of Birth</b></td>
                                            <td><h6><?php echo $appl['appl_placeofbirth'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Gender</b></td>
                                            <td><h6><?php echo $appl['appl_gender'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><h6><?php echo $appl['appl_civilstatus'] ?></h6></td>
                                        </tr>
                                        <tr>
                                            <td><b>Previous Occupation</b></td>
                                            <td><h6><?php echo $appl['appl_prevoccupation'] ?></h6></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </main><!-- End #main -->

    <?php //include 'footer.php'; ?>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Add Purchase -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="bi bi-cart"></i> Add New Purchase</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="insert_purchase_form" class="needs-validation" novalidate>
                        <input name="pot" type="text" class="visually-hidden">
                        <div class="form-floating mb-2">
                            <select name="pur_commodity" class="form-control" required>
                                <option value="" selected disabled>Select a commodity..</option>
                                <option value="Canned Sardines, Tuna">Canned Sardines, Tuna</option>
                                <option value="Evaporated, Condensed & Powdered Filled Milk">Evaporated, Condensed & Powdered Filled Milk</option>
                                <option value="Coffee">Coffee</option>
                                <option value="Bread">Bread</option>
                                <option value="Sugar">Sugar</option>
                                <option value="Cooking Oil">Cooking Oil</option>
                                <option value="Instant Noodles">Instant Noodles</option>
                                <option value="Luncheon Meat, Meatloaf, Corned Beef, Pork, Frozen/Preserved/Ready-to-Cook Beef, and Chicken">Luncheon Meat, Meatloaf, Corned Beef, Pork, Frozen/Preserved/Ready-to-Cook Beef, and Chicken</option>
                                <option value="Powdered, Liquid, Bar Laundry & Detergent Soap">Powdered, Liquid, Bar Laundry & Detergent Soap</option>
                            </select>
                            <span class="focus-border"></span>
                            <label>Commodity <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-group row mb-2">
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input name="pur_quantity" type="text" class="form-control" onkeypress="return numberInputOnly(event)" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>Quantity <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating">
                                    <input name="pur_amount" type="text" class="form-control" onkeypress="return numberInputOnly(event)" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>Amount in Php <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="form-floating">
                                <input name="pur_establishment" type="text" class="form-control" placeholder=" " required>
                                <span class="focus-border"></span>
                                <label>Name of Establishment <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <b class="form-label">Select an image for proof <span class="text-danger">*</span></b>
                            <div class="input-group">
                                <input name="pur_proof" id="file-input" class="form-control" type="file" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff" type="file" required>
                                <span class="focus-border"></span>
                                <div class="input-group-append">
                                    <label id="file-clear" class="btn btn-danger">Clear</label>
                                </div>
                            </div>
                            <span id="error_file" class="text-danger"></span>
                            <div id="preview" class="form-group row mt-1"></div>
                        </div>
                        <div class="float-end">
                            <button name="pur_submit" type="submit" class="btn btn-primary">Add Purchase</button>
                            <button type="button" class="btn btn-secondary close" >Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Update purchase -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="bi bi-cart"></i> View Purchase</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="updateModalBody">
                </div>
            </div>
        </div>
    </div>
    <!-- Update username/password -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title"><i class="bi bi-person-fill"></i> Update Username / Password</h5>
                    <button type="button" class="btn-close close1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="errorsucces"></div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Username</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Password</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="POST" class="needs-validation update_username" novalidate>
                                <input name="pot" type="text" class="visually-hidden">
                                <div class="form-floating mb-1">
                                    <input name="new_username" type="text" class="form-control new_username" placeholder=" " minlength="6" maxlength="15" value="<?php echo $acc['acc_username'];?>" required>
                                    <span class="focus-border"></span>
                                    <label>Username <span class="text-danger">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="cur_password" type="password" class="form-control cur_password" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="float-end">
                                    <button name="update_username" type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary close1" >Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form method="POST" class="needs-validation update_password" novalidate>
                                <b>Note: Password should have a number and be at leat 8 characters.</b>
                                <input name="pot" type="text" class="visually-hidden">
                                <div class="form-floating mb-1">
                                    <input name="new_password" type="password" id="input_pass1" class="form-control new_password" placeholder=" " pattern="(?=.*\d)(?=.*[a-z]).{8,}" required>
                                    <span class="focus-border"></span>
                                    <label>New Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input name="re_new_password" type="password" id="input_pass2" class="form-control re_new_password" placeholder=" " pattern="(?=.*\d)(?=.*[a-z]).{8,}" required>
                                    <span class="focus-border"></span>
                                    <label>Re-new password <span class="text-danger">*</span></label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input name="curr_password" type="password" id="input_pass" class="form-control curr_password" placeholder=" " pattern="(?=.*\d)(?=.*[a-z]).{8,}" required>
                                    <span class="focus-border"></span>
                                    <label>Current Password <span class="text-danger">*</span></label>
                                </div>
                                <div class="float-end">
                                    <button name="update_password" type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary close1" >Cancel</button>
                                </div>
                            </form>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showpass">
                                <label class="form-check-label" for="showpass">Show Passwords</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SMS view -->
    <div class="modal fade" id="smsViewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" id="sms_info">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SMS Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/js/bootstrap.bundle.min.js" integrity="sha512-lAJppLlFlj2g7mb8jrbx34cdZcB24LLIK0N4U0rZtRPoY4oq9uiRXBbigPzGmzN5EXiDn0yMLIBjf0+E/alhXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.js" integrity="sha512-TEY9MppoX49BydDCCSsdqDUihEAEdO2S2En3WRjPoM+4wBkLtE7HKJ/Xt34c46/XM0Qxf6+F5caDMejengSDdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js" integrity="sha512-fHXRw0CXruAoINU11+hgqYvY/PcsOWzmj0QmcSOtjlJcqITbPyypc8cYpidjPurWpCnlB8VKfRwx6PIpASCUkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/profile.js"></script>
    <script>
        // const stepButtons = document.querySelectorAll('.step-button');
        // const progress = document.querySelector('#progress');

        // Array.from(stepButtons).forEach((button,index) => {
        //     button.addEventListener('click', () => {
        //         progress.setAttribute('value', index * 100 /(stepButtons.length - 1) );//there are 3 buttons. 2 spaces.

        //         stepButtons.forEach((item, secindex)=>{
        //             if(index > secindex){
        //                 item.classList.add('done');
        //             }
        //             if(index < secindex){
        //                 item.classList.remove('done');
        //             }
        //         })
        //     })
        // })
    </script>
</body>
</html>