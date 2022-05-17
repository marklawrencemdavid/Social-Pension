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
    <title>Add Pensioner | <?php echo $pages['page_website_title'];?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha512-rBi1cGvEdd3NmSAQhPWId5Nd6QxE8To4ADjM2a6n0BrqQdisZ/RPUlm0YycDzvNL1HHAh1nKZqI0kSbif+5upQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css" integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css" integrity="sha512-ClXpwbczwauhl7XC16/EFu3grIlYTpqTYOwqwAi7rNSqxmTqCpE8VS3ovG+qi61GoxSLnuomxzFXDNcPV1hvCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <h1>Add New Pensioner</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Pensioners</li>
                                <li class="breadcrumb-item active">Add New</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-md-center">
                        <div class="col-md-11">
                            <div class="card bg-transparent shadow">
                                <form id="insert_pensioner" class="needs-validation" novalidate>    
                                    <div class="card-body mt-1">
                                        <input name="pot" type="text" class="pot">
                                        <!-- Full Name -->
                                        <label for="fullname">Full name</label>
                                        <div class="form-row" id="fullname">
                                            <div class="col-md-4 mb-3">
                                                <input name="appl_lastname" type="text" class="form-control required" placeholder="Last name *"  required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input name="appl_firstname" type="text" class="form-control required" placeholder="First name *" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <input name="appl_middlename" type="text" class="form-control" placeholder="Middle name">
                                            </div>
                                        </div>
                                        <!-- Address -->
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <div class="form-row" id="address">
                                            <div class="col-md-3 mb-3">
                                                <input name="appl_houseno" type="text" class="form-control required" placeholder="House No./Street/Purok" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <select name="appl_barangay" class="form-control selectpicker required" data-size="5" title="Select a Barangay..." data-style="form-control" data-live-search="true" required>
                                                    <?php 
                                                        $page_barangay = explode(',',$pages['page_barangay']);
                                                        $count = 0;
                                                        while(count($page_barangay) > $count){
                                                    ?>
                                                        <option value="<?php echo $page_barangay[$count]?>"><?php echo $page_barangay[$count]?></option>
                                                    <?php $count++;} ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <input name="appl_municipality" type="text" class="form-control" placeholder="City/Municipality" value="<?php echo $pages['page_city']?>" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <input name="appl_province" type="text" class="form-control" placeholder="Province" value="<?php echo $pages['page_province']?>" readonly>
                                            </div>
                                        </div>
                                        <!-- Birthday | Birthplace | Gender | Civil Status -->
                                        <div class="form-row">
                                            <div class="col-md-2 mb-3">
                                                <label for="dateOfBirth">Date of Birth <span class="text-danger">*</span></label>
                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                    <input name="appl_birthdate" type="text" class="form-control datetimepicker-input required" id="dateOfBirth" placeholder="mm/dd/yyyy" data-target="#reservationdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask required>
                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                        <div class="input-group-text rounded-0 border-top-0 border-right-0 <?php if($acc['acc_darkmode'] == 1){echo 'bg-dark';}else{echo 'bg-white';} ?>">
                                                        <i class="fas fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-2 mb-3">
                                                <label for="dateOfBirth">Date of Birth</label>
                                                <input name="appl_birthdate" type="date" class="form-control required" id="dateOfBirth" required>
                                            </div> -->
                                            <div class="col-md-4 mb-3">
                                                <label for="placeOfBirth">Place of Birth <span class="text-danger">*</span></label>
                                                <input name="appl_birthplace" type="text" class="form-control required" id="placeOfBirth" placeholder="ex. San fernando, Pampanga" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="gender">Gender <span class="text-danger">*</span></label>
                                                <select class="form-control required" name="appl_gender" id="gender" required>
                                                    <option value="" selected disabled>-Select Gender-</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="civilStatus">Civil Status <span class="text-danger">*</span></label>
                                                <select class="form-control required" name="appl_civilStatus" id="civilStatus" required>
                                                    <option value="" selected disabled>-Select Civil Status-</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Separated">Separated</option>
                                                    <option value="Widowed">Widowed </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Previous Occupation | Contact No. | Email -->
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>
                                                <input name="appl_contactNumber" type="tel" onpaste="return false;" class="form-control required" id="contactNumber" placeholder="ex. 09xxxxxxxxx" 
                                                    onkeypress="return onlyNumberInput(event)" pattern="[0]{1}[9]{1}[0-9]{9}"  minlength="11" maxlength="11" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input name="appl_email" type="email" class="form-control required" id="email" placeholder="ex. your@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="prevOccupation">Previous Occupation <span class="text-danger">*</span></label>
                                                <input name="appl_prevOccupation" type="text" class="form-control required" id="prevOccupation" placeholder="ex. Teacher (If none, put 'N/A')" required>
                                            </div>
                                        </div>
                                        <!-- Pensioner | Picture -->
                                        <div class="row">
                                            <div class="col order-1 order-md-1">
                                                <label>Picture (1x1) <span class="text-danger">*</span></label>
                                                <img src="/assets/img/account_picture/profile.svg" id='displaypicture' 
                                                    class="rounded mx-auto d-block" alt="1x1 picture" style="height: 200px; width: 200px;">
                                                <br>
                                                <div class="input-group">
                                                    <div class="custom-file">   
                                                        <input name="appl_picture" type="file" class="custom-file-input btn required" id="appl_picture" onchange="readUrl(this)" 
                                                            accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" required>
                                                        <label class="custom-file-label" for="appl_picture" id="appl_picturelabel">Choose file...</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="btn btn-danger" id="img_remove" type="button" onclick="removeImg()">
                                                            Remove
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col order-2 order-md-2">
                                                <label>
                                                    Current pensioner at:
                                                    <br>
                                                    <small>NOTE: <i>If none, please skip.</i></small>
                                                </label> 
                                                <div class="icheck-primary">
                                                    <input name="appl_sss" type="checkbox" class="custom-control-input" id="sss" value="SSS">
                                                    <label for="sss">Social Security System (SSS)</label>
                                                </div>
                                                <div class="icheck-primary">
                                                    <input name="appl_gsis" type="checkbox" class="custom-control-input" id="gsis" value="GSIS">
                                                    <label for="gsis">Government Service Insurance System (GSIS)</label>
                                                </div>
                                                <div class="icheck-primary">
                                                    <input name="appl_pvao" type="checkbox" class="custom-control-input" id="pvao" value="PVAO">
                                                    <label for="pvao">Philippine Veterans Affairs Office (PVAO)</label>
                                                </div>
                                                <div class="icheck-primary">
                                                    <input name="appl_fps" type="checkbox" class="custom-control-input" id="fps" value="4Ps">
                                                    <label for="fps">Pantawid Pamilyang Pilipino Program (4P's)</label>
                                                </div>
                                                <div class="col-12 px-2 row">
                                                    <div class="icheck-primary col-2 px-0">
                                                        <input name="appl_otherCheckbox" type="checkbox" class="custom-control-input" id="other" onclick="enableDisableOther(this.checked, 'otherTB')">
                                                        <label for="other">Other</label>
                                                    </div>
                                                    <div class="col-10">
                                                        <input name="appl_other" type="text" class="form-control required" id="otherTB" placeholder="if other, please specify..." required disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-1">
                                                    <label for="civilStatus">Status <span class="text-danger">*</span></label>
                                                    <select class="form-control required" name="appl_status" id="status" required>
                                                        <option value="Applicant" selected>Applicant</option>
                                                        <option value="Active">Active</option>
                                                        <option value="Deceased">Deceased</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3" id="div_proof">
                                            <div class="col-12">
                                                <label>Upload an ID or Birth certificate <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="custom-file">   
                                                        <input name="appl_proof" type="file" class="custom-file-input btn required" id="proof-input" onchange="readProof(this)" 
                                                            accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" required>
                                                        <label class="custom-file-label" for="appl_picture" id="appl_picturelabel">Choose file...</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="btn btn-danger" id="img_remove" type="button" onclick="removeProof()">
                                                            Remove
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mx-auto sidebar mt-3 h-auto" style="overflow: auto; max-height: 500px;">
                                                    <center><img src="" class="img-fluid" id="proof-display" alt=""></center>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <!-- Button submit -->
                                            <div class="col text-center">
                                                <button class="btn btn-primary" type="submit">Add Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js" integrity="sha512-CJXg3iK9v7yyWvjk2npXkQjNQ4C1UES1rQaNB7d7ZgEVX2a8/2BmtDmtTclW4ial1wQ41cU34XPxOw+6xJBmTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- InputMask -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js" integrity="sha512-sR3EKGp4SG8zs7B0MEUxDeq8rw9wsuGVYNfbbO/GLCJ59LBE4baEfQBVsP2Y/h2n8M19YV1mujFANO1yA3ko7Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php if($acc['acc_darkmode'] == 1){ ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <?php }else{ ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php } ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js" integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/admin/assets/js/admin_main.js"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();

                            var errorElements = document.querySelectorAll(".required:invalid");
                            // errorElements.forEach(function(element) {
                            //     element.parentNode.childNodes.forEach(function(node) {
                            //         if (node.className == 'valid-feedback') {
                            //             node.className = 'invalid-feedback';
                            //             node.innerText = 'Please choose a Gender';
                            //         }
                            //     });
                            // });
                            $('html, body').animate({
                                // scrollTop: $(errorElements[0]).offset().top
                                scrollTop: $(errorElements[0]).focus().offset().top - 200
                            }, 100);
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        //Datemask2 mm/dd/yyyy
        // $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
        $('[data-mask]').inputmask()
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        function enableDisableInput(isChecked, inputID){
            document.getElementById(inputID).disabled = !isChecked
            document.getElementById(inputID).focus();
        }
        function readProof(input){
            if(input.files){
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload=(e)=>{
                document.getElementById("proof-display").src = e.target.result;
                }
            }
            document.getElementById("proof-display").style.background = '#f6f9fe';
        }
        function removeProof(){
            document.getElementById("proof-display").src=""; 
            document.getElementById("proof-input").value=""; 
        }
        // Add new pensioner
        $("body").on('submit', '#insert_pensioner', function(event){
            event.preventDefault();
            Swal.fire({
                title: 'Do you really want to add this data?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Add data'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "php/register.php",
                        method: "POST",
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: new FormData(this),
                        success:function(response){
                            if(response == 1){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data added successfully.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                })
                                $('#insert_pensioner').removeClass('was-validated');
                                $('#displaypicture').attr('src','/assets/img/applicant_picture/profile.svg');
                                $('#proof-display').attr('src','');
                                $('#insert_pensioner')[0].reset();
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
