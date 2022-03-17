<?php
session_start();
$title='Hizmet';
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
        <title>Yeni <?php echo ucfirst($title); ?> Ekleniyor</title>
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
        <a href="index.html">
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
                                    <h2 class="text-white font-weight-bold my-2 mr-5">Yeni <?php echo ucfirst($title); ?> Ekleniyor</h2>
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
                                                <span class="card-label font-weight-bolder text-dark"><?php echo ucfirst($title); ?> İçeriği</span>
                                                <span class="text-muted mt-3 font-weight-bold font-size-sm">Eklemek İstediğiniz <?php echo ucfirst($title); ?> Bu Alandan Oluşturabilirsiniz.</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body pt-3 pb-0">
                                          <?php
                                        //   $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 16);
                                        //   if ($permissionControl == 0) {  // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
                                        //     $functions->errorList("noBlogProcess");
                                        //   }
                                          ?>
                                            <form class="form" id="services_form">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group mb-5">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Hizmet Adı</label>
                                                            <input class="form-control h-auto form-control-solid py-4 px-8"
                                                                   type="text" placeholder="Hizmet Başlığı"
                                                                   name="servicesname"
                                                                   autocomplete="off" value=""/>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="form-group mb-5">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Hizmet Kısa Açıklaması</label>
                                                            <input class="form-control h-auto form-control-solid py-4 px-8"
                                                                   type="text" placeholder="Hizmet kısa açıklama"
                                                                   name="sorttext"
                                                                   autocomplete="off" value=""/>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                             
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label class="col-form-label">Hizmet İcon 1 (40x40) </label>
                                                        <div class="dropzone dropzone-default dropzone-primary"
                                                             id="servicesDesktop">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Görsel Yüklemek İçin Tıklayın yada Sürükleyin</h3>
                                                                <span class="dropzone-msg-desc">Sadece .jpg ve .png uzantılı görseller kabul edilmektedir. 40x40 px önerilmektedir.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label class="col-form-label">Hizmet İcon 2 (120x122) </label>
                                                        <div class="dropzone dropzone-default dropzone-primary"
                                                             id="servicesDesktop2">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Görsel Yüklemek İçin Tıklayın yada Sürükleyin</h3>
                                                                <span class="dropzone-msg-desc">Sadece .jpg ve .png uzantılı görseller kabul edilmektedir. 120x122 px önerilmektedir.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label class="col-form-label">Hizmet Resmi (650x406) </label>
                                                        <div class="dropzone dropzone-default dropzone-primary"
                                                             id="servicesDesktop3">
                                                            <div class="dropzone-msg dz-message needsclick">
                                                                <h3 class="dropzone-msg-title">Görsel Yüklemek İçin Tıklayın yada Sürükleyin</h3>
                                                                <span class="dropzone-msg-desc">Sadece .jpg ve .png uzantılı görseller kabul edilmektedir. 650x406 px önerilmektedir.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label>Hizmet İçeriği</label>
                                                            <textarea
                                                            class="form-control form-control-solid form-control-lg summernote"
                                                            name="detail"
                                                            id=""></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group mb-5">
                                                        <label class="col-xl-3 col-lg-3 col-form-label">Hizmet Sırası</label>
                                                        <input class="form-control h-auto form-control-solid py-4 px-8"
                                                                type="number" placeholder="Hizmet Başlığı"
                                                                name="sort"
                                                                autocomplete="off" value="999"/>
                                                    </div>
                                                </div>
                                                <!--end::Group-->
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group mb-5">
                                                        <button id="services_add"
                                                                class="btn btn-primary font-weight-bold px-9 py-4 mr-5 ml-0">
                                                            Kaydet
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
    <script src="assets/js/pages/crud/forms/editors/summernote.js?v=7.0.3"></script>
    <script src="assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.3"></script>
    <script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
    <script src="assets/js/pages/custom/services/services.js"></script>
    </body>
    <!--end::Body-->
    </html>
  <?php
} else { // session yok ise giriş yap sayfasına yönlendiriliyor
  header('location:giris-yap');
}
?>