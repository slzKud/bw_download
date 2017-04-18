<?php
include_once dirname(__FILE__).'/module/mysqlaction.php';
include_once dirname(__FILE__).'/module/cookiesmaker.php';
empty($_GET['code'])&& $_GET['code']="";
if($_GET['code']!=""){
 $base=base64_decode($_GET['code']);
    if(veifycookies($base)!="incorrect！"){
    $username=veifycookies($base);
    setcookie("bwcard", $base, time()+(60*60*24*0.5),"/");
    echo "<meta http-equiv='refresh' content='1;url=pay.php'> ";
//echo "<script>alert('欢迎 $username ！')</script> ";
}
}

?>