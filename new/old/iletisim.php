<?php include 'header.php' ?>

<main>
        <!-- hero-area start -->
        <section class="breadcrumb-bg pt-200 pb-180" data-background="theme/img/page/page-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="page-title">
                            <p class="small-text pb-15">Safa Sağlık İletişim</p>
                            <h1>İletişim</h1>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex justify-content-start justify-content-md-end align-items-center">
                        <div class="page-breadcumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item">
                                        <a href="/">Anasayfa</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">İletişim</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero-area end -->

        <!-- contact-area start -->
        <section class="contact-area pt-120 pb-90" data-background="assets/img/bg/bg-map.png">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="contact text-center mb-30">
                            <i class="fas fa-envelope"></i>
                            <h3>Mail Adresimiz</h3>
                            <p><?php echo $setting['email']?></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="contact text-center mb-30">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3>Adresimiz</h3>
                            <p><?php echo $setting['companyAddress']?></p>

                        </div>
                    </div>
                    <div class="col-xl-4  col-lg-4 col-md-4 ">
                        <div class="contact text-center mb-30">
                            <i class="fas fa-phone"></i>
                            <h3>İletişim Numaralarımız</h3>
                            <p><?php echo $setting['phone1']?></p>
                            <p><?php echo $setting['phone2']?></p>
                            <p><?php echo $setting['phone3']?></p>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-area end -->
        <section class="map-area">
        <!-- <div class="container-fluid">
            <div id="map" style="width: 100%; height:200;"></div>
        </div> -->
            <div id="map" class="contact-map"></div>
        </section>
    </main>

    

<?php include 'footer.php'; ?>