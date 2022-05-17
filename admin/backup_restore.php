<?php 
    include '../assets/php/database.php';
    include 'assets/php/authentication.php';
    $acc = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_accounts WHERE acc_id = '.$_SESSION['acc_id'].'') );
    $pages = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') ); 
    if ($acc['acc_role'] != 'Super Admin') {
        header('Location: dashboard');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Backup/Restore | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Backup/Restore</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Backup/Restore</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <h3>Backup</h3>
                    <div class="row mb-3">
                        <div class="col-3 col-title">
                            <label>Schedule</label>
                        </div>
                        <div class="col-9">
                            <div class="col-xl-9 col-lg-12 col-input">
                                <b>Select days of the week for automatic backup. Please make sure to schedule backup for at least once a week.</b>
                                <div>For Automatic backup to take effect please do the 5 steps specified below.</div>
                                <div><b>Step 1:</b> Go to <a target="_blank" rel="noreferrer" href="https://cron-job.org">https://cron-job.org</a>.</div>
                                <div><b>Step 2:</b> If you don't have an account, sign up for an account, otherwise go ahead and log in.</div>
                                <div><b>Step 3:</b> On cron-job.org's Dashboard, click the "CREATE CRONJOB" button.</div>
                                <div><b>Step 4:</b> Paste <u><?php  if(isset($_SERVER["HTTPS"]) && $_SERVER['HTTPS'] === 'on'){echo "https://";}else{echo "http://";} echo $_SERVER['SERVER_NAME']."/admin/assets/php/autobackup.php";?></u> on the URL field.</div>
                                <div><b>Step 5:</b> Set the Execution schedule to "Every day", you can also set the time if you want, and click the Create button below.</div>
                                <form id="backup_sched_form">
                                    <div class="icheck-primary">
                                        <input name="Monday" id="Monday" value="Monday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Monday')){echo 'checked';} ?>>
                                        <label for="Monday">Monday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Tuesday" id="Tuesday" value="Tuesday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Tuesday')){echo 'checked';} ?>>
                                        <label for="Tuesday">Tuesday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Wednesday" id="Wednesday" value="Wednesday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Wednesday')){echo 'checked';} ?>>
                                        <label for="Wednesday">Wednesday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Thursday" id="Thursday" value="Thursday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Thursday')){echo 'checked';} ?>>
                                        <label for="Thursday">Thursday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Friday" id="Friday" value="Friday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Friday')){echo 'checked';} ?>>
                                        <label for="Friday">Friday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Saturday" id="Saturday" value="Saturday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Saturday')){echo 'checked';} ?>>
                                        <label for="Saturday">Saturday</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="Sunday" id="Sunday" value="Sunday" type="checkbox" class="custom-control-input" <?php if(strpos($pages['page_autobackup_days'], 'Sunday')){echo 'checked';} ?>>
                                        <label for="Sunday">Sunday</label>
                                    </div>
                                    <button id="back_sched_btn" type="submit" class="btn btn-primary mb-3">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 col-title">
                            <label>Backup</label>
                        </div>
                        <div class="col-9">
                            <div class="col-xl-9 col-lg-12 col-input">
                                <p><strong><i class="fas fa-arrow-circle-down"> </i> Click the button to start backup </strong></p>
                                <form id="backup_form">
                                    <button id="backup_button" type="submit" class="btn btn-primary mb-3">Backup </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <h3>Restore</h3>
                    <div class="row mb-3">
                        <div class="col-3 col-title">
                            <label>Upload a Backup</label>
                        </div>
                        <div class="col-9">
                            <div class="col-xl-9 col-lg-12 col-input">
                                <form id="upload_backup_form" class="needs-validation" novalidate>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">   
                                            <input name="back_name" type="file" class="custom-file-input btn" id="appl_picture" onchange="readUrlBackup(this)"  accept=".zip" required>
                                            <label class="custom-file-label" for="appl_picture" id="appl_picturelabel">Choose file...</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" id="upload_backup_btn">
                                                Upload
                                            </button>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="btn btn-danger" id="img_remove" type="button" onclick="removeBackup()">
                                                Remove
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 col-title">
                            <label>Available Backups</label>
                        </div>
                        <div class="col-9">
                            <div class="col-xl-9 col-lg-12 col-input">
                                <table id="tblBackups" class="table table-stripped">
                                    <thead>
                                        <th>Backup</th>
                                        <th>Date</th>
                                        <th>Restore</th>
                                        <th>Download</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query=mySQLi_query($con, "SELECT * from tbl_backup order by back_id DESC") or die(mySQLi_error($con));
                                            while($back=mySQLi_fetch_assoc($query)){
                                        ?>
                                            <tr>
                                                <td><?php echo pathinfo($back['back_name'], PATHINFO_FILENAME); ?></td>
                                                <td><?php echo date("M d, Y - h:i a", strtotime($back['back_date'])); ?></td>
                                                <td><a href="#" class="restore_button" id="<?php echo $back['back_id'];?>">Restore</a></td>
                                                <td><a href="#" class="download_button text-info" id="<?php echo $back['back_id'];?>">Download</a></td>
                                                <td><a href="#" class="delete_button text-danger" id="<?php echo $back['back_id'];?>">Delete</a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    <!-- Sweet Alert -->
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        // Backup
        $("body").on('submit', '#backup_form', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to perform a backup?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Backup'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Please input your password to continue.",
                        input: 'password',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',        
                    }).then((result) => {
                        if (result.value) {
                            var password = result.value;
                            $.ajax({
                                url: "/admin/assets/php/backup_restore_crud.php?id=7",
                                method: "POST",
                                data: {password:password},
                                success:function(response){
                                    if(response == 1){
                                        Swal.fire({
                                            title: "",
                                            text: "Please wait.",
                                            showConfirmButton: false,
                                            allowOutsideClick: false
                                        });

                                        $.ajax({
                                            url: "/admin/assets/php/backup_restore_crud.php",
                                            method: "GET",
                                            // processData: false,
                                            // contentType: false,
                                            // cache: false,
                                            data: {id:'1'},
                                            success:function(response){
                                                if(response == 1){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Website backuped successfully',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                    $('#tblBackups').load(location.href + " #tblBackups")
                                                }else{
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Website backuped failed',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                }
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: 'warning',
                                            title: response
                                        })
                                    }
                                }
                            });
                        }else if(result.value == ''){
                            Swal.fire({
                                icon: 'warning',
                                title: "Blank input detected."
                            })
                        }
                    });
                }
            })
        });
        // Restore
        $("body").on('click', '.restore_button', function(event){
            // $(".restore_button").click(function(){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to restore the websites data?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore'
            }).then((result) => {
                if (result.isConfirmed) {
                    var back_id = $(this).attr("id");
                    Swal.fire({
                        title: "Please input your password to continue.",
                        input: 'password',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',        
                    }).then((result) => {
                        if (result.value) {
                            var password = result.value;
                            $.ajax({
                                url: "/admin/assets/php/backup_restore_crud.php?id=7",
                                method: "POST",
                                data: {password:password},
                                success:function(response){
                                    if(response == 1){
                                        Swal.fire({
                                            title: "",
                                            text: "Please wait.",
                                            showConfirmButton: false,
                                            allowOutsideClick: false
                                        });

                                        $.ajax({
                                            url: "/admin/assets/php/backup_restore_crud.php?id=2",
                                            method: "GET",
                                            // processData: false,
                                            // contentType: false,
                                            // cache: false,
                                            data: {back_id:back_id},
                                            success:function(response){
                                                Swal.close();
                                                
                                                if(response == 1){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Website data restored successfully',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                    $('#tblBackups').load(location.href + " #tblBackups")
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
                                    }else{
                                        Swal.fire({
                                            icon: 'warning',
                                            title: response
                                        })
                                    }
                                }
                            });
                        }else if(result.value == ''){
                            Swal.fire({
                                icon: 'warning',
                                title: "Blank input detected."
                            })
                        }
                    });
                }
            })
        });
        // Delete
        $("body").on('click', '.delete_button', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to delete this backup file?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    var back_id = $(this).attr("id");
                    Swal.fire({
                        title: "Please input your password to continue.",
                        input: 'password',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',        
                    }).then((result) => {
                        if (result.value) {
                            var password = result.value;
                            $.ajax({
                                url: "/admin/assets/php/backup_restore_crud.php?id=7",
                                method: "POST",
                                data: {password:password},
                                success:function(response){
                                    if(response == 1){
                                        $.ajax({
                                            url: "/admin/assets/php/backup_restore_crud.php?id=5",
                                            method: "GET",
                                            // processData: false,
                                            // contentType: false,
                                            // cache: false,
                                            data: {back_id:back_id},
                                            success:function(response){
                                                if(response == 1){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'A backup file deleted successfully',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                    $('#tblBackups').load(location.href + " #tblBackups")
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
                                    }else{
                                        Swal.fire({
                                            icon: 'warning',
                                            title: response
                                        })
                                    }
                                }
                            });
                        }else if(result.value == ''){
                            Swal.fire({
                                icon: 'warning',
                                title: "Blank input detected."
                            })
                        }
                    });
                }
            })
        });
        // Auto backup sched
        $("body").on('submit', '#backup_sched_form', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to update the auto backup schedule?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save changes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#back_sched_btn').append(' <i class="fas fa-spinner fa-spin"></i>');
                    $.ajax({
                        url: "/admin/assets/php/backup_restore_crud.php?id=4",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData(this),
                        success:function(response){
                            if(response == 1){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Website auto backup schedule updated successfully',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Website auto backup schedule failed to update',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                            }
                            $('#back_sched_btn').html('Save changes');
                        }
                    });
                }
            })
        });
        // Upload backup
        $("body").on('submit', '#upload_backup_form', function(event){
            event.preventDefault();
            var formData = new FormData(this);
            if($('#appl_picture').val()){
                Swal.fire({
                    title: 'Do you really want to upload a new backup?',
                    // text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Upload'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                        title: "Please input your password to continue.",
                        input: 'password',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',        
                    }).then((result) => {
                        if (result.value) {
                            var password = result.value;
                            $.ajax({
                                url: "/admin/assets/php/backup_restore_crud.php?id=7",
                                method: "POST",
                                data: {password:password},
                                success:function(response){
                                    if(response == 1){
                                        Swal.fire({
                                            title: "",
                                            text: "Please wait.",
                                            showConfirmButton: false,
                                            allowOutsideClick: false
                                        });

                                        // $('#upload_backup_btn').append(' <i class="fas fa-spinner fa-spin"></i>');
                                        $.ajax({
                                            url: "/admin/assets/php/backup_restore_crud.php?id=3",
                                            method: "POST",
                                            processData: false,
                                            contentType: false,
                                            cache: false,
                                            data: formData,
                                            success:function(response){
                                                if(response == 1){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Successfully uploaded new data backup',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                    $('#appl_picturelabel').html('Choose file...');
                                                    $('#upload_backup_form')[0].reset();
                                                    $('#upload_backup_form').removeClass('was-validated');
                                                    $('#tblBackups').load(location.href + " #tblBackups")
                                                }else{
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Failed to uploaded new data backup.',
                                                        toast: true,
                                                        position: 'top-end',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                        timerProgressBar: true
                                                    })
                                                }
                                                // $('#upload_backup_btn').html('Upload');
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            icon: 'warning',
                                            title: response
                                        })
                                    }
                                }
                            });
                        }else if(result.value == ''){
                            Swal.fire({
                                icon: 'warning',
                                title: "Blank input detected."
                            })
                        }
                    });
                    }
                })
            }else{
                Swal.fire({
                    title: "Please select a file",
                    icon: 'error',
                })
            }
        });
        // Check backup file
        $('body').on("change", '#appl_picture', function(){
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['zip']) == -1) {
                Swal.fire({
                    title: "File should be zipped",
                    text: 'ex. backup.zip',
                    icon: 'error',
                })
                $('#appl_picturelabel').html('Choose file...');
            }else{
                $('#appl_picturelabel').html(this.file);
            }
        });
        // Download backup
        $("body").on('click', '.download_button', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to download this backup?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Download'
            }).then((result) => {
                if (result.isConfirmed) {
                    var back_id = $(this).attr("id");
                    Swal.fire({
                        title: "Please input your password to continue.",
                        input: 'password',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',        
                    }).then((result) => {
                        if (result.value) {
                            var password = result.value;
                            $.ajax({
                                url: "/admin/assets/php/backup_restore_crud.php?id=7",
                                method: "POST",
                                // processData: false,
                                // contentType: false,
                                // cache: false,
                                data: {password:password},
                                success:function(response){
                                    if(response == 1){
                                        document.location = "/admin/assets/php/backup_restore_crud.php?id=6&back_id="+back_id;
                                    }else{
                                        Swal.fire({
                                            icon: 'warning',
                                            title: response
                                        })
                                    }
                                }
                            });
                        }else if(result.value == ''){
                            Swal.fire({
                                icon: 'warning',
                                title: "Blank input detected."
                            })
                        }
                    });
                }
            })
        });
        // Display Picture
        function readUrlBackup(input){
            document.getElementById("appl_picturelabel").innerHTML = document.getElementById('appl_picture').files[0].name;
        }
        // Remove Picture
        function removeBackup(){
            document.getElementById("appl_picture").value="";
            document.getElementById("appl_picturelabel").innerHTML = 'Choose file...';
        } 
    </script>
</body>
</html>
