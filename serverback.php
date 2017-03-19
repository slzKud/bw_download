<?php
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include $_SERVER['DOCUMENT_ROOT'].'/settings/ver.php';
empty($_GET['key'])&& $_GET['key']="";
if (md5(BWSERVERKEY)==md5($_GET['key'])) {
    $t=time();
   savethesettings("servertime",$t);
   echo "ok";
}else{
     echo "key invild";
}
?>