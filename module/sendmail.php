<?php
	require_once "email.class.php";
	//********************邮件正文*********************************
date_default_timezone_set('prc');
	$emailstr="<html>
 <style>
	  body {
			font-family: 'Microsoft YaHei Light','Microsoft YaHei', sans-serif;
		}
	  @media(max-width:767px) { 
 #user-info {
position: absolute;
top:0px;
right: 72px;
} }
</style>
<body>
<p>你的邮箱%email%申请了%action%操作。</p>
<p>请点击以下链接完成接下来的步骤：<a href='%link%' >点击这里</a><br>提示：<b>该链接30分钟内有效。</b>
如果你未申请此次操作，请删除这封邮件。
<br>安全性提示：<b>请不要转发这封邮件给其他人，这可能会威胁到你的账户安全。</b></p>
<br>
BetaWorld资源区
<br>
%date%
</body>
</html>";
$content=str_replace("%email%",$toemail,$emailstr);
$content=str_replace("%action%",$nowaction,$content);
$content=str_replace("%link%",$tolink,$content);
$content=str_replace("%date%",date('Y-m-d H:i:s'),$content);

	//******************** 配置信息 ********************************
	$smtpserver = "smtp.126.com";//SMTP服务器
	$smtpserverport =25;//SMTP服务器端口
	$smtpusermail = "bxm56slz@126.com";//SMTP服务器的用户邮箱
	$smtpemailto = $toemail;//发送给谁
	$smtpuser = "bxm56slz";//SMTP服务器的用户帐号
	$smtppass = "Passwordslz123";//SMTP服务器的用户密码
	$mailtitle = $title;//邮件主题
	$mailcontent =$content;//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
	
?>