<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
<!--end::Fonts-->
<!--begin::Global Theme Styles(used by all pages)-->
<link href="assets/plugins/global/plugins.bundle.css?v=7.0.3" rel="stylesheet" type="text/css"/>
<link href="assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.3" rel="stylesheet" type="text/css"/>
<link href="assets/css/style.bundle.css?v=7.0.3" rel="stylesheet" type="text/css"/>
<!--end::Global Theme Styles-->
<!--begin::Layout Themes(used by all pages)-->
<!--end::Layout Themes-->
<link rel="shortcut icon" href="assets/media/logos/favicon.ico"/>
<?php
if (isset($_SESSION['imageDetails'])) {
  unset($_SESSION['imageDetails']);
}
?>