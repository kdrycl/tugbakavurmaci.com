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
        <!-- calculate-area start -->
        <section class="calculate-area pos-rel pt-115 pb-120" data-background="img/calculate/calculate-bg.png">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-6 col-md-10">
                        <div class="section-title calculate-section pos-rel mb-45">
                            <div class="section-text section-text-white pos-rel">
                                <h5>make a call</h5>
                                <h1 class="white-color">Quote Calculator</h1>
                                <p>If you require services on a public holiday, overnight services or live-in services, please call (+00)888.666.88 so we
                                can discuss prices with you.</p>
                            </div>
                        </div>
                        <div class="section-button section-button-left mb-30">
                            <a data-animation="fadeInLeft" data-delay=".6s" href="#" class="btn btn-icon btn-icon-green ml-0"><span>+</span>Make Appointment</a>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="calculate-box white-bg">
                            <div class="calculate-content">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <select>
                                            <option value="1">When would you like our support?</option>
                                            <option value="2">When would you like our support?</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <select>
                                            <option value="1">When would you like us arrive?</option>
                                            <option value="2">When would you like our support?</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <select>
                                            <option value="1">How long should we stay?</option>
                                            <option value="2">When would you like our support?</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <select>
                                            <option value="1">Where are you located?</option>
                                            <option value="2">When would you like our support?</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <form class="calculate-form" action="#">
                                            <input type="text" placeholder="Your Phone number">
                                            <i class="fas fa-phone"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <a href="" class="btn mt-40">submit query</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- calculate-area end -->
        <!-- hiring-area start -->
        <section class="hiring-area pt-120 pb-120">
            <div class="container">
                <div class="row no-gutters hire-bg-2">
                    <div class="col-xl-6 col-lg-6">
                        <div class="hire-img">
                            <img class="img" src="img/hire/hire1.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="hire-text">
                            <h1>For Employers</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna
                                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo consequat.
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur. Excepteur sint
                                occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <a data-animation="fadeInLeft" data-delay=".6s" href="contact.html"
                                class="btn btn-icon btn-icon-green ml-0"><span>+</span>Contact us</a>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters hire-bg">
                    <div class="col-xl-6 col-lg-6">
                        <div class="hire-text">
                            <h1>For Employers</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                labore et
                                dolore magna
                                aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                                commodo
                                consequat.
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur.
                                Excepteur sint
                                occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                            <a data-animation="fadeInLeft" data-delay=".6s" href="#"
                                class="btn btn-icon ml-0"><span>+</span>apply today</a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="hire-img">
                            <img class="img" src="img/hire/hire2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hiring-area end -->
    </main>

<?php include 'footer.php'; ?>