<?php
  include('temp/dbclassinclude.php'); 
  ## SİTENİN DİLİ DEĞİŞTİRİLİYOR ##
if(isset($_POST['siteLangChange'])){
  $gelen=$_POST['langCode'];
  $_SESSION['langChange']=1;
  $_SESSION['lang']['langCode']=$gelen;
  echo json_encode(array("success"));
  // if($changeLang) echo json_encode(array($_SESSION['lang']['langCode']));
  // else echo json_encode(array("no"));
}
## SİTENİN DİLİ DEĞİŞTİRİLİYOR ##
?>