<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
if(getthesettings("ftpmode")==1){
include_once  $_SERVER['DOCUMENT_ROOT'].'/manger/interface/window/ftpsetgene.php';
}else{
include_once  $_SERVER['DOCUMENT_ROOT'].'/manger/interface/window/ftpsetbw.php';
}
?>