<?php
session_start();
include 'dbclass/dbclassinclude.php';
$sessionControl=$dbclass->cek("KAYITSAY","users","count(id)","where id=?",array($_SESSION['userid']['id']));
if ($sessionControl>0) { // kullanıcı giriş yapmış mı kontrol ediliyor giriş yapmışsa sayfaya yönlendiriliyor
  if (isset($_GET['id'])) {
    $productDetected=$dbclass->cek("KAYITSAY","galleries","COUNT(id)","WHERE id=?",array($_GET['id']));
    if ($productDetected>0) {
      $productSelect=$dbclass->cek("ASSOC","galleries","*","WHERE id=?",array($_GET['id'])); // düzenlenen kategorinin bilgileri getiriliyor
      $pageTitle='"'.$productSelect['galleryName'].'"'." İsimli Galeri Bilgileri Düzenleniyor";
      $productAction="sliderUpdateInput";
      $productId=$_GET['id'];
      if ($productSelect['galleryType']==1) {
        $status="slider";
        $fileSize=10;
      }
      else if ($productSelect['galleryType']==2) {
        $status="banner";
        $fileSize=1;
      }
    }
    else{
      echo "Aradığınız Araç Bulunamadı";
      exit;
    }
  }
  else if(isset($_GET['ekle'])){
      $pageTitle=" Yeni Araç Ekleniyor";
      $productAction="sliderAddInput";
      $productId="add";
  }

?>
<!DOCTYPE html>
<html lang="tr-TR">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title><?php echo $pageTitle ?> - Seratu Medya Yönetim Paneli</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include 'temp/header-scripts.php'; ?>
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					
					<!--begin::Header-->
					<?php include 'temp/header-menu.php'; ?>
					<!--end::Header-->
					<!--begin::Container-->
					<div class="d-flex flex-row flex-column-fluid container">
						<!--begin::Content Wrapper-->
						<div class="main d-flex flex-column flex-row-fluid">
							<div class="content flex-column-fluid p-0 p-lg-4" >
								<!--begin::Dashboard-->
                <form class="form dropzone border-0" id="new_slider" name="new_slider" method="post" enctype="multipart/form-data">
                <div class="card card-custom">
                  <div class="card-header">
                      <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon-plus text-primary"></i>
                        </span>
                        <h3 class="card-label">
                          <?php echo $pageTitle; ?>
                        </h3>
                      </div>
                        <div class="card-toolbar">
                            <a href="#" class="btn btn-sm btn-info font-weight-bold">
                                <i class="flaticon-questions-circular-button"></i> Yardım
                            </a>
                        </div>
                        <span class="form-text w-100 text-left"><?php echo $productSelect['galleryDescription']; ?></span>
                    </div>
                  <div class="card-body" id="cardBody">
                    <div class="form-group row">
                      <div class="col-12">
                        <input type="hidden" id="fileSize" data-id="<?php echo $fileSize; ?>" value="<?php echo $productId ?>" name="<?php echo $productAction ?>">
                      </div>
                    </div>
                      <div class="form-group row bg-light">
                      <div class="col-12 mb-3 mt-0">
                        <label class="form-control-label w-100 text-center font-size-h2 p-1" >
                          Galeri Görsellerini Yükleyiniz <span class="text-danger">*</span>
                          <span class="form-text w-100 text-center">Lütfen galeri görsellerinizi yükleyin.</span>
                        </label>
                      </div>
                      
                      <div class="col-12 my-3">
                        <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_3">
                          <div class="dropzone-msg dz-message needsclick">
                            <h3 class="dropzone-msg-title">Görselleri Sürükleyin veya  Seçin</h3>
                            <span class="dropzone-msg-desc">
                            <?php
                              echo "Her ".$status." İçin Maksimum ".$fileSize." Adet Görsel Yükleyebilirsiniz.";
                            ?> 
                            </span>
                          </div>
                          
                        </div>
											</div>    
                      <div class="col-12 pb-3" id="imagesDiv">
                        <?php
                            if(isset($_GET['id'])){
                              $imageCount=$dbclass->cek("KAYITSAY","images","count(id)","WHERE imageType=? AND sourceId=?",array("slider",$_GET['id']));
                              if ($imageCount>0) {
                                $photoGet=$dbclass->cek("ASSOC_ALL","images","*","WHERE imageType=? AND  sourceId=?",array("slider",$_GET['id']));
                                foreach ($photoGet as $key => $value) {
                            ?>
                            <div class="col-6 col-lg-2 float-left border-lg rounded bg-white pb-3 text-center">
                              <a class="imageDelete btn btn-link text-info" data-id="<?php echo $value['id']; ?>">Resmi Sil</a>
                              <img class="img-fluid" style="max-height:75px;" alt="" src="<?php echo $value['imageLink']; ?>">
                              <button type="button" class="btn btn-link text-info imageDetailGet" data-id="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#imageDetailModal">Resmi Düzenle</button>
                            </div>
                            <?php
                                }
                              }
                            }
                            ?>
                      </div>
                        
                           
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" id="sliderOperation" name="sliderOperation"  class="btn btn-success font-weight-bold mr-2">Kaydet</button>
                    <button type="reset" class="btn btn-light-success font-weight-bold">Temizle</button>
                  </div>
                </div>
                  </form>
                <div id="sonuc"></div>
                
								<!--end::Dashboard-->
							</div>
							<!--end::Content-->
						</div>
						<!--begin::Content Wrapper-->
					</div>
					<!--end::Container-->

					<!--begin::Footer-->
					<?php include 'temp/footer.php'; ?>
					
          <!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
    <!-- Görsel Düzenleme Modalı-->
    <div class="modal fade" id="imageDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Görsel Bilgileri Düzenleniyor</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
              </button>
          </div>
          <div class="modal-body">
            <form class="form" id="imageDetailForm" name="imageDetailForm" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <div class="col-12">
                  <label class="form-control-label" >Görsel Sıra Numarası <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" name="rowNumber" id="rowNumber" value="">
                  <span class="form-text text-muted">Görselin hangi sırada gösterileceğini giriniz</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12">
                  <label class="form-control-label" >Görsel Başlığı <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="imageTitle" id="imageTitle" value="">
                  <span class="form-text text-muted">Görselin başlığını giriniz</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12">
                  <label class="form-control-label" >Görsel Açıklaması <span class="text-danger">*</span></label>
                  <textarea class="form-control" name="imageDescription" id="imageDescription" rows="3"></textarea>
                  <span class="form-text text-muted">Görselin açıklamasını giriniz</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12">
                  <label class="form-control-label" >Görselin Hedef Linki <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="imageHrefUrl" id="imageHrefUrl" value="">
                  <span class="form-text text-muted">Görsele Tıklandığında gideceği linki giriniz</span>
                  <input type="hidden" name="imageUpdateId" id="imageUpdateId" value="">
                </div>
              </div>
              <input type="submit" name="imageDetailUpdateButton" id="imageDetailUpdateButton"  class="btn btn-success font-weight-bold mr-2" value="Kaydet">
            </form>
          </div>

        </div>
      </div>
    </div>
    <!-- Görsel Düzenleme Modalı-->
  <?php include 'temp/footer-scripts.php'; ?>
  <!--begin::Page Vendors(used by this page)-->
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  <script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
  <!--begin::Page Vendors(used by this page)-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
  <script src="assets/js/slider-page.js"></script>
  </body>
	<!--end::Body-->
</html>
<?php
}
else{ // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>