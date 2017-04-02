<?php
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include $_SERVER['DOCUMENT_ROOT'].'/settings/ver.php';
empty($_GET['key'])&& $_GET['key']="";
if (getthesettings("serverkey")==$_GET['key']) {
    $t=time();
   savethesettings("servertime",$t);
   echo "ok";
}else{
     echo "key invild";
}
?>