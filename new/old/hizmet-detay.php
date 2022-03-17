<?php include 'header.php';
$status=false;
if(isset($_GET['slug'])){
    $detectedServicesCount = $dbclass->cek("KAYITSAY","services","count(id)","where slug=?",array($_GET['slug']));
    if($detectedServicesCount>0){
        $detectedServices = $dbclass->cek("ASSOC","services","*","where slug=?",array($_GET['slug']));
    } else $status=true;
} else $status=true;
if($status==true){
    echo '<script>window.location.href="https://safasaglik.com"</script>';
}
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
        <section>
            <div class="service-details-area pt-120 pb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <article class="service-details-box">
                                <div class="service-details-thumb mb-80">
                                    <img class="img" src="<?php echo $detectedServices['img'];?>" alt="">
                                </div>
                                <div class="section-title pos-rel mb-45">
                                
                                    <div class="section-text pos-rel">
                                        <h5 class="green-color text-up-case">Safa Danışmanlık Merkezi</h5>
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
                        
                    
                    </div>
                </div>
            </div>
        </section>

        <!-- service-details-area end -->

        <section class="servcies-area gray-bg pt-115 pb-90">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-8 col-md-12">
                        <div class="section-title pos-rel mb-75">
                            <div class="section-icon">
                                <img class="section-back-icon back-icon-left" src="theme/img/section/section-back-icon.png" alt="">
                            </div>
                            <div class="section-text pos-rel">
                                <h5>Kategori Adı</h5>
                                <h2>Diğer Hizmetlerimiz</h2>
                            </div>
                            <div class="section-line pos-rel">
                                <img src="img/shape/section-title-line.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        <div class="section-button text-right d-none d-lg-block pt-80">
                            <a data-animation="fadeInLeft" data-delay=".6s" href="iletisim"
                                class="btn btn-icon ml-0"><span>+</span>Bize Ulaşın</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                <?php $detectedMoreServices = $dbclass->cek("ASSOC_ALL","services","img,name,slug,sorttext","where slug!=? ORDER BY id DESC LIMIT 0,6",array($_GET['slug']));
                    foreach ($detectedMoreServices as $keyOther => $valueOther) { ?>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="service-box-3 mb-30 text-center">
                            <div class="service-thumb">
                                <a href="hizmetlerimiz/<?php echo $valueOther['slug']?>"><img src="<?php echo $valueOther['img']?>" alt="<?php echo $valueOther['name']?> resmi"></a>
                            </div>
                            <div class="service-content-box">
                                <div class="service-content">
                                    <h3><a href="hizmetlerimiz/<?php echo $valueOther['slug']?>"><?php echo $valueOther['name']?></a></h3>
                                    <p><?php echo $valueOther['sorttext']?></p>
                                </div>
                                <a href="hizmetlerimiz/<?php echo $valueOther['slug']?>" class="service-link">Detaylı İncele</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    
                </div>
            </div>
        </section>
    </main>
<?php include 'footer.php' ?>