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
    <title>Mission & Vision Page | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" integrity="sha512-pDpLmYKym2pnF0DNYDKxRnOk1wkM9fISpSOjt8kWFKQeDmBTjSnBZhTd41tXwh8+bRMoSaFsRnznZUiH9i3pxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h1>Mission and Vision</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pages</li>
                                <li class="breadcrumb-item active">Mission and Vision</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid" id="missionvision_div">
                    <form id="missionvision_form" class="needs-validation" novalidate>
                        <?php $page = mySQLi_fetch_assoc( mySQLi_query($con, 'SELECT * from tbl_pages WHERE page_id = 1') );  ?>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Mission Image <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-12 d-flex justify-content-center col-input">
                                    <img src="/assets/img/uploads/<?php echo $page['page_mission_image']; ?>" 
                                        id='page_website_icon_preview' class="img-fluid" alt="Header Background" style="height: 369px; width: 369px;">
                                </div>
                                <div class="col-12">
                                    <div class="input-group mt-1 col-input"> 
                                        <div class="col-md-9 col-12">
                                            <input name="page_mission_label" type="text" class="form-control" id="page_website_icon_label" 
                                                value="<?php if($page['page_mission_image'] == 'no_image.png'){ echo '';}else{echo $page['page_mission_image'];} ?>" maxlength="0" readonly required/>
                                                <div class="invalid-feedback">Please select an image.</div>
                                        </div>
                                        <div class="col-md-3 col-12 row" style="height: 1px;">
                                            <div class="col-6 px-0 d-flex justify-content-center">
                                                <input name="page_mission_image" type="file" id="page_website_icon_image" onchange="pageWebsiteIcon(this)" 
                                                    accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" style="display: none;" />
                                                <label for="page_website_icon_image" class="btn btn-primary mr-2 col-12">Browes</label>
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
                                <label>Mission <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <textarea name="page_mission" class="form-control page_mission" rows="5" spellcheck="false" required><?php echo $page['page_mission']; ?></textarea>
                                    <div class="invalid-feedback">Please enter your Mission.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Vision Image <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-12 d-flex justify-content-center col-input">
                                    <img src="/assets/img/uploads/<?php echo $page['page_vision_image']; ?>" 
                                        id='page_about_image_preview' class="img-fluid" alt="Header Background" style="height: 369px; width: 369px; background-size: cover;">
                                </div>
                                <div class="col-12">
                                    <div class="input-group mt-1 col-input">
                                        <div class="col-md-9 col-12">
                                            <input name="page_vision_label" type="text" class="form-control" id="page_about_image_label" 
                                                value="<?php if($page['page_vision_image'] == 'no_image.png'){ echo '';}else{echo $page['page_vision_image'];} ?>" maxlength="0" readonly required>
                                            <div class="invalid-feedback">Please select an image.</div>
                                        </div>
                                        <div class="col-md-3 col-12 row" style="height: 1px;">
                                            <div class="col-6 px-0 d-flex justify-content-center">
                                                <input name="page_vision_image" type="file" id="page_about_image" onchange="pageAboutImage(this)" 
                                                    accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" style="display: none;" />
                                                <label for="page_about_image" class="btn btn-primary mr-2 col-12">Browes</label>
                                            </div>
                                            <div class="col-6 px-0 d-flex justify-content-center">
                                                <label class="btn btn-danger col-12" type="button" onclick="pageAboutImageRemove()">Remove</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                                <label>Vision <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <textarea name="page_vision" class="form-control page_vision" rows="5" spellcheck="false" required><?php echo $page['page_vision']; ?></textarea>
                                    <div class="invalid-feedback">Please enter your Vision.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3 col-title">
                            </div>
                            <div class="col-9">
                                <div class="col-xl-9 col-lg-12 col-input ">
                                    <button name="update_missionvision" class="btn btn-primary float-left" type="submit">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js" integrity="sha512-+cXPhsJzyjNGFm5zE+KPEX4Vr/1AbqCUuzAS8Cy5AfLEWm9+UI9OySleqLiSQOQ5Oa2UrzaeAOijhvV/M4apyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        * Summernote
        /* ---------------------------------------------- */
        $('.page_mission').summernote({
            placeholder: 'Write something...',
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        $('.page_vision').summernote({
            placeholder: 'Write something...',
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
        // Update Mission&Vision
        $("body").on('submit', '#missionvision_form', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to update the website\'s mission and vision page?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Update'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    formData.append('update_missionvision', 'true');
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
                                title: 'Website\' mission and vision page updated successfully.'
                            })
                            $('#missionvision_form').removeClass('was-validated');
                            // $('#missionvision_form')[0].reset();
                            // $('#missionvision_div').load(location.href + " #missionvision_div")
                        }
                    });
                }
            })
        })
    </script>
</body>
</html>
