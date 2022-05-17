<?php 
    include 'assets/php/authentication.php';
    include 'assets/php/database.php';
    if(isset($_SESSION['acc_id'])){
        $acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_role FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'"));
        if($acc['acc_role'] == 'Pensioner'){
            header("Location: /profile");
        }else{
            header("Location: /admin/dashboard");
        }
    }
    include 'assets/php/visit.php';
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
    // Clear Var
    if (isset($_SESSION['appl_data'])){unset($_SESSION['appl_data']);}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for SPISC | <?php echo $pages['page_website_title']; ?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">
    <!-- Vendor CSS Files -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/css/bootstrap.min.css" integrity="sha512-SCpMC7NhtrwHpzwKlE1l6ks0rS+GbMJJpoQw/A742VaxdGcQKqVD8F/y/m9WLOfIPppy7mWIs/kS0bKgSI0Bfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" integrity="sha512-9a1QYep56cYgIPFq0JYfsh9xRYYmPBxKaD6/ZfVAtplQ6y9ZUSk7GxgC2dmwtxK9T2cGQOxCV6J2Ll51nrvP2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.css" integrity="sha512-FuMUgHw8jwC1ABBFQITwogq7Q3hdvZnRJcuITfmmnP5JMY81yuC4nojF0aD1fVdRb/CxNaggJtsDdUcQgK21hQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main class="main bg-white pb-5">
        <!-- ======= Breadcrumbs Section ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Register for social pension</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li>Register for social pension</li>
                    </ol>
                </div>
            </div>
        </section><!-- Breadcrumbs Section -->
        <div class="container p-5 mt-5 shadow">
            <?php if(isset($_SESSION['acc_id'])){
                $acc = mysqli_fetch_assoc(mysqli_query($con, "SELECT acc_role FROM tbl_accounts WHERE acc_id = '".$_SESSION['acc_id']."'"));
                    if($acc['acc_role'] == 'Pensioner'){
            ?>
                    <div class="d-flex align-items-center justify-content-between">
                        <h2>You are already registered.</h2>
                        <img src="/assets/img/uploads/<?php echo $pages['page_website_icon'];?>" alt="" width="100px">
                    </div>
                <?php }else{ ?>
                    <div class="d-flex align-items-center justify-content-between">
                        <h2>Employees can add applicants/pensioners on <u><a href="/admin/applicants/add_new.php">Dashboard</a></u>.</h2>
                        <img src="/assets/img/uploads/<?php echo $pages['page_website_icon'];?>" alt="" width="100px">
                    </div>
                <?php } ?>
            <?php }else if(isset($_GET['result']) && $_GET['result'] == 'success'){ ?>
                <?php if (session_status() == PHP_SESSION_ACTIVE){session_destroy();} ?>
                <div class="section-title">
                    <h2>Application Data Sheet</h2>
                    <h3>Your request was <span>sent successfully</span></h3>
                    <p>Wait for for further notice about your registration via your contact number.</p>
                </div>
            <?php }else{ ?>
                <?php if (session_status() == PHP_SESSION_ACTIVE){session_destroy();} ?>
                <form id="registerForm"  class="needs-validation" novalidate>    
                    <input name="pot" type="text" class="visually-hidden">
                    <!-- Title -->
                    <div class="section-title">
                        <h2>Application Data Sheet</h2>
                        <h3>Register for <span>Social Pension</span></h3>
                        <p>Fill up the form with your personal information</p>
                    </div>
                    <?php
                        $days = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
                        if($pages['page_form_avail_day_from'] == 'Monday'){$count = 0;}
                        else if($pages['page_form_avail_day_from'] == 'Tuesday'){$count = 1;}
                        else if($pages['page_form_avail_day_from'] == 'Wedneday'){$count = 2;}
                        else if($pages['page_form_avail_day_from'] == 'Thursday'){$count = 3;}
                        else if($pages['page_form_avail_day_from'] == 'Friday'){$count = 4;}
                        else if($pages['page_form_avail_day_from'] == 'Saturday'){$count = 5;}
                        else if($pages['page_form_avail_day_from'] == 'Sunday'){$count = 6;}
                        $page_days = '';
                        while($pages['page_form_avail_day_to'] != $days[$count]){
                            $page_days .= ','.$days[$count];
                            $count++;
                            if($count == 7){
                                $count = 0;
                            }
                        }
                        $page_days .= ','.$days[$count];
                            
                        if (strpos($page_days, date('l'))) {
                            if(date('H:i:s') >= date('H:i:s', strtotime($pages['page_form_avail_time_from'])) && date('H:i:s') <= date('H:i:s', strtotime($pages['page_form_avail_time_to']))){
                    ?>
                        <!-- Full Name -->
                        <h5>Full name</h5>
                        <div class="row" id="fullname">
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="appl_lastname" id="lastname" type="text" class="form-control required" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>Last name <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="appl_firstname" id="firstname" type="text" class="form-control required" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>First name <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input name="appl_middlename" id="middlename" type="text" class="form-control" placeholder=" ">
                                    <span class="focus-border"></span>
                                    <label>Middle name</label>
                                </div>
                            </div>
                        </div>
                        <!-- Address -->
                        <h5>Address</h5>
                        <div class="row" id="address">
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="appl_houseno" id="houseno" type="text" class="form-control required" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>House No./Street/Purok <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <select class="form-select required" id="barangay" name="appl_barangay" required>
                                        <option value="" selected disabled>-Select a barangay-</option>
                                        <?php 
                                            $page_barangay = explode(',',$pages['page_barangay']);
                                            $count = 0;
                                            while(count($page_barangay) > $count){
                                        ?>
                                            <option value="<?php echo $page_barangay[$count]?>"><?php echo $page_barangay[$count]?></option>
                                        <?php $count++;} ?>
                                    </select>
                                    <span class="focus-border"></span>
                                    <label>Barangay <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="appl_municipality" id="city" type="text" class="form-control" placeholder=" " value="<?php echo $pages['page_city']?>" readonly>
                                    <span class="focus-border"></span>
                                    <label>City/Municipality</label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-floating">
                                    <input name="appl_province" id="province" type="text" class="form-control" placeholder=" " value="<?php echo $pages['page_province']?>" readonly>
                                    <span class="focus-border"></span>
                                    <label>Province</label>
                                </div>
                            </div>
                        </div>
                        <!-- Birthday | Birthplace | Gender -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <h5>Date of Birth <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <input name="appl_birthdate" id="birthdate" type="date" class="form-control required" required>
                                    <span class="focus-border"></span>
                                    <label>ex. 01/20/1960</label>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <h5>Place of Birth <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <input name="appl_birthplace" id="birthplace" type="text" class="form-control required" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>ex. San fernando, Pampanga</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <h5>Gender <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <select name="appl_gender" id="gender" class="form-select required" required>
                                        <option value="" selected disabled>-Select Gender-</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <span class="focus-border"></span>
                                    <label>Gender</label>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <h5>Civil Status <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <select name="appl_civilStatus" id="civilstatus" class="form-select required" required>
                                        <option value="" selected disabled>-Select Civil Status-</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Widowed">Widowed </option>
                                    </select>
                                    <span class="focus-border"></span>
                                    <label>Civil Status</label>
                                </div>
                            </div>
                        </div>
                        <!-- Civil Status | Previous Occupation | Contact No. -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h5>Email <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <input name="appl_email" type="email" class="form-control required" id="email" placeholder=" " pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                    <span class="focus-border"></span>
                                    <label>ex. your@email.com</label>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 mb-3">
                                <h5>Contact Number <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <input name="appl_contactNumber" id="contactnum" type="tel" class="form-control required" placeholder=" " onpaste="return false;"
                                        onkeypress="return numberInputOnly(event)" pattern="[0]{1}[9]{1}[0-9]{9}"  minlength="11" maxlength="11" required>
                                    <span class="focus-border"></span>
                                    <label>Format: 09xxxxxxxxx</label>
                                </div>
                            </div> -->
                            <div class="col-md-6 mb-3">
                                <h5>Previous occupation <span class="text-danger">*</span></h5>
                                <div class="form-floating">
                                    <input name="appl_prevOccupation" type="text" class="form-control required" id="prevOccupation" placeholder=" " required>
                                    <span class="focus-border"></span>
                                    <label>ex. Teacher (If none, put 'N/A')</label>
                                </div>
                            </div>
                        </div>
                        <!-- Pensioner | Picture -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>Picture <span class="text-danger">*</span></label>
                                <img src="/assets/img/applicant_picture/profile.svg" class="rounded mx-auto d-block" id="image-display"
                                    alt="1x1 picture" style="height: 200px; width: 200px;">
                                <br>
                                <div class="input-group">
                                    <input class="form-control required" type="file" name="appl_picture" id="image-input" onchange="readUrl(this)" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" required>
                                    <span class="focus-border"></span>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger form-btn" type="button" onclick="removeImg()" style="height: 38px;">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>
                                    Current pensioner at:
                                    <br>
                                    <small>NOTE: <i>If none, please skip.</i></small>
                                </h5> 
                                <div class="form-check mb-2">
                                    <input name="appl_sss" type="checkbox" class="form-check-input" id="sss" value="SSS">
                                    <label class="form-check-label" for="sss">Social Security System (SSS)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input name="appl_gsis" type="checkbox" class="form-check-input" id="gsis" value="GSIS">
                                    <label class="form-check-label" for="gsis">Government Service Insurance System (GSIS)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input name="appl_pvao" type="checkbox" class="form-check-input" id="pvao" value="PVAO">
                                    <label class="form-check-label" for="pvao">Philippine Veterans Affairs Office (PVAO)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input name="appl_fps" type="checkbox" class="form-check-input" id="fps" value="4Ps">
                                    <label class="form-check-label" for="fps">Pantawid Pamilyang Pilipino Program (4P's)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input name="appl_otherCheckbox" type="checkbox" class="form-check-input" id="other" onclick="enableDisableInput(this.checked, 'inputID')">
                                    <label class="form-check-label" for="other" style="color: #444444;">Other</label>
                                </div>
                                <div class="form-floating">
                                    <input name="appl_other" type="text" class="form-control required" id="inputID" placeholder="if other, please specify..." required disabled>
                                    <span class="focus-border"></span>
                                    <label>If other, please specify.</label>
                                </div>
                            </div>
                        </div>
                        <!-- Proof -->
                        <div class="row">
                            <h5 class="mb-3">Upload an ID or Birth certificate <span class="text-danger">*</span></h5>
                            <div class="input-group">
                                <input class="form-control required" type="file" name="appl_proof" id="proof-input" onchange="readProof(this)" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff, .svg" required>
                                <span class="focus-border"></span>
                                <div class="input-group-append">
                                    <button class="btn btn-danger form-btn" type="button" onclick="removeProof()" style="height: 38px;">Remove</button>
                                </div>
                            </div>
                            <center style="overflow: auto; max-height: 500px;">
                                <img src="" class="img-fluid mt-3" id="proof-display" alt="">
                            </center>
                        </div>
                        <!-- Agree | Submit -->
                        <div class="form-group">
                            <br>
                            <div class="form-check d-flex justify-content-center">
                                <div class="form-check col-md-9 mb-3">
                                    <input type="checkbox" class="form-check-input required" id="agree" required>
                                    <label class="form-check-label" for="agree" style="color: #444444;">
                                        <small>
                                        I do solemly swear that the above statements regarding my personal information are true and correct, 
                                        that I have no other SENIOR CITIZEN CARD/APPLICATION in any city/municipality in the Philippines. 
                                        </small>
                                    </label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
                            <!-- Button submit -->
                            <div class="col text-center">
                                <button class="btn btn-primary" id="form-submit" type="submit">Submit Application</button>
                            </div>
                        </div>
                    <?php   }else{
                            echo '<div class="col text-center text-primary">
                                    <h3>Registration for Social Pension isn\'t available at the moment.</h3><br>
                                    <h5>Only available from <strong>'.date('h:i a', strtotime($pages['page_form_avail_time_from'])).'</strong> to <strong>'.date('h:i a', strtotime($pages['page_form_avail_time_to'])).'</strong>.</h5>
                                </div>';
                            }
                        }else{
                            echo '<div class="col text-center text-primary">
                                <h3>Registration for Social Pension isn\'t available at the moment.</h3><br>
                                <h5>Only available from <strong>'.$pages['page_form_avail_day_from'].'</strong> through <strong>'.$pages['page_form_avail_day_to'].'</strong>.</h5>
                                </div>';
                        }
                    ?>
                </form>
            <?php } ?>
        </div>
    </main><!-- End #main -->

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/js/bootstrap.bundle.min.js" integrity="sha512-lAJppLlFlj2g7mb8jrbx34cdZcB24LLIK0N4U0rZtRPoY4oq9uiRXBbigPzGmzN5EXiDn0yMLIBjf0+E/alhXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.js" integrity="sha512-TEY9MppoX49BydDCCSsdqDUihEAEdO2S2En3WRjPoM+4wBkLtE7HKJ/Xt34c46/XM0Qxf6+F5caDMejengSDdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
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
        function enableDisableInput(isChecked, inputID){
            document.getElementById(inputID).disabled = !isChecked
            document.getElementById(inputID).focus();
        }
        /* ---------------------------------------------- /*
        * Display Picture
        /* ---------------------------------------------- */
        function readUrl(input){
            if(input.files){
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                reader.onload=(e)=>{
                document.getElementById("image-display").src = e.target.result;
                }
            }
            document.getElementById("image-display").style.background = '#f6f9fe';
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
        /* ---------------------------------------------- /*
        * Remove Picture
        /* ---------------------------------------------- */
        function removeImg(){
            document.getElementById("image-display").src="/assets/img/applicant_picture/profile.svg"; 
            document.getElementById("image-input").value=""; 
        }
        function removeProof(){
            document.getElementById("proof-display").src=""; 
            document.getElementById("proof-input").value=""; 
        }
        $("body").on('submit', '#registerForm', function(event){
            event.preventDefault();
            $('#form-submit').prop('disabled', true);
            // && $.trim($('#contactnum').val()) != ''
            if($.trim($('#lastname').val()) != '' && $.trim($('#firstname').val()) != '' && $.trim($('#houseno').val()) != '' && $.trim($('#barangay').val()) != '' && $.trim($('#birthdate').val()) != '' && $.trim($('#birthplace').val()) != '' && $.trim($('#gender').val()) != '' 
                && $.trim($('#civilstatus').val()) != '' && $.trim($('#email').val()) != '' && $.trim($('#prevOccupation').val()) != '' && $.trim($('#image-input').val()) != ''){
                    var name = $.trim($('#lastname').val()) + ', ' + $.trim($('#firstname').val()) + $.trim($('#middlename').val());
                    var address = $.trim($('#houseno').val()) + $.trim($('#barangay').val()) + ', ' + $.trim($('#citycity').val()) + ', ' + $.trim($('#province').val());
                    var birthdate = $.trim($('#birthdate').val());
                    var birthplace = $.trim($('#birthplace').val());
                    var gender = $.trim($('#gender').val());
                    var civilstatus = $.trim($('#civilstatus').val());
                    var email = $.trim($('#email').val());
                    var prevOccupation = $.trim($('#prevOccupation').val());
                    var img_src = $('#image-display').attr('src');
                    var img_prf_src = $('#proof-display').attr('src');
                    var cur_pensioner = '';

                    if($('#sss').is(":checked")){
                        cur_pensioner += 'SSS';
                    }
                    if($('#gsis').is(":checked")){
                        if(cur_pensioner != ''){cur_pensioner += ', ';}
                        cur_pensioner += 'GSIS';
                    }
                    if($('#pvao').is(":checked")){
                        if(cur_pensioner != ''){cur_pensioner += ', ';}
                        cur_pensioner += 'PVAO';
                    }
                    if($('#fps').is(":checked")){
                        if(cur_pensioner != ''){cur_pensioner += ', ';}
                        cur_pensioner += '4p\'s';
                    }
                    if($('#other').is(":checked")){
                        if(cur_pensioner != ''){cur_pensioner += ', and ';}
                        cur_pensioner += $.trim($('#inputID').val());
                    }
                    if(cur_pensioner == ''){cur_pensioner += 'None';}

                    var text = '<div class="container-fluid row">' + 
                                    '<div class="col-md-2"><div class="swal2-icon swal2-info swal2-icon-show m-auto" style="display: flex;"><div class="swal2-icon-content">i</div></div></div>' + 
                                    '<div class="col-md-10"><h2 class="swal2-title py-3" id="swal2-title" style="display: block;">Make sure to doucle check your data before submitting.</h2></div>' + 
                                '</div>' +
                                '<div class="container-fluid row">' + 
                                    '<div class="col-md-4 p-0">' +
                                        '<strong style="float: left; color: #212529;">Picture</strong>' +
                                        '<img src="' + img_src + '" class="rounded mx-auto d-block img-fluid" style="height: 200px; width: 200px;">' +
                                    '</div>' +
                                    '<div class="col-md-8 p-0">' + 
                                        '<table class="table table-sm table-borderless">' +
                                            '<tbody>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Name</th>' + 
                                                    '<td style="text-align: left;">' + name + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Address</th>' + 
                                                    '<td style="text-align: left;">' + address + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Birthdate</th>' + 
                                                    '<td style="text-align: left;">' + birthdate + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Birthplace</th>' + 
                                                    '<td style="text-align: left;">' + birthplace + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Gender</th>' + 
                                                    '<td style="text-align: left;">' + gender + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Civil Status</th>' + 
                                                    '<td style="text-align: left;">' + civilstatus + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Email</th>' + 
                                                    '<td style="text-align: left;">' + email + '</td>' + 
                                                '</tr>' +
                                                '<tr>' +
                                                    '<th style="text-align: left;">Previous occupation</th>' + 
                                                    '<td style="text-align: left;">' + prevOccupation + '</td>' + 
                                                '</tr>' + 
                                                '<tr>' +
                                                    '<th style="text-align: left;">Current pensioner at</th>' + 
                                                    '<td style="text-align: left;">' + cur_pensioner + '</td>' + 
                                                '</tr>';
                                    text += '</tbody>' +
                                        '</table>' +
                                    '</div>' + 
                                '</div>' +
                                '<strong style="float: left; color: #212529;">ID or Birth Certificate</strong>' +
                                '<div class = "col-12 p-0" style="overflow: auto; max-height: 500px;">' + 
                                    '<img src="' + img_prf_src + '" class="img-fluid" style="height: auto; width: 100%;"   >' + 
                                '</div>';

                    Swal.fire({
                        // title: 'Make sure to doucle check your data before submitting.',
                        html: text,
                        // icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Submit Application',
                        width: '50%'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/assets/php/sms_subs.php",
                                method: "POST",
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: new FormData(this),
                                success:function(response){
                                    if(response == "1"){
                                        $("#registerForm")[0].reset();
                                        $('#image-display').attr('src','/assets/img/applicant_picture/profile.svg');
                                        $("#registerForm").removeClass('was-validated');
                                        window.location.replace("http://developer.globelabs.com.ph/dialog/oauth/<?php echo $pages['page_sms_appid']?>");
                                    }else{
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oppss...',
                                            text: response,
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true
                                        })
                                        $('#form-submit').prop('disabled' , false);
                                    }
                                }
                            });
                        }else{
                            $('#form-submit').prop('disabled' , false);
                        }
                    })
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Blank input detected!',
                    text: 'Fields should not be filled with spaces.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
                $('#form-submit').prop('disabled' , false);
            }
        });
    </script>
</body>
</html>