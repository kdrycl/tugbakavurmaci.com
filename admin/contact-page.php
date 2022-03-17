<?php
session_start();
include 'dbclass/dbclassinclude.php';
$sessionControl=$dbclass->cek("KAYITSAY","users","count(id)","where id=?",array($_SESSION['userid']['id']));
if ($sessionControl>0) { // kullanıcı giriş yapmış mı kontrol ediliyor giriş yapmışsa sayfaya yönlendiriliyor
  $contactDetails=$dbclass->cek("ASSOC","contact","*","WHERE id=?",array(1)); // kategorileri listelemek için kullanılıyor
  $pageTitle=" iletişim Bilgileri";
  $productAction="contactUpdateInput";
  $productId="add";
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
                <form class="form dropzone border-0" id="contactDetail" name="contactDetail" method="post" enctype="multipart/form-data">
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
                    </div>
                  <div class="card-body" id="cardBody">
                    <div class="form-group row">
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Cep Telefonu Numarası <span class="text-danger">*</span></label>
                        <input type="text" name="mobileNumber" class="form-control" value="<?php echo $contactDetails['mobileNumber']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen GSM Numaranızı Giriniz. Başında "0" olmadan 10 hane olarak giriniz</span>
                      </div>
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Sabit Telefon Numarası</label>
                        <input type="text" name="phoneNumber" class="form-control" value="<?php echo $contactDetails['phoneNumber']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen Sabit Telefon Numaranızı Giriniz. Başında "0" olmadan 10 hane olarak giriniz</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >WhatsApp Numarası <span class="text-danger">*</span></label>
                        <input type="text" name="wpNumber" class="form-control" value="<?php echo $contactDetails['wpNumber']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen WhatsApp Numaranızı Giriniz. Başında "0" olmadan 10 hane olarak giriniz</span>
                      </div>
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Facebook Sayfa Linki</label>
                        <input type="text" name="facebook" class="form-control" value="<?php echo $contactDetails['facebook']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen Facebook sayfa linkinizi giriniz. Örn: https://facebook.com/seratumedya</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Instagram Sayfa Linki</label>
                        <input type="text" name="instagram" class="form-control" value="<?php echo $contactDetails['instagram']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen Instagram sayfa linkinizi giriniz. Örn: https://instagram.com/seratumedya</span>
                      </div>
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Twitter Sayfa Linki</label>
                        <input type="text" name="twitter" class="form-control" value="<?php echo $contactDetails['twitter']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen Twitter sayfa linkinizi giriniz. Örn: https://twitter.com/seratumedya</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Kurumsal Mail Adresi</label>
                        <input type="text" name="mail1" class="form-control" value="<?php echo $contactDetails['mail1']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">mail@siteadi.com olarak belirlenen kurumsal mail adresinizi giriniz.</span>
                      </div>
                      <div class="col-12 col-lg-6">
                        <label class="form-control-label" >Diğer Mail adresi</label>
                        <input type="text" name="mail2" class="form-control" value="<?php echo $contactDetails['mail2']; ?>" />
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Gmail, Yahoo gibi farklı mail sunucuları üzerinden kullandığınız mail adresini girin</span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-12">
                        <label class="form-control-label" >Açık Adres <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="adress" rows="3"><?php echo $contactDetails['adress']; ?></textarea>
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen İşyerinizin Açık Adresini Giriniz</span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-12">
                        <label class="form-control-label" >Google Harita Kodu <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="mapCode" rows="3"><?php echo $contactDetails['mapCode']; ?></textarea>
                        <div class="valid-feedback"></div>
                        <span class="form-text text-muted">Lütfen İşyerinizin Google Haritalardaki "Harita Yerleştirme Kodunu" Giriniz</span>
                      </div>
                    </div>

                  </div>
                  <div class="card-footer">
                    <input type="hidden" value="<?php echo $productId ?>" name="<?php echo $productAction ?>">
                    <button type="submit" id="productOperation" name="productOperation"  class="btn btn-success font-weight-bold mr-2">Kaydet</button>
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
  <?php include 'temp/footer-scripts.php'; ?>
  <!--begin::Page Vendors(used by this page)-->
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  <script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
  <!--begin::Page Vendors(used by this page)-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
  <script src="assets/js/contact-page.js"></script>

  <!--begin::Page Scripts(used by this page)-->
  </body>
	<!--end::Body-->
</html>
<?php
}
else{ // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>