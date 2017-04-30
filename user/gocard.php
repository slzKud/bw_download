<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
empty($_GET['type'])&&$_GET['type']="pay";
if(getthesettings("gocard")!=""){
if (isset($_COOKIE["bwuser"])){
  if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
    $base=urlencode(base64_encode($_COOKIE["bwuser"]));
    $url=getthesettings("gocard");

    $type=$_GET['type'];
    //?code=%code%&type=history
    $url=$url."/go.php?type=$type&code=$base";
    //$url=str_replace("%code%",$base,$url);
    echo "<h1>Making....</h1><meta http-equiv='refresh' content='1;url=$url'> ";
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