<?php 
    include '../assets/php/authentication.php';
    include '../assets/php/database.php';
    include '../assets/php/visit.php';
    $pages = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_pages` WHERE page_id=1 "));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio | <?php echo $pages['page_website_title']; ?></title>

    <!-- Icon -->
    <link <?php if($pages['page_website_icon'] != ''){echo 'href="/assets/img/uploads/'.$pages['page_website_icon'].'"';} ?> rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
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

<body>
    <!-- Header -->
    <?php include '../header.php'; ?>

    <main class="main bg-white">
        <?php if(!isset($_GET['id'])){ ?>
            <!-- ======= Breadcrumbs Section ======= -->
            <section class="breadcrumbs">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Portfolio</h2>
                        <ol>
                            <li><a href="/">Home</a></li>
                            <li>Transparency</li>
                            <li>Portfolio</li>
                        </ol>
                    </div>
                </div>
            </section><!-- Breadcrumbs Section -->
            <div class="container portfolio p-5">
                <div class="section-title">
                    <h3>Portfolio of <span>Activities</span></h3>
                </div>
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <?php 
                                $year_q = (mysqli_query($con, "SELECT YEAR(port_date) AS Year FROM tbl_portfolios GROUP BY YEAR(port_date) ORDER BY YEAR(port_date) desc"));
                                foreach($year_q as $year){
                            ?>
                                <li data-filter=".filter-<?php echo $year["Year"]; ?>"><?php echo $year["Year"]; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php 
                    $query_port = mysqli_query($con, "SELECT * FROM `tbl_portfolios` WHERE port_status = 'Published' ORDER BY port_id DESC");
                    if(mysqli_num_rows($query_port) > 0){
                ?>
                    <div class="row portfolio-container">
                        <?php while($port=mySQLi_fetch_assoc($query_port)){ $image = explode('|',$port['port_image']); $date = date("Y", strtotime($port['port_date']));?>
                            <div class="col-12 row portfolio-item filter-<?php echo $date;?>">
                                <div class="col-md-3">
                                    <img src="/assets/img/portfolio/<?php echo $image[0]?>" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-9">
                                    <h2><?php echo $port['port_title']?></h2>
                                    <p><?php
                                        if(strlen($port['port_notes']) < 700){
                                            echo $port['port_notes'];
                                        }else{
                                            $port_notes = $port['port_notes']." ";
                                            $port_notes = substr($port_notes,0,700);
                                            $port_notes = substr($port_notes,0,strrpos($port_notes,' '));
                                            $port_notes = $port_notes."...";
                                            echo $port_notes;
                                        }
                                    ?></p>
                                    <a href="portfolio?id=<?php echo $port['port_id']?>">See more...</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php }else{ ?>
                    <div class="col-12 d-flex justify-content-center mt-5">
                        <div class="text-center">
                            <i class="bi bi-file-earmark-richtext display-3"></i>
                            <h5>No activity available.</h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }else{ 
            $port = mySQLi_fetch_assoc(mysqli_query($con, "SELECT * FROM `tbl_portfolios` WHERE port_id = '".$_GET['id']."'"))
        ?>
            <!-- ======= Breadcrumbs Section ======= -->
            <section class="breadcrumbs">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Activity Details</h2>
                        <ol>
                            <li><a href="/">Home</a></li>
                            <li>Transparency</li>
                            <li><a href="/transparency/portfolio">Portfolio</a></li>
                            <li>Activity Details</li>
                        </ol>
                    </div>
                </div>
            </section><!-- Breadcrumbs Section -->
            <section id="portfolio-details" class="portfolio-details">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-8">
                            <div class="portfolio-details-slider swiper">
                                <div class="swiper-wrapper align-items-center">
                                <?php $image_explode = explode('|',$port['port_image']);
                                    $count = 1;
                                    foreach ($image_explode as $image) { 
                                        if($count <= 10){?>
                                    <div class="swiper-slide">
                                        <img src="/assets/img/portfolio/<?php echo $image?>" alt="">
                                    </div>
                                <?php }$count++;} ?>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="portfolio-info">
                                <h2><?php echo $port['port_title']?></h2>
                                <ul>
                                    <li><strong>Category</strong>: Web design</li>
                                    <li><strong>Project date</strong>: <?php echo date('d F, Y', strtotime($port['port_date']))?></li>
                                    <hr>
                                    <li><?php echo $port['port_notes']?></li>
                                </ul>
                            </div>
                            <div class="portfolio-description text-center">
                                <a href="/transparency/portfolio"><button class="btn btn-outline-secondary">View other activities</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>
    </main><!-- End #main -->

    <!-- Footer -->
    <?php include '../footer.php'; ?>
    
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
</body>
</html>