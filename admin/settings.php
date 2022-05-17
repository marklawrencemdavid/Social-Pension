<?php 
    include '../assets/php/database.php';
    include 'assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
    if ($acc['acc_role'] == 'Staff'){header('Location: dashboard');}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <!-- Sweet Alert -->
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Settings</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Settings</li>
                                <li class="breadcrumb-item active">General</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form id="update_default" class="needs-validation" novalidate>
                        <!-- Success/Error -->
                        <?php if (isset( $_SESSION['succeserror'])) {  echo $_SESSION['succeserror']; } unset($_SESSION['succeserror']); ?>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Website Title <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_website_title" type="text" class="form-control" value="<?php echo $pages['page_website_title']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Website Logo <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-12 d-flex justify-content-center col-input">
                                    <img src="/assets/img/uploads/<?php echo $pages['page_website_icon']; ?>" id='page_website_icon_preview' 
                                        class="img-circle img-fluid" alt="Header Background" style="height: 169px; width: 169px; background: #777777;">
                                </div>
                                <div class="col-12">
                                    <div class="input-group mt-1 col-input"> 
                                        <div class="col-md-9 col-12">
                                            <input name="page_website_icon_label" type="text" class="form-control" id="page_website_icon_label" 
                                                value="<?php if($pages['page_website_icon'] == 'no_image.png'){ echo '';}else{echo $pages['page_website_icon'];} ?>" maxlength="0" required/>
                                        </div>
                                        <div class="col-md-3 col-12 row">
                                            <div class="col-6 px-0 d-flex justify-content-center">
                                                <input name="page_website_icon_image" type="file" id="page_website_icon_image" onchange="pageWebsiteIcon(this)" 
                                                    accept=".png" style="display: none;"/>
                                                <label for="page_website_icon_image" class="btn btn-primary col-12 mr-2">Browes</label>
                                            </div>
                                            <div class="col-6 px-0 d-flex justify-content-center">
                                                <label class="btn btn-danger col-12" type="button" onclick="pageWebsiteIconRemove()">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Email <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <input name="page_email" type="email" class="form-control" value="<?php echo $pages['page_email']; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Contact Number <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0">+63</span>
                                        </div>
                                            <input name="page_contactno" type="text" class="form-control" value="<?php echo $pages['page_contactno']; ?>" 
                                        onkeypress="return onlyNumberInput(event)" pattern="[9]{1}[0-9]{9}"  minlength="10" maxlength="10" placeholder="9-- --- ----" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Address <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_address" type="text" class="form-control" value="<?php echo $pages['page_address']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Location</label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input row">
                                    <div class="col-6">
                                        <label>Province <span class="text-danger">*</span></label>
                                        <input name="page_province" type="text" class="form-control" value="<?php echo $pages['page_province']; ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label>City/Municipality <span class="text-danger">*</span></label>
                                        <input name="page_city" type="text" class="form-control" value="<?php echo $pages['page_city']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <label class="mb-0">Barangay's  <span class="text-danger">*</span></label><br>
                                    <small>Note: Use "," to add a barangay(eg. Barangay1,Brangay2,Barangay3,...)</small>
                                    <textarea name="page_barangay" class="form-control" rows="4" required><?php echo $pages['page_barangay']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Google Map <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <span>Step 1. Go to <a href="https://www.google.com/maps" target="_blank">https://www.google.com/maps</a></span><br>
                                <span>Step 2. Search your location</span><br>
                                <span>Step 3. Click "Share"</span><br>
                                <span>Step 4. Go to "Embed a map" tab</span><br>
                                <span>Step 5. Click the "Copy HTML" and paste it here</span>
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_map" type="text" class="form-control" value='<?php echo $pages['page_map']; ?>' required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Social Media</label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <div class="col-12 mb-2 px-0 mx-0 row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-0 fab fa-facebook"style="width: 42px;"></span>
                                            </div>
                                            <input name="page_facebook" type="text" class="form-control" value="<?php echo $pages['page_facebook']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 px-0 mx-0 row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-0 fab fa-instagram"style="width: 42px;"></span>
                                            </div>
                                            <input name="page_instagram" type="text" class="form-control" value="<?php echo $pages['page_instagram']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 px-0 mx-0 row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-0 fab fa-twitter"style="width: 42px;"></span>
                                            </div>
                                            <input name="page_twitter" type="text" class="form-control" value="<?php echo $pages['page_twitter']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 px-0 mx-0 row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text border-0 fab fa-skype" style="width: 42px;"></span>
                                            </div>
                                            <input name="page_skype" type="text" class="form-control" value="<?php echo $pages['page_skype']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Availability</label>
                            </div>
                            <div class="col-9 row col-input">
                                <div class="col-6 row">
                                    <div class="col-2 ">
                                        <p>From: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <input name="page_avail_time_to" id="page_avail_time_to" type="time" class="form-control" value="<?php echo $pages['page_avail_time_to'];?>" required>
                                    </div>
                                </div>
                                <div class="col-6 row">
                                    <div class="col-2">
                                        <p>To: <span class="text-danger">*</span></p>
                                    </div>
                                    <div class="col-10">
                                        <input name="page_avail_time_from" id="page_avail_time_from" type="time" class="form-control" value="<?php echo $pages['page_avail_time_from'];?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>SMS</label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <div>For Automatic SMS to take effect please do the steps specified below.</div>
                                    <div><b>Step 1:</b> Go to <a target="_blank" href="https://developer.globelabs.com.ph/users/login">https://developer.globelabs.com.ph/users/login</a>.</div>
                                    <div><b>Step 2:</b> If you don't have an account, register for an account, otherwise go ahead and log in.</div>
                                    <div><b>Step 3:</b> After setting up your account, on Globelab's Dashboard, click the "CREATE APPS" button.</div>
                                    <div><b>Step 4:</b> Fill out the form and paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/assets/php/register.php";?></u> on the "Redirect URL" field.</div>
                                    <div><b>Step 5:</b> Click Submit.</div>
                                    <div><b>Step 6:</b> Lastly, copy and paste the values needed below.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>SHORT CODE <br>(Last 4 numbers) <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_sms_shortcode" onkeypress="return onlyNumberInput(event)" minlength="4" maxlength="4" type="text" class="form-control" placeholder="ex. 1234" value="<?php echo $pages['page_sms_shortcode']; ?>"  required>
                                    <div class="invalid-feedback">Please your app's last 4 number of Short Code.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>APP ID <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_sms_appid" type="text" class="form-control" value="<?php echo $pages['page_sms_appid']; ?>" placeholder="ex. abcdefghijklmnopqrstuvwxyz"  required>
                                    <div class="invalid-feedback">Please your app's App ID.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>APP SECRET <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <input name="page_sms_appsecret" type="text" class="form-control" value="<?php echo $pages['page_sms_appsecret']; ?>" placeholder="ex. 1234567890abcdefghijklmnopqrstuvwxyz"  required>
                                    <div class="invalid-feedback">Please your app's App Secret.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                            </div>
                            <div class="col-9 pl-0">
                                <div class="col-xl-9 col-lg-12 col-input">
                                    <button name="update_settings" id="update_settings" class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
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
        // Update General
        $("body").on('submit', '#update_default', function(event){
            event.preventDefault();
            event.stopPropagation();
            Swal.fire({
                title: 'Do you really want to update the website\'s default information?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('button[name=update_settings]').html('<i class="fas fa-circle-notch fa-spin"></i> Updating');
                    $('button[name=update_settings]').prop('disabled', true);

                    var formData = new FormData(this);
                    formData.append('update_settings', 'true');
                    $.ajax({
                        url: "/admin/assets/php/settings_crud",
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
                                title: 'Website\' default information updated successfully.'
                            })
                            $('#update_default').removeClass('was-validated');
                            $('button[name=update_settings]').html('Update');
                            $('button[name=update_settings]').prop('disabled', false);
                            location.reload();
                        }
                    });
                }
            })
        })
    </script>
</body>
</html>
