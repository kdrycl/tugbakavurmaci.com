<?php 
  include('temp/dbclassinclude.php'); 
  $allBlogs=$dbclass->cek("ASSOC_ALL","blogs","*","WHERE recordStatus=?",array(1));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="">
<meta name="description" content="Tuğba Kavurmacı Güzellik Merkezi olarak sizinle paylaştığımız faydalı blog yazılarımızı bu sayfadan okuyabilirsiniz.">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title>Tuğba Kavurmacı Güzellik Merkezi | Blog Yazıları</title>
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
        <h1 class="d_block fs_60 lh_70 fw_bold mb_10">Tüm Blog Yazıları</h1>
        <ul class="bread-crumb p_relative d_block mb_8 clearfix">
          <li class="p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter mr_20"><a href="/">Anasayfa</a></li>
          <li class="current p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter">Tüm Blog Yazıları</li>
        </ul>
      </div>
    </div>
  </section>
  <!-- End Page Title -->
  <!-- news-one -->
  <section class="news-one p_relative sec-pad">
    <div class="auto-container">
      <div class="row clearfix">
        <?php
          foreach ($allBlogs as $key => $value) {
            $blogImage=$functions->imageDetected($dbclass,3,$value['uniqueId']);
        ?>
        <div class="col-lg-4 col-md-6 col-sm-12 news-block">
          <div class="news-block-one wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <div class="inner-box p_relative d_block b_radius_10 b_shadow_6">
              <div class="image-box p_relative d_block">
                <figure class="image p_relative d_block"><a href="blog/<?php echo $value['blogSlug']; ?>"><img src="<?php echo $blogImage[0][1]; ?>" alt=""></a></figure>
              </div>
              <div class="lower-content p_relative d_block pt_30 pr_30 pb_40 pl_40">
                <h4 class="d_block fs_20 lh_30 mb_15"><a href="blog/<?php echo $value['blogSlug']; ?>"><?php echo $value['blogName']; ?></a></h4>
                <p class="d_block mb_20"><?php echo $value['blogShortDescription']; ?></p>
                <div class="btn-box">
                  <a href="blog/<?php echo $value['blogSlug']; ?>" class="theme-btn theme-btn-two"><span data-text="Devamını Oku">Devamını Oku</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </section>
  <!-- news-one end -->


  
  <?php include("temp/footer.php"); ?>
</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
</body>
</html>