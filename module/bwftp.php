<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
function regftpuser($username,$pass,$type) {
$authpath=getthesettings("authpath");
$passmd5=md5($pass);
$authcode=md5(urlencode($username).$passmd5.$type);
$authpath=$authpath."/reg?username=".urlencode($username)."&pass=$passmd5&type=$type&authcode=$authcode";
//echo $authpath;
$r=curl_file_get_contents($authpath);

return $r;
}
function regftpusernomd5($username,$pass,$type) {
$authpath=getthesettings("authpath");
$passmd5=$pass;
$authcode=md5(urlencode($username).$passmd5.$type);
$authpath=$authpath."/reg?username=".urlencode($username)."&pass=$passmd5&type=$type&authcode=$authcode";
//echo $authpath;
$r=curl_file_get_contents($authpath);

return $r;
}
function getftpinfo($username,$type) {
$authpath=getthesettings("authpath");
$authcode=md5(urlencode($username).$type."aaa");
$authpath=$authpath."/read?username=".urlencode($username)."&value=$type&type=aaa&authcode=$authcode";
//echo $authpath;
$r=curl_file_get_contents($authpath);
return $r;
}
function setftplimit($username,$value) {
$authpath=getthesettings("authpath");
$authcode=md5(urlencode($username).$value."limit");
$authpath=$authpath."/do?username=".urlencode($username)."&value=$value&type=limit&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}
function setftpuserpass($username,$pass) {
$authpath=getthesettings("authpath");
$passmd5=md5($pass);
$authcode=md5(urlencode($username).$passmd5."pass");
$authpath=$authpath."/do?username=".urlencode($username)."&value=$passmd5&type=pass&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}

function delftpuser($username) {
$authpath=getthesettings("authpath");
$authcode=md5(urlencode($username)."abc"."abc");
$authpath=$authpath."/reset?username=".urlencode($username)."&value=abc&type=abc&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}
function resetftp() {
    $sql1="select userid from bw_ftp";
	$rs1=loaddb($sql1);
    while($row1 = mysqli_fetch_array($rs1, MYSQL_ASSOC))
         {
            $r=delftpuser($row1['userid']);
            echo "Delete ".$row1['userid'].":".$r."<br>";
         }
 loaddb("delete from bw_ftp");
	$lowftp=getthesettings("lowftpper");
	$sql="select username,passmd5,permission from bw_usertable where permission >=$lowftp";
	$rs=loaddb($sql);
    $authpath=getthesettings("authpath");
	 while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
             //创建数据表
			$orgusername=$row['username'];
			 $orgpassword=$row['passmd5'];
			 $per=$row['permission'];
            $sql1="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser'.$per) ."', '".$orgusername."','".$orgpassword."')";
			loaddb($sql1);
            $authcode=md5(urlencode($orgusername).$orgpassword.getthesettings('ftpuser'.$per));
            $authpath=$authpath."/reg?username=".urlencode($orgusername)."&pass=$orgpassword&type=".getthesettings('ftpuser'.$per)."&authcode=$authcode";
            //echo $authpath;
            $r=curl_file_get_contents($authpath);
             $authpath=getthesettings("authpath");
             echo "Delete ".$orgusername.":".$r."<br>";
  }
}
//
function curl_file_get_contents($durl){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $durl);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_USERAGENT, "betaworld ftp v01");
curl_setopt($ch, CURLOPT_REFERER, $durl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$r = curl_exec($ch);
curl_close($ch);
return $r;
}
function scanserver(){
    $oldtime=getthesettings("servertime");
    $newtime=time();
    if($oldtime=="error"){
        return "服务器当前运行状态:未知";
    }
    if(($newtime-$oldtime)>(60*30)){
      return "服务器当前运行状态:<b>离线超过30分钟</b>";
    }else{
       return "服务器当前运行状态:正常运行";
    }
}
?>