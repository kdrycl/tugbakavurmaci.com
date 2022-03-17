<?php 
  include('temp/dbclassinclude.php'); 
  $productControl=$dbclass->cek("KAYITSAY","products","COUNT(id)","WHERE productSlug=? AND recordStatus=?",array($_GET['slug'],1));
  if ($productControl>0) {
  $productDetail=$dbclass->cek("ASSOC","products","*","WHERE productSlug=?",array($_GET['slug']));
  $productImages=$functions->imageDetected($dbclass,2,$productDetail['uniqueId']);
  $categoryDetected=$dbclass->cek("KAYITSAY","categories","count(categories.id)","INNER JOIN productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=? AND categories.langCode=?",array($productDetail['uniqueId'],$_SESSION['lang']['langCode']));
  if($categoryDetected>0) {
    $categoryDetected=$dbclass->cek("ASSOC","categories","categories.*","INNER JOIN productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=? AND categories.langCode=?",array($productDetail['uniqueId'],$_SESSION['lang']['langCode']));
    $categoryName=$categoryDetected['categoryName'];
    $categorySlug=$categoryDetected['categorySlug'];
  }
  else {
    $categoryName="Kategori Bulunamadı";
    $categorySlug="kategori-bulunamadi";
  }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?php echo $productDetail['seoKeywords']; ?>">
<meta name="description" content="<?php echo $productDetail['seoDescription']; ?>">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title><?php echo $productDetail['seoTitle']; ?></title>
<?php include('temp/head-tags.php'); ?>
</head>
 
<body>

<div class="boxed_wrapper">
  <?php include('temp/header.php'); ?>
  <!-- Page Title -->
  <section class="page-title about-page-5 style-two p_relative centred">
    <div class="pattern-layer">
      <div class="shape-1 p_absolute l_120 t_120 rotate-me" style="background-image: url(assets/images/shape/shape-176.png);"></div>
      <div class="shape-2 p_absolute t_180 r_170 float-bob-y" style="background-image: url(assets/images/shape/shape-56.png);"></div>
      <div class="shape-3 p_absolute l_0 b_0" style="background-image: url(assets/images/shape/shape-189.png);"></div>
    </div>
    <div class="auto-container">
      <div class="content-box">
        <h1 class="d_block fs_60 lh_70 fw_bold mb_10"><?php echo $productDetail['productName']; ?></h1>
        <ul class="bread-crumb p_relative d_block mb_8 clearfix">
          <li class="p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inte mr_20"><a href="/">Anasayfa</a></li>
          <li class="p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inte mr_20"><a href="/<?php echo $categorySlug; ?>"><?php echo $categoryName; ?></a></li>
          <li class="current p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inte"><?php echo $productDetail['productName']; ?></li>
        </ul>
      </div>
    </div>
  </section>
  <!-- End Page Title -->

  <!-- service-details -->
  <section class="service-details service-details-3 p_relative sec-pad">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
          <div class="service-sidebar p_relative d_block mr_30 text-center">
            <div class="contact-widget sidebar-widget p_relative d_block mb_50">
              <figure class="image p_relative d_block mb_20"><img src="<?php echo $productImages[0][1]; ?>" alt="<?php echo $productDetail['productName']; ?>"></figure>
              <p class="font_family_poppins mb_25 px-4"><?php echo $productDetail['productShortDescription']; ?></p>
              <div class="widget-title p_relative d_block mb_17 px-4">
                <h3 class="d_block fs_24 lh_30 fw_sbold"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT001")[0]; ?></h3>
              </div>
              <div class="text p_relative d_block mb_18 px-4">
                <p class="fs_16 font_family_poppins color_black fw_medium"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT002")[0]; ?></p>
              </div>
              <ul class="info-list clearfix px-4"> 
                <li class="p_relative d_block fs_15 font_family_inter color_black mb_10"><i class="icon-2"></i><br><a href="tel:0<?php echo $companyInfo['phone1']; ?>" class="d_iblock color_black">0<?php echo $companyInfo['phone1']; ?></a></li>
                <li class="p_relative d_block fs_15 font_family_inter color_black mb_10"><i class="fab fa-whatsapp"></i><br><a href="https://wa.me/90<?php echo $companyInfo['phone3']; ?>" class="d_iblock color_black">0<?php echo $companyInfo['phone3']; ?></a></li>
                <li class="p_relative d_block fs_15 font_family_inter color_black"><i class="icon-3"></i><br><a href="mailto:<?php echo $companyInfo['mail1']; ?>" class="d_iblock color_black"><?php echo $companyInfo['mail1']; ?></a></li>
              </ul>
              <ul class="social-links clearfix p_relative d_block mt_18 px-4 pb-4">
                <li class="p_relative d_iblock mr_10"><a href="<?php echo $companyInfo['facebook']; ?>" class="p_relative d_iblock fs_17"><i class="fab fa-facebook-f"></i></a></li>
                <li class="p_relative d_iblock mr_10"><a href="<?php echo $companyInfo['twitter']; ?>" class="p_relative d_iblock fs_17"><i class="fab fa-twitter"></i></a></li>
                <li class="p_relative d_iblock mr_10"><a href="<?php echo $companyInfo['instagram']; ?>" class="p_relative d_iblock fs_17"><i class="fab fa-instagram"></i></a></li>
              </ul> 
            </div>
            <?php
                $benzerUrunler=$dbclass->cek("ASSOC_ALL","products","*","WHERE  products.recordStatus=? AND products.langCode=? LIMIT 0, 6",array(1,"TR"));
            ?>
            <div class="category-widget p_relative d-none d-lg-block mb_55">
              <div class="widget-title p_relative d_block mb_25">
                <h3 class="d_block fs_24 lh_30 fw_sbold"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT003")[0]; ?></h3>
              </div>
              <ul class="category-list clearfix">
                <?php 
                  foreach ($benzerUrunler as $key => $value) {
                    echo '<li class="p_relative d_block mb_10"><a href="'.$productMainSlug.'/'.$value['productSlug'].'" class="p_relative d_block fs_16 fw_sbold font_family_inter">'.$value['productName'].'</a></li>';
                  }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 content-side">
            <div class="service-details-content">
              <div class="content-two p_relative d_block mb_60">
                <div class="image_block_one">
                  <div class="image-box p_relative d_block">
                    <div class="skills-box text-center">
                      <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 progress-block">
                          <div class="single-progress-box p_relative d_block pt_30 pr_30 pb_30 pl_30 b_shadow_6 b_radius_10">
                            <div class="box">
                              <div class="piechart_2 p_relative mb_15"  data-fg-color="#18be74" data-value=".<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT004")[0]; ?>">
                                <span>.<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT004")[0]; ?></span>
                              </div>
                              <h5 class="d_block fs_17 lh_20 fw_sbold mb_0"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT005")[0]; ?></h5>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 progress-block">
                          <div class="single-progress-box p_relative d_block pt_30 pr_30 pb_30 pl_30 b_shadow_6 b_radius_10">
                            <div class="box">
                              <div class="piechart_2 p_relative mb_15"  data-fg-color="#18be74" data-value=".<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT006")[0]; ?>">
                                <span>.<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT006")[0]; ?></span>
                              </div>
                              <h5 class="d_block fs_17 lh_20 fw_sbold mb_0"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT007")[0]; ?></h5>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 progress-block">
                          <div class="single-progress-box p_relative d_block pt_30 pr_30 pb_30 pl_30 b_shadow_6 b_radius_10">
                            <div class="box">
                              <div class="piechart_2 p_relative mb_15"  data-fg-color="#18be74" data-value=".<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT008")[0]; ?>">
                                <span>.<?php echo $functions->constDefinitions($dbclass,"PRODET","PDT008")[0]; ?></span>
                              </div>
                              <h5 class="d_block fs_17 lh_20 fw_sbold mb_0"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT009")[0]; ?></h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="content-one p_relative d_block mb_65">
                <div class="text p_relative d_block mb_60">
                  <p class="font_family_poppins mb_25"><?php echo $productDetail['productLongDescription']; ?></p>
                </div>
              </div>
              <div class="subscribe-five home-12 p_relative pb_150">
                <div class="auto-container">
                  <div class="row clearfix">
                    <div class="col-lg-10 col-md-12 col-sm-12 inner-column offset-lg-1">
                      <div class="inner-box">
                        <div class="text p_relative d_block mb_30 centred">
                          <h2 class="d_block fs_35 lh_50 fw_bold font_family_jost"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT010")[0]; ?></h2>
                        </div>
                        <div class="form-inner p_relative d_block mt_5">
                            <div class="message-btn text-center">
                              <a href="tel:0<?php echo $companyInfo['phone1']; ?>" class="theme-btn theme-btn-five"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT011")[0]; ?> <i class="fa fa-phone"></i></a>
                              <a href="https://wa.me/90<?php echo $companyInfo['phone3']; ?>" class="theme-btn theme-btn-four"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT012")[0]; ?> <i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- service-details -->
  
  <?php include("temp/footer.php"); ?>
</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
</body>
</html>
<?php }
else{
  header('Location: 404');
}