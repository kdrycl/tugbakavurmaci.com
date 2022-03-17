<?php include 'header.php';
if(isset($_GET)){
    $detectedCategory = $dbclass->cek("ASSOC","categories","*","where categorySlug=?",array($_GET['servicesCategory']));
    $services = $dbclass->cek("ASSOC_ALL","servicesvscategories","services.*","INNER JOIN categories ON categories.id = servicesvscategories.categoriesId INNER JOIN services ON services.id=servicesvscategories.servicesId WHERE categorySlug=? ORDER BY services.id DESC",array($_GET['servicesCategory']));
}
?>
<main>
        <!-- hero-area start -->
        <section class="breadcrumb-bg pt-200 pb-180" data-background="theme/img/page/page-bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="page-title">
                            <p class="small-text pb-15">Hizmetler</p>
                            <h2><?php echo $detectedCategory['categoryName']?></h2>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 d-flex justify-content-start justify-content-md-end align-items-center">
                        <div class="page-breadcumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb ">
                                    <li class="breadcrumb-item">
                                        <a href="/">Anasayfa</a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">Kategori</li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $detectedCategory['categoryName']?></li>
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
                    <?php foreach ($services as $keyservices => $servicesVal) { ?>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="service-box text-center mb-30">
                            <div class="service-thumb">
                                <img src="<?php echo $servicesVal['icon']; ?>" alt="<?php echo $servicesVal['alt']; ?>">
                            </div>
                            <div class="service-content">
                                <h3><a href="hizmetlerimiz/<?php echo $servicesVal['slug'];?>"><?php echo $servicesVal['name'];?></a></h3>
                                <p><?php echo $servicesVal['sorttext'];?></p>
                                <a class="service-link" href="hizmetlerimiz/<?php echo $servicesVal['slug'];?>">Devamını Oku</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- about-area end -->
    </main>

<?php include 'footer.php'; ?>