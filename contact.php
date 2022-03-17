<?php 
  include('temp/dbclassinclude.php'); 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Tuğba Kavurmacı - İletişim Bilgileri</title>
<meta name="keywords" content="HTML5 Template">
<meta name="description" content="Tuğba Kavurmacı - İletişim Bilgileri">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title>Revagri</title>
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
        <h1 class="d_block fs_60 lh_70 fw_bold mb_10"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT001")[0]; ?></h1>
        <ul class="bread-crumb p_relative d_block mb_8 clearfix">
          <li class="p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter mr_20"><a href="/">Anasayfa</a></li>
          <li class="current p_relative d_iblock fs_16 lh_25 fw_sbold font_family_inter"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT001")[0]; ?></li>
        </ul>
      </div>
    </div>
  </section>
  <!-- End Page Title -->
  <!-- contact-four -->
  <section class="contact-four p_relative sec-pad">
    <div class="shape">
      <div class="shape-1 p_absolute l_0 t_0" style="background-image: url(assets/images/shape/shape-210.png);"></div>
      <div class="shape-2 p_absolute b_0 r_150" style="background-image: url(assets/images/shape/shape-211.png);"></div>
    </div>
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12 info-column">
          <div class="info-inner">
            <div class="sec-title p_relative d_block mb_40">
              <h5 class="d_block fs_17 lh_20 fw_sbold uppercase mb_17"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT003")[0]; ?></h5>
              <h3 class="d_block fs_30 lh_40 fw_bold"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT004")[0]; ?></h3>
            </div>
            <ul class="info-list clearfix">
              <li class="p_relative d_block pl_100 pb_18 mb_25">
                <div class="icon-box p_absolute l_0 t_0 d_iblock w_80 h_80 lh_80 b_radius_50 text-center fs_45 z_1 mb_25 tran_5">
                  <div class="icon p_relative d_iblock"><i class="icon-180"></i></div>
                  <div class="icon-img hidden-icon"><img src="assets/images/icons/hid-icon-133.png" alt=""></div>
                </div>
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_7"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT009")[0]; ?></h4>
                <p class="font_family_poppins"><?php echo $companyInfo['adress']; ?></p>
              </li>
              <li class="p_relative d_block pl_100 pb_18 mb_25">
                <div class="icon-box p_absolute l_0 t_0 d_iblock w_80 h_80 lh_80 b_radius_50 text-center fs_45 z_1 mb_25 tran_5">
                  <div class="icon p_relative d_iblock"><i class="icon-181"></i></div>
                  <div class="icon-img hidden-icon"><img src="assets/images/icons/hid-icon-134.png" alt=""></div>
                </div>
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_7"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT007")[0]; ?></h4>
                <p class="font_family_poppins"><a href="mailto:<?php echo $companyInfo['mail1']; ?>"><?php echo $companyInfo['mail1']; ?></a><br /><a href="mailto:<?php echo $companyInfo['mail2']; ?>"><?php echo $companyInfo['mail2']; ?></a></p>
              </li>
              <li class="p_relative d_block pl_100 pb_18">
                <div class="icon-box p_absolute l_0 t_0 d_iblock w_80 h_80 lh_80 b_radius_50 text-center fs_45 z_1 mb_25 tran_5">
                  <div class="icon p_relative d_iblock"><i class="icon-182"></i></div>
                  <div class="icon-img hidden-icon"><img src="assets/images/icons/hid-icon-135.png" alt=""></div>
                </div>
                <h4 class="d_block fs_20 lh_30 fw_sbold mb_7"><?php echo $functions->constDefinitions($dbclass,"CONTCT","CNT002")[0]; ?></h4>
                <p class="font_family_poppins"><a href="tel:0<?php echo $companyInfo['phone1']; ?>">0<?php echo $companyInfo['phone1']; ?></a><br /><a href="tel:0<?php echo $companyInfo['phone2']; ?>">2<?php echo $companyInfo['phone2']; ?></a><br /><a href="https//wa.me/90<?php echo $companyInfo['phone3']; ?>">2<?php echo $companyInfo['phone3']; ?></a></p>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 form-column">
          <div class="form-inner p_relative ml_40 b_radius_10 b_shadow_6">
            <div class="text p_relative d_block">
              <?php echo $companyInfo['mapCode']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- contact-four end -->

  <?php include("temp/footer.php"); ?>

</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
</body>
</html>