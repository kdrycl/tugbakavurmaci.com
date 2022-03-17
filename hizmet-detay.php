<?php include 'header.php';
$status=false;
if(isset($_GET['slug'])){
    $detectedServicesCount = $dbclass->cek("KAYITSAY","services","count(id)","where slug=?",array($_GET['slug']));
    if($detectedServicesCount>0){
        $detectedServices = $dbclass->cek("ASSOC","services","*","where slug=?",array($_GET['slug']));
    } else $status=true;
} else $status=true;

?>

<main>
        <!-- hero-area start -->
        <section class="breadcrumb-bg pt-200 pb-180" data-background="theme/img/page/page-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="page-title">
                            <p class="small-text pb-15"><?php echo $detectedServices['sorttext'];?></p>
                            <h1><?php echo $detectedServices['name'];?></h1>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex justify-content-start justify-content-md-end align-items-center">
                        <div class="page-breadcumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item">
                                        <a href="/">Anasayfa</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $detectedServices['name'];?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero-area end -->
        <!-- service-details-area start -->
        <div class="service-details-area pt-120 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8">
                        <article class="service-details-box">
                            <div class="service-details-thumb mb-80">
                                <img class="img" src="<?php echo $detectedServices['img'];?>" alt="">
                            </div>
                            <div class="section-title pos-rel mb-45">
                            
                                <div class="section-text pos-rel">
                                    <h5 class="green-color text-up-case">Safa Sağlık Merkezi</h5>
                                    <h2><?php echo $detectedServices['name'];?></h2>
                                </div>
                                <div class="section-line pos-rel">
                                    <img src="theme/img/shape/section-title-line.png" alt="">
                                </div>
                            </div>
                            <div class="service-details-text mb-30">
                                <?php echo $detectedServices['detail'];?>
                            </div>
                           
                        </article>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="service-widget mb-50">
                            <div class="widget-title-box mb-30">
                                <h6 class="widget-title " style="font-size: 35px!important;">Diğer Hizmetlerimiz</h6>
                            </div>
                            <div class="more-service-list">
                                <ul>
                                    <?php $detectedMoreServices = $dbclass->cek("ASSOC_ALL","services","icon2,name,slug","where slug!=? ORDER BY id DESC ",array($_GET['slug']));
                                    foreach ($detectedMoreServices as $keyOther => $valueOther) { ?>
                                        <li>
                                            <a href="hizmetlerimiz/<?php echo $valueOther['slug']?>">
                                                <div class="more-service-icon"><img src="<?php echo $valueOther['icon2']?>" alt="<?php echo $valueOther['name']?>"></div>
                                                <div class="more-service-title"><?php echo $valueOther['name']?></div>
                                            </a>
                                        </li>
                                   <?php } ?>
                                    
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="service-widget mb-50">
                            <div class="widget-title-box mb-30">
                                <h3 class="widget-title">Get Some Advice?</h3>
                            </div>
                            <form class="service-contact-form" action="">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="contact-input contact-icon contact-user mb-20">
                                            <input type="text" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="contact-input contact-icon contact-mail mb-20">
                                            <input type="text" placeholder="Enter your email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="contact-input contact-icon contact-hourglass">
                                            <select name="#" id="service-option">
                                                <option value="1">Select type of care</option>
                                                <option value="2">Select type of care</option>
                                                <option value="2">Select type of care</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="ser-form-btn text-center mt-40">
                                <a data-animation="fadeInLeft" data-delay=".6s" href="#" class="btn btn-icon ml-0" style="animation-delay: 0.6s;"
                                    tabindex="0"><span>+</span>Request for call</a>
                            </div>
                        </div>
                        <div class="service-widget mb-50 border-0 p-0">
                            <div class="banner-widget">
                                <a href="#">
                                    <img src="img/services/services-banner.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- service-details-area end -->
    </main>
<?php include 'footer.php' ?>