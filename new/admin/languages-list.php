<?php
session_start();
include 'dbclass/dbclassinclude.php';
$sessionControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "where id=?", array($_SESSION['userid']['id']));
if ($sessionControl > 0) { // kullanıcı giriş yapmış mı kontrol ediliyor giriş yapmışsa sayfaya yönlendiriliyor
  ?>
    <!DOCTYPE html>
    <html lang="tr">
    <!--begin::Head-->
    <head>
        <base href="">
        <meta charset="utf-8"/>
        <title>Diller Listeleniyor</title>
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
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                      fill="#000000" fill-rule="nonzero" opacity="0.3"/>
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
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
                                    <h2 class="text-white font-weight-bold my-2 mr-5">Dil Yönetimi</h2>
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
                            <div class="card card-custom">
                                <!--begin::Header-->
                                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                    <div class="card-title">
                                        <h3 class="card-label">Site Dil Ayarları
                                            <span class="d-block text-muted pt-2 font-size-sm">
												Bu menüde sitenize eklediğiniz dilleri inceleyebilir, güncelleyebilir ve silebilirsiniz.</span>
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <!--begin::Button-->
                                        <button type="button" id="langAddModalButton"
                                                class="btn btn-primary font-weight-bolder text-uppercase mr-3"
                                                data-toggle="modal" data-target="#langAddModal">
                                            <i class="fas fa-flag"></i>Yeni Dil Ekle
                                        </button>
                                        <!--end::Button-->
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body">
                                  <?php
                                  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 9);
                                  if ($permissionControl == 0) { // kullanıcının, yönetim panelinde kullanıcı listeleme izni kontrol ediliyor
                                    $functions->errorList("noPermissionProcess");
                                  }
                                  ?>
                                    <!--begin::Search Form-->
                                    <div class="mb-7">
                                        <div class="form-group row align-items-center">
                                            <div class="col-lg-12">
                                                <div class="row align-items-end">
                                                    <div class="col-12 col-lg-4">
                                                        <label for="blogSearch">Dil Adı ile Arama</label>
                                                        <div class="input-icon">
                                                            <input type="text" id="langSearch" class="form-control"
                                                                   placeholder="Dil Arama..." id="userSearch"/>
                                                            <span>
																	<i class="flaticon2-search-1 text-muted"></i>
																</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-1 text-right">
                                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold">Arama</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-5">
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Search Form-->
                                    <!--begin: Datatable-->
                                    <div class="datatable datatable-bordered datatable-head-custom"
                                         id="kt_datatable"></div>
                                    <!--end: Datatable-->
                                </div>
                                <!--end::Body-->
                                <!-- New Lang Modal-->
                                <div class="modal fade" id="langAddModal" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Yeni Dil Ekle</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!--begin::Form-->
                                            <form class="form" id="newLangForm">
                                                <div class="modal-body">
                                                  <?php
                                                  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 9);
                                                  if ($permissionControl == 0) { // kullanıcının, yönetim panelinde etkinlik ekleme ve düzenleme izni kontrol ediliyor
                                                    $functions->errorList("noPermissionProcess");
                                                  }
                                                  ?>
                                                    <div class="form-group">
                                                        <label>Dil Adı</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               name="langName" placeholder="Dil Adını Giriniz"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Eklemek İstediğiniz Dilin Sitede Gösterilecek Adını Giriniz.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Dil Kısa Kodu</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               name="langShortCode"
                                                               placeholder="Dil Kısa Kodunu Giriniz"/>
                                                        <input type="hidden" name="langAdd" value="1">
                                                        <span class="d-block text-muted pt-2 font-size-sm">Ekleyeceğiniz dilin kısa harf kodunu giriniz. Benzersiz ve maksimum 4 karakterden oluşmalıdır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Kategori Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="categorySlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen kategorilerin ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Etiket Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="tagSlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen etiketlerin ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sayfa Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="pageSlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen sayfaların ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Blog Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="blogSlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen blogların ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Ürün Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="productSlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen ürünlerin ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Arama Sayfası Ana Linki</label>
                                                        <input type="text"
                                                               class="form-control form-control-solid form-control-lg"
                                                               placeholder="Dil Kısa Kodunu Giriniz" name="searchSlug"/>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Listelenen ürünlerin ana link yapısı için bu alan kullanılacaktır.</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Dil Yazım Yönü</label>
                                                        <select name="langDirection" class="form-control">
                                                            <option value="0">Soldan Sağa</option>
                                                            <option value="1">Sağdan Sola</option>
                                                        </select>
                                                        <span class="d-block text-muted pt-2 font-size-sm">Eklemek İstediğiniz Dilin Yazım Yönünü Seçiniz.</span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="submitButton"
                                                            id="addLangButton">Dil Ekle
                                                    </button>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Vazgeç
                                                    </button>
                                                </div>
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                    </div>
                                </div>
                                <!-- New Lang Modal-->
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
                     height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24"/>
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                              fill="#000000" fill-rule="nonzero"/>
					</g>
				</svg>
                <!--end::Svg Icon-->
			</span>
    </div>
    <!--end::Scrolltop-->
    <?php include 'temp/footer-scripts.php'; ?>
    <!--begin::Page Scripts(used by this page)-->
    <script src="assets/js/pages/custom/languages/language-list.js"></script>
    <!--end::Page Scripts-->
    </body>
    <!--end::Body-->
    </html>
  <?php
} else { // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>