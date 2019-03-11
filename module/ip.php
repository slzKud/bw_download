<?php
include_once  dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once  dirname(dirname(__FILE__)).'/module/ipip.class.php';
function getIPLoc($queryIP){ 
$sql="select loc from bw_ip where ip='$queryIP'";
$rs=loaddb($sql);
if (mysqli_num_rows($rs)>0){
      $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
      if($row['loc']!=""){
        return $row['loc'];
      }else{
        return getIPLoc_ipip($queryIP);
      }
  }else{
	  $loc=getIPLoc_ipslashapi($queryIP);
	  $sql1="INSERT INTO bw_ip (ip,loc) VALUES( '$queryIP', '$loc')";
	  loaddb($sql1);
	  return $loc;
  } 
}

function getIPLocCode($queryIP){ 
    $sql="select loc from bw_ip where ip='".$queryIP."_1'";
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)>0){
          $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
          if($row['loc']!=""){
            return $row['loc'];
          }else{
            return getIPLocCode_ipip($queryIP);
          }
      }else{
          $loc= getIPLocCode_ipslashapi($queryIP);
          $sql1="INSERT INTO bw_ip (ip,loc) VALUES( '".$queryIP."_1', '$loc')";
          loaddb($sql1);
          return $loc;
      } 
}
/*
//此程序废弃
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
*/
function getIPLoc_ipslashapi($queryIP){
    $arr=explode(".",$queryIP);
    if($arr[0]=="192" and $arr[1]="168"){
    return "The C-Type Insider";
    }elseif($arr[0]=="127"){
    return "This Computer";
    }elseif($arr[0]=="10" or $arr[0]=="172"){
    return "The A or B";
    } 
    $url = 'http://ip-api.com/json/'.$queryIP."?lang=zh-CN"; //加入中文显示
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $location = curl_exec($ch); 
    //echo($location);
    //echo 'Curl error: ' . curl_error($ch);
    $location = json_decode($location); 
    curl_close($ch); 
    $loc=$location->country.$location->regionName.$location->city;
    //echo($location->data->country_id);
    return $loc;

}
function getIPLocCode_ipslashapi($queryIP){
    $arr=explode(".",$queryIP);
    if($arr[0]=="192" and $arr[1]="168"){
        return "LOCAL";
    }elseif($arr[0]=="127"){
        return "LOCAL";
    }elseif($arr[0]=="10" or $arr[0]=="172"){
        return "LOCAL";
    } 
    $url = 'http://ip-api.com/json/'.$queryIP; 
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $location = curl_exec($ch); 
    //echo($location);
    $location = json_decode($location); 
    curl_close($ch); 
    $loc=$location->countryCode;
    //echo($location->data->country_id);
    return $loc;
}
function get_IP(){
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
    $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
    $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknown";
    return $ip;
    }
function Get_UserLang(){
    return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

function Get_Userexpect($username){
    $sql="select * from bw_ipexpect where username='".$username."'";
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)>0){return(true);}
    return(false);
}

function Set_Userexpect($username){
    //TODO
}

function Get_IPBanList($queryIP){
    $sql="select * from bw_ipblacklist where ip='".$queryIP."'";
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)>0){return(true);}
    return(false);
}

function Set_IPBanList($queryIP,$username){
    //TODO
}
?>
