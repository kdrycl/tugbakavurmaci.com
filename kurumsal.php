<?php include 'header.php';?>
<main>
        <!-- hero-area start -->
        <section class="breadcrumb-bg pt-200 pb-180" data-background="theme/img/page/page-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="page-title">
                            <p class="small-text pb-15">Safa Sağlık Merkezi</p>
                            <h1>Kurumsal</h1>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex justify-content-start justify-content-md-end align-items-center">
                        <div class="page-breadcumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item">
                                        <a href="/">Anasayfa</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Kurumsal</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero-area end -->
        <!-- about-area start -->
        <section class="about-area pt-120 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-5">
                        <div class="about-left-side pos-rel mb-30">
                            <div class="about-front-img pos-rel">
                                <img src="theme/img/about/about-img.jpg" alt="">
                                <a class="popup-video about-video-btn white-video-btn" href="https://www.youtube.com/watch?v=0w-U7ro6iO8"><i class="fas fa-play"></i></a>
                            </div>
                            <div class="about-shape">
                                <img src="img/about/about-shape.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <div class="about-right-side pt-55 mb-30">
                            <div class="about-title mb-20">
                                <h5>Kurumsal</h5>
                                <h2>Safa Sağlık Merkezi</h2>
                            </div>
                            <div class="about-text mb-50">
                                <p><?php echo $setting['corparateDetail']?></p>
                            </div>
                            <div class="our-destination">
                                <div class="single-item mb-30">
                                    <div class="mv-icon f-left">
                                        <img src="theme/img/about/destination-icon-1.png" alt="">
                                    </div>
                                    <div class="mv-title fix">
                                        <h3>Misyonumuz</h3>
                                        <p><?php echo $setting['misyon']?></p>
                                    </div>
                                </div>
                                <div class="single-item">
                                    <div class="mv-icon f-left">
                                        <img src="theme/img/about/destination-icon-2.png" alt="">
                                    </div>
                                    <div class="mv-title fix">
                                        <h3>Vizyonumuz</h3>
                                        <p><?php echo $setting['vizyon']?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-area end -->
        <!-- Counter Section Satrt -->
        <section class="counter-wraper pt-120 pb-90 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-couter mb-30">
                            <img src="theme/img/counter/counter-icon-1.png" alt="">
                            <div class="counter-text-box">
                                <h1><span class="counter">2174</span>+</h1>
                                <h3>Sigara Bırakma</h3>
                                <p>2174 kişi safa sağlık merkezinde sigarayı bıraktı.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-couter mb-30">
                            <img src="theme/img/counter/counter-icon-2.png" alt="">
                            <div class="counter-text-box">
                                <h1><span class="counter">1456</span>+</h1>
                                <h3>Tam Vücut Taraması</h3>
                                <p>1456 adet tam vücut taramasıyla müşterlerimize hizmet verdik.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-couter mb-30">
                            <img src="theme/img/counter/counter-icon-3.png" alt="">
                            <div class="counter-text-box">
                                <h1><span class="counter">4596</span>+</h1>
                                <h3>Psikolojik Danışmanlık</h3>
                                <p>4596 kişi safa sağlıktan psikolojik danışmanlıkta SAFA SAĞLIK MERKEZ'ini tercih etti.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Counter Section end -->
        <!-- team-area start -->
        <section class="team-area pt-115 pb-55">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-10">
                        <div class="section-title pos-rel mb-75">
                            <div class="section-icon">
                                <img class="section-back-icon back-icon-left" src="img/section/section-back-icon.png" alt="">
                            </div>
                            <div class="section-text pos-rel">
                                <h5>Doktolarımız</h5>
                                <h1>Safa Sağlık Ekibi</h1>
                            </div>
                            <div class="section-line pos-rel">
                                <img src="img/shape/section-title-line.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5">
                        <div class="section-button text-right d-none d-lg-block pt-80">
                            <a data-animation="fadeInLeft" data-delay=".6s" href="#" class="btn btn-icon ml-0"><span>+</span>Randevu Al</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-box text-center mb-60">
                            <div class="team-thumb mb-45 pos-rel">
                                <img src="https://s3-eu-west-1.amazonaws.com/doktortakvimi.com/doctor/b0b428/b0b4286b457775756b42b658753442cc_140_square.jpg" alt="">
                            </div>
                            <div class="team-content">
                                <h3>Uzm. Kl. Psk. Rukiyye Meryem Parladıcı⁠</h3>
                                <h6>Psikoloji, Aile Danışmanlığı</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- team-area end -->
    </main>
<?php include 'footer.php';?>
