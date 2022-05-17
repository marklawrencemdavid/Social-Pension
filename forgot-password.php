<?php 
    include 'assets/php/authentication.php';
    include 'assets/php/database.php';
    include 'assets/php/visit.php';
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | <?php echo $pages['page_website_title']; ?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/css/bootstrap.min.css" integrity="sha512-SCpMC7NhtrwHpzwKlE1l6ks0rS+GbMJJpoQw/A742VaxdGcQKqVD8F/y/m9WLOfIPppy7mWIs/kS0bKgSI0Bfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" integrity="sha512-9a1QYep56cYgIPFq0JYfsh9xRYYmPBxKaD6/ZfVAtplQ6y9ZUSk7GxgC2dmwtxK9T2cGQOxCV6J2Ll51nrvP2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.css" integrity="sha512-FuMUgHw8jwC1ABBFQITwogq7Q3hdvZnRJcuITfmmnP5JMY81yuC4nojF0aD1fVdRb/CxNaggJtsDdUcQgK21hQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body class="body">
    <!-- Header -->
    <?php include 'header.php'; ?>
    <main class="main mt-0">
        <!-- ======= Breadcrumbs Section ======= -->
        <!-- <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Log in</h2>
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li><a href="/login">Log in</a></li>
                        <li>Forgot Passowrd</li>
                    </ol>
                </div>
            </div>
        </section> -->
        <!-- Breadcrumbs Section -->
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center vh-100" style="background-color: #f6f9fe; <?php if($pages['page_header_back_image'] != 'no_image.png'){echo "background: url('assets/img/uploads/".$pages['page_header_back_image']."') top left;";}?> background-attachment: fixed; background-size: cover;">
            <div class="container">
                <div class="d-flex justify-content-center align-items-center">
                    <?php if ($pages['page_website_icon'] != 'no_image.png') { ?>
                        <img class="img-circle img-fluid" src="assets/img/uploads/<?php echo $pages['page_website_icon'] ?>" alt="Minalin Logo" width="70px">
                    <?php } ?>
                    <h3 class="login-label ms-2">Office Of The Senior Citizen Affair</h3>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <div class="col-lg-6 col-12 d-flex justify-content-center" style="max-width: 500px;">
                        <div class="card card-primary card-login col-12 px-0">
                            <form class="needs-validation" novalidate>
                                <input name="pot" type="text" class="visually-hidden">
                                <div class="card-body card-login-body">
                                    <div class="col-12">
                                        <h3 class="card-title card-title-login">Search your account</h3>
                                        <div id="response_search"></div>
                                        <div class="form-floating mb-3">
                                            <input name="username" type="text" class="form-control" placeholder=" "required>
                                            <span class="focus-border"></span>
                                            <label>Enter your username</label>
                                        </div>
                                        <button name="search_account" type="submit" class="btn btn-block form-btn btn-primary col-12"><i class="bi bi-search"></i> Search</button>
                                        <a href="/login" class="d-flex justify-content-center mt-3"><small>Back to Log in</small></a>
                                    </div>
                                </div>
                            </form>
                            <form class="send-confirmation visually-hidden"></form>
                            <form class="verify visually-hidden"></form>
                            <form class="reset-password visually-hidden"></form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Hero -->
    </main><!-- End #main -->

    <?php include 'footer.php'; ?>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/js/bootstrap.bundle.min.js" integrity="sha512-lAJppLlFlj2g7mb8jrbx34cdZcB24LLIK0N4U0rZtRPoY4oq9uiRXBbigPzGmzN5EXiDn0yMLIBjf0+E/alhXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.js" integrity="sha512-TEY9MppoX49BydDCCSsdqDUihEAEdO2S2En3WRjPoM+4wBkLtE7HKJ/Xt34c46/XM0Qxf6+F5caDMejengSDdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js" integrity="sha512-fHXRw0CXruAoINU11+hgqYvY/PcsOWzmj0QmcSOtjlJcqITbPyypc8cYpidjPurWpCnlB8VKfRwx6PIpASCUkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.5.0/js/md5.min.js"></script> -->
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script>
        // Show password
        $("body").on('click', '#btn_newpassword', function(event){
            event.preventDefault();
            if($('#newpassword').attr("type") == "text"){
                $('#newpassword').attr('type', 'password');
                $('#icn_newpassword').addClass( "bi-eye-slash" );
                $('#icn_newpassword').removeClass( "bi-eye" );
            }else if($('#newpassword').attr("type") == "password"){
                $('#newpassword').attr('type', 'text');
                $('#icn_newpassword').removeClass( "bi-eye-slash" );
                $('#icn_newpassword').addClass( "bi-eye" );
            }
        });
        $("body").on('click', '#btn_renewpassword', function(event){
            event.preventDefault();
            if($('#renewpassword').attr("type") == "text"){
                $('#renewpassword').attr('type', 'password');
                $('#icn_renewpassword').addClass( "bi-eye-slash" );
                $('#icn_renewpassword').removeClass( "bi-eye" );
            }else if($('#renewpassword').attr("type") == "password"){
                $('#renewpassword').attr('type', 'text');
                $('#icn_renewpassword').removeClass( "bi-eye-slash" );
                $('#icn_renewpassword').addClass( "bi-eye" );
            }
        });
        // Search Account
        $("body").on('submit', '.needs-validation', function(event){
            event.preventDefault();
            $('button[name=search_account]').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('button[name=search_account]').prop('disabled', true);
            $.ajax({
                url: "/assets/php/forgot-password.php",
                method: "POST",
                processData: false,
                contentType: false, 
                // cache: false,
                data: new FormData(this),
                success:function(response){
                    if(response == 0){
                        $('#response_search').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> Your search did not return any results. Please try again with other username.</div>');
                        $('button[name=search_account]').html('<i class="bi bi-search"></i> Search');
                        $('button[name=search_account]').prop('disabled', false);
                    }else{
                        // $('.form-check-input').val(md5(response));
                        // $('button[name=send_code]').val($('input[name=username]').val());
                        var split = response.split('@');
                        var split2 = split[1].split('.');
                        var response = split[0][0] + split[0][1] + Array(split[0].length-1).join('*') + '@' + split2[0][0] + Array(split2[0].length).join('*') + '.' + Array(split2[1].length + 1).join('*');
                        // $('.form-check-label').html("Email a confirmation code to "+response);
                        $('.send-confirmation').html('<input name="pot" type="text" class="visually-hidden"><div class="card-body card-login-body"><div class="col-12"><h3 class="card-title card-title-login">Send code</h3><div id="response_send"></div><p>We found the following information associated with your account.</p><div class="form-check px-0"><label class="form-check-label float-start" for="radio1">Email a confirmation code to '+response+'</label><input class="form-check-input float-end" type="radio" name="email" id="radio1" value="radio" required></div><br><button value="'+$('input[name=username]').val()+'" name="send_code" type="submit" class="btn btn-block form-btn btn-primary col-12">Next</button><a href="/login" class="d-flex justify-content-center mt-3"><small>Cancel</small></a></div></div>');
                        $('.needs-validation').html('');
                        $('.needs-validation').addClass('visually-hidden');
                        $('.send-confirmation').removeClass('visually-hidden');
                        $('.needs-validation')[0].reset();
                    }
                    $('.needs-validation').removeClass('was-validated');
                }
            });
        });
        // Send Code
        var stop = false;
        $("body").on('submit', '.send-confirmation', function(event){
            event.preventDefault();
            $('button[name=send_code]').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('button[name=send_code]').prop('disabled', true);
            var formData = new FormData(this);
            formData.append('var_username', $('button[name=send_code]').val());
            $.ajax({
                url: "/assets/php/forgot-password.php",
                method: "POST",
                processData: false,
                contentType: false, 
                // cache: false,
                data: formData,
                success:function(response){
                    if(response == 0){
                        $('#response_send').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> Failed to send email. Please try again.</div>'+response);
                        $('button[name=send_code]').prop('disabled', false);
                    }else{
                        // $('button[name=ver_code]').val($('button[name=send_code]').val());
                        $('.verify').html('<input name="pot" type="text" class="visually-hidden"><div class="card-body card-login-body"><div class="col-12"><h3 class="card-title card-title-login">Check your email</h3><div id="response_verify"></div><p>You will receive a code for verification before you can reset your account password.</p><b class="tries">Note: You only have 5 tries</b><div class="form-floating mb-3"><input name="code" type="text" class="form-control" placeholder=" "required><span class="focus-border"></span><label>Enter your code</label></div><div class="text-center fw-bold">After 5 minutes the page will automatically reload.</div><p class="count text-center h1 text-primary fw-bold">00:00</p><button value="'+$('button[name=send_code]').val()+'" name="ver_code" type="submit" class="btn btn-block form-btn btn-primary col-12">Verify</button><a href="/login" id="ver_cancel" class="d-flex justify-content-center mt-3"><small>Cancel</small></a></div></div>');
                        $('.send-confirmation').html('');
                        $('.send-confirmation').addClass('visually-hidden');
                        $('.verify').removeClass('visually-hidden');
                        $('.send-confirmation')[0].reset();
                        startTimer();
                    }
                }
            });
        });
        // Time function
        function startTimer() {
            var count = 0;
            var interval = setInterval(function() {
                if(stop == false){
                    count += 1;
                    if(count == 300){
                        window.location.reload();
                    }
                    var minutes = Math.floor(count / 60);
                    if(minutes < 10){minutes = '0'+minutes;}
                    var seconds = count - minutes * 60;
                    if(seconds < 10){seconds = '0'+seconds;}
                    $('.count').html(minutes+':'+seconds);
                }else{
                    $.ajax({
                        url: "/assets/php/forgot-password.php",
                        type: "post",
                        data: {remove_code:$('button[name=ver_code]').val()}
                    });
                    clearInterval(interval);
                }
            }, 1000); 
        }
        // Verify
        var try_code = 0;
        $("body").on('submit', '.verify', function(event){
            event.preventDefault();
            $('button[name=ver_code]').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('button[name=ver_code]').prop('disabled', true);
            var formData = new FormData(this);
            formData.append('var_username', $('button[name=ver_code]').val());
            if(try_code < 4){
                $.ajax({
                    url: "/assets/php/forgot-password.php",
                    method: "POST",
                    processData: false,
                    contentType: false, 
                    // cache: false,
                    data: formData,
                    success:function(response){
                        if(response == 0){
                            $('#response_verify').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> The code is incorrect, please check your email and try again.</div>');
                            $('button[name=ver_code]').prop('disabled', false);
                        }else{
                            $.ajax({
                                url: "/assets/php/forgot-password.php",
                                type: "post",
                                data: {remove_code:$('button[name=ver_code]').val()}
                            });
                            // $('button[name=reset_pass]').val($('button[name=ver_code]').val());
                            $('.reset-password').html('<input name="pot" type="text" class="visually-hidden"><div class="card-body card-login-body"><div class="col-12"><h3 class="card-title card-title-login">Reset your password</h3><div id="response_reset"></div><p>Your password needs to be at least 8 characters.</p><div class="input-group mb-3"><div class="form-floating col-11"><input name="newpassword" type="password" id="newpassword" class="form-control" placeholder=" " minlength="8" required><span class="focus-border"></span><label>New password</label></div><span class="col-1" type="button" id="btn_newpassword"><i class="bi bi-eye-slash btn col-12 fs-5 mt-2" id="icn_newpassword"></i></span></div><div class="input-group mb-3"><div class="form-floating col-11"><input name="renewpassword" type="password" id="renewpassword" class="form-control" placeholder=" " minlength="8" required><span class="focus-border"></span><label>Re enter new password</label></div><span class="col-1" type="button" id="btn_renewpassword"><i class="bi bi-eye-slash btn col-12 fs-5 mt-2" id="icn_renewpassword"></i></span></div><button value="'+$('button[name=ver_code]').val()+'" name="reset_pass" type="submit" class="btn btn-block form-btn btn-primary col-12">Reset password</button><a href="/login" class="d-flex justify-content-center mt-3"><small>Cancel</small></a></div></div>');
                            $('.verify').html('');
                            $('.verify').addClass('visually-hidden');
                            $('.reset-password').removeClass('visually-hidden');
                            stop = true;
                        }
                        $('.verify')[0].reset();
                        if(try_code < 3){$('.tries').html((4-try_code)+" tries left");}
                        else{$('.tries').html((4-try_code)+" try left");}
                        try_code += 1;
                    }
                });
            }else{
                $.ajax({
                    url: "/assets/php/forgot-password.php",
                    type: "post",
                    data: {remove_code:$('button[name=ver_code]').val()}
                });
                $('button[name=ver_code]').prop('disabled', true);
                $('.verify').html('<div class="card-body card-login-body"><div class="col-12"><h3 class="card-title card-title-login">Too many password reset attempts</h3><div id="response_verify"></div><p>You’ll need to wait before you can try again. We do this when we notice suspicious activity.</p><a href="/login" class="d-flex justify-content-center mt-3 btn btn-primary"><small>Got it</small></a></div></div>');
            }
        });
        // Verify Cancel
        $("body").on('click', '#ver_cancel', function(event){
            event.preventDefault();
            $.ajax({
                url: "/assets/php/forgot-password.php",
                type: "post",
                data: {remove_code:$('button[name=ver_code]').val()}
            });
            window.location.href = "/login";
        });
        // Reset Pass
        $("body").on('submit', '.reset-password', function(event){
            event.preventDefault();
            $('button[name=reset_pass]').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('button[name=reset_pass]').prop('disabled', true);
            var formData = new FormData(this);
            formData.append('var_username_reset', $('button[name=reset_pass]').val());
            $.ajax({
                url: "/assets/php/forgot-password.php",
                method: "POST",
                processData: false,
                contentType: false, 
                // cache: false,
                data: formData,
                success:function(response){
                    if(response == 1){
                        $('.reset-password').html('<div class="card-body card-login-body"><div class="col-12"><h3 class="card-title card-title-login">Password changed successfully</h3><div id="response_verify"></div><p>Try logging in with your new password.</p><a href="/login" class="d-flex justify-content-center mt-3 btn btn-primary"><small>Log in</small></a></div></div>');
                    }else if(response == 2){
                        $('#response_reset').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> The password should be at least 8 characters long and must not contain spaces.</div>');
                    }else if(response == 3){
                        $('#response_reset').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> Your passwords do not match.</div>');
                    }else{
                        $('#response_reset').html('<div class="alert alert-danger" role="alert"><span class="bi bi-check-circle-fill" style="width:24px; height:24px" ></span> '+response+'.</div>');
                    }
                    $('button[name=reset_pass]').html('Reset Password');
                    $('button[name=reset_pass]').prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>