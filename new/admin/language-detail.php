<?php
session_start();
include 'dbclass/dbclassinclude.php';
$sessionControl=$dbclass->cek("KAYITSAY","users","count(id)","where id=?",array($_SESSION['userid']['id']));
if ($sessionControl>0) { // kullanıcı giriş yapmış mı kontrol ediliyor giriş yapmışsa sayfaya yönlendiriliyor
$languageDetail=$dbclass->cek("ASSOC","languages","*","WHERE id=?",array($_GET['id']));
?>
<!DOCTYPE html>
<html lang="tr">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title><?php echo $languageDetail['langName'] ?> Adlı Dil Bilgileri</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<?php include 'temp/head-tags.php'; ?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" style="background-image: url(assets/media/bg/bg-10.jpg)" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile">
			<!--begin::Logo-->
			<a href="index.html">
				<img alt="Logo" src="assets/media/logos/logo-letter-1.png" class="logo-default max-h-30px" />
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
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
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
										<h2 class="text-white font-weight-bold my-2 mr-5"><?php echo $languageDetail['langName'] ?> Adlı Dil Bilgileri</h2>
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
  
								<!--begin::Row-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Advance Table Widget 2-->
										<div class="card card-custom card-stretch gutter-b">
											<!--begin::Header-->
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark">Dil Bilgileri</span>
													<span class="text-muted mt-3 font-weight-bold font-size-sm">Dilin Bilgilerini Bu Alandan Görüntüleyebilir ve Güncelleyebilirsiniz. Ana link yapıları belirlenirken türkçe karakter ve boşluk kullanmayınız. Sadece alfanümerik karakterler, sayılar ve (-) kullanınız.</span>
												</h3>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-3 pb-0">
                        <?php
                        $permissionControl=$functions->permissionControl($dbclass,$_SESSION['userid']['id'],9);
                          if ($permissionControl==0){  // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
                            $functions->errorList("nolanguageProcess");
                          }
                        ?>
												<form class="form" id="language_form">
													<div class="row">
														<div class="col-12 col-lg-12">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Dil Adı</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Dil Adı"
																	name="langName" autocomplete="off" value="<?php echo $languageDetail['langName']; ?>"/>
                                <span class="d-block text-muted pt-2 font-size-sm">Eklediğiniz dilin sitede dil seçimi menüsünde gösterilecek adını giriniz.</span>

															</div>
														</div>
													</div>
                          <div class="row">
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Dil Kısa Kodu</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Dil Kısa Kodu"
																	name="langShortCode" autocomplete="off" value="<?php echo $languageDetail['langShortCode']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Eklediğiniz dilin kısa dil kodunu giriniz. Maksimum 4 karakter olarak girebilirsiniz. Örnek: "TR", "FR", "EN" vb.</span>
															</div>
														</div>
														<div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Kategori Ana linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Kategori Ana Link Koduc"
																	name="categorySlug" autocomplete="off" value="<?php echo $languageDetail['categorySlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Kategori listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Etiket Ana Linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Etiket Ana Linki"
																	name="tagSlug" autocomplete="off" value="<?php echo $languageDetail['tagSlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Etiket listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
													</div>
                          <div class="row">
														<div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Sayfa Ana linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Sayfa Ana Link Koduc"
																	name="pageSlug" autocomplete="off" value="<?php echo $languageDetail['pageSlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Sayfa listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Blog Ana Linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Blog Ana Linki"
																	name="blogSlug" autocomplete="off" value="<?php echo $languageDetail['blogSlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Blog listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Ürün Ana linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Ürün Ana Link Koduc"
																	name="productSlug" autocomplete="off" value="<?php echo $languageDetail['productSlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Ürün listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
													</div>
													<div class="row">
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Arama Sayfası Ana Linki</label>
																<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Arama Sayfası Ana Linki"
																	name="searchSlug" autocomplete="off" value="<?php echo $languageDetail['searchSlug']; ?>"/>
                                  <span class="d-block text-muted pt-2 font-size-sm">Arama sonuçları listeleme sayfalarında adres çubuğunda gösterilecek link yapısını giriniz. Türkçe karakter ve boşluk kullanmayınız.</span>
															</div>
														</div>
														<div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-lg-12 col-form-label">Dil Yazım Yönü</label>
																<select name="langDirection" class="form-control">
                                  <?php
                                    $rtl="";
                                    $ltr="";
                                    if($languageDetail['langDirection']==0) $ltr="selected";
                                    else if($languageDetail['langDirection']==1) $rtl="selected";
                                  ?>
                                  <option value="0"<?php echo $ltr; ?>>Soldan Sağa</option>
                                  <option value="1"<?php echo $rtl; ?>>Sağdan Sola</option>
                                </select>
                                <span class="d-block text-muted pt-2 font-size-sm">Eklediğiniz dilin soldan sağa doğru mu yoksa sağdan sola doğru mu yazıldığını belirtiniz.</span>
															</div>
														</div>
                            <div class="col-12 col-lg-4">
															<div class="form-group mb-5">
																<label class="col-xl-12 col-form-label">Durumu</label>
																	<select class="form-control form-control-lg form-control-solid" id="recordStatus" name="recordStatus">
																	<?php 
																		$statupassive="";
																		$statuactive="";
																		if($languageDetail['status']==0)$statupassive="selected";
																		else$statuactive="selected";
																	?>
																	<option value="1"<?php echo $statuactive; ?>>Aktif</option>
																	<option value="0"<?php echo $statupassive; ?>>Pasif</option>
																</select>
                                <span class="d-block text-muted pt-2 font-size-sm">Eklediğiniz dili sitede aktif ya da pasif duruma getirebilirsiniz.</span>
															</div>
														</div>
													</div>
													<div class="col-12">
														<div class="form-group mb-5">
                              <input type="hidden" name="langDetailUpdate" value="<?php echo $languageDetail['id'] ?>">
															<button id="language_detail_update" class="btn btn-block btn-primary font-weight-bold px-9 py-4">
																Dil Ayarlarını Kaydet
															</button>
														</div>
													</div>
												</form>
											</div>
											<!--end::Body-->
										</div>
										<!--end::Advance Table Widget 2-->
                    
									</div>
								</div>
								<!--end::Row-->

                	<!--begin::Row-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Advance Table Widget 2-->
										<div class="card card-custom card-stretch gutter-b">
											<!--begin::Header-->
											<div class="card-header border-0 pt-5">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark">Dil Bilgileri</span>
													<span class="text-muted mt-3 font-weight-bold font-size-sm">Dilin Bilgilerini Bu Alandan Görüntüleyebilir ve Güncelleyebilirsiniz. Ana link yapıları belirlenirken türkçe karakter ve boşluk kullanmayınız. Sadece alfanümerik karakterler, sayılar ve (-) kullanınız.</span>
												</h3>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body pt-3 pb-0">
                        <?php
                        $permissionControl=$functions->permissionControl($dbclass,$_SESSION['userid']['id'],9);
                          if ($permissionControl==0){  // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
                            $functions->errorList("nolanguageProcess");
                          }
                        ?>
												<form class="form" id="constant_form">
                          <?php
                            $groupConstants=$dbclass->cek("ASSOC_ALL","siteConstants","*","WHERE lang=? GROUP BY pageCode ORDER BY id ASC",array($languageDetail['langShortCode']));
                            foreach ($groupConstants as $key => $value) {
                            if($value['pageCode']=="HEDMENU"){
                              $title="Site Üst Menü Değişkenleri";
                              $message="Sitenizin Header Menü olarak adlandırılan üst tarafındaki menü kısmında kullanılan dil değişkenlerini bu alandan düzenleyebilirsiniz.";
                            } 
                            else if($value['pageCode']=="HOMEPAG"){
                              $title="Anasayfa Değişkenleri";
                              $message="Sitenizin anasayfasında kullanılan dil  değişkenlerini bu alandan düzenleyebilirsiniz.";
                            } 
                            else if($value['pageCode']=="FOOTER"){
                              $title="Site Alt Kısım Değişkenleri";
                              $message="Sitenizin Footer Alanı olarak adlandırılan ve sitenin en altında bulunan kısımdaki dil değişkenlerini bu alandan düzenleyebilirsiniz.";
                            } 

                            ?>
                              <div class="row border mb-5 rounded">
                                <div class="col-12 mb-5 py-4 border-bottom text-center">
                                  <h3 class="card-label font-weight-bolder text-dark h3 w-100"><?php echo $title; ?></h3>
                                  <span class="card-label text-muted w-100"><?php echo $message; ?></span>
                                </div>
                                <div class="col-12">
																	<div class="row">

																	<?php
																	$constants=$dbclass->cek("ASSOC_ALL","siteConstants","*","WHERE lang=? AND pageCode=?",array($languageDetail['langShortCode'],$value['pageCode']));
																	foreach ($constants as $keys => $values) {
																		$turkishConstants=$dbclass->cek("ASSOC","siteConstants","*","WHERE lang=? AND constCode=?",array("TR",$values['constCode']));
																	?>
																		<div class="col-12 col-lg-6">
																			<div class="form-group">
																				<label><?php echo $turkishConstants['constValue'] ?></label>
																				<input class="form-control h-auto form-control-solid py-4 px-8" type="text"
																				name="<?php echo $values['constCode'] ?>" autocomplete="off" value="<?php echo $values['constValue']; ?>"/>
																				
																			</div>
																		</div>
																	<?php } ?>
																	</div>
																</div>
                              </div>
                            <?php } ?>
													<div class="col-12">
														<div class="form-group mb-5">
                              <input type="hidden" name="langConstUpdate" id="langConstUpdate" value="<?php echo $languageDetail['langShortCode'] ?>">
															<button id="constants_update" class="btn btn-block btn-primary font-weight-bold px-9 py-4">
																Dil Değişkenlerini Kaydet
															</button>
														</div>
													</div>
												</form>
											</div>
											<!--end::Body-->
										</div>
										<!--end::Advance Table Widget 2-->
                    
									</div>
								</div>
								<!--end::Row-->


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
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</div>
		<!--end::Scrolltop-->
		<?php include 'temp/footer-scripts.php'; ?>
	<script src="assets/js/pages/custom/languages/language-detail.js"></script>
    <script src="assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.3"></script>


	</body>
	<!--end::Body-->
</html>
<?php
}
else{ // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>