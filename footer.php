<?php
    $curPageName = basename($_SERVER['PHP_SELF']);
    if ($curPageName == 'footer.php') {header('location: /');}
?>
<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-newsletter">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <?php if($pages['page_website_icon'] != 'no_image.png'){ ?>
                            <img src="/assets/img/uploads/<?php echo $pages['page_website_icon']; ?>" class="rounded-circle img-fluid me-2" alt="" width="50px">
                        <?php } ?>
                        <h3 class="mb-0"> <?php echo $pages['page_website_title']; ?></h3>
                    </div>
                    <hr>
                    <p class="text-start"><?php echo $pages['page_footer_desc']; ?></p>
                </div>
                <div class="col-lg-4">
                    <h4><?php echo $pages['page_footer_news_title']; ?></h4>
                    <p><?php echo $pages['page_footer_news_text']; ?></p>
                    <form id="subsForm" class="needs-validation" novalidate>
                        <input type="email" name="email" id="subs_email" placeholder="ex. your@email.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                        <input type="submit" value="Subscribe">
                        <div class="invalid-feedback">Please follow the format "ex. your@email.com"</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-top bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 footer-links">
                    <img src="/assets/img/default/RepOfPH.png" alt="Republic of the Philippines" class="img-thumbnail border-0 p-0 bg-transparent">
                </div>
                <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>REPUBLIC OF THE PHILIPPINES</h4>
                    <p>All content is in the public domain unless otherwise stated.</p>
                </div>
                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>ABOUT GOVPH</h4>
                    <p>Learn more about the Philippine government, its structure, how government works and the people behind it.</p>
                    <br>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://www.gov.ph/">GOV.PH</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://www.gov.ph/data/">Open Data Portal</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://www.officialgazette.gov.ph/">Official Gazette</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>GOVERNMENT LINKS</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://president.gov.ph/" target="_blank">Office of the President</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://www.ovp.gov.ph/" target="_blank">Office of the Vice President</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="http://legacy.senate.gov.ph/">Senate of the Philippines</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://www.congress.gov.ph/">House of Representatives</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://sc.judiciary.gov.ph/">Supreme Court</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://ca2.judiciary.gov.ph/caws-war/">Court of Appeals</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="https://sb.judiciary.gov.ph/">Sandiganbayan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>