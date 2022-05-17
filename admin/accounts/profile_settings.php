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
    <title>Profile Settings | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <!-- Sweet Alert -->
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
                            <h1 class="m-0">Profile Settings</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Accounts</li>
                                <li class="breadcrumb-item"><a href="/admin/accounts/profile">Profile</a></li>
                                <li class="breadcrumb-item active">Settings</li>
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
                                        <a class="nav-link" href="/admin/accounts/profile">
                                            <i class="fas fa-clock"></i> Activity Log
                                        </a>
                                        <a class="nav-link active" href="/admin/accounts/profile_settings">
                                            <i class="fas fa-cog"></i> Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <h5><i class="fas fa-cog"></i> Settings</h5>
                                    <!-- Details -->
                                    <form id="update_profile_d" class="needs-validation" novalidate>
                                        <div class="row h4">
                                            <div class="col-2">
                                                Details
                                            </div>
                                            <div class="col-10">
                                                <hr>
                                            </div>
                                        </div>
                                        <!-- Username | Role -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input name="uname_update" type="text" class="form-control" value="<?php echo $acc['acc_username'] ?>" minlength="6" maxlength="15" required>
                                            </div>
                                            <label class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="<?php echo $acc['acc_role'] ?>" disabled>
                                            </div>
                                        </div>
                                        <!-- Full Name -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="row col-sm-10 pr-0">
                                                <div class="col-sm-4">
                                                    <input name="fname_update" type="text" class="form-control" placeholder="First Name *" value="<?php echo ucfirst($acc['acc_firstname']) ?>" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input name="mname_update" type="text" class="form-control" placeholder="Middle Name" value="<?php echo ucfirst($acc['acc_middlename']) ?>">
                                                </div>
                                                <div class="col-sm-4 pr-0">
                                                    <input name="lname_update" type="text" class="form-control" placeholder="Last Name *" value="<?php echo ucfirst($acc['acc_lastname']) ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Contact No | Email -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Contact No. <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input name="contactno_update" type="text" class="form-control" placeholder="ex. 09123123132" value="<?php echo $acc['acc_contactno'] ?>" 
                                                onkeypress="return onlyNumberInput(event)" pattern="[0]{1}[9]{1}[0-9]{9}"  minlength="11" maxlength="11" required>
                                            </div> 
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                                            <div class="col-sm-4">
                                                <input name="email_update" type="email" class="form-control" placeholder="Email" value="<?php echo $acc['acc_email'] ?>" required>
                                            </div>
                                        </div>
                                        <!-- Picture -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Picture</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-6 d-flex justify-content-center">
                                                    <img src="/assets/img/account_picture/<?php echo $acc['acc_picture'] ?>" id='displaypicture' 
                                                        class="img-fluid img-circle" alt="1x1 picture" style="width: 200px; height: 200px; background: #777777;">
                                                </div>
                                                <br>
                                                <div class="input-group col-sm-6 col-12">
                                                    <div class="custom-file">
                                                        <input name="piture_update" type="file" class="custom-file-input btn" id="appl_picture"
                                                            onchange="readUrl(this)" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg">
                                                        <label class="custom-file-label" for="appl_picture" id="appl_picturelabel"><?php if($acc['acc_picture'] != 'profile.svg'){echo $acc['acc_picture'];}else{echo 'Choose file...';}?></label>
                                                        <div class="invalid-feedback">Please upload your a 1x1 picture.</div>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="btn btn-danger" id="img_remove" type="button" onclick="removeImg()">
                                                            Remove
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <!-- Darkmode -->
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Darkmode</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="dm_update" id="dm_update" data-bootstrap-switch <?php if($acc['acc_darkmode']==1){echo 'checked';} ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-12">
                                                <button id="update_details" name="update_details" type="submit" class="btn btn-primary">Update Account Details</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Password -->
                                    <form id="update_profile_p" class="needs-validation" novalidate>
                                        <div class="row h4">
                                            <div class="col-2">
                                                Password
                                            </div>
                                            <div class="col-10">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10 pr-0">
                                                <div class="row">
                                                    <small class="col-sm-4 col-form-label">New Password <span class="text-danger">*</span></small>
                                                    <div class="col-sm-5">
                                                        <input name="new_password" id="new_password" type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                        <div class="invalid-feedback">Must contain a lowercase and uppercase letter, a number, and at least 8 characters.</div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <small class="col-sm-4 col-form-label">Reenter New Password <span class="text-danger">*</span></small>
                                                    <div class="col-sm-5">
                                                        <input name="re_password" id="re_password" type="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                        <div class="invalid-feedback">Must contain a lowercase and uppercase letter, a number, and at least 8 characters.</div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <small class="col-sm-4 col-form-label">Old Password <span class="text-danger">*</span></small>
                                                    <div class="col-sm-5">
                                                        <input name="old_password" id="old_password" type="password" class="form-control" minlength="8" required>
                                                        <div class="invalid-feedback">Password is at least 8 characters.</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <small class="col-sm-4 col-form-label"></small>
                                                    <div class="col-sm-5 d-flex align-items-center">
                                                        <div class="icheck-primary d-inline d-flex align-items-center">
                                                            <input id="updatePasswordShowHide" type="checkbox">
                                                            <label for="updatePasswordShowHide"> Show Passwords</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-12">
                                                <button id="update_password" name="update_password" type="submit" class="btn btn-primary">Update Account Password</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Delete Account -->
                                    <form id="update_profile_de" class="needs-validation" novalidate>
                                        <div class="row h4">
                                            <div class="col-2">
                                                Delete Account
                                            </div>
                                            <div class="col-10">
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Delete Account</label>
                                            <div class="col-sm-10 pr-0">
                                                Once you deleted your account
                                                <li>You cannot use your account again.</li>
                                                <li>All your data will be deleted.</li>
                                                <li>Account deletion is cannot be undone.</li>
                                                <?php if($acc['acc_role'] == 'Super Admin'){ ?>
                                                    <br>
                                                    Please select new Super Admin if you're going to delete your account <span class="text-danger">*</span>
                                                    <div class="col-sm-6">
                                                        <select name="new_sa" id="new_sa" class="form-control" required>
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php $query = mysqli_query($con, "SELECT * FROM tbl_accounts WHERE acc_role = 'Admin'");
                                                                while($new = mysqli_fetch_assoc($query)){ ?>
                                                                <option value="<?php echo $new['acc_username']; ?>"><?php echo $new['acc_username']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="invalid-feedback">Select new Super Admin.</div>
                                                    </div>
                                                <?php } ?>
                                                <br>
                                                <p>Enter your password if you realy want to delete your account.</p>
                                                <div class="row mb-3">
                                                    <small class="col-auto col-form-label">Password <span class="text-danger">*</span></small>
                                                    <div class="col-sm-5">
                                                        <input name="del_password" id="del_password" type="password" class="form-control" required>
                                                        <div class="invalid-feedback">Please enter your password for confirmation.</div>
                                                    </div>
                                                </div>
                                                <button id="delete_account" class="btn btn-primary" type="submit" name="delete_account">Delete Account</button>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js" integrity="sha512-J+763o/bd3r9iW+gFEqTaeyi+uAphmzkE/zU8FxY6iAvD3nQKXa+ZAWkBI9QS9QkYEKddQoiy0I5GDxKf/ORBA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        $("input[data-bootstrap-switch]").bootstrapSwitch()
        $('#dm_update').on('switchChange.bootstrapSwitch', function(event, state) {
            if(state == true) {
                $('#headertag').addClass("navbar-dark");
                $('#headertag').removeClass("navbar-white navbar-light");

                $('#bodytag').addClass("dark-mode");
            } else {
                $('#headertag').addClass("navbar-white navbar-light");
                $('#headertag').removeClass("navbar-dark");
                
                $('#bodytag').removeClass("dark-mode");
            }
        });
        // Update Profile
        var btnUpdate = 0;
        $("body").on('click', '#update_details', function(){ btnUpdate = '1';})
        $("body").on('click', '#update_password', function(){ btnUpdate = '2';})
        $("body").on('click', '#delete_account', function(){ btnUpdate = '3';})
        $("body").on('submit', '#update_profile_d, #update_profile_p, #update_profile_de', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            var title = toastTitle = btn = '';
            if(btnUpdate == '1'){title = 'Do you really want to update your account details?';toastTitle = 'Account details updated successfully';btn = 'Update Details';formData.append('update_details', 'true');formData.append('img_label', $("#appl_picturelabel").text());}
            else if(btnUpdate == '2'){title = 'Do you really want to update your account password?';toastTitle = 'Account password updated successfully';btn = 'Update Password';formData.append('update_password', 'true');}
            else if(btnUpdate == '3'){title = 'Do you really want to delete your account?';toastTitle = '';btn = 'Delete Account';formData.append('delete_account', 'true');}
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
                        url: "php/profile_crud.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        success:function(response){
                            if(response == 1){
                                if(btnUpdate == '1'){ window.location="/admin/accounts/profile_settings";}
                                else if(btnUpdate == '3'){window.location = "/";}
                                else{
                                    Swal.fire({
                                        icon: 'success',
                                        title: toastTitle,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    })
                                }
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
                            if(response != 1 || (response == 1 && btnUpdate == 2)){
                                $('#update_profile_d, #update_profile_p, #update_profile_de').removeClass('was-validated');
                                $('#update_profile_d, #update_profile_p, #update_profile_de')[0].reset();
                            }
                        }
                    });
                }
            })
        })
    </script>
</body>
</html>
