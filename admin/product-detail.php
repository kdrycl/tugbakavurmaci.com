<?php
session_start();
include 'dbclass/dbclassinclude.php';
$sessionControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "where id=?", array($_SESSION['userid']['id']));
if ($sessionControl > 0) { // kullanıcı giriş yapmış mı kontrol ediliyor giriş yapmışsa sayfaya yönlendiriliyor
  if (isset($_GET['langCode'])) $langCode = $_GET['langCode'];
  else $langCode = "TR";
  $productDetail = $dbclass->cek("ASSOC", "products", "*", "WHERE uniqueId=? AND langCode=?", array($_GET['uniqueId'], $langCode));
  ?>
    <!DOCTYPE html>
    <html lang="tr">
    <!--begin::Head-->
    <head>
        <base href="">
        <meta charset="utf-8"/>
        <title><?php echo $productDetail['productName']; ?> - Ürünü Düzenleniyor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
      <?php include 'temp/head-tags.php'; ?>
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" style="background-image: url(assets/media/bg/bg-10.jpg)"
          class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile">
        <!--begin::Logo-->
        <a href="anasayfa">
            <img alt="Logo" src="assets/media/logos/logo-letter-1.png" class="logo-default max-h-30px"/>
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button>
            <button class="btn btn-icon btn-hover-transparent-white p-0 ml-3" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24"/>
								<path
                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"/>
								<path
                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero"/>
							</g>
						</svg>
                        <!--end::Svg Icon-->
					</span>
            </button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
              <?php include 'temp/header-menu.php'; ?>
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Subheader-->
                    <div class="subheader min-h-lg-175px pt-5 pb-7 subheader-transparent" id="kt_subheader">
                        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <!--begin::Details-->
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <!--begin::Heading-->
                                <div class="d-flex flex-column">
                                    <!--begin::Title-->
                                    <h2 class="text-white font-weight-bold my-2 mr-5"><?php echo $productDetail['productName']; ?>
                                        Bilgileri</h2>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->
                            </div>
                            <!--end::Details-->
                        </div>
                    </div>
                    <!--end::Subheader-->
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">

                                <div class="card-body">
                                  <?php
                                  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 14);
                                  if ($permissionControl == 0) { // kullanıcının, yönetim panelinde ürün ekleme ve düzenleme izni kontrol ediliyor
                                    $functions->errorList("noProductProcess");
                                  }
                                  ?>
                                    <div class="d-flex align-items-center">
                                        <!--begin: Pic-->
                                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                            <div class="symbol symbol-50 symbol-lg-120">
                                              <?php
                                              $productMainImage = $functions->imageDetected($dbclass, 2, $productDetail['uniqueId'], $productDetail['langCode'], 0);
                                              ?>
                                                <img alt="Pic" src="<?php echo $productMainImage[0][1]; ?>"/>
                                            </div>
                                            <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                                <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                                            </div>
                                        </div>
                                        <!--end: Pic-->
                                        <!--begin: Info-->
                                        <div class="flex-grow-1">
                                            <!--begin: Title-->
                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                <div class="mr-3">
                                                    <!--begin::Name-->
                                                    <h1 href="#"
                                                        class="d-flex align-items-center text-dark font-size-h5 font-weight-bold mr-3"><?php echo $productDetail['productName']; ?>
                                                      <?php
                                                      if ($productDetail['recordStatus'] == 1) echo '<i class="flaticon2-correct text-success icon-md ml-2" title="Ürün Aktif"></i>';
                                                      else echo '<i class="flaticon-cancel text-danger icon-md ml-2" title="Ürün Pasif"></i>';
                                                      ?>
                                                    </h1>
                                                    <!--end::Name-->
                                                </div>
                                                <!--end: Title-->
                                            </div>
                                            <!--end: Info-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card-->
                                <!--begin::Header-->
                                <div class="card-header card-header-tabs-line">
                                    <div class="card-toolbar">
                                        <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#productDetails">
														<span class="nav-icon mr-1">
															<i class="fas fa-list-ul"></i>
														</span>
                                                    <span class="nav-text font-weight-bold">Ürün Bilgileri</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#gallery">
														<span class="nav-icon mr-1">
															<i class="far fa-images"></i>
														</span>
                                                    <span class="nav-text font-weight-bold">Galeri</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#informations">
														<span class="nav-icon mr-1">
															<i class="fas fa-feather-alt"></i>
														</span>
                                                    <span class="nav-text font-weight-bold">Ürün Yorumları</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#variants">
														<span class="nav-icon mr-1">
															<i class="fas fa-box-open"></i>
														</span>
                                                    <span class="nav-text font-weight-bold">Ürün Varyasyonları</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Card-->
                                <div class="card card-custom gutter-bs">
                                    <!--begin::Body-->
                                    <div class="card-body px-0 pt-0">
                                        <div class="tab-content pt-5">
                                            <!--begin::#productDetails Tab Content-->
                                            <div class="tab-pane active" id="productDetails" role="tabpanel">
                                                <div class="container">
                                                    <form class="form" id="product_form">
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <div class="col-12 col-lg-6">
                                                                <label class="col-xl-12 px-0 col-form-label">Ürün
                                                                    Adı</label>
                                                                <div class="col-lg-12 px-0">
                                                                    <input class="form-control form-control-solid form-control-lg"
                                                                           name="productName" type="text"
                                                                           value="<?php echo $productDetail['productName']; ?>"
                                                                           placeholder="Etkinliğin Sitede Görüntülenecek Adı"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label class="col-12 px-0 col-form-label">Ürün
                                                                    Kategorisi</label>
                                                                <div class="col-12 px-0">
                                                                    <select name="productCategories[]" id="productCategory"
                                                                            class="select2 form-control form-control-lg form-control-solid" multiple="multiple">
                                                                      <?php
                                                                      $allCategoriesGet = $dbclass->cek("ASSOC_ALL", "categories", "uniqueId,categoryName", "WHERE categoryType=? AND langCode=? AND recordStatus=?", array(0, $productDetail['langCode'], 1));
                                                                      foreach ($allCategoriesGet as $key => $value) {
                                                                        $categoryDetected = $dbclass->cek("KAYITSAY", "productsVsCategories", "COUNT(id)", "WHERE productUniqueId=? AND categoryUniqueId=?", array($productDetail['uniqueId'], $value['uniqueId']));
                                                                        if ($categoryDetected > 0) $selected = "selected";
                                                                        else $selected = "";
                                                                        echo '<option value="' . $value['uniqueId'] . '" ' . $selected . '>' . $value['categoryName'] . '</option>';
                                                                      }
                                                                      ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <div class="col-12 col-lg-6">
                                                              <label class="col-xl-12 col-lg-12 col-form-label">Ürün Video
                                                                Linki</label>
                                                                <input class="form-control h-auto form-control-solid py-4 px-8"
                                                                       type="text" placeholder="Ürünün Video Linki"
                                                                       value="<?php echo $productDetail['productVideo']; ?>"
                                                                       name="productVideo" autocomplete="off" value=""/>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                              <label class="col-xl-12 col-lg-12 col-form-label">Sıra Numarası</label>
                                                                <input class="form-control h-auto form-control-solid py-4 px-8"
                                                                       type="text" placeholder="Ürünün Gösterim Sırası"
                                                                       value="<?php echo $productDetail['rowNumber']; ?>"
                                                                       name="rowNumber" autocomplete="off" value=""/>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <div class="form-group row">
                                                          <div class="col-12 col-lg-6">
                                                            <div class="form-group">
                                                              <label class="col-xl-12 col-form-label">Durumu</label>
                                                                <select class="form-control form-control-lg form-control-solid" id="recordStatus" name="recordStatus">
                                                                <?php 
                                                                  $statupassive="";
                                                                  $statuactive="";
                                                                  if($productDetail['recordStatus']==0)$statupassive="selected";
                                                                  else$statuactive="selected";
                                                                ?>
                                                                <option value="1"<?php echo $statuactive; ?>>Aktif</option>
                                                                <option value="0"<?php echo $statupassive; ?>>Pasif</option>
                                                              </select>
                                                            </div>
                                                          </div>
                                                          <div class="col-12 col-lg-6">
                                                            <div class="form-group">
                                                              <label class="col-xl-12 col-form-label">Ana Ürün</label>
                                                                <select class="form-control form-control-lg form-control-solid" id="mainProduct" name="mainProduct">
                                                                    <option value="0">Ana Ürün</option>
                                                                <?php 
                                                                    $allProducts=$dbclass->cek("ASSOC_ALL","products","*","WHERE langCode=? AND recordStatus=? AND mainProduct=?",array("TR",1,0));
                                                                    foreach ($allProducts as $key => $value) {
                                                                        if($productDetail['mainProduct']==$value['uniqueId']) $selected="selected";
                                                                        else $selected="";
                                                                        echo '<option value="'.$value['uniqueId'].'"'.$selected.'>'.$value['productName'].'</option>        ';
                                                                    }
                                                                ?>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="form-group row">
                                                          <div class="col-12 col-lg-6">
                                                            <div class="form-group">
                                                              <label class="col-xl-12 col-form-label">Menü Gösterim Ayarı</label>
                                                              <select class="form-control form-control-lg form-control-solid" id="showMenu" name="showMenu">
                                                                <?php 
                                                                  $menupassive="";
                                                                  $menuactive="";
                                                                  if($productDetail['showMenu']==0)$menupassive="selected";
                                                                  else$menuactive="selected";
                                                                ?>
                                                                <option value="1"<?php echo $menuactive; ?>>Gösterilsin</option>
                                                                <option value="0"<?php echo $menupassive; ?>>Gösterilmesin</option>
                                                              </select>
                                                            </div>
                                                          </div>
                                                          <div class="col-12 col-lg-6">
                                                            <div class="form-group">
                                                              <label class="col-12 col-form-label">Anasayfa Gösterim Ayarı</label>
                                                              <select class="form-control form-control-lg form-control-solid" id="showHome" name="showHome">
                                                                <?php 
                                                                  $homepassive="";
                                                                  $homeactive="";
                                                                  if($productDetail['showHome']==0)$homepassive="selected";
                                                                  else$homeactive="selected";
                                                                ?>
                                                                <option value="1"<?php echo $homeactive; ?>>Gösterilsin</option>
                                                                <option value="0"<?php echo $homepassive; ?>>Gösterilmesin</option>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-12 col-lg-12 col-form-label">Ürün Kısa
                                                                Açıklaması</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <textarea class="form-control form-control-solid form-control-lg"
                                                                        name="productShortDescription" rows="5"
                                                                        placeholder="Etkinliği Kısa Bir Şekilde Açıklayınız"><?php echo $productDetail['productShortDescription']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <label class="col-xl-12 col-lg-12 col-form-label">Ürün
                                                                Detaylı Açıklaması</label>
                                                            <div class="col-lg-12 col-xl-12">
                                                                <textarea class="form-control form-control-solid form-control-lg summernote"
                                                                        name="productLongDescription"
                                                                        id="productLongDescription"><?php echo $productDetail['productLongDescription']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <div class="col-12 col-lg-12">
                                                                <label>SEO Başlığı</label>
                                                                <input class="form-control form-control-solid form-control-lg"
                                                                       name="seoTitle"
                                                                       type="text"
                                                                       value="<?php echo $productDetail['seoTitle']; ?>"
                                                                       placeholder="SEO Başlığı Giriniz"/>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <div class="col-12 col-lg-6">
                                                                <label>SEO Anahtar Kelimeleri</label>
                                                                <textarea
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="seoKeywords"
                                                                        rows="5"
                                                                        placeholder="SEO Anahtar Kelimeleri Giriniz"><?php echo $productDetail['seoKeywords']; ?></textarea>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label>SEO Açıklaması</label>
                                                                <textarea
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="seoDescription"
                                                                        rows="5"
                                                                        placeholder="SEO Açıklamasını Giriniz"><?php echo $productDetail['seoDescription']; ?></textarea>
                                                                <input type="hidden" name="productProcess"
                                                                       value="update">
                                                                <input type="hidden" id="uniqueId" name="uniqueId"
                                                                       value="<?php echo $productDetail['uniqueId']; ?>">
                                                                <input type="hidden" id="langCode" name="langCode"
                                                                       value="<?php echo $langCode; ?>">


                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <div class="col-12">
                                                                <label>SEO+ Etiketleri</label>
                                                                <select class="form-control select2" id="tags" name="param" multiple="multiple">
                                                                    <?php
                                                                      $tagsGet=$dbclass->cek("ASSOC_ALL","tags","*","",array());
                                                                      foreach ($tagsGet as $key => $value) {
                                                                        $tagControl=$dbclass->cek("KAYITSAY","productsVsTags","count(id)","WHERE productId=? AND tagId=?",array($productDetail['id'],$value['id']));
                                                                        $selected="";
                                                                        if ($tagControl>0) $selected="selected";
                                                                        echo '
                                                                            <option value="'.$value['id'].'" '.$selected.'>'.$value['tagName'].'</option>  
                                                                        ';
                                                                      }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end::Group-->
                                                        <!--begin::Group-->
                                                        <div class="form-group row">
                                                            <button type="submit"
                                                                    class="btn btn-success font-weight-bold text-uppercase px-9 py-4"
                                                                    name="submitButton" id="productUpdateButton">
                                                                Bilgileri Güncelle
                                                            </button>
                                                        </div>
                                                        <!--end::Group-->
                                                    </form>
                                                </div>
                                            </div>
                                            <!--end::#productDetails Tab Content-->
                                            <!--begin::#gallery Content-->
                                            <div class="tab-pane" id="gallery" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!--begin::Advance Table Widget 1-->
                                                        <div class="card card-custom card-stretch gutter-b shadow-none">
                                                            <!--begin::Header-->
                                                            <div class="card-header border-0 py-5">
                                                                <h3 class="card-title align-items-start flex-column">
                                                                    <span class="card-label font-weight-bolder text-dark">Görsel Galerisi</span>
                                                                    <span
                                                                            class="text-muted mt-3 font-weight-bold font-size-sm">Bu menü altından Ürün için tanıtım görsellerini ve Ürün sonrası görsellerini düzenleyebilirsiniz. Maksimum 2MB boyutunda görseller kabul edilmektedir.</span>
                                                                </h3>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <div class="container py-0">
                                                                <div class="row border py-4 shadow rounded mb-20">
                                                                    <div class="col-lg-12">
                                                                        <h2 class="card-label font-weight-bolder text-dark text-center">
                                                                            Ürün Tanıtım Görselleri</h2>
                                                                      <?php $productMainImage = $functions->imageDetected($dbclass, 2, $productDetail['uniqueId'], $productDetail['langCode'], 0); ?>
                                                                        <div class="container m-0 p-0">
                                                                            <div class="row border-lg justify-content-center rounded bg-white m-0 text-center my-4 p-2 ">
                                                                              <?php
                                                                              foreach ($productMainImage as $key => $value) {
                                                                                ?>
                                                                                  <div class="col-2 mx-5 mb-4 border border-success rounded bg-light p-2">
                                                                                      <img class="img-fluid rounded"
                                                                                           style="height:150px;" alt=""
                                                                                           src="<?php echo $value[1]; ?>">
                                                                                      <a class="imageDetailGet btn btn-block btn-primary mt-3"
                                                                                         data-id="<?php echo $value[0]; ?>"
                                                                                         data-toggle="modal"
                                                                                         data-target="#imageDetailModal">Görseli
                                                                                          Düzenle</a>
                                                                                      <a class="imageDelete btn btn-block btn-danger mt-3"
                                                                                         data-id="<?php echo $value[0]; ?>">Görseli
                                                                                          Sil</a>
                                                                                  </div>
                                                                              <?php } ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="dropzone dropzone-default dropzone-primary"
                                                                                         id="productDesktop">
                                                                                        <div class="dropzone-msg dz-message needsclick">
                                                                                            <h3 class="dropzone-msg-title">
                                                                                                Görsel Yüklemek İçin
                                                                                                Tıklayın yada
                                                                                                Sürükleyin</h3>
                                                                                            <span class="dropzone-msg-desc">Sadece .jpg ve .png uzantılı görseller kabul edilmektedir.</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 my-5">
                                                                        <button class="btn btn-success font-weight-bold btn-block text-uppercase px-9 py-4 imageSave"
                                                                                data-id="<?php echo $productDetail['uniqueId']; ?>"
                                                                                data-lang="<?php echo $productDetail['langCode']; ?>"
                                                                                id="imageSave">Tanıtım Görsellerini
                                                                            Yükle
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-20">
                                                                    <div class="col-12">
                                                                        <h2 class="card-label font-weight-bolder text-dark text-center">
                                                                            Şema Görselleri</h2>
                                                                    </div>
                                                                    <div class="col-12 ">
                                                                      <?php
                                                                      $productImageDetected = $dbclass->cek("KAYITSAY", "images", "count(id)", "WHERE imageType=? AND sourceId=?", array(4, $productDetail['uniqueId']));
                                                                      if ($productImageDetected > 0) {
                                                                        $categoryMobileImage = $functions->imageDetected($dbclass, 4, $productDetail['id'], $productDetail['langCode'], 0); ?>
                                                                          <div
                                                                                  class="row border-lg justify-content-center rounded bg-white m-0 text-center my-4 p-2 ">
                                                                            <?php
                                                                            $endproductImagesGet = $dbclass->cek("ASSOC_ALL", "images", "id,imageLink", "WHERE imageType=? AND sourceId=?", array(4, $productDetail['uniqueId']));
                                                                            foreach ($endproductImagesGet as $key => $value) {
                                                                              ?>
                                                                                <div class="col-2 mx-5 mb-4 border border-success rounded bg-light p-2">
                                                                                    <img class="img-fluid rounded"
                                                                                         style="height:150px;"
                                                                                         alt=""
                                                                                         src="<?php echo $value['imageLink']; ?>">
                                                                                    <a class="imageDetailGet btn btn-block btn-primary mt-3"
                                                                                       data-id="<?php echo $value['id']; ?>"
                                                                                       data-toggle="modal"
                                                                                       data-target="#imageDetailModal">Görseli
                                                                                        Düzenle</a>
                                                                                    <a class="imageDelete btn btn-block btn-danger mt-3"
                                                                                       data-id="<?php echo $value['id']; ?>">Görseli
                                                                                        Sil</a>
                                                                                </div>
                                                                            <?php } ?>
                                                                          </div>
                                                                      <?php } ?>
                                                                        <div class="dropzone dropzone-default dropzone-primary my-10"
                                                                             id="productGallery">
                                                                            <div class="dropzone-msg dz-message needsclick">
                                                                                <h3 class="dropzone-msg-title">Görsel
                                                                                    Yüklemek İçin Tıklayın yada
                                                                                    Sürükleyin</h3>
                                                                                <span class="dropzone-msg-desc">Sadece .jpg ve .png uzantılı görseller kabul edilmektedir. Tek Seferde 10 Adet Görsel Yükleyebilirsiniz.</span>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-success font-weight-bold btn-block text-uppercase px-9 py-4 imageSave"
                                                                                data-id="<?php echo $productDetail['uniqueId']; ?>"
                                                                                data-lang="<?php echo $productDetail['langCode']; ?>">
                                                                            Şema Görsellerini Yükle
                                                                        </button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Advance Table Widget 1-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::#gallery Content-->
                                            <!--begin::#informations Content-->
                                            <div class="tab-pane" id="informations" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!--begin::Advance Table Widget 1-->
                                                        <div class="card card-custom card-stretch gutter-b shadow-none">
                                                            <!--begin::Header-->
                                                            <div class="card-header border-0 py-5">
                                                                <h3 class="card-title align-items-start flex-column">
                                                                    <span class="card-label font-weight-bolder text-dark">Ürün Yorumları</span>
                                                                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Bu menü altından ürününüz için yorumlar ekleyebilirsiniz.</span>
                                                                </h3>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <div class="container py-0" id="infoRow">
                                                                <div class="row rounded shadow py-5 mb-10">
                                                                    <div class="col-lg-5">
                                                                        <div class="form-group">
                                                                            <label>Müşteri Adı <span
                                                                                        class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                   id="infoTitle"
                                                                                   placeholder="Yorum Yapan Müşteri Adını Giriniz"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group">
                                                                            <label>Yorum İçeriği <span
                                                                                        class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                   id="infoContent"
                                                                                   placeholder="Yorum İçeriğini Giriniz"/>
                                                                        </div>
                                                                        <input type="hidden" id="productId"
                                                                               value="<?php echo $productDetail['uniqueId'] ?>">
                                                                        <input type="hidden" id="productLang"
                                                                               value="<?php echo $productDetail['langCode'] ?>">
                                                                    </div>
                                                                    <div class="col-lg-1 d-flex align-items-center justify-content-center">
                                                                        <button id="infoAdd"
                                                                                class="btn btn-primary mr-2 btn-block">
                                                                            Ekle
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                              <?php
                                                              $infosDetected = $dbclass->cek("ASSOC_ALL", "productInformations", "*", "WHERE productId=? AND langCode=?", array($productDetail['uniqueId'], $productDetail['langCode']));
                                                              foreach ($infosDetected as $key => $value) {
                                                                ?>
                                                                  <div class="row border rounded mb-5 py-3">
                                                                      <div class="col-lg-5">
                                                                          <div class="form-group">
                                                                              <label>Müşteri Adı <span
                                                                                          class="text-danger">*</span></label>
                                                                              <input type="text" class="form-control"
                                                                                     id="infoTitle<?php echo $value['id'] ?>"
                                                                                     value="<?php echo $value['infoTitle']; ?>"
                                                                                     placeholder="Yorum Yapan Müşteri Adını Giriniz"/>
                                                                          </div>
                                                                      </div>
                                                                      <div class="col-lg-7">
                                                                          <div class="form-group">
                                                                              <label>Yorum İçeriği <span
                                                                                          class="text-danger">*</span></label>
                                                                              <input type="text" class="form-control"
                                                                                     id="infoContent<?php echo $value['id'] ?>"
                                                                                     value="<?php echo $value['infoContent']; ?>"
                                                                                     placeholder="Yorum İçeriğini Giriniz"/>
                                                                          </div>
                                                                          <input type="hidden"
                                                                                 id="productId<?php echo $value['id'] ?>"
                                                                                 value="<?php echo $productDetail['uniqueId'] ?>">
                                                                          <input type="hidden"
                                                                                 id="productLang<?php echo $value['id'] ?>"
                                                                                 value="<?php echo $productDetail['langCode'] ?>">
                                                                          <input type="hidden"
                                                                                 id="infoId<?php echo $value['id'] ?>"
                                                                                 value="<?php echo $value['id'] ?>">
                                                                      </div>
                                                                      <div class="col-lg-12">
                                                                          <button
                                                                                  class="btn btn-primary mx-2 infoUpdate"
                                                                                  data-id="<?php echo $value['id'] ?>">
                                                                              Güncelle
                                                                          </button>
                                                                          <button
                                                                                  data-id="<?php echo $value['id'] ?>"
                                                                                  class="infoDelete btn btn-danger mx-2">
                                                                              Sil
                                                                          </button>
                                                                      </div>
                                                                  </div>
                                                              <?php } ?>

                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Advance Table Widget 1-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::#informations Content-->
                                            <!--begin::#informations Content-->
                                            <div class="tab-pane" id="variants" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <!--begin::Advance Table Widget 1-->
                                                        <div class="card card-custom card-stretch gutter-b shadow-none">
                                                            <!--begin::Header-->
                                                            <div class="card-header border-0 py-5">
                                                                <h3 class="card-title align-items-start flex-column">
                                                                    <span class="card-label font-weight-bolder text-dark">Ürün Varyasyonları</span>
                                                                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Bu menü altından ürününüz için farklı varyasyonlar ekleyibir, var olan varyasyonları düzenleyebilir ve silebilirsiniz.</span>
                                                                </h3>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Body-->
                                                            <div class="container py-0">
                                                                <div class="row rounded shadow py-5 mb-10">
                                                                    <div class="col-lg-12">
                                                                        <a href="yeni-urun"
                                                                                class="btn btn-block btn-primary mr-2 btn-block">
                                                                            Yeni Varyasyon Ekle
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <?php
                                                                    $variantsDetected = $dbclass->cek("ASSOC_ALL", "products", "*", "WHERE mainProduct=? AND langCode=?", array($productDetail['uniqueId'], $productDetail['langCode']));
                                                                    foreach ($variantsDetected as $key => $value) {
                                                                        $variantImage=$functions->imageDetected($dbclass, 2, $value['uniqueId'], $value['langCode'], 0);
                                                                        ?>
                                                                        <div class="col-md-4 col-xxl-4 col-lg-12">
                                                                            <!--begin::Card-->
                                                                            <div class="card card-custom card-shadowless">
                                                                                <div class="card-body p-0">
                                                                                    <!--begin::Image-->
                                                                                    <div class="overlay">
                                                                                        <div class="overlay-wrapper rounded bg-light text-center">
                                                                                            <img src="<?php echo $variantImage[0][1]; ?>" alt="" class="mw-100 w-200px">
                                                                                        </div>
                                                                                        <div class="overlay-layer">
                                                                                            <a href="urun-detay-<?php echo $value['uniqueId']."-".$value['langCode']; ?>" class="btn font-weight-bolder btn-sm btn-primary mr-2">Düzenle</a>
                                                                                            <a href="javascript:void(0);" class="btn font-weight-bolder btn-sm btn-light-danger variantDelete">Sil</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--end::Image-->
                                                                                    <!--begin::Details-->
                                                                                    <div class="text-center mt-5 mb-md-0 mb-lg-5 mb-md-0 mb-lg-5 mb-lg-0 mb-5 d-flex flex-column">
                                                                                        <a href="urun-detay-<?php echo $value['uniqueId']."-".$value['langCode']; ?>" class="font-size-h5 font-weight-bolder text-dark-75 text-hover-primary mb-1"><?php echo $value['productName']; ?></a>
                                                                                    </div>
                                                                                    <!--end::Details-->
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Card-->
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Advance Table Widget 1-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::#informations Content-->
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->
                  <?php include 'temp/footer.php'; ?>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->
        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                     height="24px"
                     viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24"/>
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
						<path
                                d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                                fill="#000000" fill-rule="nonzero"/>
					</g>
				</svg>
                <!--end::Svg Icon-->
			</span>
        </div>
        <!--end::Scrolltop-->
        <!-- Görsel Düzenleme Modalı-->
        <div class="modal fade bd-example-modal-lg" id="imageDetailModal" tabindex="-1" role="dialog"
             aria-labelledby="staticBackdrop"
             aria-hidden="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Görsel Bilgileri Düzenleniyor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form" id="imageDetailForm" name="imageDetailForm" method="post"
                              enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Görsel Sıra Numarası <span
                                                class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="orderNumber" id="orderNumber"
                                           value="">
                                    <span class="form-text text-muted">Görselin hangi sırada gösterileceğini giriniz</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Görsel Başlığı <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="">
                                    <span class="form-text text-muted">Görselin başlığını giriniz</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Görsel Açıklaması <span
                                                class="text-danger">*</span></label>
                                    <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                                    <span class="form-text text-muted">Görselin açıklamasını giriniz</span>
                                </div>
                            </div>
                            <div class="form-group row" id="imageTableDiv">
                                <div class="col-12">
                            <textarea class="form-control form-control-solid form-control-lg summernote"
                                      name="imageTable" id="imageTable"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label class="form-control-label">Görselin Hedef Linki <span
                                                class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="hrefUrl" id="hrefUrl" value="">
                                    <span class="form-text text-muted">Görsele Tıklandığında gideceği linki giriniz</span>
                                    <input type="hidden" name="imageUpdateId" id="imageUpdateId" value="">
                                </div>
                            </div>
                            <input type="submit" name="imageDetailUpdateButton" id="imageDetailUpdateButton"
                                   class="btn btn-success font-weight-bold mr-2" value="Kaydet">
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Görsel Düzenleme Modalı-->
      <?php include 'temp/footer-scripts.php'; ?>
        <script src="assets/js/pages/crud/forms/editors/summernote.js?v=7.0.3"></script>
        <script src="assets/js/pages/custom/products/product-detail.js"></script>
        <script src="assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.3"></script>
        <script src="assets/js/pages/crud/forms/widgets/select2.js?v=7.0.3"></script>
    </body>
    <!--end::Body-->
    </html>
  <?php
} else { // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>

