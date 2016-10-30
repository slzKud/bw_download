<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
function getIPLoc($queryIP){ 
$sql="select loc from bw_ip where ip='$queryIP'";
$rs=loaddb($sql);
if (mysqli_num_rows($rs)>0){
	  $row = mysqli_fetch_array($rs, MYSQL_ASSOC);
	  return $row['loc'];
  }else{
	  $loc=getIPLoc_sina($queryIP);
	  $sql1="INSERT INTO bw_ip (ip,loc) VALUES( '$queryIP', '$loc')";
	  loaddb($sql1);
	  return $loc;
  } 
}
function getIPLoc_sina($queryIP){
    $arr=explode(".",$queryIP);
if($arr[0]=="192" and $arr[1]="168"){
return "The C-Type Insider";
}elseif($arr[0]=="127"){
return "This Computer";
}elseif($arr[0]=="10" or $arr[0]=="172"){
return "The A or B";
} 
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP; 
    $ch = curl_init($url); 
    //curl_setopt($ch,CURLOPT_ENCODING ,'utf8'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $location = curl_exec($ch); 
    $location = json_decode($location); 
    curl_close($ch); 
     
    $loc = ""; 
    if($location===FALSE) return "未知"; 
    if (empty($location->desc)) { 
        $loc = $location->province.$location->city.$location->district.$location->isp; 
    }else{ 
        $loc = $location->desc; 
    } 
    return $loc; 
} 
?>
