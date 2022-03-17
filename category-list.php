<?php 
  include('temp/dbclassinclude.php');
  $categoryControl=$dbclass->cek("KAYITSAY","categories","COUNT(id)","WHERE categorySlug=? AND recordStatus=?",array($_GET['slug'],1));
  if ($categoryControl>0) {
  $categoryDetail=$dbclass->cek("ASSOC","categories","*","WHERE categorySlug=?",array($_GET['slug']));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<?php include('temp/head-tags.php'); ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?php echo $categoryDetail['seoKeywords']; ?>">
<meta name="description" content="<?php echo $categoryDetail['seoDescription']; ?>">
<meta name="author" content="<?php echo $companyInfo['companyName']; ?>">
<title><?php echo $categoryDetail['seoTitle']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
<link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
<link rel="stylesheet" href="assets/css/skins/skin-demo-13.css">
<link rel="stylesheet" href="assets/css/demos/demo-13.css">
</head>

<body>

<div class="page-wrapper">
  
  <?php include('temp/header.php'); ?>

  <main class="main">
    <div class="page-content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h1 class="title title-border mt-5"><?php echo $categoryDetail['categoryName']; ?></h1><!-- End .title -->
            <p><?php echo $categoryDetail['categoryDescription']; ?></p>
            <div class="mb-3 mb-lg-5"></div><!-- End .mb-3 mb-lg-5 -->
            <?php
              $subCategoriesCount=$dbclass->cek("KAYITSAY","categories","COUNT(id)","WHERE mainCategoryId=? AND recordStatus=? AND langCode=?",array($categoryDetail['uniqueId'],1,$_SESSION['lang']['langCode']));
              if($subCategoriesCount>0){
            ?>
            <div class="cat-blocks-container">
              <div class="row">
                <?php
                  $subCategories=$dbclass->cek("ASSOC_ALL","categories","*","WHERE mainCategoryId=? AND recordStatus=? AND langCode=? ORDER BY rowNumber ASC",array($categoryDetail['uniqueId'],1,$_SESSION['lang']['langCode']));
                  foreach ($subCategories as $key => $value) {
                    $categoryImageDetected=$functions->imageDetected($dbclass, 5, $value['uniqueId'], $_SESSION['lang']['langCode'], 0);
                ?>
                <div class="col-6 col-md-4 col-lg-3 bg-white">
                    <a href="<?php echo $categoryMainSlug.'/'.$value['categorySlug']; ?>" class="cat-block">
                      <figure>
                        <span>
                          <img src="<?php echo $categoryImageDetected[0][1]; ?>" alt="<?php echo $value['categoryName']; ?>">
                        </span>
                      </figure>

                      <h3 class="cat-block-title mt-2"><?php echo $value['categoryName']; ?></h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-6 col-md-4 col-lg-3 -->
                    <?php } ?>
              </div><!-- End .row -->
            </div><!-- End .cat-blocks-container -->
            <?php } ?>
            <div class="mb-2"></div><!-- End .mb-2 -->

            <div class="products mb-3">
                <!-- gelen kategori ürün kategorisi ise -->
                <?php if($categoryDetail['categoryType']==0){ ?>
                  <div class="row">
                      <?php
                        $homProducts=$dbclass->cek("ASSOC_ALL","products","products.uniqueId,products.productName,products.productSlug","INNER JOIN productsVsCategories ON productsVsCategories.productUniqueId = products.uniqueId WHERE products.recordStatus=? AND products.langCode=? AND productsVsCategories.categoryUniqueId=? AND products.mainProduct=?",array(1,$_SESSION['lang']['langCode'],$categoryDetail['uniqueId'],0));
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
                        <div class="col-6 col-md-4 col-lg-3">
                          <div class="product product-2">
                            <figure class="product-media">
                              <a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>">
                                <img src="<?php echo $productImageDetected[0][1]; ?>" alt="<?php echo $value['productName'] ?>" class="product-image">
                              </a>
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                              <div class="product-cat">
                                <a href="<?php echo $categoryMainSlug.'/'.$categorySlug; ?>"><?php echo $categoryName; ?></a>
                              </div><!-- End .product-cat -->
                              <h3 class="product-title"><a href="<?php echo $productMainSlug.'/'.$value['productSlug']; ?>"><?php echo $value['productName'] ?></a></h3><!-- End .product-title -->
                            </div><!-- End .product-body -->
                          </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                        <?php } ?>
                  </div><!-- End .row -->
                <?php } ?>
                <!-- gelen kategori ürün kategorisi ise -->
                <!-- gelen kategori blog kategorisi ise -->
                <?php if($categoryDetail['categoryType']==1){ ?>
                  <div class="row">
                      <?php
                        $homProducts=$dbclass->cek("ASSOC_ALL","blogs","blogs.uniqueId,blogs.blogName,blogs.blogSlug","INNER JOIN blogsVsCategories ON blogsVsCategories.blogUniqueId = blogs.uniqueId WHERE blogs.recordStatus=? AND blogsVsCategories.blogUniqueId=?",array(1,$categoryDetail['uniqueId']));
                        foreach ($homProducts as $key => $value) {
                          $categoryCount=$dbclass->cek("KAYITSAY","categories","COUNT(categories.id)","INNER JOIN blogsVsCategories ON blogsVsCategories.categoryUniqueId = blogs.uniqueId WHERE blogsVsCategories.blogUniqueId=?",array($value['uniqueId']));
                          if($categoryCount>0){
                            $categoryDetected=$dbclass->cek("ASSOC_ALL","categories","categories.uniqueId,categories.categoryName,categories.categorySlug","INNER JOIN blogsVsCategories ON blogsVsCategories.categoryUniqueId = categories.uniqueId WHERE blogsVsCategories.blogUniqueId=?",array($value['uniqueId']));
                            $categoryName=$categoryDetected[0]['categoryName'];
                            $categorySlug=$categoryDetected[0]['categorySlug'];
                          } 
                          else{
                            $categoryName="Kategori Bulunamadı";
                            $categorySlug="#";
                          }
                          $productImageDetected=$functions->imageDetected($dbclass, 3, $value['uniqueId'], "TR", 0);
                        ?>
                        <div class="col-6 col-md-4 col-lg-3">
                          <div class="product product-2">
                            <figure class="product-media">
                              <a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>">
                                <img src="<?php echo $productImageDetected[0][1]; ?>" alt="<?php echo $value['blogName'] ?>" class="product-image">
                              </a>
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                              <div class="product-cat">
                                <a href="<?php echo $categoryMainSlug.'/'.$categorySlug; ?>"><?php echo $categoryName; ?></a>
                              </div><!-- End .product-cat -->
                              <h3 class="product-title"><a href="<?php echo $blogMainSlug.'/'.$value['blogSlug']; ?>"><?php echo $value['blogName'] ?></a></h3><!-- End .product-title -->
                            </div><!-- End .product-body -->
                          </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                        <?php } ?>
                  </div><!-- End .row -->
                <?php } ?>
                <!-- gelen kategori blog kategorisi ise -->
            </div><!-- End .products -->

          </div><!-- End .col-lg-9 -->
        </div><!-- End .row -->
      </div><!-- End .container -->
    </div><!-- End .page-content -->
  </main><!-- End .main -->

  <?php include("temp/footer.php"); ?>

</div>
<!--End pagewrapper-->
<!-- JS -->
<?php include("temp/footer-scripts.php"); ?>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/bootstrap-input-spinner.js"></script>
<script src="assets/js/jquery.plugin.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>

</body>
</html>
<?php }
else{
  header('Location: 404');
}
?>