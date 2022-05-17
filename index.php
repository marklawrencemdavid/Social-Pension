<?php 
    include 'assets/php/authentication.php';
    include 'assets/php/database.php';
    include 'assets/php/visit.php';
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
    $appl = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `tbl_applicants` WHERE appl_status = 'Active'"));
    $port_query = mysqli_query($con, "SELECT * FROM `tbl_portfolios` WHERE port_status = 'Published' ORDER BY port_id DESC LIMIT 9");
    $faq_query = mysqli_query($con, "SELECT * FROM `tbl_faqs` WHERE faq_status = 'Published' ORDER BY faq_id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $pages['page_website_title']; ?></title>
    <meta name="description" content="Social pension for indigent senior citizens">
    <meta name="keywords" content="Social pension for indigent senior citizens, Social Pension, Pension, Senior citizens, Senior, Indigent">

    <!-- Favicons -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/css/bootstrap.min.css" integrity="sha512-SCpMC7NhtrwHpzwKlE1l6ks0rS+GbMJJpoQw/A742VaxdGcQKqVD8F/y/m9WLOfIPppy7mWIs/kS0bKgSI0Bfw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css" integrity="sha512-9a1QYep56cYgIPFq0JYfsh9xRYYmPBxKaD6/ZfVAtplQ6y9ZUSk7GxgC2dmwtxK9T2cGQOxCV6J2Ll51nrvP2w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.css" integrity="sha512-FuMUgHw8jwC1ABBFQITwogq7Q3hdvZnRJcuITfmmnP5JMY81yuC4nojF0aD1fVdRb/CxNaggJtsDdUcQgK21hQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php' ?>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center"  style="background-color: #f6f9fe; <?php if($pages['page_header_back_image'] != 'no_image.png'){echo "background: url('assets/img/uploads/".$pages['page_header_back_image']."') top left;";}?> background-attachment: fixed; background-size: cover;">
        <div class="container container-index" data-aos="zoom-out" data-aos-delay="100">
            <h1>Welcome to <span><?php echo $pages['page_header_info_title'];?></span></h1>
            <h2><?php echo $pages['page_header_info_text']; ?>...</h2>
            <div class="d-flex">
                <a href="<?php if (isset($_SESSION['acc_id'])){echo 'javascript:void(0)';}else{echo '/register-for-social-pension';} ?>" class="btn-get-started scrollto" >Register for Social Pension</a>
                <a href="<?php echo $pages['page_demo_website'];?>" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main class="main">
        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0">
                        <a href="<?php if (isset($_SESSION['acc_id'])){echo 'javascript:void(0)';}else{echo '/register-for-social-pension';} ?>">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon"><i class="bx bxs-file-plus"></i><span>Social Pension</span></div>
                                <h4 class="title"><p>Register for SPISC</p></h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0">
                        <a href="/transparency/portfolio.php">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon"><i class="bx bx-folder"></i><span>OSCA Activities</span></div>
                                <h4 class="title"><p>Portfolio</p></h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0">
                        <a href="/transparency/accomplishment-report.php">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon"><i class="bx bx-file"></i><span>Accomplisments</span></div>
                                <h4 class="title"><p>Reports</p></h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 align-items-stretch mb-5 mb-lg-0">
                        <a href="/contact-us.php">
                            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                <div class="icon"><i class="bx bx-phone"></i><span>Email or Phone No.</span></div>
                                <h4 class="title"><p>Contact Us</p></h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section><!-- End Featured Services Section -->
        <!-- ======= About Section ======= -->
        <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>About</h2>
                    <h3><?php echo $pages['page_about_title']; ?></h3>
                    <p><?php echo $pages['page_about_description']; ?></p>
                </div>
              <div class="row">
                  <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
                      <img src="<?php if($pages['page_about_image'] != 'no_image.png'){echo "assets/img/uploads/".$pages['page_about_image'];}?>" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
                      <center><h3><?php echo $pages['page_about_par_title']; ?></h3></center>
                      <p class="text-justify"><?php echo $pages['page_about_para_text']; ?></p>
                  </div>
              </div>
            </div>
        </section><!-- End About Section -->
        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-map"></i><?php $page_barangay = explode(',',$pages['page_barangay']); $page_barangay_count = count($page_barangay) ?>
                            <span data-purecounter-start="0" data-purecounter-end="<?php echo $page_barangay_count;?>" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Barangay</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                        <div class="count-box">
                            <i class="bi bi-person"></i>
                            <span data-purecounter-start="0" data-purecounter-end="<?php echo $page_barangay_count;?>" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Barangay Presidents</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-people"></i>
                            <span data-purecounter-start="0" data-purecounter-end="<?php echo $appl;?>" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Pensioners</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-clock"></i>
                            <span class="d-flex justify-content-center">
                                <span><?php echo date("h:ia", strtotime($pages['page_avail_time_to']));?></span>
                                <span> - </span>
                                <span><?php echo date("h:ia", strtotime($pages['page_avail_time_from']));?></span>
                            </span>
                            <p>Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Counts Section -->
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Portfolio</h2>
                    <h3>Recent <span>Activities</span></h3>
                </div>
                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    <?php 
                        if(mysqli_num_rows($port_query) > 0){
                        while ($port = mysqli_fetch_assoc($port_query)) { 
                            $image_explode = explode('|',$port['port_image']);
                            $image = $image_explode[0];
                            ?>
                            <div class="col-lg-4 col-md-6 portfolio-item">
                                <img src="assets/img/portfolio/<?php echo $image?>" class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4><?php echo $port['port_title']?></h4>
                                    <a href="/assets/img/portfolio/<?php echo $image?>" data-gall="portfolioGallery" class="portfolio-lightbox preview-link" title="<?php echo $port['port_title']?>"><i class="bx bx-zoom-in"></i></a>
                                    <a href="/transparency/portfolio?id=<?php echo $port['port_id']?>" class="details-link" title="More Details"><i class="bx bx-file"></i></a>
                                </div>
                            </div>
                    <?php }}else{ ?>
                        <div class="portfolio-item justify-content-center mt-5">
                            <div class="text-center">
                                <i class="bi bi-file-earmark-richtext display-3"></i>
                                <h5>No activity available.</h5>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section><!-- End Portfolio Section -->
        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>F.A.Q</h2>
                    <h3>Frequently Asked <span>Questions</span></h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <?php if(mysqli_num_rows($faq_query) > 0){ ?>
                            <ul class="faq-list">
                                <?php $c=1; while($faq = mysqli_fetch_assoc($faq_query)) { ?>
                                    <li>
                                        <div data-bs-toggle="collapse" class="collapsed question" href="#a<?php echo $c?>"><?php echo $faq['faq_question'] ?><i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
                                        <div id="a<?php echo $c?>" class="collapse" data-bs-parent=".faq-list">
                                            <p><?php echo $faq['faq_answer'] ?></p>
                                        </div>
                                    </li>
                                <?php $c++; } if(mysqli_num_rows($faq_query) > 0){?>
                                <p class="text-center p-0"><a href="/frequently-asked-questions.php">View All</a></p>
                                <?php } ?>
                            </ul>
                        <?php }else{ ?>
                            <div class="justify-content-center mt-5">
                                <div class="text-center">
                                    <i class="bi bi-question-circle display-3"></i>
                                    <h5>There are no frequently asked questions at the moment.</h5>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section><!-- End Frequently Asked Questions Section -->
        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Contact Us</h2>
                    <h3>Get In <span>Touch</span></h3>
                    <div class="row d-flex justify-content-center">
                        <?php if($pages['page_facebook'] != ''){ ?>
                            <h4><a href="<?php echo $pages['page_facebook']; ?>" target="_blank"><i class="bi bi-facebook"></i></a></h4>
                        <?php } ?>
                        <?php if($pages['page_instagram'] != ''){ ?>
                            <h4><a href="<?php echo $pages['page_instagram']; ?>" target="_blank"><i class="bi bi-instagram"></i></a></h4>
                        <?php } ?>
                        <?php if($pages['page_twitter'] != ''){ ?>
                            <h4><a href="<?php echo $pages['page_twitter']; ?>" target="_blank"><i class="bi bi-twitter"></i></a></h4>
                        <?php } ?>
                        <?php if($pages['page_skype'] != ''){ ?>
                            <h4><a href="<?php echo $pages['page_skype']; ?>" target="_blank"><i class="bi bi-skype"></i></a></h4>
                        <?php } ?>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p><?php echo $pages['page_address']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p><?php echo $pages['page_email']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>+63 <?php echo $pages['page_contactno']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6">
                        <?php 
                            $src = explode('"', $pages['page_map']);
                            echo '<iframe class="mb-4 mb-lg-0" src="'.$src[1].'" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>';
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <form action="/assets/php/contact-us.php" method="post" role="form" class="php-email-form">
                            <input name="pot" type="text" class="visually-hidden">
                            <div class="form-row">
                                <div class="col form-group form-floating">
                                    <input type="text" class="form-control" name="name" placeholder=" " required/>
                                    <span class="focus-border"></span>
                                    <label>Full name</label>
                                </div>
                                <div class="col form-group form-floating">
                                    <input type="email" class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder=" " required/>
                                    <span class="focus-border"></span>
                                    <label>your@email.com</label>
                                </div>
                            </div>
                            <div class="col form-group form-floating">
                                <textarea class="form-control" name="message" placeholder=" " style="height: 105px" required></textarea>
                                <span class="focus-border"></span>
                                <label>Your message</label>
                            </div>
                            <div class="mb-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit" name="contact_submit" class="btn btn-primary">Send Message</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main><!-- End #main -->

    <?php include 'footer.php' ?>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/js/bootstrap.bundle.min.js" integrity="sha512-lAJppLlFlj2g7mb8jrbx34cdZcB24LLIK0N4U0rZtRPoY4oq9uiRXBbigPzGmzN5EXiDn0yMLIBjf0+E/alhXg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/assets/vendor/php-email-form/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/7.0.8/swiper-bundle.min.js" integrity="sha512-TEY9MppoX49BydDCCSsdqDUihEAEdO2S2En3WRjPoM+4wBkLtE7HKJ/Xt34c46/XM0Qxf6+F5caDMejengSDdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/noframework.waypoints.min.js" integrity="sha512-fHXRw0CXruAoINU11+hgqYvY/PcsOWzmj0QmcSOtjlJcqITbPyypc8cYpidjPurWpCnlB8VKfRwx6PIpASCUkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Main JS File -->
    <script src="/assets/js/main.js"></script>
    <script>
        (function() {
            "use strict";
            /**
             * Animation on scroll
             */
            window.addEventListener('load', () => {
                AOS.init({
                    duration: 1000,
                    easing: 'ease-in-out',
                    once: true,
                    mirror: false
                })
            });
        })()
    </script>
</body>
</html>