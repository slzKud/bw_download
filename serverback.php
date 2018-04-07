<?php
include dirname(__FILE__).'/module/mysqlaction.php';
include dirname(__FILE__).'/settings/ver.php';
empty($_GET['key'])&& $_GET['key']="";
if (getthesettings("serverkey")==$_GET['key']) {
    $t=time();
   savethesettings("servertime",$t);
   echo "ok";
}else{
     echo "key invild";
}
?>