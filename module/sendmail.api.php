<?php
include_once  dirname(dirname(__FILE__)).'/module/mysqlaction.php';
	require_once "email.class.php";
	date_default_timezone_set('prc');
	//echo SendMailTo("804317269@qq.com","如果你看到这封邮件，那么你的邮件配置信息是正确的。","如果你看到这封邮件，那么你的邮件配置信息是正确的。");
	function SendMailTo($to,$title,$str){
		//******************** 配置信息 ********************************
	$smtpserver = getthesettings('smtpserver');//SMTP服务器
	$smtpserverport =getthesettings('smtpport');//SMTP服务器端口
	$smtpusermail = getthesettings('emailadress');//SMTP服务器的用户邮箱
	$smtpemailto = $to;//发送给谁
	$smtpuser = getthesettings('emailuser');//SMTP服务器的用户帐号
	$smtppass = getthesettings('emailpass');//SMTP服务器的用户密码
	$mailtitle = $title;//邮件主题
	$mailcontent =$str;//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
	return $state;
	}		
	//********************邮件正文*********************************
	function SendMailToBanedUser($toemail,$username,$time){
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
<p>尊敬的%username%:</p>
<p>非常遗憾的告诉你，你已经被Betaworld管理组封禁。<br>被封禁的原因:违反社区规则<br>被封禁的时长:%time%
<br>如果你对此次封禁有异议，请反馈给管理员。</p>
<br><small>你会收到这封邮件是因为你在Betaworld资源区上注册了账户。</small>
</p>
<br>
BetaWorld资源区
<br>
%date%
</body>
</html>";
$content=str_replace("%username%",$username,$emailstr);
$content=str_replace("%time%",$time,$content);
$content=str_replace("%date%",date('Y-m-d H:i:s'),$content);
SendMailTo($toemail,"BetaWorld资源区 封禁通知",$content);
	}
	function SendMailToTellresult($toemail,$username,$result){
		if($result==1){
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
<p>尊敬的%username%:</p>
<p>恭喜你，你的用户组审批通过了。<br></p>
<br>请重新登录资源区后即可享受新的权利。（如果无法使用，请清除cookies）。</b>
<br><small>你会收到这封邮件是因为你在Betaworld资源区上注册了账户，并且提交了提升用户组申请。</small>
</p>
<br>
BetaWorld资源区
<br>
%date%
</body>
</html>";
		}else{
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
<p>尊敬的%username%:</p>
<p>很抱歉，你的用户组审批已被否决了。<br></p>
<br>这可能是因为你的用户资历不够，或者不符合社区规则。请再次申请并等待结果。</b>
<br><small>你会收到这封邮件是因为你在Betaworld资源区上注册了账户，并且提交了提升用户组申请。</small>
</p>
<br>
BetaWorld资源区
<br>
%date%
</body>
</html>";
		}
$content=str_replace("%username%",$username,$emailstr);
$content=str_replace("%date%",date('Y-m-d H:i:s'),$content);
SendMailTo($toemail,"BetaWorld资源区 用户组审批结果",$content);
	}
    function SendMailToUser($toemail,$title,$nowaction,$tolink){
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
SendMailTo($toemail,$title,$content);
	}
	function SendMailToFk($toemail,$title,$fktitle,$fktype,$fktext){
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
<p>BetaWorld 资源区 - 新反馈</p>
<p>现有一个新%type%反馈'%title%'，特将其送达,请及时处理。以下为内容：<br>
%text%
<br><small>你会收到这封邮件是因为你被设置为了反馈员。</small></p>
BetaWorld资源区
<br>
%date%
</body>
</html>";
$content=str_replace("%title%",$fktitle,$emailstr);
$content=str_replace("%type%",$fktype,$content);
$content=str_replace("%text%",$fktext,$content);
$content=str_replace("%date%",date('Y-m-d H:i:s'),$content);
SendMailTo($toemail,$title,$content);
	}
	function SendMailToConnect($to,$title,$str){
	}
?>