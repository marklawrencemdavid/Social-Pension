<?php 
    include '../../assets/php/database.php';
    include '../assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
    if ($acc['acc_role'] == 'Staff') {
        header('Location: dashboard');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account | <?php echo $pages['page_website_title'];?></title>

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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed <?php if($acc['acc_darkmode'] == 1){echo 'dark-mode';} ?>" id="bodytag">
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
                            <h1>Create New Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Accounts</li>
                                <li class="breadcrumb-item active">Create Account</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <form id="insert_account" class="needs-validation" novalidate>
                        <input name="pot" type="text" class="pot">
                        <!-- Pensioner | Picture -->
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Picture Display</label>
                            </div>
                            <div class="col-9 col-input row">
                                <img src="/assets/img/account_picture/profile.svg" id='displaypicture' 
                                class="rounded mx-auto d-block" alt="1x1 picture" style="height: 200px; width: 200px;">
                                <br>
                                <div class="input-group">
                                    <div class="custom-file">   
                                        <input name="appl_picture" type="file" class="custom-file-input btn" id="appl_picture" onchange="readUrl(this)" 
                                            accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg">
                                        <label class="custom-file-label" for="appl_picture" id="appl_picturelabel">Choose file...</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="btn btn-danger" id="img_remove" type="button" onclick="removeImg()">
                                            Remove
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Full name</label>
                            </div>
                            <div class="col-9 col-input row px-0">
                                <div class="col-4">
                                    <input name="appl_lastname" type="text" class="form-control" placeholder="Last name *"  required>
                                </div>
                                <div class="col-4">
                                    <input name="appl_firstname" type="text" class="form-control" placeholder="First name *" required>
                                </div>
                                <div class="col-4">
                                    <input name="appl_middlename" type="text" class="form-control" placeholder="Middle name">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Email <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 col-input row">
                                <input name="appl_email" type="email" class="form-control" placeholder="ex. your@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Contact Number <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 col-input row">
                                <input name="appl_contactNumber" type="tel" class="form-control" placeholder="ex. 09xxxxxxxxx" onpaste="return false;"
                                    onkeypress="return onlyNumberInput(event)" pattern="[0]{1}[9]{1}[0-9]{9}"  minlength="11" maxlength="11" required>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Username <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 col-input row">
                                <input name="appl_username" type="text" class="form-control" placeholder="username"  minlength="6" required>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Password <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 col-input row">
                                <?php $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_"; $acc_password = substr( str_shuffle( $chars ), 0, 24 ); ?>
                                <a href="#" type="button" onclick="generate_password()" class="text-muted"><i class="fas fa-sync-alt"></i> Generate Password</a>
                                <div class="input-group">
                                    <input name="appl_password" id="appl_password" type="password" class="form-control" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" value="<?php echo $acc_password ?>" required>
                                    <div class="input-group-append">
                                        <span type="button" class="btn btn-default border-0" id="passwordShowHide">
                                            <i class="fa fa-eye-slash" id="passwordShowHideIcon" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">Must contain a lowercase and uppercase letter, a number, and at least 8 characters.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title">
                                <label>Role <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9 col-input row">
                                <select name="role" class="form-control" required>
                                    <option value="Staff">Staff</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <!-- Agree | Submit -->
                        <div class="col-12 row mb-3">
                            <div class="col-3 col-title"></div>
                            <div class="col-9 col-input row">
                                <button name="create_account" class="btn btn-primary" type="submit">Create account</button>
                            </div>
                        </div>
                    </form>
                </div>
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
        // Add new accounts
        $("body").on('submit', '#insert_account', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to add an account?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create Account'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    formData.append('create_account', 'true');
                    $.ajax({
                        url: "php/accounts_crud.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        success:function(response){
                            if(response == 1){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Account created successfully.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                                $('#insert_account').removeClass('was-validated');
                                $('#insert_account')[0].reset();
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
        })
    </script>
</body>
</html>
