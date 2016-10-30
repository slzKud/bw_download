<?php
if($_SERVER['QUERY_STRING']==""){
	$url = 'https://api.hitokoto.us:214/rand'; 
}else{
	$url = 'https://api.hitokoto.us:214/rand?'.$_SERVER['QUERY_STRING']; 
}
  
    $ch = curl_init($url); 
    //curl_setopt($ch,CURLOPT_ENCODING ,'utf8'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0) ;
    $output = curl_exec($ch); 
    //$location = json_decode($location); 
    curl_close($ch); 
	echo $output;
?>