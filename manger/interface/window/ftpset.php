<?php
include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
if(getthesettings("ftpmode")==1){
include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/manger/interface/window/ftpsetgene.php';
}else{
include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/manger/interface/window/ftpsetbw.php';
}
?>