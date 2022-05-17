<?php 
    include '../../assets/php/database.php';
    include '../assets/php/authentication.php';
    if (!(isset($_GET['id']))){header('location: ../dashboard');}
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $acc_pensioner = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_appl_id = '.$_GET['id'].'') );
    $appl = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_applicants WHERE appl_id = '.$_GET['id'].'') );
    $pur = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT SUM(pur_amount) as total from tbl_purchases WHERE pur_status = "Approved" AND acc_id = '.$acc_pensioner['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $acc_pensioner['acc_username']?> | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css"> 
    <?php } ?>
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
                            <h1 class="m-0">Pensioner Profile</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php if($appl['appl_status'] == 'Active'){echo '/admin/pensioners/active';}else{echo '/admin/pensioners/deceased';} ?>"><?php if($appl['appl_status'] == 'Active'){echo 'Active';}else{echo 'Deceased';} ?></a></li>
                                <li class="breadcrumb-item active">Pensioner Profile</li>
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
                            <div class="col-12 px-0 pb-1">
                                <a href="<?php if($appl['appl_status'] == 'Active'){echo '/admin/pensioners/active';}else{echo '/admin/pensioners/deceased';} ?>" class="btn btn-primary col"><i class="fas fa-arrow-left"></i> Go Back</a>
                            </div>
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="/assets/img/applicant_picture/<?php echo $acc_pensioner['acc_picture'] ?>" 
                                        alt="" style="background-color: #777777; width: 200px; height: 200px; border: 0; padding: 0;">
                                    </div>
                                    <h6 class="text-center mb-0 text-wrap"><?php echo $acc_pensioner['acc_lastname'] . ', ' . $acc_pensioner['acc_firstname'] . ' ' . $acc_pensioner['acc_middlename']?></h6>
                                    <p class="text-center text-muted"><?php echo $acc_pensioner['acc_username'] ?></p>
                                    <p class="mb-0"><span>Email Address:</span>  <label><?php echo $acc_pensioner['acc_email'] ?></label></p>
                                    <p class="mb-0"><span>Contact No.:</span>  <label>0<?php echo $acc_pensioner['acc_contactno'] ?></label></p>
                                    <p class="mb-0"><span>Address:</span>  <label><?php echo $appl['appl_houseno'].' '.$appl['appl_barangay'].','.$appl['appl_municipality'].','.$appl['appl_province'] ?></label></p>
                                    <p class="mb-0"><span>Birthdate:</span>  <label><?php echo date('F d, Y', strtotime($appl['appl_birthdate'])) ?></label></p>
                                    <p class="mb-0"><span>Birth Place:</span>  <label><?php echo $appl['appl_placeofbirth'] ?></label></p>
                                    <p class="mb-0"><span>Gender:</span>  <label><?php echo $appl['appl_gender'] ?></label></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- CARDS -->
                            <div class="col-12 row pr-0">
                                <?php 
                                    $Applicant = mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Applicant'") or die(mySQLi_error($con)); 
                                    $Applicant_count = mysqli_num_rows($Applicant);
                                    $Active = mySQLi_query($con, "SELECT * from tbl_applicants where appl_status = 'Active'") or die(mySQLi_error($con)); 
                                    $Active_count = mysqli_num_rows($Active);
                                ?>
                                <div class="col-md-6 pr-0">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>Php <?php echo $appl['appl_pension_recieved'];?>.00</h3>
                                            <p>Total Pension Received</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>Php <?php if($pur['total'] == ''){echo 0;}else{echo $pur['total'];}?>.00</h3>
                                            <p>Total Spent</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-shopping-basket"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <h2><i class="fas fa-shopping-cart"></i> Purchases</h2>
                                    <table class="table table-hover" id="tblDataTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Status</th>
                                                <th scope="col">Commodity</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Establishment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $query = mysqli_query($con, "SELECT * FROM tbl_purchases WHERE acc_id = '".$acc_pensioner['acc_id']."' ORDER BY pur_id DESC");
                                                while($pur = mySQLi_fetch_assoc($query)){
                                            ?>
                                            <tr class="view_pur_data" data-id="<?php echo $pur['pur_id']; ?>">
                                                <th scope="row">
                                                    <?php 
                                                    if($pur['pur_status'] == 'Pending'){echo '<span class="badge bg-warning">'.$pur['pur_status'].'</span>';}
                                                    elseif($pur['pur_status'] == 'Approved'){echo '<span class="badge bg-success">'.$pur['pur_status'].'</span>';}
                                                    elseif($pur['pur_status'] == 'Rejected'){echo '<span class="badge bg-danger">'.$pur['pur_status'].'</span>';}
                                                    ?>
                                                </th>
                                                <td><?php echo $pur['pur_commodity'];?></td>
                                                <td><?php echo $pur['pur_quantity'];?></td>
                                                <td><?php echo $pur['pur_amount'];?></td>
                                                <td><?php echo $pur['pur_establishment'];?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <div class="modal fade" id="purchase_details_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="purchase_details">
                
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
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        // Update Purchase Solo
        $("body").on('submit', '#pen_app_form_solo', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if(btnUpdate == '1'){title='Do you really want to approve this item?';toast_title='Successfully approved selected item/s';btn='Approve';formData.append('update_purchase_a', $("#update_purchase_a").val());}
            else if(btnUpdate == '2'){title='Do you really want to reject this item?';toast_title='Successfully rejected selected item/s';btn='Reject';formData.append('update_purchase_r', $("#update_purchase_r").val());}
            else if(btnUpdate == '3'){title='Do you really want to set this item as pending?';toast_title='Successfully set the selected item/s as pending';btn='Move to pending';formData.append('update_purchase_p', $("#update_purchase_p").val());}
            Swal.fire({
                title: title,
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: btn
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "php/purchase_crud.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        success:function(response){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            })
                            Toast.fire({
                                icon: 'success',
                                title: toast_title
                            })
                            $('#purchase_details_modal').modal('hide');
                            $('#tblDataTable').load(location.href + " #tblDataTable");
                        }
                    });
                }
            })
        })
    </script>
</body>
</html>
