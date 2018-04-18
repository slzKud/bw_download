<?php 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/settings/ver.php';
echo "Preapring Update....";
echo '<br />'.str_repeat(' ', 1024*4);
if(file_exists("update.lock")){
	echo 'Install failed,please delete update.lock and again.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if (DVER!="0.63"){
    echo "ERROR:VER is not 0.63";
    echo '<br />'.str_repeat(' ', 1024*4);
    exit;
}
$sql_array=preg_split("/;[\r\n]+/", file_get_contents('./bwupdate.sql'));  
$i=0;
echo 'Updating......';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
foreach ($sql_array as $k => $v) { 
$i=$i+1; 
           loaddb($v);  
		   //echo $v;
		   echo "Running......$v";
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
		   sleep(1);
		   //echo "执行第$i 条语句中<br>";  
		   //echo file_put_contents('log.txt', mysqli_error()."\n", FILE_APPEND|LOCK_EX);
           //echo mysql_error().'<br>';  
}
   echo "OK!";
   echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
 sleep(1);
 file_put_contents("update.lock","");
 exit;
?>