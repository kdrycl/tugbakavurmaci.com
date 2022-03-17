<?php
## SİTENİN DİLİ DEĞİŞTİRİLİYOR ##
if(isset($_POST['siteLangChange'])){
  echo $_SESSION['lang']['langCode'];
  $changeLang=$_SESSION['lang']['langCode']=$_POST['langCode'];
  if($changeLang) echo json_encode(array($_SESSION['lang']['langCode']));
  else echo json_encode(array("no"));
}
## SİTENİN DİLİ DEĞİŞTİRİLİYOR ##
?>