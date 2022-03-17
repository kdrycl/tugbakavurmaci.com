<?php 
  include('temp/dbclassinclude.php'); 
  $pageControl=$dbclass->cek("KAYITSAY","pages","COUNT(id)","WHERE pageSlug=? AND recordStatus=?",array($_GET['slug'],1));
  if ($pageControl>0) {
    $pageDetail=$dbclass->cek("ASSOC","pages","*","WHERE pageSlug=?",array($_GET['slug']));
    $pageImages=$functions->imageDetected($dbclass,7,$pageDetail['uniqueId']);
    $categoryDetected=$dbclass->cek("KAYITSAY","categories","count(categories.id)","INNER JOIN pagesVsCategories ON pagesVsCategories.categoryId = categories.uniqueId WHERE pagesVsCategories.pageId=? AND categories.langCode=?",array($pageDetail['uniqueId'],$_SESSION['lang']['langCode']));
    if($categoryDetected>0) {
      $categoryDetected=$dbclass->cek("ASSOC","categories","categories.*","INNER JOIN pagesVsCategories ON pagesVsCategories.categoryId = categories.uniqueId WHERE pagesVsCategories.pageId=? AND categories.langCode=?",array($pageDetail['uniqueId'],$_SESSION['lang']['langCode']));
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
<meta name="keywords" content="<?php echo $pageDetail['seoKeywords']; ?>">
<meta name="description" content="<?php echo $pageDetail['seoDescription']; ?>">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title><?php echo $pageDetail['seoTitle']; ?></title>
<?php include('temp/head-tags.php'); ?>
</head>
 
<body>

<div class="boxed_wrapper">
  <?php include('temp/header.php'); ?>
  <!-- Page Title -->
  <section class="page-title about-page-3 p_relative centred mt_110">
    <div class="bg-layer p_absolute l_0 parallax_none parallax-bg" data-parallax='{"y": 100}' style="background-image: url(assets/images/background/page-title-3.jpg);"></div>
    <div class="auto-container">
      <div class="content-box">
        <h1 class="d_block fs_60 lh_70 fw_bold mb_10"><?php echo $pageDetail['pageName']; ?></h1>
        <ul class="bread-crumb p_relative d_block mb_8 clearfix">
          <li class="p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter mr_20"><a href="/">Anasayfa</a></li>
          <li class="current p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter"><?php echo $pageDetail['pageName']; ?></li>
        </ul>
      </div>
    </div>
  </section>
  <!-- End Page Title -->
  <!-- feature-13 -->
  <section class="feature-13 about-page-4 p_relative pt_110 pb_110 centred">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
          <div class="feature-block-eight wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block pt_50 pr_30 pb_45 pl_30">
              <div class="text">
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_18"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD001")[0]; ?></h4>
                <p class="font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD002")[0]; ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
          <div class="feature-block-eight wow fadeInUp animated" data-wow-delay="200ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block pt_50 pr_30 pb_45 pl_30">
              <div class="text">
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_18"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD003")[0]; ?></h4>
                <p class="font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD004")[0]; ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
          <div class="feature-block-eight wow fadeInUp animated" data-wow-delay="400ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block pt_50 pr_30 pb_45 pl_30">
              <div class="text">
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_18"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD005")[0]; ?></h4>
                <p class="font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD006")[0]; ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 feature-block">
          <div class="feature-block-eight wow fadeInUp animated" data-wow-delay="600ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block pt_50 pr_30 pb_45 pl_30">
              <div class="text">
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_18"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD007")[0]; ?></h4>
                <p class="font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"PGEDET","PGD008")[0]; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- feature-13 end -->
  <!-- about-19 -->
  <section class="about-19 p_relative sec-pad">
    <div class="pattern-layer p_absolute l_100 t_50 float-bob-y" style="background-image: url(assets/images/shape/shape-184.png);"></div>
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-6 col-md-12 col-sm-12 content-column">
          <div class="content_block_one">
            <div class="content-box p_relative d_block">
              <div class="text p_relative d_block mb_25">
                <p class="font_family_poppins"><?php echo $pageDetail['pageContent']; ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 image-column">
          <div class="image_block_20">
            <div class="image-box p_relative d_block ml_30 pl_50 pb_50">
              <div class="shape">
                <div class="shape-3 p_absolute rotate-me" style="background-image: url(assets/images/shape/shape-176.png);"></div>
                <div class="shape-4 p_absolute l_15 t_120 rotate-me" style="background-image: url(assets/images/shape/shape-176.png);"></div>
              </div>
              <figure class="image p_relative d_block b_radius_10"><img src="<?php echo $pageImages[0][1]; ?>" alt="<?php echo $pageDetail['pageName']; ?>"></figure>
              <div class="text p_absolute b_radius_10 pl_40 pt_40 pr_40 pb_35 l_0 b_0">
                <div class="icon-box p_relative d_block fs_40 lh_40 mb_15">
                  <div class="icon"><i class="icon-123"></i></div>
                  <div class="icon-img hidden-icon"><img src="assets/images/icons/hid-icon-96.png" alt=""></div>
                </div>
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_6">Bize Ulaşın</h4>
                <h3 class="d_block fw_medium"><a href="tel:0<?php echo $companyInfo['phone1']; ?>">0<?php echo $companyInfo['phone1']; ?></a></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- about-19 end -->

  
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
?>