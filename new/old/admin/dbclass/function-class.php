<?php

class functions
{
  public function errorList($errCode)
  {
    if ($errCode == "noPermission") $errorMessage = "Bu Sayfayı Görünteleme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noUserProcess") $errorMessage = "Kullanıcı Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır. Yapacağınız Ekleme ve Güncelleme İşlemleri Kaydedilmeyecektir.";
    else if ($errCode == "noUserDelete") $errorMessage = "Kullanıcı Silme Yetkiniz Bulunmamaktadır. Yapacağınız Silme İşlemleri Kaydedilmeyecektir.";
    else if ($errCode == "noActivityProcess") $errorMessage = "Etkinlik Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır. Yapacağınız Ekleme ve Güncelleme İşlemleri Kaydedilmeyecektir.";
    else if ($errCode == "noActivityDelete") $errorMessage = "Etkinlik Silme Yetkiniz Bulunmamaktadır. Yapacağınız Silme İşlemleri Kaydedilmeyecektir.";
    else if ($errCode == "noDonationProcess") $errorMessage = "Bağış ve İade Kaydı Oluşturma Yetkiniz Bulunmamaktadır. Yapacağınız Kayıt Oluşturma İşlemleri Kaydedilmeyecektir.";
    else if ($errCode == "noVolunteerProcess") $errorMessage = "Yeni Gönüllü Ekleme ve Gönüllülük Başvurularını Onaylama Yetkiniz Bulunmamaktadır. Yapacağınız İşlemler Kaydedilmeyecektir.";
    else if ($errCode == "noPermissionProcess") $errorMessage = "Dil Yönetimi Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noCategoryProcess") $errorMessage = "Kategori Ekleme ve Düzenleme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noCategoryDelete") $errorMessage = "Kategori Silme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noBankProcess") $errorMessage = "Bankalar ve Hesaplar Üzerinde İşlem Yapma Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noProductProcess") $errorMessage = "Yeni Ürün Ekleme ve Ürün Bilgilerini Güncelleme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noProductDelete") $errorMessage = "Ürün Silme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noBlogProcess") $errorMessage = "Yeni Blog Yazısı Ekleme ve Blog Yazılarını Güncelleme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "noBlogDelete") $errorMessage = "Blog Silme Yetkiniz Bulunmamaktadır.";
    else if ($errCode == "nolanguageProcess") $errorMessage = "Dil Yönetimi Yetkiniz Bulunmamaktadır.";



    $messageBox = '
      <div class="alert alert-custom alert-light-danger fade show" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
          <div class="alert-text">' . $errorMessage . '</div>
          <div class="alert-close">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="ki ki-close"></i></span>
              </button>
          </div>
      </div>';
    echo $messageBox;
  }

  public function imageUpload($dbclass, $imageType, $deviceType = 0, $sourceId, $altTag, $langCode = "TR", $key = 0)
  {
    // $imageType = yüklenen görselin nerede kullanılacağını belirten alandır
    // “0” = Slider - dosya yolu = uploads/sliders
    // “1” = Banner - dosya yolu = uploads/banners
    // “2” = Ürün Tanıtım Görseli - dosya yolu = uploads/products
    // “3” = Blog Tanıtım Görseli - dosya yolu = uploads/blogs
    // “4” = Ürün Sonrası Görseli - dosya yolu = uploads/productGallery
    // $deviceType = yüklenen görselin hangi cihazlarda gösterileceğini belirten alandır.
    // “0” = Masaüstü
    // “1” = Mobil
    if ($imageType == 0) $newFolder = "uploads/sliders"; // gelen görsel slider için kullanılacaktır.
    else if ($imageType == 1) $newFolder = "uploads/banners"; // gelen görsel banner için kullanılacaktır.
    else if ($imageType == 2) $newFolder = "uploads/products"; // gelen görsel kullanıcı profil resmi için kullanılacaktır.
    else if ($imageType == 3) $newFolder = "uploads/blogs"; // gelen görsel blog tanıtım görseli olarak kullanılacaktır.
    else if ($imageType == 4) $newFolder = "uploads/productGallery"; // gelen görsel blog tanıtım görseli olarak kullanılacaktır.
    else if ($imageType == 5) $newFolder = "uploads/categories"; // gelen görsel blog tanıtım görseli olarak kullanılacaktır.

    else $newFolder = "uploads/others";

    $yeniYol = str_replace("tasks", $newFolder, $_SESSION['imageDetails'][$key]['imageLink']);
    if (rename($_SESSION['imageDetails'][$key]['imageLink'], $yeniYol)) {
      $imageKaydet = $dbclass->ekle("images", "imageLink,imageType,sourceId,imageAlt,deviceType,langCode", array($yeniYol, $imageType, $sourceId, $altTag, $_SESSION['imageDetails'][$key]['deviceType'], $langCode));
    } else echo json_encode(array("error", "Resim Taşınırken Bir Hata Oluştu"));
    unset($_SESSION['imageDetails'][$key]);
  }

  public function imageDetected($dbclass, $imageType, $sourceId, $langCode = "TR", $deviceType = 0)
  {
    // $imageType = yüklenen görselin nerede kullanılacağını belirten alandır
    // “0” = Slider - dosya yolu = uploads/sliders
    // “1” = Banner - dosya yolu = uploads/banners
    // “2” = Kullanıcı Profil Fotoğrafı - dosya yolu = uploads/users
    // “3” = Etkinlik Tanıtım Görseli - dosya yolu = uploads/activities/main
    // “4” = Etkinlik Sonrası Görseller - dosya yolu = uploads/activities/gallery
    // “5” = Blog Görseli - dosya yolu = uploads/blogs
    // “6” = Kategeori - dosya yolu = uploads/categories
    // “7” = Banka Logoları - dosya yolu = uploads/banks
    // “6” = Diğer - dosya yolu = uploads/others


    // $deviceType = yüklenen görselin hangi cihazlarda gösterileceğini belirten alandır.
    // “0” = Masaüstü
    // “1” = Mobil
    if ($imageType == 0) $newFolder = "uploads/sliders"; // gelen görsel slider için kullanılacaktır.
    else if ($imageType == 1) $newFolder = "uploads/banners"; // gelen görsel banner için kullanılacaktır.
    else if ($imageType == 2) $newFolder = "uploads/products"; // gelen görsel ürün görseli için kullanılacaktır.
    else if ($imageType == 3) $newFolder = "uploads/blogs"; // gelen görsel blog tanıtım görseli olarak kullanılacaktır.
    else if ($imageType == 4) $newFolder = "uploads/productGallery"; // gelen görsel ürün sonrası görseli olarak kullanılacaktır.
    else if ($imageType == 5) $newFolder = "uploads/categories"; // gelen kategori görseli olarak kullanılacaktır.
    else $newFolder = "uploads/others";
    $imageCount = $dbclass->cek("KAYITSAY", "images", "count(id)", "WHERE sourceId=? AND imageType=? AND langCode=? AND deviceType=?", array($sourceId, $imageType, $langCode, $deviceType));
    if ($imageCount > 0) {
      $categoryImage = $dbclass->cek("ASSOC_ALL", "images", "*", "WHERE sourceId=? AND imageType=? AND langCode=? AND deviceType=? ORDER BY orderNumber ASC", array($sourceId, $imageType, $langCode, $deviceType));
      $imageLinkReturn = array();
      foreach ($categoryImage as $key => $value) {
        $imageLinkReturn[$key][0] = $categoryImage[$key]['id'];
        $imageLinkReturn[$key][1] = $categoryImage[$key]['imageLink'];
        $imageLinkReturn[$key][2] = $categoryImage[$key]['title'];
        $imageLinkReturn[$key][3] = $categoryImage[$key]['content'];
        $imageLinkReturn[$key][4] = $categoryImage[$key]['extraDetails'];
        $imageLinkReturn[$key][5] = $categoryImage[$key]['hrefUrl'];
      }

    } else {
      $imageLinkReturn[0][0] = "no-image";
      $imageLinkReturn[0][1] = "../uploads/no-image.jpg";
    }
    return $imageLinkReturn;
  }

  public function donationDetailModal($dbclass, $donationId)
  {
    ## bağış bilgileri getiriliyor ##
    $donationControl = $dbclass->cek("KAYITSAY", "activitiesVsDonations", "count(id)", "WHERE id=?", array($donationId));
    if ($donationControl > 0) {
      $donationDetails = $dbclass->cek("ASSOC", "activitiesVsDonations", "*", "WHERE id=?", array($donationId));
      $donationRowGet = $dbclass->cek("ASSOC_ALL", "activitiesVsDonations", "*", "WHERE activityId=? AND userId=?", array($donationDetails['activityId'], $donationDetails['userId']));
      $donationRow = "";
      $totalPlus = 0;
      $totalMinus = 0;
      foreach ($donationRowGet as $keyRow => $valueRow) {
        if ($valueRow['paymentMethod'] == 0) $paymentMethod = "Kredi Kartı";
        else if ($valueRow['paymentMethod'] == 1) $paymentMethod = "Havale/EFT";
        else if ($valueRow['paymentMethod'] == 2) $paymentMethod = "Elden Teslim";
        if ($valueRow['recordType'] == 0) {
          $paymentTotal = '<span class="text-success">+' . $valueRow['paymentTotal'] . '₺</span>';
          $totalPlus = $totalPlus + $valueRow['paymentTotal'];
        } else if ($valueRow['recordType'] == 1) {
          $paymentTotal = '<span class="text-danger">-' . $valueRow['paymentTotal'] . '₺</span>';
          $totalMinus = $totalMinus + $valueRow['paymentTotal'];
        }
        if ($valueRow['paymentStatus'] == 0) {
          $paymentClass = '';
        } else if ($valueRow['paymentStatus'] == 1) {
          $paymentClass = 'checked="checked"';
        }
        $donorNotes = "";
        if (!empty($valueRow['donorNotes'])) {
          $donorNotes = '
            <div class="col-12 text-left">
              <span class="font-weight-bolder mb-2">Bağışçı Notu: </span>
              <span>' . $valueRow['donorNotes'] . '</span>
            </div>
          ';
        }

        $donationRow .= '
          <div class="row border p-2 p-lg-3 mb-3 rounded bg-gray-100">
            <div class="col-12 d-flex p-2 mb-2">
              <div class="d-flex flex-column flex-root text-left">
                <span class="font-weight-bold text-muted text-uppercase mb-2">Tarih</span>
                <span class="font-weight-bold">' . date("d-m-Y h:m:s", strtotime($valueRow['paymentTime'])) . '</span>
              </div>
              <div class="d-flex flex-column flex-root text-left">
                <span class="font-weight-bold text-muted text-uppercase mb-2">Ödeme Yöntemi</span>
                <span class="font-weight-bold">' . $paymentMethod . '</span>
              </div>
              <div class="d-flex flex-column flex-root text-left">
                <span class="font-weight-bold text-muted text-uppercase mb-2">Ödeme Miktarı</span>
                <span class="font-weight-bolder">' . $paymentTotal . '</span>
              </div>
              <div class="d-flex flex-column flex-root text-center">
                <span class="font-weight-bold text-muted text-uppercase mb-2">Ödeme Durumu</span>
                <span class="switch switch-outline switch-icon switch-success">
                  <label>
                  <input type="checkbox" ' . $paymentClass . ' data-activity-id="' . $valueRow['activityId'] . '" data-user-id="' . $valueRow['userId'] . '" data-record-number="' . $valueRow['id'] . '" name="select" class="paymentStatus"/>
                  <span></span>
                  </label>
                </span>
              </div>
            </div>
            ' . $donorNotes . '
          </div>
        ';
      }
      ## bağış bilgileri getiriliyor ##
      ## bağışı yapan kullanıcı bilgileri getiriliyor ##
      $userDetail = $dbclass->cek("ASSOC", "users", "*", "WHERE id=?", array($donationDetails['userId']));
      $userCountry = $dbclass->cek("ASSOC", "countries", "*", "WHERE id=?", array($userDetail['country']));
      $userCity = $dbclass->cek("ASSOC", "cities", "*", "WHERE id=?", array($userDetail['city']));
      ## bağışı yapan kullanıcı bilgileri getiriliyor ##
      ## bağış yapılan etkinlik bilgileri getiriliyor  ##
      $activityDetail = $dbclass->cek("ASSOC", "activities", "activityName", "WHERE uniqueId=? AND langCode=?", array($donationDetails['activityId'], "TR"));
      ## bağış yapılan etkinlik bilgileri getiriliyor  ##
      $donationModal = '
      <!-- New Donation Modal-->
        <div class="modal fade donationDetailModal" id="donationDetailModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">' . $activityDetail['activityName'] . '</h5>
                  <button type="button" class="btn btn-danger" id="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                  </button>
                </div>
                <div class="modal-body p-0">
                  <!-- begin::Card-->
                  <div class="card card-custom overflow-hidden">
                    <div class="card-body p-12 p-lg-0">
                      <!-- begin: Invoice-->
                      <!-- begin: Invoice header-->
                      <div class="row justify-content-center">
                        <div class="col-md-12 p-0 p-lg-10">
                          <div class="d-flex justify-content-between pb-5 flex-column flex-md-row align-items-center">
                            <h3 class="display-6 font-weight-boldest">' . $userDetail['name'] . ' ' . $userDetail['surname'] . '</h3>
                            <div class="d-flex flex-column align-items-md-end px-0">
                              <h4 class="display-6 font-weight-boldest"></h4>
                              <span class="d-flex flex-column align-items-md-end opacity-70">
                                <span>' . $userDetail['adress'] . '</span>
                                <span>' . $userCountry['countryName'] . ', ' . $userCity['cityName'] . '</span>
                              </span>
                            </div>
                          </div>
                          <div class="border-bottom w-100 mb-4"></div>
                          ' . $donationRow . '
                        </div>
                      </div>
                      <!-- end: Invoice header-->
                      <!-- begin: Invoice body-->
                      <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-11">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th class="pl-0 font-weight-bold text-muted text-uppercase">Özet</th>
                                  <th class="text-right font-weight-bold text-muted text-uppercase">İşlem Türü</th>
                                  <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Miktar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr class="font-weight-boldest">
                                  <td class="pl-0 pt-7">Toplam Bağışlar</td>
                                  <td class="text-success text-center pt-7">Bağış</td>
                                  <td class="text-success pr-0 pt-7 text-right">' . $totalPlus . '₺</td>
                                </tr>
                                <tr class="font-weight-boldest">
                                  <td class="pl-0 pt-7">Toplam İadeler</td>
                                  <td class="text-danger text-center pt-7">İade</td>
                                  <td class="text-danger pr-0 pt-7 text-right">' . $totalMinus . '₺</td>
                                </tr>
                                <tr class="font-weight-boldest">
                                  <td class="pl-0 pt-7">Genel Toplam</td>
                                  <td class="text-success text-center pt-7">Toplam</td>
                                  <td class="text-success pr-0 pt-7 text-right">' . ($totalPlus - $totalMinus) . '₺</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <!-- end: Invoice body-->
                      <!-- begin: Invoice action-->
                      <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-12">
                          <div class="d-flex justify-content-end">
                            <button type="button" class="mr-3 btn btn-primary font-weight-bold" onclick="window.print();">Yazdır</button>
                            <button type="button" class="mr-3 btn btn-danger" id="close" data-dismiss="modal" aria-label="Close">Kapat</button>
                          </div>
                        </div>
                      </div>
                      <!-- end: Invoice action-->
                      <!-- end: Invoice-->
                    </div>
                  </div>
                  <!-- end::Card-->
                </div>
              </div>
            </div>
        </div>
      <!-- New Donation Modal-->
      ';
      echo $donationModal;
    }
  }

  public function permissionControl($dbclass, $userId, $permissionId)
  {
    // $permissionId = 1 => bu ayar kullanıcı ekleme ve düzenleme ayarıdır. Yeni kullanıcı ekleme, kullanıcı bilgileri düzenleme ve yetkilendirme işlemlerini etkilemektedir.
    $control = $dbclass->cek("KAYITSAY", "usersVsPermissions", "count(id)", "WHERE permissionId=? AND userId=? AND permissionStatus=?", array($permissionId, $userId, 1));
    if ($control > 0) $return = 1;
    else $return = 0;
    return $return;
  }

  public function constDefinitions($dbclass, $pageCode, $constCode)
  {
    ## $slugType değişkeni 3. kırılım linklemeler olduğu zaman root slug'a gerek duyulmadığında sadece 3. kırılım slug geri döndürülmesi gerektiğinde 1 olarak gönderilir. Varsayılan değeri 1'dir $slugType 1 geliyor ise $pageRootSlug ile birleştirilerek döndürülür. 0 geliyor ise sadece 3. kırılım olan systemSlug döndürülür
    ## FİXED NUMBER : ÖRNEĞİN 75 -> İNGİLİZCE DİLİNDE EXİT ANLAMINA GELİRKEN TÜRKÇE DİLİNDE CIKIŞ ANLAMINA GELİR VE BU DEĞERLERİ RETURN EDER
    ## $lang değeri site ön yüzde $_SESSION['lang'] oluşturulduktan sonra direkt olarak sessiondan alacaktır.
    $langCode = "TR";
    $count = $dbclass->cek("KAYITSAY", "siteConstants", "count(id)", "WHERE pageCode=? AND constCode=? AND lang=?", array($pageCode, $constCode, $langCode));
    if ($count > 0) {
      $check = $dbclass->cek("ASSOC", "siteConstants", "constValue,constSlug,pageCode", "WHERE pageCode=? AND constCode=? AND lang=?", array($pageCode, $constCode, $langCode));
      return array($check['constValue'], $check['constSlug']);
    } else {
      return "Hatalı Kod!!";
    }
  }

  public function contactDetails($dbclass, $pageCode, $constCode)
  {
    ## $slugType değişkeni 3. kırılım linklemeler olduğu zaman root slug'a gerek duyulmadığında sadece 3. kırılım slug geri döndürülmesi gerektiğinde 1 olarak gönderilir. Varsayılan değeri 1'dir $slugType 1 geliyor ise $pageRootSlug ile birleştirilerek döndürülür. 0 geliyor ise sadece 3. kırılım olan systemSlug döndürülür
    ## FİXED NUMBER : ÖRNEĞİN 75 -> İNGİLİZCE DİLİNDE EXİT ANLAMINA GELİRKEN TÜRKÇE DİLİNDE CIKIŞ ANLAMINA GELİR VE BU DEĞERLERİ RETURN EDER
    ## $lang değeri site ön yüzde $_SESSION['lang'] oluşturulduktan sonra direkt olarak sessiondan alacaktır.
    $langCode = "TR";
    $count = $dbclass->cek("KAYITSAY", "siteConstants", "count(id)", "WHERE pageCode=? AND constCode=? AND lang=?", array($pageCode, $constCode, $langCode));
    if ($count > 0) {
      $check = $dbclass->cek("ASSOC", "siteConstants", "constValue,constSlug,pageCode", "WHERE pageCode=? AND constCode=? AND lang=?", array($pageCode, $constCode, $langCode));
      return array($check['constValue'], $check['constSlug']);
    } else {
      return "Hatalı Kod!!";
    }
  }

  ## BU FONKSYİON SİTENİN SESSİONDAKİ MEVCUT DİLİNE GÖRE SABİT METİNLERİNİ RETURN EDER ##

  public function pageDetected($dbclass, $pageId, $pageUniqueId)
  {
    $query = $dbclass->cek("ASSOC", "pages", "pageCode", "WHERE uniqueId=? AND langCode=?", array($pageUniqueId, "TR"));
    if ($query['pageCode'] == 101) $response = "about";
    else if ($query['pageCode'] == 102) $response = "team";
    else if ($query['pageCode'] == 104) $response = "faqs";
    else if ($query['pageCode'] == 105) $response = "bankAccounts";


    else $response = "other";
    return $response;
  }
}

?>