<?php include 'includes/dbclass.php';
$dbclass = new db('safa','rootsafa','Ovn7u47&');
$setting = $dbclass->cek("ASSOC","companyinfo",'logo,phone1,phone2,phone3,email,companyAddress,misyon,vizyon,corparateDetail',"where id=?",array(1));
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <base href="https://ustawebci.com/new/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Safa Sağlık </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.png in the root directory -->
    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <!-- header begin -->
    <header>
        <div class="top-bar d-none d-md-block">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <div class="col-xl-6 offset-xl-1 col-lg-6 offset-lg-1 col-md-7 offset-md-1">
                        <div class="header-info">
                            <span><i class="fas fa-phone"></i><?php echo $setting['phone1'];?></span>
                            <span><i class="fas fa-envelope"></i><?php echo $setting['email'];?></span>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-4">
                        <div class="header-top-right-btn f-right">
                            <a href="#" class="btn">Randevu Al</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- menu-area -->
        <div class="header-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-5 d-flex align-items-center">
                        <div class="logo logo-circle pos-rel" >
                            <a href="#"><img style="margin-left:-4px" src="<?php echo $setting['logo'];?>" alt="Safa Sağlık Site Logosu"></a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9">
                        <div class="header-right f-right">
                            <div class="header-social-icons f-right d-none d-xl-block">
                                <ul>
                                    <?php 
                                    $socialmedia = $dbclass->cek("ASSOC_ALL","socialmedia","icon,link,status","where status=?",array(1));
                                    foreach ($socialmedia as $key => $value) { ?>
                                        <li><a href="<?php echo $value['link']?>"><i class="<?php echo $value['icon']?>"></i></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="header__menu f-right">
                            <nav id="mobile-menu">
                                <ul>
                                    <li><a href="#">Anasayfa</a></li>
                                    <li><a href="kurumsal">Kurumsal</a></li>
                                    <li><a href="services.html">Kategoriler +</a>
                                    <ul class="submenu">
                                        <?php 
                                        
                                        $detectedCategoriesCount=$dbclass->cek("KAYITSAY","categories","count(id)","where recordStatus=?",array(1));
                                        if($detectedCategoriesCount>0){
                                            $detectedCategories = $dbclass->cek("ASSOC_ALL","categories","*","where recordStatus=? and mainCategoryId=?",array(1,-1));
                                            foreach ($detectedCategories as $keyCat => $valueCat) { ?>
                                                    <?php 
                                                    $class="";
                                                    $say = $dbclass->cek("KAYITSAY","servicesvscategories","count(id)","where categoriesId=?",array($valueCat['id']));
                                                    if($say>0) $class='sub-dropdown';
                                                    ?>
                                                        <li class="<?php echo $class;?>"><a href="kategori/<?php echo $valueCat['categorySlug']?>"><?php echo $valueCat['categoryName']?> <?php if($class=='sub-dropdown'){echo '<i class="d-none d-lg-inline-block ml-2 fa-solid fa-angle-down"></i>';}?> </a>
                                                    <?php if($say>0){ ?>
                                                        <ul class="sub-menu-2">
                                                        <?php $detectedServices = $dbclass->cek("ASSOC","servicesvscategories","GROUP_CONCAT(servicesId) as ids","where categoriesId=?",array($valueCat['id']))['ids'];
                                                        $allServices = $dbclass->cek("ASSOC_ALL","services","name,slug","where id IN($detectedServices)",array());
                                                        foreach ($allServices as $keyS => $valueS) { ?>
                                                            <li class="font-weight-light"><a href="hizmetlerimiz/<?php echo $valueS['slug']?>"><?php echo $valueS['name'];?></a></li>
                                                        <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                    </li>
                                                   
                                                        
                                                   
                                            <?php } ?>
                                        <?php } ?>
                                        
                                        </ul>
                                    </li>
                                    <li><a href="bloglar">Blog</a></li>
                                    <li><a href="iletisim">İletişim</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->