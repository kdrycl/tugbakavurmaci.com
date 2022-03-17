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
<?php include('temp/head-tags.php'); ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?php echo $productDetail['seoKeywords']; ?>">
<meta name="description" content="<?php echo $productDetail['seoDescription']; ?>">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title><?php echo $productDetail['seoTitle']; ?></title>
<link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
<link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
</head>

<body>

<div class="page-wrapper">
  
  <?php include('temp/header.php'); ?>
  <main class="main">
    <div class="page-content">
      <?php 
        if($productDetail['productVideo']!=null OR $productDetail['productVideo']!=""){
      ?>
      <div class="video-banner video-banner-bg bg-image text-center" style="background-image: url('<?php echo $productImages[0][1]; ?>')">
        <div class="container">
          <a href="<?php echo $productDetail['productVideo']; ?>" class="btn-video btn-iframe"><i class="icon-play"></i></a>
        </div><!-- End .container -->
      </div>
      <?php } ?>
      <div class="container mt-5">
        <div class="product-details-top">
          <div class="row">
            <div class="col-md-6">
              <div class="product-gallery">
                <figure class="product-main-image">
                    <img id="product-zoom" src="<?php echo $productImages[0][1]; ?>" alt="<?php echo $productDetail['productName']; ?>">
                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                        <i class="icon-arrows"></i>
                    </a>
                </figure><!-- End .product-main-image -->

                <div id="product-zoom-gallery" class="product-image-gallery">
                  <?php
                      foreach ($productImages as $key => $value) {
                        if($key==0) $active="active";
                        else $active="";
                        echo '
                          <a class="product-gallery-item '.$active.'" href="#" data-image="'.$value[1].'">
                            <img src="'.$value[1].'" alt="'.$productDetail['productName'].'">
                          </a>    
                        ';
                      }
                    ?>

                </div><!-- End .product-image-gallery -->
              </div><!-- End .product-gallery -->
            </div><!-- End .col-md-6 -->
            <div class="col-md-6">
              <div class="product-details">
                <div class="product-content text-center">
                  <h1 class="product-title"><?php echo $productDetail['productName']; ?></h1><!-- End .product-title -->
                  <div class="product-cat mb-2 text-featured">
                    <a href="<?php echo $categoryMainSlug."/".$categorySlug; ?>"><?php echo $categoryName; ?></a>
                  </div><!-- End .product-cat -->
                  <p><?php echo $productDetail['productShortDescription']; ?></p>
                </div><!-- End .product-content -->

                <div class="details-filter-row details-row-size">
                  <div class="row mx-1">
                  <?php
                    $productInfos=$dbclass->cek("ASSOC_ALL","productInformations","*","WHERE productId=?",array($productDetail['uniqueId']));
                    foreach ($productInfos as $key => $value) {
                      if($key%2==0) $class="bg-light-featured";
                      else $class="bg-white";
                    ?>
                    <div class="col-12 border-featured table-featured px-3 py-2 d-flex justify-content-between <?php echo $class; ?>">
                      <span><?php echo $value['infoTitle'];?> :</span><b> <?php echo $value['infoContent'];?></b>
                    </div>
                  <?php } ?>
                  </div>
                </div><!-- End .details-filter-row -->
              </div><!-- End .product-details -->
            </div><!-- End .col-md-6 -->
          </div><!-- End .row -->
        </div><!-- End .product-details-top -->

        <div class="product-details-tab bg-light border p-3 row">
            <div class="product-desc-content"><?php echo $productDetail['productLongDescription']; ?></div><!-- End .product-desc-content -->
        </div><!-- End .product-details-tab -->
        <?php
          $schemaImages=$functions->imageDetected($dbclass,4,$productDetail['uniqueId']);
          if($schemaImages[0][0]!="no-image"){ ?>
        <h2 class="title text-center mb-4"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT001")[0]; ?></h2><!-- End .title text-center -->
        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
            data-owl-options='{
                "nav": false, 
                "dots": true,
                "margin": 20,
                "loop": true,
                "responsive": {
                    "0": {
                        "items":1   
                    },
                    "480": {
                        "items":1
                    },
                    "768": {
                        "items":1
                    },
                    "992": {
                        "items":1
                    },
                    "1200": {
                        "items":1,
                        "nav": true,
                        "dots": false
                    }
                }
            }'>
            <?php 
                foreach ($schemaImages as $key => $value) {
            ?>
            <div class="row w-100">
                <div class="w-50 p-3 d-flex align-items-center">
                    <figure class="product-media">
                        <span class="product-label label-new">Şema Görseli</span>
                            <img src="<?php echo $value[1] ?>" alt="Product image" class="product-image">
                    </figure><!-- End .product-media -->
                </div>
                <div class="w-50 p-3 d-flex align-items-center">
                    <?php echo $value[4] ?>
                </div>
            </div>
            <?php } ?>
            
        </div><!-- End .owl-carousel -->
        <?php } ?>
        <?php
          $subProductCount=$dbclass->cek("KAYITSAY","products","count(id)","WHERE mainProduct=? AND recordStatus=? AND langCode=?",array($productDetail['uniqueId'],1,$_SESSION['lang']['langCode']));
          if($subProductCount>0){
        ?>
        <h2 class="title text-center mb-4"><?php echo $functions->constDefinitions($dbclass,"PRODET","PDT002")[0]; ?></h2>
        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
            data-owl-options='{
                "nav": false, 
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":1
                    },
                    "480": {
                        "items":2
                    },
                    "768": {
                        "items":3
                    },
                    "992": {
                        "items":4
                    },
                    "1200": {
                        "items":4,
                        "nav": true,
                        "dots": true
                    }
                }
            }'>
            <?php
              $subProducts=$dbclass->cek("ASSOC_ALL","products","*","WHERE mainProduct=? AND recordStatus=? AND langCode=?",array($productDetail['uniqueId'],1,$_SESSION['lang']['langCode']));
              foreach ($subProducts as $key => $value) {
                $productImages=$functions->imageDetected($dbclass,2,$value['uniqueId']);
            ?>
                <div class="product product-7 text-center">
                  <figure class="product-media">
                    <a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>">
                      <img src="'<?php echo $productImages[0][1]; ?>" alt="<?php echo $value['productName']; ?>" class="product-image">
                    </a>
                  </figure>

                  <div class="product-body">
                    <div class="product-cat">
                      <a href="<?php echo $categoryMainSlug."/".$categorySlug; ?>"><?php echo $categoryName; ?></a>
                    </div>
                    <a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>"><h3 class="product-title"><?php echo $value['productName']; ?></h3></a>
                  </div>
                </div>
            <?php } ?>
        </div>
      </div><!-- End .container -->
      <?php } ?>
    </div><!-- End .page-content -->
  </main><!-- End .main -->

  <?php include("temp/footer.php"); ?>

</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/bootstrap-input-spinner.js"></script>
<script src="assets/js/jquery.elevateZoom.min.js"></script>
<script src="assets/js/bootstrap-input-spinner.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>

</body>
</html>
<?php }
else{
  header('Location: 404');
}
?>