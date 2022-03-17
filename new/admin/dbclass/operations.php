<?php
include 'dbclassinclude.php';
session_start();
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
error_reporting(E_ALL);
ini_set("display_errors", 1);

############################################################################################
############################# YÖNETİM PANELİ İŞLEMLERİ #####################################
############################################################################################

## YÖNETİM PANELİNE GİRİŞ YAPILIYOR ##
if (isset($_POST['loginOperations'])) {
  $pass = md5(sha1($_POST['password']));
  $userControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "WHERE email=? AND password=? AND adminUser=?", array($_POST['email'], $pass, 1));
  if ($userControl > 0) {
    $userGet = $dbclass->cek("ASSOC", "users", "id", "WHERE email=? AND password=? AND adminUser=?", array($_POST['email'], $pass, 1));
    $_SESSION['userid'] = $userGet;
    echo json_encode(array("success", "Giriş Başarılı Yönlendiriliyorsunuz"));
  } else {
    echo json_encode(array("error", "Giriş Yapılamadı! Lütfen E-Posta ve Şifrenizi Kontrol Ediniz"));
  }
}
## YÖNETİM PANELİNE GİRİŞ YAPILIYOR ##
## YÖNETİM PANELİNDEN ÇIKIŞ YAPILIYOR ##
else if (isset($_POST['logOut'])) {
  session_destroy();
  echo json_encode(array("success", "Oturum Sonlandırılıyor"));
}
## YÖNETİM PANELİNDEN ÇIKIŞ YAPILIYOR ##
## ŞEHİRLER GETİRİLİYOR ##
else if (isset($_POST['countryId'])) { // Seçilen ülkenin şehirleri listeleniyor
  $countryControl = $dbclass->cek("KAYITSAY", "countries", "count(id)", "WHERE id=?", array($_POST['countryId']));
  if ($countryControl > 0) {
    $cityGet = $dbclass->cek("ASSOC_ALL", "cities", "cityName,id", "WHERE countryId=?", array($_POST['countryId']));
    $cities['data'] = array();
    foreach ($cityGet as $key => $value) {
      echo '<option value="' . $value['id'] . '">' . $value['cityName'] . '</option>';
    }
  }
}
## ŞEHİRLER GETİRİLİYOR ##
################################# GÖRSEL İŞLEMLERİ #################################
## GÖRSEL YÜKLENİYOR ##
else if (isset($_FILES['imageUpload'])) {
  $tempFile = $_FILES['imageUpload']['tmp_name'];
  $targetPath = "../../uploads/sliders/";
  $bol = explode('.',$_FILES['imageUpload']['name']);
  $targetFile = $targetPath . $dbclass->seo($bol[0]).'.'.$bol[1];
  if (move_uploaded_file($tempFile, $targetFile)) {
    if (!isset($_SESSION['imageDetails'])) $_SESSION['imageDetails'] = array();
    $imageDetails = array("imageLink" => $targetFile, "userid" => $_SESSION['userid']['id'], "deviceType" => $_GET['deviceType'], "imageType" => $_GET['imageType']);
    array_push($_SESSION['imageDetails'], $imageDetails);
  }
}
## GÖRSEL YÜKLENİYOR ##
## GÖRSEL SİLİNİYOR ##
else if (isset($_POST['imageDelete'])) {
  if ($_POST['imageId'] != "no-image") {
    $imageCount = $dbclass->cek("KAYITSAY", "images", "count(id)", "WHERE id=?", array($_POST['imageId']));
    if ($imageCount > 0) {
      $imageDetected = $dbclass->cek("ASSOC", "images", "imageLink", "WHERE id=?", array($_POST['imageId']));
      $deleteImage = $dbclass->sil("images", "WHERE id=?", array($_POST['imageId']));
      if ($deleteImage) {
        unlink($imageDetected['imageLink']);
        echo json_encode(array("success", "Görsel Silme İşlemi Başarı İle Gerçekleştirildi."));
      } else echo json_encode(array("error", "Görsel Silinirken Bir Hata İle Karşılaşıldı."));
    } else echo json_encode(array("error", "Görsel Bulunamadı."));
  } else echo json_encode(array("error", "Görsel Bulunamadı."));
}
## GÖRSEL SİLİNİYOR ##
## YÜKLENEN GÖRSEL KAYDEDİLİYOR ##
else if (isset($_POST['imageSave'])) {
  if (isset($_SESSION['imageDetails'])) {
    foreach ($_SESSION['imageDetails'] as $key => $value) {
      $productDetected = $dbclass->cek("ASSOC", "products", "productName,langCode", "WHERE uniqueId=? AND langCode=?", array($_POST['id'], $_POST['lang']));
      $imageUpload = $functions->imageUpload($dbclass, $value['imageType'], $value['deviceType'], $_POST['id'], $productDetected['productName'], $productDetected['langCode'], $key);
      if ($imageUpload) echo json_encode(array("success", "resim başarıyla yüklendi"));
    }
    echo json_encode(array("success", "Görsel Başarı İle Kaydedildi"));
  }
}
## YÜKLENEN GÖRSEL KAYDEDİLİYOR ##
## GÖRSEL BİLGİLERİ GÜNCELLENMEK İÇİN GETİRİLİYOR ##
else if (isset($_POST['imageDetailGet'])) {
  $imageDetails = $dbclass->cek("ASSOC", "images", "*", "WHERE id=?", array($_POST['imageDetailGet']));
  echo json_encode(array("success", $imageDetails['id'], $imageDetails['orderNumber'], $imageDetails['title'], $imageDetails['content'], $imageDetails['hrefUrl'], $imageDetails['extraDetails'], $imageDetails['imageType']));
}
## GÖRSEL BİLGİLERİ GÜNCELLENMEK İÇİN GETİRİLİYOR ##
## GÖRSEL BİLGİLERİ GÜNCELLENİYOR ##
else if (isset($_POST['imageUpdateId'])) {
  $imageControl = $dbclass->cek("KAYITSAY", "images", "count(id)", "WHERE id=?", array($_POST['imageUpdateId']));
  if ($imageControl > 0) {
    $imageUpdate = $dbclass->guncelle(0, "images", "orderNumber,title,content,extraDetails,hrefUrl", "WHERE id=?", array($_POST['orderNumber'], $_POST['title'], $_POST['content'],$_POST['imageTable'], $_POST['hrefUrl'], $_POST['imageUpdateId']));
    if ($imageUpdate) echo json_encode(array("success", "Resim Bilgileri Başarı ile Güncellendi"));
    else echo json_encode(array("error", "Resim Bilgileri Güncellenirken Hata Oluştu"));
  }
}
## GÖRSEL BİLGİLERİ GÜNCELLENİYOR ##
################################# GÖRSEL İŞLEMLERİ #################################
################################# KULLANICI İŞLEMLERİ #################################
## KULLANICILAR LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_USERLIST'])) {
  $usersGet = $dbclass->cek("ASSOC_ALL", "users", "*", "", array());
  $data['data'] = array();
  foreach ($usersGet as $key => $value) {
    array_push($data['data'], array("userNumber" => $key + 1, "name" => $value['name'], "surname" => $value['surname'], "adminUser" => $value['adminUser'], "actions" => $value['id']));
  }
  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);
}
## KULLANICILAR LİSTELENİYOR ##
## KULLANICI EKLENİYOR ##
else if (isset($_POST['userAdd'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 1);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
    $emailControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "WHERE email=?", array($_POST['email']));
    if ($emailControl > 0) { // Aynı E-Posta ile daha önce farklı bir kayıt oluşturulmuş ise
      echo json_encode(array("error", "Bu E-posta adresi sistemde kayıtlıdır. Lüften farklı bir E-Posta Adresi Giriniz"));
    } else { // Gelen E-Posta ile başka bir kayıt yok ise
      $uniqueId = $dbclass->uniqueId("users");
      $admin = 1; // admin kullanıcı durumu her ihtimalde 1 olarak kaydediliyor. Admin harici kullanıcı eklenmek isterse 0 olarak gönderilmesi yeterli olur
      if (isset($_POST['contactPermission'])) $contactPermission = $_POST['contactPermission'];
      else $contactPermission = 0;
      $recordTime = date('Y.m.d H:i:s');
      $pass = md5(sha1($_POST['password']));
      $userAdd = $dbclass->ekle("users", "uniqueId,name,surname,password,email,adminUser,userStatus,recordTime", array($uniqueId, $_POST['name'], $_POST['surname'], $pass, $_POST['email'], $admin, 0, $recordTime));
      if ($userAdd) echo json_encode(array("success", "Kayıt Başarılı"));
      else echo json_encode(array("error", "Kayıt Oluşturulurken Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz."));
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Kullanıcı Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## KULLANICI EKLENİYOR ##
## KULLANICI BİLGİLERİ GÜNCELLENİYOR ##
else if (isset($_POST['userUpdate'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 1);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
    $userControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "WHERE id=?", array($_POST['userUpdate']));
    if ($userControl > 0) { // kullanıcı kontrol edildikten sonra böyle bir kullanıcı olduğu tespit edilir ise
      $admin = 1;
      $emailControl = $dbclass->cek("KAYITSAY", "users", "count(id)", "WHERE email=? AND id!=?", array($_POST['email'], $_POST['userUpdate']));
      if ($emailControl > 0) { // güncellenen e-posta adresi kontrol ediliyor
        echo json_encode(array("error", "Bu E-Posta Adresi Farklı Bir Kullanıcı Tarafından Kullanılmaktadır. Lütfen Farklı Bir E-Posta  Adresi Kullanın"));
      } else {
        if ($_POST['password'] != "" or $_POST['password'] != null) $pass = $pass = md5(sha1($_POST['password']));
        else {
          $passDetected = $dbclass->cek("ASSOC", "users", "password", "WHERE id=?", array($_POST['userUpdate']));
          $pass = $passDetected['password'];
        }
        $userUpdate = $dbclass->guncelle(0, "users", "name,surname,email,password,adminUser,userStatus", "WHERE id=?", array($_POST['name'], $_POST['surname'], $_POST['email'], $pass, $admin, 0, $_POST['userUpdate']));
        if ($userUpdate) {
          echo json_encode(array("success", "Bilgiler Başarılı Bir Şekilde Güncellendi"));
        } else echo json_encode(array("error", "Bilgiler Güncellenirken Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz."));
      }
    } else { // ilgili kullanıcı bulunamadı ise
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Kullanıcı Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## KULLANICI BİLGİLERİ GÜNCELLENİYOR ##
## KULLANICI SİLİNİYOR ##
else if (isset($_POST['deleteUserId'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 2);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde kullanıcı silme izni kontrol ediliyor
    $userDelete = $dbclass->sil("users", "WHERE id=?", array($_POST['deleteUserId']));
    if ($userDelete) {
      echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
    } else {
      echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Kullanıcı Silme Yetkiniz Bulunmamaktadır."));
  }
}
## KULLANICI SİLİNİYOR ##
## KULLANICI YETKİLENDİRMELERİ GÜNCELLENİYOR ##
else if (isset($_POST['permissionUpdate'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 1);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde kullanıcı ekleme ve düzenleme izni kontrol ediliyor
    $permissionControl = $dbclass->cek("KAYITSAY", "permissions", "count(id)", "WHERE id=?", array($_POST['permissionId']));
    if ($permissionControl > 0) {
      $permissionDetected = $dbclass->cek("KAYITSAY", "usersVsPermissions", "count(id)", "WHERE permissionId=? AND userId=?", array($_POST['permissionId'], $_POST['userId']));
      $permissionStatusControl = $dbclass->cek("ASSOC", "usersVsPermissions", "id,permissionStatus", "WHERE permissionId=? AND userId=?", array($_POST['permissionId'], $_POST['userId']));
      if ($permissionDetected > 0) { // ilgili kullanıcının güncelleme yapılacak izin için usersVsPermissions tablosunda daha önce kaydı oluşturulmuş ise güncelleme yapılacaktır.
        if ($permissionStatusControl['permissionStatus'] == 0) $permissionStatus = 1;
        else $permissionStatus = 0;
        $update = $dbclass->guncelle(0, "usersVsPermissions", "permissionStatus", "WHERE id=?", array($permissionStatus, $permissionStatusControl['id']));
      } else { // usersVsPermissons tablosunda kontrol edilen kayıt yok ise yeni kayıt oluşturulacaktır.
        $add = $dbclass->ekle("usersVsPermissions", "permissionId,userId,permissionStatus", array($_POST['permissionId'], $_POST['userId'], 1));
      }
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Kullanıcı Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## KULLANICI YETKİLENDİRMELERİ GÜNCELLENİYOR ##
################################# KULLANICI İŞLEMLERİ #################################

################################# DİL İŞLEMLERİ #################################
## DİLLER LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_LANGUAGELIST'])) {
  $languagesGet = $dbclass->cek("ASSOC_ALL", "languages", "*", "", array());
  $data['data'] = array();
  foreach ($languagesGet as $key => $value) {
    array_push($data['data'], array("langNumber" => $key + 1, "langName" => $value['langName'], "langShortCode" => $value['langShortCode'], "status" => $value['status'], "actions" => $value['id']));
  }
  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);
}
## DİLLER LİSTELENİYOR ##
## YENİ DİL EKLENİYOR ##
else if (isset($_POST['langAdd'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 9);
  if ($permissionControl == 1) { // kullanıcının,  yönetim panelinde dil yönetimi izni kontrol ediliyor
    $shortCodeControl = $dbclass->cek("KAYITSAY", "languages", "count(id)", "WHERE langShortCode=?", array($_POST['langShortCode']));
    if ($shortCodeControl > 0) {
      echo json_encode(array("warning", "Eklemek İstediğiniz Kısa Kod Daha Önce Kullanılmıştır. Lütfen Başka Bir Kısa Kod Giriniz"));
    } else {
      $langAdd = $dbclass->ekle("languages", "langName,langShortCode,categorySlug,tagSlug,pageSlug,blogSlug,productSlug,searchSlug,langDirection,status", array($_POST['langName'], $_POST['langShortCode'], $_POST['categorySlug'], $_POST['tagSlug'], $_POST['pageSlug'], $_POST['blogSlug'], $_POST['productSlug'], $_POST['searchSlug'], $_POST['langDirection'], 0));
      if ($langAdd) {
        ## YENİ DİL OLUŞTURULDUKTAN SONRA BU ZAMANA KADAR OLUŞTURULAN ÜRÜNLER İÇİN YENİ EKLENEN DİLE GÖRE YENİ KAYITLARI OLUŞTURULUYOR ##
        $productsGet = $dbclass->cek("ASSOC_ALL", "products", "DISTINCT uniqueId,productName,productSlug,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus,showHome,showMenu,rowNumber,mainProduct", "WHERE langCode=?", array("TR"));
        foreach ($productsGet as $key => $value) {
          $productLangControl = $dbclass->cek("KAYITSAY", "products", "count(id)", "WHERE uniqueId=? AND langCode=?", array($value['uniqueId'], $_POST['langShortCode']));
          if ($productLangControl <= 0) {
            $productAdd = $dbclass->ekle("products", "uniqueId,productName,productSlug,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus,showHome,showMenu,rowNumber,mainProduct", array($value['uniqueId'], "", "", "", "", $value['productVideo'], "", "", "", $_POST['langShortCode'],0, $value['showHome'],$value['showMenu'],$value['rowNumber'],$value['mainProduct']  ));
          }
        }
        ## YENİ DİL OLUŞTURULDUKTAN SONRA BU ZAMANA KADAR OLUŞTURULAN ÜRÜNLER İÇİN YENİ EKLENEN DİLE GÖRE YENİ KAYITLARI OLUŞTURULUYOR ##
        ## YENİ DİL OLUŞTURULDUKTAN SONRA BU ZAMANA KADAR OLUŞTURULAN KATEGORİLER İÇİN YENİ EKLENEN DİLE GÖRE YENİ KAYITLARI OLUŞTURULUYOR ##
        $categoriesGet = $dbclass->cek("ASSOC_ALL", "categories", "DISTINCT uniqueId,categoryName,categorySlug,mainCategoryId,categoryDescription,categoryType,langCode,seoTitle,seoKeywords,seoDescription,recordStatus", "WHERE langCode=?", array("TR"));
        foreach ($categoriesGet as $key => $value) {
          $categoryLangControl = $dbclass->cek("KAYITSAY", "categories", "count(id)", "WHERE uniqueId=? AND langCode=?", array($value['uniqueId'], $_POST['langShortCode']));
          if ($categoryLangControl <= 0) {
            $categoryadd = $dbclass->ekle("categories", "categoryName,categorySlug,mainCategoryId,uniqueId,categoryDescription,categoryType,langCode,seoTitle,seoKeywords,seoDescription,recordStatus", array("", "", $value['mainCategoryId'], $value['uniqueId'], "", $value['categoryType'], $_POST['langShortCode'], "", "", "", 0));
          }
        }
        ## YENİ DİL OLUŞTURULDUKTAN SONRA BU ZAMANA KADAR OLUŞTURULAN KATEGORİLER İÇİN YENİ EKLENEN DİLE GÖRE YENİ KAYITLARI OLUŞTURULUYOR ##
        echo json_encode(array("success", "Dil Ekleme İşlemi Başarı İle Gerçekleştirilmiştir."));
      } else echo json_encode(array("error", "Dil Eklenirken Bir Hata Oluştu."));
    }
  } else { // kullanıcının, dil yönetimi yok ise
    echo json_encode(array("error", "Dil Yönetimi Yetkiniz Bulunmamaktadır."));
  }
}
## YENİ DİL EKLENİYOR ##
## DİL SİLİNİYOR ##
else if (isset($_POST['deleteLangId'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 9);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde dil yönetimi izni kontrol ediliyor
    $primaryLangControl=$dbclass->cek("KAYITSAY","languages","COUNT(id)","WHERE id=? AND primaryLang=?",array($_POST['deleteLangId'],1));
    if ($primaryLangControl<=0) {
      $userDelete = $dbclass->sil("languages", "WHERE id=?", array($_POST['deleteLangId']));
      if ($userDelete) {
        echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi."));
      } else {
        echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu."));
      }
    } else echo json_encode(array("error", "Silmek İstediğiniz Dil Sistem Dili Olduğu İçin Silinemez."));
  } else { // kullanıcının, dil yönetimi yok ise
    echo json_encode(array("error", "Dil Yönetimi Yetkiniz Bulunmamaktadır."));
  }
}
## DİL SİLİNİYOR ##
## DİL DETAYLARI GÜNCELLENİYOR ##
else if(isset($_POST['langDetailUpdate'])){
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 9);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde dil yönetimi izni kontrol ediliyor
    $langControl = $dbclass->cek("KAYITSAY", "languages", "count(id)", "WHERE id=?", array($_POST['langDetailUpdate']));
    if ($langControl > 0) { // dil kontrol edildikten sonra böyle bir dil olduğu tespit edilir ise
      $langUpdate = $dbclass->guncelle(0, "languages", "langName,langShortCode,categorySlug,tagSlug,pageSlug,blogSlug,productSlug,searchSlug,langDirection,status", "WHERE id=?", 
      array($_POST['langName'], $_POST['langShortCode'], $_POST['categorySlug'], $_POST['tagSlug'], $_POST['pageSlug'], $_POST['blogSlug'], $_POST['productSlug'], $_POST['searchSlug'], $_POST['langDirection'], $_POST['recordStatus'], $_POST['langDetailUpdate']));
        if ($langUpdate) {
          echo json_encode(array("success", "Bilgiler Başarılı Bir Şekilde Güncellendi", $_POST['langDetailUpdate']));
        } else echo json_encode(array("error", "Bilgiler Güncellenirken Bir Hata Oluştu. Lütfen Daha Sonra Tekrar Deneyiniz."));
    } else { // ilgili dil bulunamadı ise
    }
  } else { // kullanıcının, dil yönetimi izni yok ise
    echo json_encode(array("error", "Dil Yönetimi Yetkiniz Bulunmamaktadır."));
  }
}
## DİL DETAYLARI GÜNCELLENİYOR ##
## SİTE DEĞİŞKENLERİ GÜNCELLENİYOR ##
else if(isset($_POST['langConstUpdate'])){
  $langControl=$dbclass->cek("KAYITSAY","languages","count(id)","WHERE langShortCode=?",array($_POST['langConstUpdate']));
  if($langControl>0){
    $sayac=0;
    foreach (json_decode($_POST['degiskenler'],true) as $key => $value) {
      if($value['name']!="langConstUpdate"){
        $link=$dbclass->seo($value['value']);
        $update = $dbclass->guncelle(0,'siteConstants','constValue,constSlug','WHERE constCode=? and lang=?',array($value['value'],$link,$value['name'],$_POST['langConstUpdate']));
        if($update) $sayac++;
      }
    }
    if($sayac>0) echo json_encode(array("success","Dil Değişkenleri Başarıyla Güncellendi."));
    else echo json_encode(array("error","Dil Değişkenleri Güncellenirken Bir Hata İle Karşılaşıldı."));
  }
  else echo json_encode(array("error","Hata!!!"));
}
## SİTE DEĞİŞKENLERİ GÜNCELLENİYOR ##
################################# DİL İŞLEMLERİ #################################
################################# KATEGORİ İŞLEMLERİ #################################
## KATEGORİLER LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_CATEGORYLIST'])) {
  $categoriesGet = $dbclass->cek("ASSOC_ALL", "categories", "*", "", array());
  $data['data'] = array();
  $actions = array();
  foreach ($categoriesGet as $key => $value) {
     $mainCategoryCount=$dbclass->cek("KAYITSAY","categories","count(id)","WHERE id=?",array($value['mainCategoryId']));
      if($mainCategoryCount>0){
        $mainCategory=$dbclass->cek("ASSOC","categories","categoryName","WHERE id=?",array($value['mainCategoryId']));
        $mainCategoryName=$mainCategory['categoryName'];
      }
      else{
        $mainCategoryName="Ana Kategori";
      }
    $langRows = "";
    $activeLangs = $dbclass->cek("ASSOC_ALL", "languages", "*", "WHERE status=?", array(1));
    foreach ($activeLangs as $keys => $values) {
      $langRows .= '
						<li class="navi-item">
							<a href="kategori-detay-' . $value['uniqueId'] . '-' . $values['langShortCode'] . '" target="_blank" class="navi-link">
								<span class="navi-icon"><i class="la la-flag"></i></span>
								<span class="navi-text">' . $values['langName'] . '</span>
							</a>
						</li>
					';
    }
    $actions[0] = $langRows;
    $actions[1] = $value['id'];
    array_push($data['data'], array("categoryNumber" => $key + 1, "categoryName" => $value['categoryName'], "categoryType" => $value['categoryType'], "mainCategory" => $mainCategoryName, "recordStatus" => $value['recordStatus'], "actions" => $actions));
  }
  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);
}
## KATEGORİLER LİSTELENİYOR ##
## KATEGORİ EKLEME VE GÜNCELLEME İŞLEMLERİ ##
else if (isset($_POST['categoryProcess'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 11);
  if ($permissionControl == 1) {
    ## YENİ KATEGORİ EKLENİYOR ##
    if ($_POST['categoryProcess'] == "add") {
      $uniqueId = $dbclass->uniqueId("categories"); // etkinlik tablosunda benzeri olmayan uniqueId üretiliyor
      $categoryLink = $dbclass->seo($_POST['categoryName']); // gelen etkinlik adına göre seo uyumlu slug oluşturuluyor
      $categoryLink = $categoryLink . "-" . $uniqueId;
      $categoryAdd = $dbclass->ekle("categories", "categoryName,categorySlug,mainCategoryId,uniqueId,categoryDescription,categoryType,langCode,seoTitle,seoKeywords,seoDescription,recordStatus,showMenu,showHome,rowNumber", array($_POST['categoryName'], $categoryLink, $_POST['mainCategory'], $uniqueId, $_POST['categoryDescription'], $_POST['categoryType'], $_POST['langCode'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], 1, $_POST['showMenu'], $_POST['showHome'], $_POST['rowNumber']));
      if ($categoryAdd) {
        $categoryDetected = $dbclass->cek("ASSOC", "categories", "id,uniqueId,categoryName", "WHERE langCode=? ORDER BY id DESC", array("TR"));
        echo json_encode(array("success", "Kayıt Başarı İle Eklendi.",$categoryDetected['uniqueId']));
      } else echo json_encode(array("error", "Kayıt Eklenirken Bir Hata İle Karşılaşıldı."));

    }
    ## YENİ KATEGORİ EKLENİYOR ##
    ## KATEGORİ GÜNCELLENEYOR ##
    else if ($_POST['categoryProcess'] == "update") {
      $categoryControl = $dbclass->cek("KAYITSAY", "categories", "count(id)", "WHERE uniqueId=? AND langCode=?", array($_POST['uniqueId'], $_POST['langCode']));
      if ($categoryControl > 0) {
        $categoryLink = $dbclass->seo($_POST['categoryName']); // gelen etkinlik adına göre seo uyumlu slug oluşturuluyor
        $categoryLink = $categoryLink . "-" . $_POST['uniqueId'];
        $categoryUpdate = $dbclass->guncelle(0, "categories", "categoryName,categorySlug,mainCategoryId,uniqueId,categoryDescription,categoryType,langCode,seoTitle,seoKeywords,seoDescription,recordStatus,showMenu,showHome,rowNumber ", "WHERE uniqueId=? AND langCode=?", array($_POST['categoryName'], $categoryLink, $_POST['mainCategory'], $_POST['uniqueId'], $_POST['categoryDescription'], $_POST['categoryType'], $_POST['langCode'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], 1, $_POST['showMenu'], $_POST['showHome'], $_POST['rowNumber'], $_POST['uniqueId'], $_POST['langCode']));
        if ($categoryUpdate) {
          if (isset($_SESSION['imageDetails'])) { // etkinlik eklenirken yüklenen tanıtım görseli var ise görsel veritabanına kaydediliyor
            $categoryDetected = $dbclass->cek("ASSOC", "categories", "id,uniqueId,categoryName", "WHERE uniqueId=? ORDER BY id DESC", array($_POST['uniqueId']));
            foreach ($_SESSION['imageDetails'] as $key => $value) {
              $imageUpload = $functions->imageUpload($dbclass, 5, $value['deviceType'], $categoryDetected['uniqueId'], $categoryDetected['categoryName']);
            }
          }

          echo json_encode(array("success", "Güncelleme İşlemi Başarı İle Gerçekleştirildi.",$categoryDetected['uniqueId']));
        } else echo json_encode(array("error", "Güncelleme İşlemi Gerçekleştirilemedi"));

      } else echo json_encode(array($categoryControl, "İlgili Kategori Bulunamadı"));
    }
    ## KATEGORİ GÜNCELLENEYOR ##
  } else { // kullanıcının, kategori düzenleme ve ekleme yok ise
    echo json_encode(array("error", "Kategori Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }

}
## KATEGORİ EKLEME VE GÜNCELLEME İŞLEMLERİ ##
## KATEGORİ SİLİNİYOR ##
else if (isset($_POST['deleteCategoryId'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 12);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde kategori silme izni kontrol ediliyor
    $userDelete = $dbclass->sil("categories", "WHERE id=?", array($_POST['deleteCategoryId']));
    if ($userDelete) {
      echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
    } else {
      echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
    }
  } else { // kullanıcının, kategori silme izni yok ise
    echo json_encode(array("error", "Kategori Silme Yetkiniz Bulunmamaktadır."));
  }
}
## KATEGORİ SİLİNİYOR ##
################################# KATEGORİ İŞLEMLERİ #################################
################################# ÜRÜN İŞLEMLERİ #################################
## ÜRÜNLER LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_PRODUCTLIST'])) {
  $productsGet = $dbclass->cek("ASSOC_ALL", "products", "*", "WHERE langCode=? AND mainProduct=? ORDER BY rowNumber ASC", array("TR",0));
  $data['data'] = array();
  $actions = array();
  $productCategory = "Ürün Kategorisi";
  foreach ($productsGet as $key => $value) {
    $categoryControl = $dbclass->cek("KAYITSAY", "categories", "count(categories.id)", "INNER JOIN  productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=? AND categories.langCode=?", array($value['uniqueId'], "TR"));
    if ($categoryControl > 0) {
      $categoryDetected = $dbclass->cek("ASSOC", "categories", "categories.categoryName", "INNER JOIN  productsVsCategories ON productsVsCategories.categoryUniqueId = categories.uniqueId WHERE productsVsCategories.productUniqueId=? AND categories.langCode=?", array($value['uniqueId'], "TR"));
      $productCategory = $categoryDetected['categoryName'];
    } else $productCategory = "Kategori Bulunamadı";
    $langRows = "";
    $activeLangs = $dbclass->cek("ASSOC_ALL", "languages", "*", "WHERE status=?", array(1));
    foreach ($activeLangs as $keys => $values) {
      $langRows .= '
        <li class="navi-item">
          <a href="urun-detay-' . $value['uniqueId'] . '-' . $values['langShortCode'] . '" target="_blank" class="navi-link">
            <span class="navi-icon"><i class="la la-flag"></i></span>
            <span class="navi-text">' . $values['langName'] . '</span>
          </a>
        </li>
        ';
    }
    $actions[0] = $langRows;
    $actions[1] = $value['id'];
    array_push($data['data'], array("productNumber" => $key + 1, "name" => $value['productName'], "category" => $productCategory, "productStatus" => $value['recordStatus'], "actions" => $actions));
  }
  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);

}
## ÜRÜNLER LİSTELENİYOR ##
## ÜRÜN EKLEME VE GÜNCELLEME İŞLEMLERİ ##
else if (isset($_POST['productProcess'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 14);
  if ($permissionControl == 1) { // kullanıcının ürün ekleme ve düzenleme yetkisi kontrol ediliyor
    ## YENİ ÜRÜN EKLENİYOR ##
    if ($_POST['productProcess'] == "add") {
      $uniqueId = $dbclass->uniqueId("products"); // ürünler tablosunda benzeri olmayan uniqueId üretiliyor
      $productLink = $dbclass->seo($_POST['productName']); // gelen ürün adına göre seo uyumlu slug oluşturuluyor
      $productLink = $productLink . "-" . $uniqueId;
      $productAdd = $dbclass->ekle("products", "productName,productSlug,uniqueId,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus,showHome,showMenu,rowNumber,mainProduct",array($_POST['productName'], $productLink, $uniqueId, $_POST['productShortDescription'], $_POST['productLongDescription'], $_POST['productVideo'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], "TR", 1, $_POST['showHome'], $_POST['showMenu'], $_POST['rowNumber'],$_POST['mainProduct']));
      if ($productAdd) {
        $productDetected = $dbclass->cek("ASSOC", "products", "id,uniqueId,productName", "ORDER BY id DESC", array());
        if (isset($_SESSION['imageDetails'])) { // ürün eklenirken yüklenen tanıtım görseli var ise görsel veritabanına kaydediliyor
          foreach ($_SESSION['imageDetails'] as $key => $value) {
            $imageUpload = $functions->imageUpload($dbclass, 2, 0, $productDetected['uniqueId'], $productDetected['productName']);
          }
        }
        ## seo etiketleri işleniyor ##
        if (isset($_POST['seoTags'])) {
          $tagIds = $_POST['seoTags'];
          $allTagsDelete = $dbclass->sil("productsVsTags", "WHERE productId=?", array($productDetected['id']));
          foreach ($tagIds as $key => $value) {
            $tagAdd = $dbclass->ekle("productsVsTags", "productId,tagId", array($productDetected['id'], $value));
          }
        }
        ## seo etiketleri işleniyor ##
        $langControl = $dbclass->cek("KAYITSAY", "languages", "count(id)", "WHERE langShortCode!=?", array("TR"));
        if ($langControl > 0) { // veritabanında türkçe haricinde farklı bir dil var ise eklenen etkinlik diğer diller içinde oluşturuluyor
          $langsGet = $dbclass->cek("ASSOC_ALL", "languages", "*", "WHERE langShortCode!=?", array("TR"));
          foreach ($langsGet as $key => $value) {
            $add = $dbclass->ekle("products", "productName,productSlug,uniqueId,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus", array("", "", $uniqueId, "", "", "", "", "", "", $value['langShortCode'], 0));
          }
        }
        $categoryAdd = $dbclass->ekle("productsVsCategories", "productUniqueId,categoryUniqueId", array($productDetected['uniqueId'], $_POST['productCategory']));
        echo json_encode(array("success", "Kayıt Başarı İle Eklendi.",$productDetected['uniqueId']));
      } else echo json_encode(array("error", "Kayıt Eklenirken Bir Hata İle Karşılaşıldı."));

    }
    ## YENİ ÜRÜN EKLENİYOR ##
    ## ÜRÜN GÜNCELLENİYOR ##
    if ($_POST['productProcess'] == "update") {
      $productDetected = $dbclass->cek("ASSOC", "products", "*", "WHERE uniqueId=? AND langCode=? ORDER BY id DESC", array($_POST['uniqueId'], $_POST['langCode']));
      $productLink = $dbclass->seo($_POST['productName']); // gelen ürün adına göre seo uyumlu slug oluşturuluyor
      $productLink = $productLink . "-" . $_POST['uniqueId'];
      $productUpdate = $dbclass->guncelle(0, "products", "productName,productSlug,uniqueId,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus,showHome,showMenu,rowNumber,mainProduct", "WHERE uniqueId=? AND langCode=?", array($_POST['productName'], $productLink, $_POST['uniqueId'], $_POST['productShortDescription'], $_POST['productLongDescription'], $_POST['productVideo'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], $_POST['langCode'], 1, $_POST['showHome'], $_POST['showMenu'], $_POST['rowNumber'],$_POST['mainProduct'], $_POST['uniqueId'], $_POST['langCode']));
      if ($productUpdate){
        $categoryDelete=$dbclass->sil("productsVsCategories","WHERE productUniqueId=?",array($productDetected['uniqueId']));
        $categoryAdd=$dbclass->ekle("productsVsCategories","productUniqueId,categoryUniqueId",array($productDetected['uniqueId'],$_POST['productCategories']));
        echo json_encode(array("success", "Kayıt Başarı İle Güncellendi.",$productDetected['uniqueId']));
      } 
      else echo json_encode(array("error", "Kayıt Güncellenirken Bir Hata İle Karşılaşıldı"));
    }
    ## ÜRÜN GÜNCELLENİYOR ##
  } else { // kullanıcının, ürün düzenleme ve ekleme yok ise
    echo json_encode(array("error", "Ürün Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## ÜRÜN EKLEME VE GÜNCELLEME İŞLEMLERİ ##
## ÜRÜN SİLİNİYOR ##
else if (isset($_POST['deleteProductId'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 15);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde ürün silme izni kontrol ediliyor
    $userDelete = $dbclass->sil("products", "WHERE id=?", array($_POST['deleteProductId']));
    if ($userDelete) {
      echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
    } else {
      echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Ürün Silme Yetkiniz Bulunmamaktadır."));
  }
}
## ÜRÜN SİLİNİYOR ##
## ÜRÜN EK BİLGİSİ İŞLEMLERİ ##
else if (isset($_POST['infoProcess'])) {
  if ($_POST['infoProcess'] == "add") {
    $infoAdd = $dbclass->ekle("productInformations", "infoTitle,infoContent,productId,langCode", array($_POST['title'], $_POST['content'], $_POST['productId'], $_POST['productLang']));
    if ($infoAdd) echo json_encode(array("success", "Ürün Ek Bilgisi Başarıyla Eklendi"));
    else echo json_encode(array("error", "ürün Ek Bilgisi Eklenirken Bir Hata Oluştu"));
  }
  if ($_POST['infoProcess'] == "update") {
    $infoUpdate = $dbclass->guncelle(0, "productInformations", "infoTitle,infoContent,productId,langCode", "WHERE id=?", array($_POST['title'], $_POST['content'], $_POST['productId'], $_POST['productLang'], $_POST['infoId']));
    if ($infoUpdate) echo json_encode(array("success", "Ürün Ek Bilgisi Başarıyla Güncellendi"));
    else echo json_encode(array("error", "ürün Ek Bilgisi Güncellenirken Bir Hata Oluştu"));
  }
}
## ÜRÜN EK BİLGİSİ İŞLEMLERİ ##
## ÜRÜN EK BİLGİSİ SİLİNİYOR ##
else if (isset($_POST['deleteInfoId'])) {
  $infoDelete = $dbclass->sil("productInformations", "WHERE id=?", array($_POST['deleteInfoId']));
  if ($infoDelete) {
    echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
  } else {
    echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
  }
}
## ÜRÜN EK BİLGİSİ SİLİNİYOR ##
## BENZER ÜRÜN EKLENİYOR ##
else if(isset($_POST['similarProductId'])){
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 14);
  if ($permissionControl == 1) { // kullanıcının ürün ekleme ve düzenleme yetkisi kontrol ediliyor
    $oldProduct=$dbclass->cek("ASSOC","products","*","WHERE id=?",array($_POST['similarProductId']));
    $uniqueId = $dbclass->uniqueId("products"); // ürünler tablosunda benzeri olmayan uniqueId üretiliyor
    $productLink = $dbclass->seo($oldProduct['productName']."(Kopya)"); // gelen ürün adına göre seo uyumlu slug oluşturuluyor
    $productLink = $productLink . "-" . $uniqueId;
    $productAdd = $dbclass->ekle("products", "productName,productSlug,uniqueId,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus,showHome,showMenu,rowNumber", array($oldProduct['productName']."(Kopya)", $productLink, $uniqueId, $oldProduct['productShortDescription'], $oldProduct['productLongDescription'], $oldProduct['productVideo'], $oldProduct['seoTitle'], $oldProduct['seoKeywords'], $oldProduct['seoDescription'], $oldProduct['langCode'], 0, $oldProduct['showHome'], $oldProduct['showMenu'], $oldProduct['rowNumber']));
      if ($productAdd) {
        $productDetected = $dbclass->cek("ASSOC", "products", "id,uniqueId,productName", "ORDER BY id DESC", array());
        ## seo etiketleri işleniyor ##
        $oldProductSeoTagsCount=$dbclass->cek("KAYITSAY","productsVsTags","count(id)","WHERE productId=?",array($oldProduct['id']));
        if ($oldProductSeoTagsCount>0) {
          $oldProductSeoTags=$dbclass->cek("ASSOC_ALL","productsVsTags","*","WHERE productId=?",array($oldProduct['id']));
          foreach ($oldProductSeoTags as $key => $value) {
            $tagAdd = $dbclass->ekle("productsVsTags", "productId,tagId", array($productDetected['id'], $value['tagId']));
          }
        }
        ## seo etiketleri işleniyor ##
        $langControl = $dbclass->cek("KAYITSAY", "languages", "count(id)", "WHERE langShortCode!=?", array($oldProduct['langCode']));
        if ($langControl > 0) { // veritabanında seçilen dil haricinde farklı bir dil var ise eklenen ürün diğer diller içinde oluşturuluyor
          $langsGet = $dbclass->cek("ASSOC_ALL", "languages", "*", "WHERE langShortCode!=?", array($oldProduct['langCode']));
          foreach ($langsGet as $key => $value) {
            $add = $dbclass->ekle("products", "productName,productSlug,uniqueId,productShortDescription,productLongDescription,productVideo,seoTitle,seoKeywords,seoDescription,langCode,recordStatus", array("", "", $uniqueId, "", "", "", "", "", "", $value['langShortCode'], 0));
          }
        }
        $oldProductCategoryCount=$dbclass->cek("KAYITSAY","productsVsCategories","count(id)","WHERE productUniqueId=?",array($oldProduct['uniqueId']));
        if ($oldProductCategoryCount>0) {
          $oldProductCategoryCount=$dbclass->cek("ASSOC_ALL","productsVsCategories","*","WHERE productUniqueId=?",array($oldProduct['uniqueId']));
          foreach ($oldProductCategoryCount as $key => $value) {
            $categoryAdd = $dbclass->ekle("productsVsCategories", "productUniqueId,categoryUniqueId", array($productDetected['uniqueId'], $value['categoryUniqueId']));
          }
        }
        echo json_encode(array("success", "Kayıt Başarı İle Eklendi."));
      }
    } else { // kullanıcının, ürün düzenleme ve ekleme yok ise
    echo json_encode(array("error", "Ürün Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## BENZER ÜRÜN EKLENİYOR ##
################################# ÜRÜN İŞLEMLERİ #################################
################################# SEO+ ETİKET İŞLEMLERİ #################################
## SEO+ ETİKETLERİ LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_TAGSLIST'])) {
  $tagsGet = $dbclass->cek("ASSOC_ALL", "tags", "*", "", array());
  $data['data'] = array();
  foreach ($tagsGet as $key => $value) {
    array_push($data['data'], array("tagNumber" => $key + 1, "name" => $value['tagName'], "actions" => $value['id']));
  }

  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);
}
## SEO+ ETİKETLERİ LİSTELENİYOR ##
## SEO+ ETİKETİ EKLENİYOR ##
else if (isset($_POST['tagOperation'])) {
  if ($_POST['tagOperation'] == "add") {
    $randSayi = $dbclass->rastgelesayi(1);
    $tagSlug = $dbclass->seo($_POST['tagName']);
    $slugControl = $dbclass->cek("KAYITSAY", "tags", "count(id)", "WHERE tagSlug=?", array($tagSlug)); // slug kontrol ediliyor
    if ($slugControl > 0) {
      $tagSlug = $tagSlug . "-" . $randSayi; // aynı slug farklı bir üründe var ise 4 haneli random bir sayı oluşturulup slug'ın sonuna ekleniyor
    }
    $tagAdd = $dbclass->ekle("tags", "tagName,tagSlug,seoTitle,seoKeywords,seoDescription", array($_POST['tagName'], $tagSlug, $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription']));
    if ($tagAdd) echo json_encode(array("success", "Etiket Başarıyla Eklendi"));
    else echo json_encode(array("error", "Etiket Eklenirken Bir Hata ile Karşılaşıldı"));
  } else {
    $randSayi = $dbclass->rastgelesayi(1);
    $tagSlug = $dbclass->seo($_POST['tagName']);
    $slugControl = $dbclass->cek("KAYITSAY", "tags", "count(id)", "WHERE tagSlug=?", array($tagSlug)); // slug kontrol ediliyor
    if ($slugControl > 0) {
      $tagSlug = $tagSlug . "-" . $randSayi; // aynı slug farklı bir üründe var ise 4 haneli random bir sayı oluşturulup slug'ın sonuna ekleniyor
    }
    $tagUpdate = $dbclass->guncelle(0, "tags", "tagName,tagSlug,seoTitle,seoKeywords,seoDescription", "WHERE id=?", array($_POST['tagName'], $tagSlug, $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], $_POST['tagOperation']));
    if ($tagUpdate) echo json_encode(array("success", "Etiket Başarıyla Güncellendi"));
    else echo json_encode(array("error", "Etiket Güncellenirken Bir Hata ile Karşılaşıldı"));
  }
}
## SEO+ ETİKETİ EKLENİYOR ##
## SEO+ ETİKETİ BİLGİLERİ GETİRİLİYOR ##
else if (isset($_POST['tagValue'])) {
  $tagGet = $dbclass->cek("ASSOC", "tags", "*", "WHERE id=?", array($_POST['tagValue']));
  echo json_encode(array("success", $tagGet));
}
## SEO+ ETİKETİ BİLGİLERİ GETİRİLİYOR ##
## SEO+ ETİKETİ SİLİNİYOR ##
else if (isset($_POST['deleteTagId'])) {
  $orderDelete = $dbclass->sil("tags", "WHERE id=?", array($_POST['deleteTagId']));
  if ($orderDelete) {
    echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
  } else {
    echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
  }
}
## SEO+ ETİKETİ SİLİNİYOR ##
################################# SEO+ ETİKET İŞLEMLERİ #################################
################################# BLOG İŞLEMLERİ #################################
## BLOGLAR LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_BLOGLIST'])) {
  $productsGet = $dbclass->cek("ASSOC_ALL", "blogs", "*", "", array());
  $data['data'] = array();
  $actions = array();
  foreach ($productsGet as $key => $value) {
    $detectedCountCat = $dbclass->cek("KAYITSAY","blogsvscategories","count(blogsvscategories.id)","INNER JOIN blogs ON blogs.uniqueId = blogsvscategories.blogUniqueId WHERE blogs.uniqueId=?",array($value['uniqueId']));
    if($detectedCountCat){
      $detectedCountCatAssoc = $dbclass->cek("ASSOC","blogsvscategories","categories.categoryName","INNER JOIN blogs ON blogs.uniqueId = blogsvscategories.blogUniqueId INNER JOIN categories ON categories.uniqueId=blogsvscategories.categoryUniqueId WHERE blogs.uniqueId=?",array($value['uniqueId']));
      $blogCategory = $detectedCountCatAssoc['categoryName'];
    } else $blogCategory = "Kategori Bulunamadı";
    // $categoryControl = $dbclass->cek("KAYITSAY", "categories", "count(categories.id)", "INNER JOIN  blogsVsCategories ON blogsVsCategories.categoryUniqueId = categories.uniqueId WHERE blogsVsCategories.categoryUniqueId=? AND categories.langCode=?", array($value['uniqueId'], "TR"));
    // if ($categoryControl > 0) {
    //   $categoryDetected = $dbclass->cek("ASSOC", "categories", "categories.categoryName", "INNER JOIN  blogsVsCategories ON blogsVsCategories.categoryUniqueId = categories.uniqueId WHERE blogsVsCategories.productUniqueId=? AND categories.langCode=?", array($value['uniqueId'], "TR"));
    //   $blogCategory = $categoryDetected['categoryName'];
    // } else $blogCategory = "Kategori Bulunamadı";
    array_push($data['data'], array("blogNumber" => $key + 1, "name" => $value['blogName'], "category" => $blogCategory, "blogStatus" => $value['recordStatus'], "actions" => $value['id']));
  }
  echo json_encode($data['data'], JSON_UNESCAPED_UNICODE);

}
## BLOGLAR LİSTELENİYOR ##
## BLOG EKLEME VE GÜNCELLEME İŞLEMLERİ ##
else if (isset($_POST['blogProcess'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 16);
  if ($permissionControl == 1) { // kullanıcının blog yazısı ekleme ve düzenleme yetkisi kontrol ediliyor
    ## YENİ BLOG EKLENİYOR ##
    if ($_POST['blogProcess'] == "add") {
      $uniqueId = $dbclass->uniqueId("blogs"); // ürünler tablosunda benzeri olmayan uniqueId üretiliyor
      $blogLink = $dbclass->seo($_POST['blogName']); // gelen ürün adına göre seo uyumlu slug oluşturuluyor
      $blogLink = $blogLink . "-" . $uniqueId;
      $blogImage= null;
      if(isset($_SESSION['imageDetails'])) $blogImage = substr($_SESSION['imageDetails'][0]['imageLink'],6);
      $now = new DateTime();
      $timestring = $now->format('Y-m-d h:i:s');
      $blogAdd = $dbclass->ekle("blogs", "blogName,blogSlug,uniqueId,blogShortDescription,blogLongDescription,seoTitle,seoKeywords,seoDescription,recordStatus,blogImage,date",
        array($_POST['blogName'], $blogLink, $uniqueId, $_POST['blogShortDescription'], $_POST['blogLongDescription'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], 1,$blogImage,$timestring));
      if ($blogAdd) {
        $blogDetected = $dbclass->cek("ASSOC", "blogs", "id,uniqueId,blogName", "ORDER BY id DESC", array());
        if (isset($_SESSION['imageDetails'])) { // ürün eklenirken yüklenen tanıtım görseli var ise görsel veritabanına kaydediliyor
          foreach ($_SESSION['imageDetails'] as $key => $value) {
            $imageUpload = $functions->imageUpload($dbclass, 3, 0, $blogDetected['id'], $blogDetected['blogName']);
          }
        }
        ## seo etiketleri işleniyor ##
        if (isset($_POST['seoTags'])) {
          $tagIds = $_POST['seoTags'];
          $allTagsDelete = $dbclass->sil("blogsVsTags", "WHERE blogId=?", array($blogDetected['id']));
          foreach ($tagIds as $key => $value) {
            $tagAdd = $dbclass->ekle("blogsVsTags", "blogId,tagId", array($blogDetected['id'], $value));
          }
        }
        ## seo etiketleri işleniyor ##
        if (isset($_POST['blogCategory'])) {
          $categoryAdd = $dbclass->ekle("blogsVsCategories", "blogUniqueId,categoryUniqueId", array($blogDetected['uniqueId'], $_POST['blogCategory']));
        }
        echo json_encode(array("success", "Kayıt Başarı İle Eklendi."));
      } else echo json_encode(array("error", "Kayıt Eklenirken Bir Hata İle Karşılaşıldı."));

    }
    ## YENİ BLOG EKLENİYOR ##
    ## BLOG GÜNCELLENİYOR ##
    if ($_POST['blogProcess'] == "update") {
      $blogControl = $dbclass->cek("KAYITSAY", "blogs", "count(id)", "WHERE uniqueId=?", array($_POST['uniqueId']));
      if ($blogControl > 0) {
        $blogLink = $dbclass->seo($_POST['blogName']); // gelen etkinlik adına göre seo uyumlu slug oluşturuluyor
        $blogLink = $blogLink . "-" . $_POST['uniqueId'];
        $blogUpdate = $dbclass->guncelle(0, "blogs", "blogName,blogSlug,blogShortDescription,blogLongDescription,seoTitle,seoKeywords,seoDescription,recordStatus", "WHERE uniqueId=?", array($_POST['blogName'], $blogLink, $_POST['blogShortDescription'], $_POST['blogLongDescription'], $_POST['seoTitle'], $_POST['seoKeywords'], $_POST['seoDescription'], 1, $_POST['uniqueId']));
        if ($blogUpdate) {
          $blogDetected = $dbclass->cek("ASSOC", "blogs", "id,blogName", "WHERE uniqueId=?", array($_POST['uniqueId']));
          if (isset($_SESSION['imageDetails'])) { // ürün eklenirken yüklenen tanıtım görseli var ise görsel veritabanına kaydediliyor
            $allImagesDelete = $dbclass->sil("images", "WHERE imageType=? AND sourceId=?", array(3, $blogDetected['id']));
            foreach ($_SESSION['imageDetails'] as $key => $value) {
              $imageUpload = $functions->imageUpload($dbclass, 3, 0, $blogDetected['id'], $blogDetected['blogName']);
            }
          }
          ## seo etiketleri işleniyor ##
          if (isset($_POST['seoTags'])) {
            $tagIds = $_POST['seoTags'];
            $allTagsDelete = $dbclass->sil("blogsVsTags", "WHERE blogId=?", array($blogDetected['id']));
            foreach ($tagIds as $key => $value) {
              $tagAdd = $dbclass->ekle("blogsVsTags", "blogId,tagId", array($blogDetected['id'], $value));
            }
          }
          ## seo etiketleri işleniyor ##
          echo json_encode(array("success", "Kayıt Başarı İle Güncellendi."));
        } else echo json_encode(array("error", "Kayıt Güncellenirken Bir Hata İle Karşılaşıldı."));
      }
    }
    ## BLOG GÜNCELLENİYOR ##
  } else { // kullanıcının, ürün düzenleme ve ekleme yok ise
    echo json_encode(array("error", "Blog Yazısı Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır."));
  }
}
## BLOG EKLEME VE GÜNCELLEME İŞLEMLERİ ##
## BLOG SİLİNİYOR ##
else if (isset($_POST['deleteBlogId'])) {
  $permissionControl = $functions->permissionControl($dbclass, $_SESSION['userid']['id'], 17);
  if ($permissionControl == 1) { // kullanıcının, yönetim panelinde ürün silme izni kontrol ediliyor
    $userDelete = $dbclass->sil("blogs", "WHERE id=?", array($_POST['deleteBlogId']));
    if ($userDelete) {
      echo json_encode(array("success", "Silme İşlemi Başarıyla Gerçekleştirildi"));
    } else {
      echo json_encode(array("error", "Silme İşlmesi Esnasında Bir Hata Oluştu"));
    }
  } else { // kullanıcının, kullanıcı silme izni yok ise
    echo json_encode(array("error", "Blog Yazısı Silme Yetkiniz Bulunmamaktadır."));
  }
}
## BLOG SİLİNİYOR ##

####### YETSİS BACKEND SS ##

## SLİDER EKLENİYOR ##
else if(isset($_POST['sliderAdd'])){
  if(!isset($_POST['update'])){
    if(isset($_SESSION['imageUploadSlider'])){
      if($_SESSION['imageUploadSlider'][0]['imageType']=="slider"){
        $resimLink = substr($_SESSION['imageUploadSlider'][0]['imageLink'],6);
        $ekle = $dbclass->ekle("sliders","path,text1,text2,text3,link,status",array($resimLink,$_POST['text1'],$_POST['text2'],$_POST['text3'],$_POST['link'],1));
        if($ekle){
          unset($_SESSION['imageUploadSlider']);
          echo json_encode(array("success","Slider başarıyla eklendi.."));
        }else echo json_encode(array("error","Bir Hata oluştu , lütfen tekrar deneyiniz.."));
      }else echo json_encode(array("error","Lütfen slider resmi ekleyiniz.."));
    
    }
    else{
      echo json_encode(array("error","Lütfen slider resmi ekleyiniz.."));
    }
  }
  else{
    if(isset($_SESSION['imageUploadSlider'])){
      if($_SESSION['imageUploadSlider'][0]['imageType']=="slider"){
        $resimLink = substr($_SESSION['imageUploadSlider'][0]['imageLink'],6);
      } else $resimLink = $dbclass->cek("ASSOC","sliders","path","where id=?",array($_POST['update']))['path'];
    }else  $resimLink = $dbclass->cek("ASSOC","sliders","path","where id=?",array($_POST['update']))['path'];

    $gg = $dbclass->guncelle(0,"sliders","path,text1,text2,text3,link,status","where id=?",array($resimLink,$_POST['text1'],$_POST['text2'],$_POST['text3'],$_POST['link'],1,$_POST['update']));
    if($gg){
      unset($_SESSION['imageUploadSlider']);
      echo json_encode(array("success","Slider başarıyla güncellendi.."));
    }else if($gg==0) echo json_encode(array("warning","Değişiklik Algılanmadı.."));
    else echo json_encode(array("error","Bir Hata oluştu , lütfen tekrar deneyiniz.."));
  }
  
}
## SLİDER EKLENİYOR ##
## SLİDERLAR LİSTELENİYOR ##
else if (isset($_SERVER['HTTP_SLIDERLIST'])) {
  $productsGet = $dbclass->cek("ASSOC_ALL", "sliders", "id,path,text1,text2,text3,link,status", "where status=?", array(1));
  echo json_encode($productsGet, JSON_UNESCAPED_UNICODE);
}
else if(isset($_POST['deleteSliderId'])){
  $delete = $dbclass->sil("sliders","where id=?",array($_POST['deleteSliderId']));
  if($delete){
    echo json_encode(array("success","Slider başarıyla silindi"));
  }
  else{
    echo json_encode(array("error","Hata oluştu, Lütfen tekrar deneyiniz"));
  }
}
## SLİDERLAR LİSTELENİYOR ##
## HİZMET İŞLEMLERİ ##

else if (isset($_FILES['imageUploadSlider'])) {
  $tempFile = $_FILES['imageUploadSlider']['tmp_name'];
  $targetPath = "../../uploads/sliders/";
  // geri gel
  // $targetFile = $targetPath . $dbclass->seo($_FILES['imageUploadSlider']['name']);
  $bol = explode('.',$_FILES['imageUploadSlider']['name']);
  $targetFile = $targetPath . $dbclass->seo($bol[0]).'.'.$bol[1];
  if (move_uploaded_file($tempFile, $targetFile)) {
    if (!isset($_SESSION['imageUploadSlider'])) $_SESSION['imageUploadSlider'] = array();
    $imageDetails = array("imageLink" => $targetFile, "userid" => $_SESSION['userid']['id'], "deviceType" => $_GET['deviceType'], "imageType" => $_GET['imageType']);
    array_push($_SESSION['imageUploadSlider'], $imageDetails);
  }
}
else if (isset($_FILES['servicesicon1'])) {
  $tempFile = $_FILES['servicesicon1']['tmp_name'];
  $targetPath = "../../uploads/services/";
  $bol = explode('.',$_FILES['servicesicon1']['name']);
  $targetFile = $targetPath . $dbclass->seo($bol[0]).'.'.$bol[1];
  if (move_uploaded_file($tempFile, $targetFile)) {
    if (!isset($_SESSION['servicesicon1'])) $_SESSION['servicesicon1'] = array();
    $imageDetails = array("imageLink" => $targetFile, "userid" => $_SESSION['userid']['id'], "deviceType" => $_GET['deviceType'], "imageType" => $_GET['imageType']);
    array_push($_SESSION['servicesicon1'], $imageDetails);
  }
}
else if (isset($_FILES['servicesicon2'])) {
  $tempFile = $_FILES['servicesicon2']['tmp_name'];
  $targetPath = "../../uploads/services/";
  $bol = explode('.',$_FILES['servicesicon2']['name']);
  $targetFile = $targetPath . $dbclass->seo($bol[0]).'.'.$bol[1];
  if (move_uploaded_file($tempFile, $targetFile)) {
    if (!isset($_SESSION['servicesicon2'])) $_SESSION['servicesicon2'] = array();
    $imageDetails = array("imageLink" => $targetFile, "userid" => $_SESSION['userid']['id'], "deviceType" => $_GET['deviceType'], "imageType" => $_GET['imageType']);
    array_push($_SESSION['servicesicon2'], $imageDetails);
  }
}
else if (isset($_FILES['servicesimage'])) {
  $tempFile = $_FILES['servicesimage']['tmp_name'];
  $targetPath = "../../uploads/services/";
  $bol = explode('.',$_FILES['servicesimage']['name']);
  $targetFile = $targetPath . $dbclass->seo($bol[0]).'.'.$bol[1];
  if (move_uploaded_file($tempFile, $targetFile)) {
    if (!isset($_SESSION['servicesimage'])) $_SESSION['servicesimage'] = array();
    $imageDetails = array("imageLink" => $targetFile, "userid" => $_SESSION['userid']['id'], "deviceType" => $_GET['deviceType'], "imageType" => $_GET['imageType']);
    array_push($_SESSION['servicesimage'], $imageDetails);
  }
}
else if(isset($_POST['servicesAdd'])){
    if(!isset($_POST['update'])){
      $servicesIcon1=null;
      $servicesIcon2=null;
      $servicesIconImage=null;
      if(!isset($_SESSION['servicesicon1'])){echo json_encode(array("error","Lütfen Hizmet İcon 1 Yükleyin."));exit;}else{$servicesIcon1=substr($_SESSION['servicesicon1'][0]['imageLink'],6);}
      if(!isset($_SESSION['servicesicon2'])){echo json_encode(array("error","Lütfen Hizmet İcon 2 Yükleyin."));exit;}else{$servicesIcon2=substr($_SESSION['servicesicon2'][0]['imageLink'],6);}
      if(!isset($_SESSION['servicesimage'])){echo json_encode(array("error","Lütfen Hizmet Resmi Yükleyin."));exit;}else{$servicesIconImage=substr($_SESSION['servicesimage'][0]['imageLink'],6);}
      $ekle = $dbclass->ekle("services","name,sorttext,icon,icon2,detail,slug,status,sort,img",array($_POST['servicesname'],$_POST['sorttext'],$servicesIcon1,$servicesIcon2,$_POST['detail'],$dbclass->seo($_POST['servicesname']),1,$_POST['sort'],$servicesIconImage));
      if($ekle){
        unset($_SESSION['servicesicon1']);
        unset($_SESSION['servicesicon2']);
        unset($_SESSION['servicesimage']);

        echo json_encode(array("success","Hizmet başarıyla eklendi"));
      }
      else{
        echo json_encode(array("error","Hata oluştu lütfen tekrar deneyiniz"));
      }
    }
    else{

        $detectedServices = $dbclass->cek("ASSOC","services","icon,icon2,img","where id=?",array($_POST['update']));
        $servicesIcon1=$detectedServices['icon'];
        $servicesIcon2=$detectedServices['icon2'];
        $servicesIconImage=$detectedServices['img'];
        if(isset($_SESSION['servicesicon1'])){$servicesIcon1=substr($_SESSION['servicesicon1'][0]['imageLink'],6);}
        if(isset($_SESSION['servicesicon2'])){$servicesIcon2=substr($_SESSION['servicesicon2'][0]['imageLink'],6);}
        if(isset($_SESSION['servicesimage'])){$servicesIconImage=substr($_SESSION['servicesimage'][0]['imageLink'],6);}
        $ekle = $dbclass->guncelle(0,"services","name,sorttext,icon,icon2,detail,status,sort,img","where id=?",array($_POST['servicesname'],$_POST['sorttext'],$servicesIcon1,$servicesIcon2,$_POST['detail'],1,$_POST['sort'],$servicesIconImage,$_POST['update']));
        if($ekle==1){
          unset($_SESSION['servicesicon1']);
          unset($_SESSION['servicesicon2']);
          unset($_SESSION['servicesimage']);
          echo json_encode(array("success","Hizmet başarıyla güncellendi"));
        }
        else if($ekle==0){
          echo json_encode(array("warning","Değişiklik Algılanmadı"));
        }
        else{
          echo json_encode(array("error","Hata oluştu lütfen tekrar deneyiniz"));
        }
    }
    
}
else if (isset($_SERVER['HTTP_SERVICESLIST'])) {
  $productsGet = $dbclass->cek("ASSOC_ALL", "services", "id,name,icon,icon2,img,status", "where status=?", array(1));
  echo json_encode($productsGet, JSON_UNESCAPED_UNICODE);
}
else if(isset($_POST['deleteServicesId'])){
  $delete = $dbclass->sil("services","where id=?",array($_POST['deleteServicesId']));
  if($delete){
    echo json_encode(array("success","Hizmet başarıyla silindi"));
  }
  else{
    echo json_encode(array("error","Hata oluştu, Lütfen tekrar deneyiniz"));
  }
}

## HİZMET İŞLEMLERİ ##

####### YETSİS BACKEND SS ##

################################# BLOG İŞLEMLERİ #################################


############################################################################################
############################# YÖNETİM PANELİ İŞLEMLERİ #####################################
############################################################################################

?>

