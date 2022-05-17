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
    <title>Log in | <?php echo $pages['page_website_title']; ?></title>

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
                        <li>Log in</li>
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
                        <!-- jquery validation -->
                        <div class="card card-primary card-login col-12 px-0">
                            <!-- form start -->
                            <form class="needs-validation" action="/assets/php/login.php" method="post" novalidate>
                                <div class="card-body card-login-body">
                                    <div class="col-12">
                                        <h3 class="card-title card-title-login">Welcome</h3>
                                        <!-- Success/Error -->
                                        <?php if (isset( $_SESSION['succeserror'])) {  echo $_SESSION['succeserror']; } unset($_SESSION['succeserror']); ?>
                                        <div class="form-floating mb-3">
                                            <input name="username" type="text" class="form-control" placeholder=" "required>
                                            <span class="focus-border"></span>
                                            <label>Username</label>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="form-floating col-11">
                                                <input name="password" type="password" id="password" class="form-control" placeholder=" " required>
                                                <span class="focus-border"></span>
                                                <label>Password</label>
                                            </div>
                                            <span class="col-1" type="button"><i class="bi bi-eye-slash btn col-12 fs-5 mt-2" id="togglePassword"></i></span>
                                        </div>
                                        <button name="login_submit" id="submit" type="submit" class="btn btn-block form-btn btn-primary col-12">Log in</button>
                                        <a href="/forgot-password" class="d-flex justify-content-center mt-3 "><small>Forgot Password</small></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
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
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>
</body>
</html>