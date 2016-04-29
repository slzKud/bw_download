<?php
	include  '/aes.class.php';
function makecookies($username,$passmd5,$day) {
 //cookies要求
 //内容：user=$username;bwcode=*******(bwcode由用户名 密码md5和BWDOWNLOAD!!!合在一起后AES加密)
 setcookie("bwuser", "username=".$username.";bwcode=".makebwcode($username,$passmd5).";end", time()+(60*60*24*$day),"/");
}
function makebwcode($username,$passmd5) {
	$string=md5($username.'#'. strtolower($passmd5)."#BWDOWNLOAD!!!");
	return base64_encode("BW!".$string."BW!");
 //bwcode由用户名 密码md5和BWDOWNLOAD!!!合在一起后AES加密)
}
function veifybwcode($username,$bwcode) {
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
	$rs=loaddb("SELECT username,passmd5 FROM bw_usertable where username='".$username."'");
	$row = mysqli_fetch_array($rs);
	$comp=makebwcode($row['username'],$row['passmd5']);
	//echo "bw ".$comp." <br>new ".$bwcode."<br>";
	if($comp==$bwcode){
		return true;
	}else{
		return false;
	}
}
function veifycookies($cookies) {
	$username=getSubstr($cookies,"username=",";bwcode=");
	$bwcode=getSubstr($cookies,"bwcode=",";end");
	if(veifybwcode($username,$bwcode)){
		return $username;
	}else{
		return "incorrect！";
	}
}
function getSubstr($str, $leftStr, $rightStr)
{
 $left = strpos($str, $leftStr);
 //echo '左边:'.$left;
 $right = strpos($str, $rightStr,$left);
 //echo '<br>右边:'.$right;
 if($left < 0 or $right < $left) return '';
 return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
?>
