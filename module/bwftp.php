<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
function regftpuser($username,$pass,$type) {
$authpath=getthesettings("authpath");
$passmd5=md5($pass);
$authcode=md5($username.$passmd5.$type);
$authpath=$authpath."/reg?username=$username&pass=$passmd5&type=$type&authcode=$authcode";
//echo $authpath;
$r=curl_file_get_contents($authpath);

return $r;
}
function getftpinfo($username,$type) {
$authpath=getthesettings("authpath");
$authcode=md5($username.$type."aaa");
$authpath=$authpath."/read?username=$username&value=$type&type=aaa&authcode=$authcode";
//echo $authpath;
$r=curl_file_get_contents($authpath);
return $r;
}
function setftplimit($username,$value) {
$authpath=getthesettings("authpath");
$authcode=md5($username.$value."pass");
$authpath=$authpath."/do?username=$username&value=$value&type=limit&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}
function setftpuserpass($username,$pass) {
$authpath=getthesettings("authpath");
$passmd5=md5($pass);
$authcode=md5($username.$passmd5."limit");
$authpath=$authpath."/do?username=$username&value=$passmd5&type=pass&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}
function delftpuser($username) {
$authpath=getthesettings("authpath");
$authcode=md5($username."abc"."abc");
$authpath=$authpath."/reset?username=$username&value=abc&type=abc&authcode=$authcode";
$r=curl_file_get_contents($authpath);
return $r;
}
function resetftp() {

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
?>