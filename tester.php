<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/bwftp.php';
$r=getftpinfo("kud","StatsDownloaded");
$r1=getftpinfo("kud","DefaultLimit");
if($r<(1024*1024*1024)){
$r2= round($r/(1024*1024),2);
$r3= round($r1/(1024*1024*1024),2);
echo $r2."MB/".$r3."GB";
exit;
}
if($r<(1024*1024)){
 $r2= round($r/(1024),2);
$r3= round($r1/(1024*1024*1024),2);
echo $r2."KB/".$r3."GB" ;
exit;  
}
$r2= round($r/(1024*1024*1024),2);
$r3= round($r1/(1024*1024*1024),2);
echo $r2."GB/".$r3."GB";
?>