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

<div class="page-wrapper">
  <?php include('temp/header.php'); ?>
  <main class="main">
      <div class="page-content">
        <div class="container mt-5">
          <div class="product-details-top">
            <div class="row">
              <div class="col-12">
                <div class="product-details">
                  <div class="product-content text-center">
                    <?php
                      $schemaImages=$functions->imageDetected($dbclass,7,$pageDetail['uniqueId']);
                      if($schemaImages[0][0]!="no-image"){ 
                        foreach ($schemaImages as $key => $value) {
                      ?>
                        <div class="row w-100">
                          <div class="w-12 p-3 d-flex align-items-center">
                            <figure class="product-media">
                              <img src="<?php echo $value[1] ?>" alt="Product image" class="product-image">
                            </figure><!-- End .product-media -->
                          </div>
                        </div>
                      <?php }
                      }    
                    ?>
                    <h1 class="product-title"><?php echo $pageDetail['pageName']; ?></h1><!-- End .product-title -->
                    <div class="product-cat mb-2 text-featured">
                      <a href="<?php echo $categoryMainSlug."/".$categorySlug; ?>"><?php echo $categoryName; ?></a>
                    </div><!-- End .product-cat -->
                    <p><?php echo $pageDetail['pageContent']; ?></p>
                  </div><!-- End .product-content -->
                </div><!-- End .product-details -->
              </div><!-- End .col-md-6 -->
            </div><!-- End .row -->
          </div><!-- End .product-details-top -->
      </div><!-- End .page-content -->
    </main><!-- End .main -->

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