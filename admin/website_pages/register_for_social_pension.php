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
    <title>Register for SPISC Page | <?php echo $pages['page_website_title'];?></title>

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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if($acc['acc_darkmode'] == 1){echo 'dark-mode';}?>" id="bodytag">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Registers for SPISC</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Registers for SPISC</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid" id="register_div">
                    <form id="register_form">
                        <h3>Form availability</h3>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Days of the week</label>
                            </div>
                            <div class="col-9 col-input row">
                                <div class="col-6 row">
                                    <div class="col-2 ">
                                        <p>From: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <select name="page_form_avail_day_from" class="form-control" id="page_form_avail_day_from">
                                            <option value="Monday" <?php if($pages['page_form_avail_day_from']=='Monday'){echo 'selected';} ?>>Monday</option>
                                            <option value="Tuesday" <?php if($pages['page_form_avail_day_from']=='Tuesday'){echo 'selected';} ?>>Tuesday</option>
                                            <option value="Wednesday" <?php if($pages['page_form_avail_day_from']=='Wednesday'){echo 'selected';} ?>>Wednesday</option>
                                            <option value="Thursday" <?php if($pages['page_form_avail_day_from']=='Thursday'){echo 'selected';} ?>>Thursday</option>
                                            <option value="Friday" <?php if($pages['page_form_avail_day_from']=='Friday'){echo 'selected';} ?>>Friday</option>
                                            <option value="Saturday" <?php if($pages['page_form_avail_day_from']=='Saturday'){echo 'selected';} ?>>Saturday</option>
                                            <option value="Sunday" <?php if($pages['page_form_avail_day_from']=='Sunday'){echo 'selected';} ?>>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 row">
                                    <div class="col-2">
                                        <p>To: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <select name="page_form_avail_day_to" class="form-control" id="page_form_avail_day_to">
                                            <option value="Monday" <?php if($pages['page_form_avail_day_to']=='Monday'){echo 'selected';} ?>>Monday</option>
                                            <option value="Tuesday" <?php if($pages['page_form_avail_day_to']=='Tuesday'){echo 'selected';} ?>>Tuesday</option>
                                            <option value="Wednesday" <?php if($pages['page_form_avail_day_to']=='Wednesday'){echo 'selected';} ?>>Wednesday</option>
                                            <option value="Thursday" <?php if($pages['page_form_avail_day_to']=='Thursday'){echo 'selected';} ?>>Thursday</option>
                                            <option value="Friday" <?php if($pages['page_form_avail_day_to']=='Friday'){echo 'selected';} ?>>Friday</option>
                                            <option value="Saturday" <?php if($pages['page_form_avail_day_to']=='Saturday'){echo 'selected';} ?>>Saturday</option>
                                            <option value="Sunday" <?php if($pages['page_form_avail_day_to']=='Sunday'){echo 'selected';} ?>>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <span class="text-red" id='messagedy'></span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Time of the day</label>
                            </div>
                            <div class="col-9 row col-input">
                                <div class="col-6 row">
                                    <div class="col-2 ">
                                        <p>From: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <input name="page_form_avail_time_from" id="page_form_avail_time_from" type="time" class="form-control" value="<?php echo $pages['page_form_avail_time_from']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-6 row">
                                    <div class="col-2">
                                        <p>To: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <input name="page_form_avail_time_to" id="page_form_avail_time_to" type="time" class="form-control" value="<?php echo $pages['page_form_avail_time_to']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <span class="text-red" id='messagehr'></span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                            </div>
                            <div class="col-9 pl-0">
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <button name="update_form_avail" class="btn btn-primary float-left" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        // Update Register
        $("body").on('submit', '#register_form', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to update the website\'s registration page availability?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    formData.append('update_form_avail', 'true');
                    $.ajax({
                        url: "php/pages_crud",
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
                                title: 'Website\' registration page availability updated successfully.'
                            })
                            $('#register_form').removeClass('was-validated');
                            // $('#register_form')[0].reset();
                            // $('#register_div').load(location.href + " #register_div")
                        }
                    });
                }
            })
        })
    </script>
</body>
</html>