<footer>
            <div class="footer-top primary-bg pt-115 pb-90">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 col-md-8">
                            <div class="footer-contact-info mb-30">
                                <div class="emmergency-call fix">
                                    <div class="emmergency-call-icon f-left">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="emmergency-call-text f-left">
                                        <h6>İletişim Numaramız</h6>
                                        <span><?php echo $setting['phone1'];?></span>
                                    </div>
                                </div>
                                <div class="footer-logo mb-35">
                                    <a href=""><img src="<?php echo $setting['logo'];?>" alt="Safa Sağlık Footer Logo"></a>
                                </div>
                                <div class="footer-contact-content mb-25">
                                    <p>Safa sağlık merkezi olarak 2018 yılından itibaren Konya'da hizmetlerimiz devam etmektedir.</p>
                                </div>
                                <div class="footer-emailing">
                                    <ul>
                                        <li><i class="far fa-envelope"></i><?php echo $setting['phone1'];?></li>
                                        <li><i class="far fa-flag"></i><?php echo $setting['companyAddress'];?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 offset-xl-1 col-lg-3 col-md-4">
                            <div class="footer-widget mb-30">
                                <div class="footer-title">
                                    <h3>Hizmetlerimiz</h3>
                                </div>
                                <div class="footer-menu">
                                    <ul>
                                        <?php 
                                        $services = $dbclass->cek("ASSOC_ALL","services","id,name,sorttext,img,slug","where status=? ORDER BY sort ASC LIMIT 0,6",array(1));
                                        foreach ($services as $keyservices => $servicesVal) { ?>
                                            <li><a href="hizmetlerimiz/<?php echo $servicesVal['slug'];?>"><?php echo $servicesVal['name'];?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 offset-xl-1 col-lg-3 d-md-none d-lg-block">
                            <div class="footer-widget mb-30">
                                <div class="footer-title">
                                    <h3>Son Yazılar</h3>
                                </div>
                                <div class="footer-menu">
                                    <ul>
                                    <?php $detectedBlog = $dbclass->cek("ASSOC_ALL","blogs","id,blogName,blogSlug,blogShortDescription","where recordStatus=?  ORDER BY id DESC LIMIT 0,6",array(1));
                                        foreach ($detectedBlog as $keyBlog => $valueBlog) { ?>
                                            <li><a href="<?php echo $valueBlog['blogSlug'] ?>"><?php echo $valueBlog['blogName'] ?></a></li>
                                    <?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom pt-25 pb-20">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="footer-copyright text-center">
                                <p class="white-color">Copyright @ Safa Sağlık Merkezi 2022 - Tüm Hakları Saklıdır  <br> <a class="white-color" href="https://seratumedya.com" target="_blank">Seratu Medya Konya Reklam Ajansı</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- JS here -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/one-page-nav-min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/jquery.meanmenu.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
