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
                                    <?php $detectedBlog = $dbclass->cek("ASSOC_ALL","blogs","id,blogName,blogSlug,uniqueId,blogShortDescription","where recordStatus=?  ORDER BY id DESC LIMIT 0,6",array(1));
                                        foreach ($detectedBlog as $keyBlog => $valueBlog) { ?>
                                            <li><a href="blog/<?php echo $valueBlog['blogSlug'] ?>-<?php echo $valueBlog['uniqueId']?>"><?php echo $valueBlog['blogName'] ?></a></li>
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
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAwq-ODsSuAeq_iAup3seV_emodqEIt8WM&sensor=false" 
        type="text/javascript" ></script>
        <script type="text/javascript">
        $("#map").height($(window).height()-$("nav").height()-59);
        var locations = [
        ['Safa Danışmanlık Merkezi', 37.8595339,32.4436243, 4],
        ];

        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,scrollwheel: false,
        center: new google.maps.LatLng(37.8595339,32.4436243),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon: 'uploads/mapmarkernew.png'
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
        }
        })(marker, i));
        }
        </script>
</body>

</html>
