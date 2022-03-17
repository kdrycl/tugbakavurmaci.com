<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
class db {
	protected $baglan;
//veritabanına bağlantı
	public $dbpass;
	public function __construct($dbname,$dbuser,$dbpass) {
		try {
			date_default_timezone_set('Europe/Istanbul');
			$this->baglan = new PDO("mysql:host=localhost;dbname=$dbname",$dbuser,$dbpass,
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		} catch (PDOException $e) {
			echo "<b>HATA:Baglantı hatası</b> ". $e->getMessage();
			$this->kapat(); exit;
		}
	}
	

//veritabanı bağlantıyı kapat __destruct
	public function kapat() {
		if($this->baglan) { $this->baglan = null; }
	}

	public function dogrudanSorgu($sql){
		// ASSOC_ALL CALIŞIR
		try {
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute();
			if ($sonuc) { return $sonuc->fetchAll(PDO::FETCH_ASSOC); }else{ return false; }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}
//doğrudan sorgu çalıstır
	public function sorgu($sql, $degerler) {
		try {
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute($degerler);
			if ($sonuc) { return $sonuc; }else{ return false; }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}

//veritabanından bilgi çek
	public function cek($tip, $tabloAdi, $sutunlar, $kosul, $degerler) {
		try {
			$sql = "SELECT " . $sutunlar . " FROM " . $tabloAdi . " " . $kosul;
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute($degerler);
			if($tip==""){ return $sonuc; }
			if($tip=="ASSOC"){ return $sonuc->fetch(PDO::FETCH_ASSOC); }
			if($tip=="OBJ"){ return $sonuc->fetch(PDO::FETCH_OBJ); }
			if($tip=="NUM"){ return $sonuc->fetch(PDO::FETCH_NUM); }
			if($tip=="ASSOC_ALL"){ return $sonuc->fetchAll(PDO::FETCH_ASSOC); }
			if($tip=="OBJ_ALL"){ return $sonuc->fetchAll(PDO::FETCH_OBJ); }
			if($tip=="NUM_ALL"){ return $sonuc->fetchAll(PDO::FETCH_NUM); }
			if($tip=="KAYITSAY"){ return $sonuc->fetchColumn(); }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}

//Tablodaki belirli kayıtları güncelle
	public function guncelle($tip, $tabloAdi, $sutunlar, $kosul, $degerler) {
		$sutunlar=explode(",", $sutunlar);
		$sutundeger="";
		foreach ($sutunlar as $sutun) {
			if($tip==0){ $sutundeger .= ($sutundeger == "") ? "" : ", "; $sutundeger .= $sutun . "=?"; }
			if($tip==1){ $sutundeger .= ($sutundeger == "") ? "" : ", "; $sutundeger .= $sutun . "=$sutun+?"; }
		}
		try {
			$sql = "UPDATE " . $tabloAdi . " SET " . $sutundeger . " " . $kosul;
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute($degerler);
			if ($sonuc) { return $sonuc->rowCount(); }else{ return false; }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}

//tabloya kayıt ekle
	public function ekle($tabloAdi, $sutunlar, $degerler) {
		$deger = "";
		foreach ($degerler as $d) {
			$deger .= ($deger == "") ? "" : ","; $deger .= "?";
		}
		try {
			$sql = "INSERT INTO $tabloAdi ($sutunlar) VALUES ($deger)";
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute($degerler);
			if($sonuc) { return $this->baglan->lastInsertId(); }else{ return false; }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}
	public function uniqueId($tableName){
		// $tableName = veritabanında uniqueId kontrolü yapılacak tablo adını göndermek için kullanılır.
		$key="";
		$karakterler="";
		$uzunluk=2;
		$sayilar=0;
		$karakterler = "ABCDEFGHJKLMNOPRSTUYVZabcdefghjklmnoprstuyvz";
		$sayilar = "1234567890";
		$key.="9";
		for($i=0;$i<$uzunluk;$i++)
		{	
			$key.=rand(100,9999);
			//$key .=$karakterler{rand(0,40)}.$sayilar{rand(0,9)};
		}
		$keyControl=$this->cek("KAYITSAY","$tableName","count(id)","WHERE uniqueId=?",array($key));
		if ($keyControl>0) {
			$this->uniqueId($tableName);
		}
		else return $key;
	}

//tablodan kayıt silme
	public function sil($tabloAdi, $kosul, $degerler) {
		try {
			$sql = "DELETE FROM " . $tabloAdi . " " . $kosul;
			$sonuc = $this->baglan->prepare($sql);
			$sonuc->execute($degerler);
			if ($sonuc) { return $sonuc->rowCount(); }else{ return false; }
		} catch (PDOException $e) {
			echo $this->hatabul($e->getTrace(), $e->getCode(), $e->getMessage(), $sql);
			$this->kapat(); exit;
		}
	}

//sayfalama yapan function
	public function sayfala($tip, $tabloAdi, $sutunlar, $kosul, $degerler, $toplamkayit, $sayfa, $link, $x) {
		if(empty($sayfa)) { $sayfa = 1; }
		if($sayfa < 1) $sayfa = 1; 
		$countdizi = explode(",", $sutunlar);
		$kayitSayisi = $this->cek("KAYITSAY", $tabloAdi, "COUNT(".$countdizi[0].")", $kosul, $degerler);
		$toplamsayfa = ceil($kayitSayisi / $toplamkayit);
		if($sayfa > $toplamsayfa) { $sayfa = 1; }
		$baslangic = ($sayfa-1)*$toplamkayit;
		$sonuc = $this->cek($tip, $tabloAdi, $sutunlar, "$kosul LIMIT $baslangic,$toplamkayit", $degerler);
		$sayfala = "";
		if($kayitSayisi > $toplamkayit) {
			if($sayfa > 1){ $onceki = $sayfa-1;
				$sayfala .="<li><a href=\"".$link."1\">&laquo; İlk</a></li>";
				$sayfala .="<li><a href=\"".$link.$onceki."\">Önceki</a></li>"; }
				if($sayfa==1){ $sayfala .="<li><a class=\"current\">[1]</a></li>";
			}elseif($sayfa-$x < 2){ $sayfala .="<li><a href=\"".$link."1\">1</a></li>"; }   
			if($sayfa-$x > 2){ $i = $sayfa-$x; }else{ $i = 2; } 
			if($sayfa-$x-10 > 0){ $sayfala .="<li><a class=\"current\" href=\"".$link.($sayfa-$x-10)."\">[".($sayfa-$x-10)."]</a></li>"; }
			for($i; $i<=$sayfa+$x; $i++) { 
				if($i==$sayfa){ $sayfala .="<li><a class=\"current\">[$i]</a></li>"; }else{ $sayfala .="<li><a href=\"".$link.$i."\">$i</a></li>"; }
				if($i==$toplamsayfa) break; 
			} 
			if($sayfa+$x+10 < $toplamsayfa){ $sayfala .="<li><a class=\"current\" href=\"".$link.($sayfa+$x+10)."\">[".($sayfa+$x+10)."]</a></li>"; }
			if($sayfa < $toplamsayfa){
				$sonraki = $sayfa+1; $sayfala .="<li><a href=\"".$link.$sonraki."\">Sonraki</a></li>";
				$sayfala .="<li><a href=\"".$link.$toplamsayfa."\">Son &raquo;</a></li>"; } 
			}
			return array("veriler"=>$sonuc, "sayfalar"=>$sayfala, "toplamsayfa"=>$toplamsayfa, "toplamkayit"=>$kayitSayisi);
		}

//hata detayları
		private function hatabul($hata, $kodu, $mesaj, $sql) {
			$htmsj = "<b>PHP PDO HATA:</b> " . strval($kodu) . "<br><br>";
			$i=0;
			foreach ($hata as $a){
				if($i==0){ $htmsj .="<b>Class tarafı hata bilgileri</b><br>"; }else{ $htmsj .="<b>Dosya tarafı hata bilgileri</b><br>"; }
				$htmsj .= "Hatalı SQL: ". htmlspecialchars($sql) ."<br>";
				$htmsj .= "Hatalı Function: ". $a["function"] . "<br>";
				$htmsj .= "Hatalı Dosya: ". $a["file"] . "<br>";
				$htmsj .= "Hatalı Satır: ". $a["line"] . "<br><br>";
				$i++;
			}
			$htmsj .= "<b>Hata MSJ:</b> " . $mesaj;
			return $htmsj;
		}


	    public	function rastgele($uzunluk)
		{
			$key="";
			$karakterler="";
			$sayilar=0;
			$karakterler = "ABCDEFGHJKLMNOPRSTUYVZabcdefghjklmnoprstuyvz";
			$sayilar = "1234567890";
			$key.="9";
			for($i=0;$i<$uzunluk;$i++)
			{	
				$key.=rand(100,9999);
				//$key .=$karakterler{rand(0,40)}.$sayilar{rand(0,9)};
			}

			return $key;
		}
		public	function rastgeleharf($uzunluk)
		{
			$key="";
			$karakterler = "ABCDEFGOPRSTUYABCDEFGHJKLMEFGVZHJKLMEFGHJKLMEFGHJKLMNOPRSTUYABCDEFGHJKLMEFGVZ";
			for($i=0;$i<$uzunluk;$i++)
			{
				$key.=rand(100,9999);
				//$key .=$karakterler{rand(1,66)};
			}

			return $key;
		}
		public	function rastgelesayi($uzunluk)
		{
			
			$key="";
			$sayilar = "54123456789045";
			for($i=0;$i<$uzunluk;$i++)
			{
				$key.=rand(100,9999);
				//$key .=$sayilar{rand(1,11)};
			}

			return $key;
		}
		function seo($s) {
			$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','+','*','?',"'",'^','','.',' ','%','<0x32>',"!");
			$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','',"-",'-','-','-','-','-','-','-','-','-');
			$s = str_replace($tr,$eng,$s);
			$s = strtolower($s);
			$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
			$s = preg_replace('/\s+/', '-', $s);
			$s = preg_replace('|-+|', '-', $s);
			$s = preg_replace('/#/', '', $s);
			$s = trim($s, '-');
			return $s;
		} 
		function imageseo($s) {
			$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',','+','*','?',"'",'^','',' ','%','<0x32>');
			$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','',"-",'-','-','-','-','-','-','-','-');
			$s = str_replace($tr,$eng,$s);
			$s = strtolower($s);
			$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
			$s = preg_replace('/\s+/', '-', $s);
			$s = preg_replace('|-+|', '-', $s);
			$s = preg_replace('/#/', '', $s);
			$s = trim($s, '-');
			return $s;
		}
		public function bosluksil($metin){
			$metin = trim($metin);
			$eski = array(" ");
			$yeni = array("");
			$metin = str_replace($eski, $yeni, $metin);
			return $metin;
		}
		public function blogCategoryParentDetected($ids)
		{
			## Girilen blog kategorisinin üst kategorilerini array olarak return eder
			
			global $id;
			$sonuc=$this->cek("ASSOC", "blogCategories", "id,mainCategoryId,categoryName,categorySlug", "Where id=?", array($ids));
			$kategoriadi=$sonuc["categoryName"];
			$katidsi=$sonuc["id"];
			$ustKatNo=$sonuc['mainCategoryId'];
			$link[]=$sonuc['categorySlug'];
			if ($ustKatNo!=0) {
				$id[]=$katidsi;
				$this->blogCategoryParentDetected($ustKatNo);
			}
			else{
				$id[]=$katidsi;
			}
			return $id;
		}

		public function ustKatBulAgacGetir($ids)
		{
			## Girilen kategoriNo'nun tüm üst kategori agacını verir.
			## LİNK SONRADAN EKLENDİ HATA VERİRSE KONTROL EDİN
			global $kategoriadi;
			global $agac;
			global $id;
			global $link;

			$sonuc =$this->cek("ASSOC", "kategoriler", "id,kategoriAdi,ustKategoriNo,kategoriNo,kategoriSlug", "Where kategoriNo='".$ids."'  ", array());
			$kategoriadi=$sonuc["kategoriAdi"];
			$katidsi=$sonuc["kategoriNo"];
			$ustKatNo=$sonuc['ustKategoriNo'];
			$link[]=$sonuc['kategoriSlug'];
			if ($ustKatNo!=0) {
				$agac[]=$kategoriadi." > ";
				$id[]=$katidsi." > ";
				$this->ustKatBulAgacGetir($ustKatNo);
			}else{
				$agac[]=$kategoriadi." > ";
				$id[]=$katidsi." > ";

			}
			$dizi1 = array_reverse($agac);
			$dizi2 = array_reverse($id);
			$dizi3 = array_reverse($link);



			return array($dizi1,$dizi2,$dizi3);
		}
		public function altKategorileriGetir($ids)
		{
			## Girilen kategoriNo'nun sadece alt kategorilerini return eder 0 da id 1 de isim
			global $donendizi;
			$sonuc =$this->cek("ASSOC_ALL", "kategoriler", "kategoriNo,kategoriAdi", "Where ustKategoriNo='".$ids."'  ", array());
			foreach ($sonuc as $index => $value) {
				$donendizi[$value['kategoriNo']]=$value['kategoriAdi'];
			}
			return array($donendizi);
		}

		// public function blogAltKategorileriGetir($ids,$returnType=""){
		// 	## Girilen kategoriNo'nun sadece alt kategorilerini return eder 0 da id 1 de isim 2 de kategori slug
		// 	## returnType sonradan eklenmiştir, önceki veriler etkilenmemesi için default boştur. slug değerini aldığında modules class'da kullanıcağı şekilde return eder
		// 	global $donendizi2;
		// 	global $sayac;
		// 	$ext=new ext();
		// 		$in="";
		// 		$categorySlug="";
		// 		if($returnType=="slug" && $sayac==null) {
		// 			$donendizi2[]=$this->cek("ASSOC","blogCategories","categorySlug","where id=?",array($ids))['categorySlug']; 
		// 			$sayac=1;
		// 		}
		// 		$say=$this->cek("KAYITSAY","blogCategories","count(id)","where mainCategoryId IN ($ids)",array());
		// 		if($say>0){
		// 			$sonuc=$this->cek("ASSOC_ALL", "blogCategories", "id,categoryName,categorySlug", "WHERE mainCategoryId IN($ids)  ", array());
		// 			foreach ($sonuc as $index => $value) {
		// 				$in.="'".$value['id']."'".",";
		// 				if($returnType=="slug"){
		// 					if(!$ext->searchForArray($value['categorySlug'], $donendizi2)){
		// 						$donendizi2[]=$value['categorySlug'];
		// 					 }
		// 				}
		// 				else $donendizi2[]=array("id"=>$value['id'],"categoryName"=>$value['categoryName'],"categorySlug"=>$value['categorySlug']);
		// 			}
		// 			$in=$this->ifadekes($in,1);
		// 			if($returnType=="slug") $this->blogAltKategorileriGetir($in,"slug");
		// 			else $this->blogAltKategorileriGetir($in); 
		// 		}
			
		// 	return $donendizi2;
		// }

		public function ifadekes($string,$sondankacadet){
			## İLGİLİ STRİNGİ SONDAN GÖNDERİLEN SAYI KADAR KESER 
			$say=strlen($string);
			$kes=substr($string,0,$say-$sondankacadet);
			return $kes;
		}
		public function sqlcontrol($gelen){
			## GET İLE GELEN DEĞERİ SQL İNJECTİON KONTROLÜ YAPAR
			if (preg_match("/[\-]{2,}|[;]|[']|[\\\*]/", $gelen)){
				return false;
			}
			else{
				return true;
			}
		}

		public function taksitsorgula($entegrator){
			## TAKSİT SORGULAMA

			if ($entegrator=="paytr") { // PAYTR ' den taksit oranları isteniyor

			$paytrcek=$this->cek("ASSOC","pos","*","where id=?",array(1));
			$merchant_id=$paytrcek['alan2'];
			$merchant_key=$paytrcek['alan3'];
			$merchant_salt=$paytrcek['alan4'];
			$request_id=time();
			$paytr_token=base64_encode(hash_hmac('sha256',$merchant_id.$request_id.$merchant_salt,$merchant_key,true));
			$post_vals=array(
				'merchant_id'=>$merchant_id,
				'request_id'=>$request_id,
				'paytr_token'=>$paytr_token
			);
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/taksit-oranlari");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1) ;
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 90);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 90);
			$result = @curl_exec($ch);
			if(curl_errno($ch))
			{
				echo curl_error($ch);
				curl_close($ch);
				exit;
			}
			curl_close($ch);
			$result=json_decode($result,1);
			if($result['status']=='success')
			{
				return $result;
			}
			else 
			{
				return $result['err_msg'];
			}
		}

	}


	public function cssbas(){
		## İLGİLİ SAYAFA GÖRE CSS CAĞIRIR HEADER.PHP
		$css="";
		$sayfa=basename($_SERVER["SCRIPT_NAME"]);
		if ($sayfa=="urun.php") {
			$css.='<link href="https://cdn.yetsispro.com/admin/assets/css/pages/wizard/wizard-1.css?v=7.0.3" rel="stylesheet" type="text/css"/>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
			';
		}
		if($sayfa=="urunozellestir.php" || $sayfa=="urunler.php" || $sayfa=="kampanya.php" || $sayfa=="siparis-duzenle.php" || $sayfa=="kategorilerlist.php"  || $sayfa=="siparisler.php" || $sayfa=="sliderolustur.php" || $sayfa=="marka.php" || $sayfa=="kargo.php" || $sayfa=="odemeayarlari.php" || $sayfa=="urunozellikleri.php" || $sayfa=="menu.php" || $sayfa=="urunozellestirme.php"){//DATATABLES İŞLEMLERİ
			$css.= '<link href="https://cdn.yetsispro.com/admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.3" rel="stylesheet" type="text/css" />
			<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
			';
		}
		if($sayfa=="blok.php" || $sayfa=="sayfa.php" || $sayfa=="slider.php"){
			$css.= '<link href="https://cdn.yetsispro.com/admin/css/blok.css" rel="stylesheet" type="text/css" />
			<link href="https://cdn.yetsispro.com/admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.3" rel="stylesheet" type="text/css" />
			<script src="https://cdn.yetsispro.com/admin/plugins/ckeditor/ckeditor.js"></script>
			';
		}
		if ($sayfa=="slider.php") {
			$css.='<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
		}
		if ($sayfa=="kampanya.php") {
			$css.='
			<script src="assets/plugins/custom/ckeditor/ckeditor-document.bundle.js?v=7.0.3"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
		}
		if($sayfa=="blog-add.php"){
			
			$css.='<link href="https://cdn.yetsisyazilim.com/admin/assets//plugins/custom/cropper/cropper.bundle.css?v=7.1.8" rel="stylesheet" type="text/css" />';
		}
		if($sayfa=="menu-duzenle.php"){
			
			$css.='<link href="https://cdn.yetsisyazilim.com/admin/css/nestable.css?v=7.1.8" rel="stylesheet" type="text/css" />';
		}
		





		


		return $css;

	}
	public function jsbas(){
		## İLGİLİ SAYFAYA GÖRE FOOTER DA JS CAĞIRIR
		$js="";
		$sayfa=basename($_SERVER["SCRIPT_NAME"]);
		if ($sayfa=="urun.php") {
			$js.= '<script src="https://cdn.yetsisyazilim.com/admin/js/wizardurunvs.js"></script>
			<script src="https://cdn.yetsisyazilim.com/admin/js/urun.js"></script>
			<script src="https://cdn.yetsisyazilim.com/admin/js/script-custom.js"></script>
			<script src="https://cdn.yetsisyazilim.com/admin/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js?v=7.0.3"></script>
			<script src="https://cdn.yetsisyazilim.com/admin/js/ckeditor-bundlevs.js"></script>';
		}
		if($sayfa=="urunozellestir.php" || $sayfa=="urunler.php" || $sayfa=="urunozellikleri.php"){

			$js.= '<script src="https://cdn.yetsisyazilim.com/admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3"></script>
			<script src="https://cdn.yetsisyazilim.com/admin/js/ajaxgettable.js"></script>';
		}
		 if($sayfa=="bloglar.php" || $sayfa=="blog-categories.php" || $sayfa=="blog-tags.php" || $sayfa=="kullanicilar.php" || $sayfa=="blok.php" || $sayfa=="sayfa.php" || $sayfa=="slider.php" || $sayfa=="kampanya.php" || $sayfa=="kategorilerlist.php" || $sayfa=="siparis-duzenle.php" || $sayfa=="siparisler.php" || $sayfa=="sliderolustur.php" || $sayfa=="marka.php" || $sayfa=="kargo.php"  || $sayfa=="odemeayarlari.php"  || $sayfa=="menu.php" || $sayfa=="urunozellestirme.php"){//tablo olusturma
		 	$js.='
		 	<script src="https://cdn.yetsisyazilim.com/admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/js/ajaxgettable.js"></script>';
		 }
		 if ($sayfa=="blok.php" || $sayfa=="sayfa.php") {
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/blok.js"></script>';
		 }
		 if($sayfa=="slider.php"){
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/script-custom.js"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/assets/plugins/custom/ckeditor/ckeditor-document.bundle.js?v=7.0.3"></script>
		 	';
		 }
		 if ($sayfa=="kampanya.php") {
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/blok.js"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/js/script-custom.js"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/js/date-time-picker.js"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/js/ckeditor-bundlevs.js"></script>
		 	';
		 }
		 if ($sayfa=="siparisler.php") {
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/printThis.js"></script>
		 	<script src="https://cdn.yetsisyazilim.com/admin/js/ajaxgettabledt.js"></script>';
		 }
		 if ($sayfa=="index.php") {
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/chart.js"></script>';
		 }
		 if ($sayfa=="kategori.php") { // DROPZONE KULLANIMI
		 	$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/script-custom.js"></script>';
		 }
		 if($sayfa=="kullanicilar.php" || $sayfa=="kullanici-islem.php"){
			$js.='<script src="js/users.js"></script>';
			$js.='<script src="assets/js/pages/crud/datatables/extensions/buttons.js?v=7.1.8"></script>';
		 }
		 if($sayfa=="roles.php"){
			$js.='<script src="js/ktdatatable.js"></script>';
			$js.='<script src="js/roles.js"></script>';
		 }
		 if($sayfa=="bloglar.php" ){
			$js.='<script src="js/ktdatatable.js"></script>';
			$js.='<script src="js/blogs.js"></script>';
		 }
		 if($sayfa=="delegated-user.php" ){
			$js.='<script src="js/ktdatatable.js"></script>';
			$js.='<script src="js/delegatedpermission.js"></script>';
		 }
		 if($sayfa=="blog-add.php"){
			 $js.='<script src="https://cdn.yetsisyazilim.com/admin/assets/plugins/custom/cropper/cropper.bundle.js?v=7.1.8"></script>';
			 $js.='<script src="https://cdn.yetsisyazilim.com/admin/plugins/ckeditor-custom/ckeditor.js"></script>';
		 }
		 if($sayfa=="design-page.php"){
			$js.='<script src="js/ktdatatable.js"></script>';
			$js.='<script src="js/design-page.js"></script>';
		 }
		 if($sayfa=="menu-yonetimi.php"){
			$js.='<script src="js/ktdatatable.js"></script>';
			$js.='<script src="js/menu-yonetimi.js"></script>';
		 }
		 if($sayfa=="menu-duzenle.php"){
			$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/jquery.validate.js"></script>';
			$js.='<script src="https://cdn.yetsisyazilim.com/admin/js/menu-duzenle.js"></script>';
		 }

		 return $js;


	}

		public function aciklamainput($baslik,$mesaj){
			echo '<i  class="flaticon-questions-circular-button text-danger icon-xl" data-toggle="popover" data-trigger="hover" title="'.$baslik.'" data-content="'.$mesaj.'"></i>';
		}

		public function urunresimtemp(){
			## SESSİONDA TUTULAN TEMP KLASORÜNDEKİ RESİMLERİ TEMİZLER
			if (isset($_SESSION['yuklenenresimyollari'])) {
				$say=count($_SESSION['yuklenenresimyollari']);
				for ($i=0; $i < $say; $i++) { 
					unlink("../".$_SESSION['yuklenenresimyollari'][$i]);
				}
  			unset($_SESSION['yuklenenresimyollari']);//URUN EKLERKEN EKLENEN RESİMLERİN SESSİONU
  		}
  		unset($_SESSION['secenekler']);//ÜRÜN SAYFASINDA EKLENEN VARYANTLARI TEMİZLE
  	}
	public function sessiontemizle($sessionadi,$resimtemizle,$index=""){
		## İNDEX SONRADAN EKLENDİ : EĞER GÖNDERİLEN SESSİON ADININ İÇİNDE TEK BİR VERİ VAR İSE İNDEX GÖNDERİLMESİNE GEREK YOKTUR 
		## FAKAT GÖNDERİLEN SESSİON İÇİNDE BİR ARRAY VAR İSE HANGİ VERİYE İŞLEM YAPILACAĞININ İNDEX NUMARASI BURADA GÖNDERİLİR.
		## GÖNDERİLEN SESSİONLARI SESSİONDAN TEMİZLER virgül ile birden fazla session adı gönderilebilir
		## RESİM TEMİZLE 1 GELİR İSE SESSİON İÇERİSİNDEKİ DOSYA YOLUNU GERÇEK DOSYA YOLUNDAN SİLER ÖRNEGİN RESİM İÇİN KULLANILABİLİR.
		## DOSYA YOLUNDAN .yetsisyazilim.com/ KOPARILIR VE SONRASI İÇİN DOSYA SİLME İŞLEMİ YAPAR
		##SESSİONDAKİ ÖRNEK VERİ : ../../kitapsitesi.yetsisyazilim.com/upload/temp/file-name.jpg
		## KOPARILDIKTAN SONRAKİ VERi : upload/temp/file-name.jpg
		if($index==""){
			if ($resimtemizle==1) {//Resimler dosya yolundan silinir
				if (isset($_SESSION[$sessionadi])) {
					$say=count($_SESSION[$sessionadi]);
					for ($j=0; $j < $say ; $j++) { 
					  $kopar=explode(".yetsisyazilim.com/",$_SESSION[$sessionadi][$j]);
					  if(file_exists("../".$kopar[1])){
						  unlink("../".$kopar[1]);
					  }
					}
				}
			}
			$birdencokmu=explode(",",$sessionadi);
			for ($i=0; $i < count($birdencokmu); $i++) { 
			//unset($_SESSION[$birdencokmu[$i]]);
			}
		}
		else{ ## TEK BOYUTLU DİZİ İÇİN CALIŞIYOR :: 
			if ($resimtemizle==1) {//Resimler dosya yolundan silinir
				if (isset($_SESSION[$sessionadi][$index])) {
					$say=count($_SESSION[$sessionadi]);
					for ($j=0; $j < $say ; $j++) { 
					  $kopar=explode("yetsisyazilim.com/",$_SESSION[$sessionadi][$index]);
					  if(file_exists("../".$kopar[1])){
						  unlink("../".$kopar[1]);
					  }
					}
				}
			}
			$birdencokmu=explode(",",$sessionadi);
			for ($i=0; $i < count($birdencokmu); $i++) { 
			 unset($_SESSION[$birdencokmu[$i]]);
			}
		}
  		
  		
	}
  	public function kurgetir(){
			## TC MERKEZ BANKASI GÜNLÜK KURLARI DOLAR,EURO VE STRELİN OLARAK DİZİ ŞEKLİNDE RETURN EDER
  		$xml = simplexml_load_file("https://www.tcmb.gov.tr/kurlar/today.xml");
  		$xml = json_encode($xml);
  		$xml=json_decode($xml,true);
  		$kurlar=array();
  		foreach ($xml as $key => $value) {
  			if (isset($value[0])) {
  				$dolaralis=$value[0]['ForexBuying'];
  				$dolarsatis=$value[0]['ForexSelling'];
  				$kurlar['usdalis']=$dolaralis;
  				$kurlar['usdsatis']=$dolarsatis;
  			}
  			if (isset($value[3])) {
  				$euroalis=$value[3]['ForexBuying'];
  				$eurosatis=$value[3]['ForexSelling'];
  				$kurlar['euroalis']=$euroalis;
  				$kurlar['eurosatis']=$eurosatis;
  			}
  			if (isset($value[4])) {
  				$sterlinalis=$value[4]['ForexBuying'];
  				$sterlinsatis=$value[4]['ForexSelling'];
  				$kurlar['sterlinalis']=$sterlinalis;
  				$kurlar['sterlinsatis']=$sterlinsatis;
  			}
  		}
  		return json_encode($kurlar);
  	}

  	public function replaceSpace($metin){
			## GÖNDERİLEN STRİNGTEKİ BOŞLUKLARI TEMİZLER
  		$metin = trim($metin);
  		$eski = array(" ");
  		$yeni = array("");
  		$metin = str_replace($eski, $yeni, $metin);
  		return $metin;
  	}
	
	  public function domainayikla($gelen){ ## GELEN DOMAİNİ HTTPS:// WWW HTTP:// olmadan döndürür sadece etki alanını. com'da olmamak üzere

		$say=strlen($gelen);
		$www=substr($gelen,0,3);
		$http=substr($gelen,0,7);
		$https=substr($gelen,0,8);
		if ($https=="https://") {
			if(strstr($gelen, "www")) { 
				$simpledomain=substr($gelen,12,$say);
			}
			else{
				$simpledomain=substr($gelen,8,$say);
			}	
		}
		else if ($http=="http://") {
		if(strstr($gelen, "www")) { 
			$simpledomain=substr($gelen,12,$say);
		}
		else{
			$simpledomain=substr($gelen,7,$say);
		}	
		}
			else if($www=="www"){
			$simpledomain=substr($gelen,4,$say);
		}	
			else{
			$simpledomain=$gelen;
		}
		$simpledomainsay=strlen($simpledomain);
		$simpledomain=substr($simpledomain,0,$simpledomainsay-4);
		return $simpledomain;

	}


  ## SAYFA ADINA GÖRE PERMİSSİON CODE TESPİTİ YAPAN FONKSİYON ##
public function permissionCodeDetermination($page){
	switch ($page) {
		case 'kullanicilar.php':
			return "AGX475";
			break;
		case 'blog-categories.php':
			return "BLG0005";
			break;
		case 'blog-tags.php':
			return "BLG0001";
			break;
		case 'roles.php':
			return "RVZ0001";
			break;	
		case 'bloglar.php':
			return "TBG0001";
			break;
		case 'delegated-user.php':
			return "RVZ0001";
			break;
		case 'delegated-user.php':
			return "RVZ0001";
			break;
	    case 'kullanici-islem.php':
			return "AGX475";
			break;
		case 'blog-add.php':
			return "TBG0003";
			break;
		case 'design-page.php':
			return "PGDS91596";
			break;
		case 'menu-yonetimi.php':
			return "MGR145284";
			break;
		case 'menu-duzenle.php':
			return "MGR145285";
			break;
		default:
			die("izin fonksiyonunu kontrol edin ve bu sayfa için gerekli izni verin");
			break;
	}
}
  ## SAYFA ADINA GÖRE PERMİSSİON CODE TESPİTİ YAPAN FONKSİYON ##
  ## TEKİL YETKİ KONTROLÜ YAPAN FONKSİYON ##
  public function permissionControlSingle($dbclass,$type,$data){
	  ## TYPE: page GELİR İSE SAYFADAN KONTROL code GELİRSE DİREK PERMİSSİON CODE KONTROL
	  if ($type=="page") {
		$permissionCode=$this->permissionCodeDetermination($data);
	  }
	  else if($type=="code"){
		$permissionCode=$data;
	  }
	  else{
		  return false;
	  }
	  if (isset($_SESSION['permissionUser'])) {
		 if (isset($_SESSION['permissionUser'][$permissionCode])) {
			if (isset($_SESSION['permissionUser'][$permissionCode][1])) {
				if ($_SESSION['permissionUser'][$permissionCode][1]=="Enabled") {
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		 }
		 else{
			return false;
		 }
	  }
	  else{
		  return false;
	  }

  }
  ## TEKİL YETKİ KONTROLÜ YAPAN FONKSİYON ##
  ## YETKİLERİ KONTROL EDİP SESSİONA ATAYAN FONKSİYON ##
 
  ## GİRİŞ YAPILAN LİSANSIN SAHİP OLDUĞU MODÜLLER KONTROL EDİLİYOR ##
  
  ## GİRİŞ YAPILAN LİSANSIN SAHİP OLDUĞU MODÜLLER KONTROL EDİLİYOR ##

  ## YETKİLERİ KONTROL EDİP SESSİONA ATAYAN FONKSİYON ##
  
  ## DİNAMİK FORM VE MODAL OLUŞTURAN FONKSİYON ##
  public function veriduzenlemodali($dbclass,$tabloadi,$alanlar,$postlink,$whereupdatefield,$modaltitle,$valueid,$gelentip,$datatablesid){
	## GELEN TİP: UPDATE VEYA ADD UPDATE İSE VERİ GÜNCELLEYECEK ŞEKİLDE ADD İSE VERİ EKLENECEK ŞEKİLDE MODALI RETURN EDİYORUZ..
	## TABLOADI: users
	## ALANLAR: array(userName,"input","text","required","col-6","Label","Lütfen kullanıcı adınızı giriniz","digits");
	## POST LİNK : operation/operations
	## WHEREUPDATEFİELD : İD
	## MODAL TİTLE: ÜRÜN DÜZENLENİYOR
	## VALUEİD : DÜZENLENEN ROW İDSİ

	## İNPUT OLUŞTURAN FONKSYİON ##
	function inputolustur($col,$label,$name,$inputtype,$inputdegeri,$select2deger=""){
		$singlerowinput="";
		if ($inputtype!="password") {
			if ($inputtype=="text") {
				$singlerowinput='<div class="form-group '.$col.'">
								<label>'.$label.':</label>
								<input type="'.$inputtype.'" name="'.$name.'" value="'.$inputdegeri.'"  class="form-control"/>
	 	  		              </div>';
			}
			else if($inputtype=="checkbox"){
				$singlerowinput='<div class="form-group '.$col.'">
											<label>'.$label.':</label>
											<div class="checkbox-inline">
												<label class="checkbox checkbox-solid">
													<input type="checkbox" name="'.$name.'">'.$label.'
													<span></span>
												</label>
											</div>
								</div>';
			}
			else if($inputtype=="select2"){
				$singlerowinput='<div class="form-group '.$col.'">
									<label>'.$label.'</label>';
								if($inputdegeri[7]=="multiple"){//Multiple Select2
									$singlerowinput.='<select class="select2" style="width:100%;"  name="'.$name.'[]" multiple="" id="'.$inputdegeri[1].'"></select>';
								}
								else{//Single Select2
									$singlerowinput.='<select class="select2" style="width:100%;"  name="'.$name.'" id="'.$inputdegeri[1].'"></select>';
								}
								
								$singlerowinput.='<script type="text/javascript">
                                                            $(document).ready(function() {
                                                                select2search("'.$inputdegeri[0].'", "'.$inputdegeri[1].'",
                                                                    "'.$inputdegeri[2].'", "'.$inputdegeri[3].'",
																	"'.$inputdegeri[4].'", "'.$select2deger.'","'.$inputdegeri[6].'","'.$inputdegeri[8].'");
														    });
                                   				 </script>
	 	  		              </div>';
			}
			else if($inputtype=="file"){
				#SELECT2 DEĞERİ ARRAY GELİR
				$singlerowinput='<div class="form-group '.$col.'">
									<label>'.$label.'</label>
									<div class="dropzone dropzone-default dropzone-primary" id="'.$name.'">
										<div class="dropzone-msg dz-message needsclick">
											<h3 class="dropzone-msg-title">Dosyaları sürükleyip bırakın veya yüklemek için tıklayın.</h3>
											<span class="dropzone-msg-desc">Sadece '.$select2deger[4].' uzantıları kabul edilmektedir.</span>
										</div>
									</div>';
									if($inputdegeri!=""){
										$singlerowinput.='<div class="col-12 p-3">
										<label>Yüklü Resim</label><br>
										<img style="width:200px;height:150px;" src="https://'.$_SERVER['HTTP_HOST']."/".$inputdegeri.'">
										</div>';
									}
									$singlerowinput.='<script>$(document).ready(function(){
										dropZone("'.$name.'","'.$select2deger[0].'","'.$select2deger[1].'","'.$select2deger[2].'","'.$select2deger[3].'","'.$select2deger[4].'");
									});</script>
								 </div>';
								
			}
			else if($inputtype=="radio"){
				$singlerowinput='<div class="form-group '.$col.'">
									<label class="radio" > 
									<input type="radio	" name="'.$name.'"/> '.$label.'
									<span></span>
									</label>
	 	  		              </div>';
			}
			
		}
		else{ ## ŞİFRE ALANI "" İÇERDİĞİ İÇİN FARKLI İŞLENİYOR
			$singlerowinput="<div class='form-group ".$col."'>
								<label>".$label.":</label>
								<input type=".$inputtype." name=".$name." value=''  class='form-control'/>
	 	  		              </div>";
		}
		return $singlerowinput;
	}
	## İNPUT OLUŞTURAN FONKSYİON ##
	## CHECKBOX OLUŞTURAN FONKSİYON ##
	## CHECKBOX OLUŞTURAN FONKSİYON ##
	$totalinputs='<div class="row">';
	$dogrulamascriptinputname="";
	$dogrulamascriptmessages="";
	$dogrulamatipleri="";
	$extraparametrs="";
	$dogrulamascripts=array();
	$databasefield=array();
	$inputs=array();
	$inputtypes=array();
	$inputreqired=array();
	$inputcol=array();
	$inputlabel=array();
	$inputerrormessage=array();
	$inputvalidaterules=array();
	$inputvalidateextraparameters=array();
	$databasefieldsorgu="";
	$otherInputs="";
	$ikilitablotespiti=0;
	foreach ($alanlar as $key => $value) {
		if($value[0]==$tabloadi){ ## BİRİNCİL TABLO İÇİN YAPILAN İŞLEMLER
			$ikilitablotespiti++;
			$databasefieldsorgu.=$value[1].",";
			array_push($databasefield,$value[1]);
			array_push($inputs,$value[2]);
			array_push($inputtypes,$value[3]);
			array_push($inputreqired,$value[4]);
			array_push($inputcol,$value[5]);
			array_push($inputlabel,$value[6]);
			array_push($inputerrormessage,$value[7]);
			array_push($inputvalidaterules,$value[8]);
			array_push($inputvalidateextraparameters,$value[9]);
		}
		else{ ## FORM İÇERİSİNDE FARKLI TABLODAN İŞLENEN VERİLER
			
			if($ikilitablotespiti==0){
				$databasefieldsorgu.=$value[1].",";
			}
			if($value[2]=="input"){
				
						/*  [0] => blogCategoryPictures
				[1] => imageFile
				[2] => input
				[3] => file
				[4] => required
				[5] => col-6
				[6] => Kategori Resim
				[7] => Lütfen kategori resimi seçiniz
				[8] => text
				[9] => */
				if($value[3]=="file"){ ## DROPZONE
					if ($gelentip=="update") {
						$resimYolu="";
						if($value[0]=="blogCategoryPictures"){
							$imageDetected=$dbclass->cek("ASSOC","blogCategoryPictures","imageFile","where categoryId=?",array($_POST['datachangeclass']));
							if($imageDetected){
								$resimYolu=$imageDetected['imageFile'];
							}
						}
						$otherInputs.=inputolustur($value[5],$value[6],$value[1],$value[3],$resimYolu,$value[10]);
					}
					else{
						$otherInputs.=inputolustur($value[5],$value[6],$value[1],$value[3],"",$value[10]);
					}
				}
				else{
					if ($gelentip=="update") {
						$otherInputs.=inputolustur($value[5],$value[6],$value[1],$value[3],"");
					}
					else{
						$otherInputs.=inputolustur($value[5],$value[6],$value[1],$value[3],"");
					}
				}
				
			}
			
		}
			
	}
	$databasefieldsorgu=$dbclass->ifadekes($databasefieldsorgu,1);
	if ($gelentip=="update") {
		$vericek=$dbclass->cek("ASSOC",$tabloadi,$databasefieldsorgu,'where '.$whereupdatefield.'=?',array($valueid));
	}
	if(isset($databasefield)){
		foreach ($databasefield as $keys => $values) {
			if($inputs[$keys]=="input"){
				if ($gelentip=="update") {
					$totalinputs.=inputolustur($inputcol[$keys],$inputlabel[$keys],$values,$inputtypes[$keys],$vericek[$values]);
				}
				else{
					$totalinputs.=inputolustur($inputcol[$keys],$inputlabel[$keys],$values,$inputtypes[$keys],"");
				}
			}
			else if($inputs[$keys]=="select2"){
				if ($gelentip=="update") {
					$seciliSelect2Degeri="";
					if(isset($inputtypes[$keys][8])){ // SELECT 2 İÇİN VARSAYILAN BİR OPTİON GELİYOR İSE
						$seciliSelect2Degeri="0";
					}
					if(isset($vericek[$values])){
						if($vericek[$values]!=0){
							$seciliSelect2Degeri=$vericek[$values];
						}
					}
					
					$totalinputs.=inputolustur($inputcol[$keys],$inputlabel[$keys],$values,$inputs[$keys],$inputtypes[$keys],$seciliSelect2Degeri);
				}
				else{
					$totalinputs.=inputolustur($inputcol[$keys],$inputlabel[$keys],$values,$inputs[$keys],$inputtypes[$keys]);
				}
			}
			if ($inputreqired[$keys]=="required") {
				array_push($dogrulamascripts,array($values,$inputerrormessage[$keys],$inputvalidaterules[$keys],$inputvalidateextraparameters[$keys]));
			}
		}
	}
	
	
	## HANGİ TABLO GÜNCELLENİYOR SESSİONDA TABLO TUTULUYOR ## :: BURADA OLUŞTURULAN SESSİON OLUŞTURULAN DİNAMİK FORMUN POST EDİLDİĞİNDE KULLANILACAK ALANLARINI HAFIZADA TUTAR VE GELEN POST DEĞERLERİNİ AYRICA GÖNDERMEMİZ GEREKMEZ....
	$_SESSION['updatedynamic']=array();
	array_push($_SESSION["updatedynamic"],array($tabloadi,$databasefieldsorgu,$whereupdatefield,$valueid,$gelentip));	
	## HANGİ TABLO GÜNCELLENİYOR SESSİONDA TABLO TUTULUYOR ##

	## DOGRULAMA SCRİPT OLUŞTURULUYOR ##
	$dogrulanacakinputsayisi=0;
	foreach ($dogrulamascripts as $keyx => $valuex) {
		$dogrulamascriptinputname.='"'.$valuex[0].'"'.",";
		$dogrulamascriptmessages.='"'.$valuex[1].'"'.",";
		$dogrulamatipleri.='"'.$valuex[2].'"'.",";
		$extraparametrs.='"'.$valuex[3].'"'.",";
		$dogrulanacakinputsayisi++;
	}
	$dogrulamascriptinputname=$dbclass->ifadekes($dogrulamascriptinputname,1);
	$dogrulamascriptmessages=$dbclass->ifadekes($dogrulamascriptmessages,1);
	$extraparametrs=$dbclass->ifadekes($extraparametrs,1);

	## DOGRULAMA SCRİPT OLUŞTURULUYOR ##
	
	$totalinputs.='</div>';
	$totalinputs.=$otherInputs;
	$modal='
	<!--begin::Values Change Modal-->
	<div class="modal fade" id="datachangemodal" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
		aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">'.$modaltitle.'</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
			
				<form method="POST" id="veriduzenleform">
					<div data-scroll="true" data-height="500">
						'.$totalinputs.'
					
						<div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light-primary font-weight-bold"
								data-dismiss="modal">Kapat</button>
							<button type="submit" name="dynamicform" class="btn btn-primary font-weight-bold">Kaydet</button>
						</div>
					</div>
				</form>
				<div id="sonuc"></div>
				<div id="validation"></div>
				<script type="text/javascript">
				validationk("veriduzenleform",'.$dogrulanacakinputsayisi.',['.$dogrulamascriptinputname.'],['.$dogrulamascriptmessages.'],['.$dogrulamascriptmessages.'],"validation",['.$dogrulamatipleri.'],['.$dogrulamatipleri.'],['.$extraparametrs.'],"'.$postlink.'","sonuc","'.$datatablesid.'","'.$datatablesid. '")
				</script>
				</div>
			</div>
		</div>
	</div>
	<!--end::Values Change Modal-->';
	return $modal;

	
  }
## DİNAMİK FORM VE MODAL OLUŞTURAN FONKSİYON ##
  
public function replacetwotag($string,$start,$end,$new){//İKİ TAG ARASI DEĞİŞTİRİR - $DEĞİŞECEK HTMl- TAG BASLA-TAG SON - YENİ VERi
		$bas=strpos($string,$start);
		$son=strpos($string,$end);
		$endsay=strlen($end);
		$toplamsay=strlen($string);
		$kesa=substr($string,0,$bas);
		$kesb=substr($string,$son+$endsay,$toplamsay);
		$birlestir=$kesa;
		$birlestir.=$new;
		$birlestir.=$kesb;
		return $birlestir;
}
//$dene=$dbclass->dosyaisle("js/deneme.js","asdasdasdsad","//beginselect2","//endselect2");
## MENÜLERİN SEÇİLİ GELMESİNİ SAĞLAYAN FONKSYİON ##
public function activeMenu($sayfa){
	$homeactive="";
	$hometabactive="tab-pane p-5 p-lg-0 justify-content-between";
	$settingsactive="";
	$settingstabactive="tab-pane p-5 p-lg-0 justify-content-between";
	$blogactive="";
	$blogtabactive="tab-pane p-5 p-lg-0 justify-content-between";
	$usersbuttonactive=""; // KULLANICI VE YETKİLENDİRME BUTONU SEÇİLİ GELİYOR
	$rolesPermissionButtonActive="";//ROLLER VE İZİNLER BUTONU SEÇİLİ GELİYOR
	$blogCategoryButtonActive="";
	$blogTagsButtonActive="";
	$blogsButtonActive="";
	$delegatedButtonActive="";
	$designActive="";
	$designTabActive="tab-pane p-5 p-lg-0 justify-content-between";
	$designButtonActive="";
	$menuButtonActive="";
	if($sayfa=="index.php"){
		$homeactive="active";
		$hometabactive="tab-pane p-5 p-lg-0 justify-content-between active";
	}
	else if($sayfa=="kullanicilar.php" || $sayfa=="kullanici-islem.php"){
		$settingsactive="active"; // GÖZÜKÜYOR..
		$usersbuttonactive="active";
		$settingstabactive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
	}
	else if($sayfa=="blog-tags.php"){
   		$blogTagsButtonActive="active";
		$blogactive="active";
		$blogtabactive="tab-pane p-5 p-lg-0 justify-content-between active";
	}
	else if($sayfa=="roles.php"){
		$settingsactive="active"; // GÖZÜKÜYOR..
		$settingstabactive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
		$rolesPermissionButtonActive="active";
	}
	else if($sayfa=="blog-categories.php"){
		$blogCategoryButtonActive="active";
		$blogactive="active";
		$blogtabactive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
	}
	else if($sayfa=="bloglar.php" || $sayfa=="blog-add.php"){
		$blogsButtonActive="active";
		$blogactive="active";
		$blogtabactive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
	}
	else if($sayfa=="delegated-user.php"){
		$settingsactive="active"; // GÖZÜKÜYOR..
		$settingstabactive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
		$delegatedButtonActive="active";
	}
	else if($sayfa=="design-page.php"){
		$designActive="active"; // GÖZÜKÜYOR..
		$designTabActive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
		$designButtonActive="active";
	}
	else if($sayfa=="menu-yonetimi.php" || $sayfa=="menu-duzenle.php"){
		$designActive="active"; // GÖZÜKÜYOR..
		$designTabActive="tab-pane p-5 p-lg-0 justify-content-between active"; // GÖZÜKÜYOR
		$menuButtonActive="active";
	}
	return array($homeactive,$hometabactive,$settingsactive,$settingstabactive,$blogactive,$blogtabactive,$usersbuttonactive,$rolesPermissionButtonActive,$blogCategoryButtonActive,$blogTagsButtonActive,
	$blogsButtonActive,$delegatedButtonActive,$designActive,$designTabActive,$designButtonActive,$menuButtonActive);
 }
## MENÜLERİN SEÇİLİ GELMESİNİ SAĞLAYAN FONKSYİON ##
## SAYFALARIN BAŞLIK,BREADCRUMB VE AÇIKLAMASINI GETİREN FONKSYİON ##
public function getPageDetail($sayfa){
		$title="";
		$breadcrumb='';
		$datatabletitle="";
		$datatabletitlesub="";
		$pageComments="";
	if($sayfa=="kullanicilar.php"){
		$title="Tüm Kullanıcılar";
		$breadcrumb='<li class="breadcrumb-item"><a href="anasayfa" class="text-muted">Anasayfa</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="tum-kullanicilar" class="text-muted">Kullanıcı İşlemleri</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="tum-kullanicilar" class="text-muted">Tüm Kullanıcılar</a></li>';
		$datatabletitle="Tüm Kullanıcılar Listeleniyor";
		$datatabletitlesub="Kullanıcılarla ilgili işlemleri bu alanda gerçekleştirebilirsiniz";
		$pageComments="Kullanıcı oluşturma, kullanıcılara yetki tanımlama ve düzenleme işlemlerini bu sayfadan gerçekleştirebilirsiniz";
	}
	else if($sayfa=="kullanici-islem.php"){
		$title="Kullanıcı Rol Ve Yetkilendirme İşlemleri";
		$breadcrumb='<li class="breadcrumb-item"><a href="anasayfa" class="text-muted">Anasayfa</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="tum-kullanicilar" class="text-muted">Kullanıcı İşlemleri</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="tum-kullanicilar" class="text-muted">Tüm Kullanıcılar</a></li>';
		$datatabletitle="Tüm Kullanıcılar Listeleniyor";
		$datatabletitlesub="Kullanıcılarla ilgili işlemleri bu alanda gerçekleştirebilirsiniz";
		$pageComments="Kullanıcı oluşturma, kullanıcılara yetki tanımlama ve düzenleme işlemlerini bu sayfadan gerçekleştirebilirsiniz";
	}
	else if($sayfa=="roles.php"){
		$title="Rol Yönetimi";
		$breadcrumb='<li class="breadcrumb-item"><a href="anasayfa" class="text-muted">Anasayfa</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="roller-izinler" class="text-muted">Roller ve İzinler</a></li>';
		$datatabletitle="Tüm Roller Listeleniyor";
		$datatabletitlesub="Roller üzerine atanmış izinleri bu alanda yönetebilirsiniz";
		$pageComments='Roller üzerine atanmış izinleri bu alanda yönetebilirsiniz';
	}
	else if($sayfa=="blog-tags.php"){
		$title="Blog Etiketleri";
		$breadcrumb='<li class="breadcrumb-item"><a href="anasayfa" class="text-muted">Anasayfa</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="blog-etiketleri" class="text-muted">Blog Etiketleri</a></li>';
		$datatabletitle="Tüm Blog Etiketleri Listeleniyor";
		$datatabletitlesub="Blog etiketlerini bu alanda yönetebilirsiniz";
		$pageComments='Blog etiketlerini bu alanda yönetebilirsiniz';
	}
	else if($sayfa=="delegated-user.php"){
		$title="Yetki Devri";
		$breadcrumb='<li class="breadcrumb-item"><a href="anasayfa" class="text-muted">Anasayfa</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="yetki-devri" class="text-muted">Yetki Devri</a></li>';
		$datatabletitle="Devredilmiş Yetkiler Listeleniyor";
		$datatabletitlesub="Blog etiketlerini bu alanda yönetebilirsiniz";
		$pageComments='Blog etiketlerini bu alanda yönetebilirsiniz';
	}
	else if($sayfa=="blog-add.php"){
		$title="Blog Yazısı Ekle";
		$breadcrumb='<li class="breadcrumb-item"><a href="blogs" class="text-muted">Blog</a></li>';
		$breadcrumb.='<li class="breadcrumb-item"><a href="blog-ekle" class="text-muted">Blog Yazısı Ekle</a></li>';
		$datatabletitle="Devredilmiş Yetkiler Listeleniyor";
		$datatabletitlesub="Yeni Blog Yazısı eklemek için bu alanı kullanabilirsiniz.";
		$pageComments='Yeni Blog Yazısı eklemek için bu alanı kullanabilirsiniz.';
	}
	else{
		$title="Sayfa Başlığı İlgili Fonksyiondan ayarlanmalıdır.";
		$breadcrumb='<li class="breadcrumb-item"><a href="blogs" class="text-muted">breadcrumb ayarlanmalıdır</a></li>';
		$datatabletitle="Datatable başlığı ayarlanmalıdır";
		$datatabletitlesub="Datatable alt başlık ayarlanmalıdır";
		$pageComments='Sayfa detaylı açıklaması yapılmalıdır.';
	}
	return array($title,$breadcrumb,$datatabletitle,$datatabletitlesub,$pageComments);
}
## SAYFALARIN BAŞLIK,BREADCRUMB VE AÇIKLAMASINI GETİREN FONKSYİON ##

## BU FONKSYİON SİTENİN SESSİONDAKİ MEVCUT DİLİNE GÖRE SABİT METİNLERİNİ RETURN EDER ##

































}//class db sonu
?>