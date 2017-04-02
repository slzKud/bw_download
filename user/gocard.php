<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
if(getthesettings("gocard")!=""){
if (isset($_COOKIE["bwuser"])){
  if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
    $base=base64_encode($_COOKIE["bwuser"]);
    $url=getthesettings("gocard");
    $url=str_replace("%code%",$base,$url);
    echo "<meta http-equiv='refresh' content='1;url=$url'> ";
  } else{
    echo "ERROR:COOKIES ISN'T CORRECT";
  }
}else{
echo "ERROR:NO COOKIES";
}
}else{
echo "ERROR:NO TO URL";
}

?>