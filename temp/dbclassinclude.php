<?php 

  include('admin/dbclass/dbclassinclude.php'); 
  session_start();
  
  if(!isset($_SESSION['langChange'])){
    $_SESSION['lang']=array();
    $_SESSION['lang']['langCode']="TR";
  } 
  
  $langDetails=$dbclass->cek("ASSOC","languages","*","WHERE langShortCode=?",array($_SESSION['lang']['langCode']));
  $categoryMainSlug=$_SESSION['lang']['categorySlug']=$langDetails['categorySlug'];
  $tagMainSlug=$_SESSION['lang']['tagSlug']=$langDetails['tagSlug'];
  $pageMainSlug=$_SESSION['lang']['pageSlug']=$langDetails['pageSlug'];
  $blogMainSlug=$_SESSION['lang']['blogSlug']=$langDetails['blogSlug'];
  $productMainSlug=$_SESSION['lang']['productSlug']=$langDetails['productSlug'];
  if (isset($_SESSION['userDetails'])) {
    $userDetail=$dbclass->cek("ASSOC","users","*","WHERE id=?",array($_SESSION['userDetails']['userid']));
  }
  $companyInfo=$dbclass->cek("ASSOC","companyInfo","*","WHERE id=?",array(1));
?>
