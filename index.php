<?php 
  include('temp/dbclassinclude.php'); 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="HTML5 Template">
<meta name="description" content="Molla - Bootstrap eCommerce Template">
<meta name="author" content="p-themes">
<title>Tuğba Kavurmacı Güzellik Merkezi Konya</title>
<?php include('temp/head-tags.php'); ?>
</head>
 
<body>

<div class="boxed_wrapper">
  <?php include('temp/header.php'); ?>
  <!-- banner-three -->
  <section class="banner-three p_relative pb_160">
    <div class="shape parallax-scene parallax-scene-1">
      <div data-depth="0.40" class="shape-1 p_absolute" style="background-image: url(assets/images/shape/shape-66.png);"></div>
      <div data-depth="0.30" class="shape-2 p_absolute" style="background-image: url(assets/images/shape/shape-66.png);"></div>
      <div data-depth="0.50" class="shape-3 p_absolute" style="background-image: url(assets/images/shape/shape-66.png);"></div>
      <div data-depth="0.40" class="shape-4 p_absolute"></div>
    </div>
    <div class="pattern-layer hero-shape-four p_absolute"></div>
    <div class="pattern-layer-2 hero-shape-four p_absolute"></div>
    <div class="bg-layer p_absolute t_0 r_0 wow slideInDown animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="background-image: url(uploads/sliders/img-1.png);"></div>
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-6 col-md-12 col-sm-12 content-column">
          <div class="content-box p_relative d_block wow slideInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <h2 class="d_block fs_65 lh_80 fw_bold font_family_jost mb_25"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP001")[0]; ?></h2>
            <p class="fs_17 font_family_poppins lh_28 mb_20"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP002")[0]; ?></p>
            <div class="btn-box clearfix">
              <a href="https://wa.me/90<?php echo $companyInfo['phone3']; ?>" class="theme-btn theme-btn-five mr_25">WhatsApp <i class="fab fa-whatsapp"></i></a>
              <a href="tel:90<?php echo $companyInfo['phone1']; ?>" class="lightbox-image video-btn fs_20 font_family_jost fw_medium pl_80 pb_7">Bizi Arayın</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- banner-three end -->
  <!-- about-12 -->
  <section class="about-12 p_relative sec-pad">
    <div class="auto-container">
      <div class="row align-items-center clearfix">
        <div class="col-lg-6 col-md-12 col-sm-12 image-column">
          <div class="image_block_13">
            <div class="image-box p_relative d_block">
              <div class="shape parallax-scene parallax-scene-2">
                <div data-depth="0.40" class="shape-1 p_absolute" style="background-image: url(assets/images/shape/shape-66.png);"></div>
                <div data-depth="0.30" class="shape-2 p_absolute" style="background-image: url(assets/images/shape/shape-66.png);"></div>
                <div data-depth="0.40" class="shape-3 p_absolute"></div>
                <div data-depth="0.50" class="shape-4 p_absolute"></div>
                <div data-depth="0.30" class="shape-5 p_absolute"></div>
              </div>
              <figure class="image image-1 p_absolute d_block wow slideInDown animated" data-wow-delay="00ms" data-wow-duration="1500ms"><img src="uploads/sliders/about-1.png" alt=""></figure>
              <figure class="image image-2 p_absolute d_block wow slideInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms"><img src="uploads/sliders/about-2.png" alt=""></figure>
              <figure class="image image-3 p_absolute d_block wow slideInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms"><img src="uploads/sliders/about-3.png" alt=""></figure>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 content-column">
          <div class="content_block_nine">
            <div class="content-box p_relative d_block ml_40">
              <div class="sec-title-nine p_relative d_block mb_25">
                <h6 class="d_iblock pl_20 pr_20 fs_14 lh_30 b_radius_5 mb_18 fw_medium font_family_poppins">Biz Kimiz?</h6>
                <h2 class="d_block fs_45 lh_55 fw_bold font_family_jost"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP003")[0]; ?></h2>
              </div>
              <div class="text p_relative d_block mb_35">
                <p class="font_family_poppins mb_25"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP004")[0]; ?></p>
              </div>
              <div class="btn-box">
                <a href="/iletisim-bilgilerimiz" class="theme-btn theme-btn-two"><span data-text="<?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP005")[0]; ?>"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP005")[0]; ?></span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- about-12 end -->
  <!-- service-12 -->
  <!-- categories -->
  <?php 
  $productCount=$dbclass->cek("KAYITSAY","products","count(id)","WHERE recordStatus=? AND langCode=? AND showHome=? AND mainProduct=?",array(1,"TR",1,0));
  if($productCount>0){
  ?>
  <!-- products -->
  <section class="service-12 p_relative centred">
    <div class="auto-container">
      <div class="sec-title-nine p_relative d_block mb_50">
        <h6 class="d_iblock pl_20 pr_20 fs_14 lh_30 b_radius_5 mb_18 fw_medium font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP006")[0]; ?></h6>
        <h2 class="d_block fs_45 lh_55 fw_bold font_family_jost"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP007")[0]; ?></h2>
      </div>
      <div class="row clearfix">
      <?php
        $homProducts=$dbclass->cek("ASSOC_ALL","products","uniqueId,productName,productSlug,productShortDescription","WHERE recordStatus=? AND langCode=? AND showHome=? AND mainProduct=?",array(1,$_SESSION['lang']['langCode'],1,0));
        foreach ($homProducts as $key => $value) {
          $categoryCount=$dbclass->cek("KAYITSAY","categories","COUNT(categories.id)","INNER JOIN productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=?",array($value['uniqueId']));
          if($categoryCount>0){
            $categoryDetected=$dbclass->cek("ASSOC_ALL","categories","categories.uniqueId,categories.categoryName,categories.categorySlug","INNER JOIN productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=?",array($value['uniqueId']));
            $categoryName=$categoryDetected[0]['categoryName'];
            $categorySlug=$categoryDetected[0]['categorySlug'];
          } 
          else{
            $categoryName="Kategori Bulunamadı";
            $categorySlug="#";
          }
          $productImageDetected=$functions->imageDetected($dbclass, 2, $value['uniqueId'], $_SESSION['lang']['langCode'], 0);
        ?>
        <div class="col-lg-4 col-md-6 col-sm-12 service-block">
          <div class="service-block-10 wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block b_radius_10 pt_30 pl_30 pb_50 pr_30 tran_5 mb_30">
              <div class="icon-box p_relative d_iblock fs_45 mb_30">
                <div class="shape-1 l_0 t_0 hero-shape-four p_absolute tran_5"></div>
                <div class="shape-2 p_absolute l_0 t_5" style="background-image: url(assets/images/shape/shape-132.png);"></div>
                <div class="icon"><img src="<?php echo $productImageDetected[0][1]; ?>" alt="<?php echo $value['productName'] ?>" class="product-image"></div>
                <div class="icon-img hidden-icon"><a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>"><img src="<?php echo $productImageDetected[0][1]; ?>" alt="<?php echo $value['productName'] ?>" class="product-image rounded-circle"></a></div>
              </div>
              <div class="lower-content">
                <h3 class="d_block fs_24 lh_30 fw_sbold font_family_jost mb_17"><a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>" class="d_iblock color_black"><?php echo $value['productName'] ?></a></h3>
                <p class="fs_16 font_family_poppins mb_25 lh_28"><?php echo $value['productShortDescription'] ?></p>
                <div class="link">
                  <a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>" class="d_iblock p_relative fs_15 fw_sbold font_family_poppins color_black">Detaylı İncele<i class="icon-4"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>
  <!-- service-12 end -->
  <!-- testimonial-nine -->
  <?php
  $yorumSay=$dbclass->cek("KAYITSAY","productInformations","count(id)","WHERE langCode=?",array("TR"));
  if($yorumSay>0){
  ?>
  <section class="testimonial-nine p_relative pt_100 pb_120">
    <div class="pattern-layer p_absolute l_0 t_0" style="background-image: url(assets/images/shape/shape-143.png);"></div>
      <div class="auto-container">
        <div class="row clearfix">
          <div class="col-lg-4 col-md-12 col-sm-12 title-column">
            <div class="sec-title-nine p_relative d_block">
              <h6 class="d_iblock pl_20 pr_20 fs_14 lh_30 b_radius_5 mb_18 fw_medium font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP008")[0]; ?></h6><br />
              <h2 class="d_block fs_45 lh_55 fw_bold font_family_jost"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP009")[0]; ?></h2>
            </div>
          </div>
          <div class="col-lg-8 col-md-12 col-sm-12 inner-column">
            <div class="inner-content p_relative pl_65">
              <div class="two-column-carousel owl-carousel owl-theme owl-dots-none nav-style-one overflow_visible">
                <?php
                $yorumlarGet=$dbclass->cek("ASSOC_ALL","productInformations","*","WHERE langCode=? ",array("TR"));
                foreach ($yorumlarGet as $key => $value) {
                ?>
                <div class="testimonial-block-one">
                  <div class="inner-box p_relative d_block">
                    <div class="text p_relative d_block b_radius_10 pt_35 pr_30 pb_40 pl_40 mb_30">
                      <p class="font_family_poppins"><?php echo $value['infoContent']; ?></p>
                    </div>
                    <div class="author p_relative d_block pl_90 pt_7 pb_11 ml_20">
                      <figure class="thumb-box p_absolute l_0 t_0 w_70 h_70 b_radius_50 d-flex align-items-center justify-content-center"><i class="fa fa-user mx-auto"></i></figure>
                      <h4 class="d_block fs_20 lh_30 mb_2 fw_sbold font_family_jost"><?php echo $value['infoTitle']; ?></h4>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>
  <!-- testimonial-nine -->
  <!-- news-12 -->
  <?php
  $blogSay=$dbclass->cek("KAYITSAY","blogs","count(id)","WHERE recordStatus=?",array(1));
  if($blogSay>0){
  ?>
  <section class="news-12 p_relative sec-pad">
    <div class="auto-container">
      <div class="sec-title-nine p_relative d_block mb_50 centred">
        <h6 class="d_iblock pl_20 pr_20 fs_14 lh_30 b_radius_5 mb_18 fw_medium font_family_poppins"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP010")[0]; ?></h6><br />
        <h2 class="d_block fs_45 lh_55 fw_bold font_family_jost"><?php echo $functions->constDefinitions($dbclass,"HOMEPAG","HMP011")[0]; ?></h2>
      </div>
      <div class="row clearfix">
        <?php
        $bloglarGet=$dbclass->cek("ASSOC_ALL","blogs","*","WHERE recordStatus=? ORDER BY id DESC LIMIT 6 ",array(1));
        foreach ($bloglarGet as $key => $value) {
          $blogImages=$functions->imageDetected($dbclass, 3, $value['uniqueId'], "TR", 0);
        ?>
          <div class="col-lg-4 col-md-6 col-sm-12 news-block">
            <div class="news-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
              <div class="inner-box p_relative d_block b_shadow_6 b_radius_5">
                <div class="pattern-layer" style="background-image: url(assets/images/shape/shape-60.png);"></div>
                <div class="image-box">
                  <figure class="image">
                    <a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>">
                      <img src="<?php echo $blogImages[0][1]; ?>" alt="<?php echo $value["blogName"]; ?>">
                    </a>
                </figure>
                </div>
                <div class="lower-content p_relative d_block pt_40 pr_30 pb_50 pl_40">
                  <ul class="post-info clearfix p_relative d_block mb_11">
                    <li class="p_relative d_iblock float_left mr_30 fs_16 font_family_poppins"><a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>"><?php echo date("d-m-Y", strtotime($value["recordTime"])); ?></a></li>
                  </ul>
                  <h4 class="d_block fs_24 fw_sbold font_family_jost lh_30 mb_15"><a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>"><?php echo $value["blogName"]; ?></a></h4>
                  <p class="d_block font_family_poppins mb_20"><?php echo $value["blogShortDescription"]; ?></p>
                  <div class="btn-box">
                    <a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>" class="theme-btn theme-btn-two"><span data-text="Devamını Oku">Devamını Oku</span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>

  <!-- news-12 end -->
  <?php include("temp/footer.php"); ?>
</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
</body>
</html>