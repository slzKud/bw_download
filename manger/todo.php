<?php
//how?
 date_default_timezone_set("PRC");
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once dirname(dirname(__FILE__)).'/module/sendmail.api.php';
include_once dirname(dirname(__FILE__)).'/module/cookiesmaker.php'; 
include_once  dirname(dirname(__FILE__)).'/module/bwftp.php';
session_start();
empty($_SESSION['permission'])&&$_SESSION['permission']=0;
empty($_SESSION['transfer'])&&$_SESSION['transfer']=0;
$_SESSION['transfer']="";
//自动判断cookie
	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if ($_SESSION['permission']==0){
	  $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
	  $row=mysqli_fetch_array($con);
     $_SESSION['permission']=$row['permission'];
	 }
	  if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
	       echo "dont";
		   exit;
	   }
		   	 if($_SESSION['permission']<4){
		    echo "dont";
			exit;
			 }
	  }else{
		  echo "dont";
			exit; 
	  }
empty($_POST['type']) && $_POST['type']="other";
try {  
switch ($_POST['type'])
{
case "transfer":
            $p=$_POST['p'];
            $_SESSION['transfer']=$p;
            echo "ok";
            break;
case "delfiles":
empty($_POST['filelist']) && $_POST['filelist']="";
if ($_POST['filelist'] != ""){
	 $dellist=test_input($_POST['filelist']);
  $sql="delete from bw_downtable where id in (".$dellist.")";
  //echo $sql;
  loaddb($sql);
  echo "ok";
}else{
	  echo "no filelist";
	  exit;
}
  //删除
  break;  
  case "deluser":
empty($_POST['userlist']) && $_POST['userlist']="";
if ($_POST['userlist'] != ""){
	 $dellist=test_input($_POST['userlist']);
  $sql="delete from bw_usertable where id in (".$dellist.")";
  //echo $sql;
  loaddb($sql);
  echo "ok";
}else{
	  echo "no userlist";
	  exit;
}
  //删除
  break;  
  case "banuser":
empty($_POST['username']) && $_POST['username']="";
empty($_POST['timeplus']) && $_POST['timeplus']="";
empty($timet) && $timet=0;
if ($_POST['username'] != ""){
$username=test_input($_POST['username']);
$timet=test_input($_POST['timeplus']);
if($timet==-1){
	$tiemb=-1;
}else{
	$tiemb=time()+$timet;
}
$nowdate=date("Y-m-d h:i:s");
$rsuser=loaddb("SELECT * FROM bw_usertable where username='".$username."'");
	if(mysqli_num_rows($rsuser) >0){
		 //更改用户权限
		 $sql="update bw_usertable SET permission=-1 where username='$username'";
		 loaddb($sql);
		 //查找封禁记录
		 $rschk=loaddb("SELECT * FROM bw_baneduser where username='".$username."' and ifclose=1");
		 if(mysqli_num_rows($rschk) >0){
			 echo  "user baned"; 
         exit;
		 }else{
	     //添加封禁记录
			 $sql="INSERT INTO bw_baneduser(username,btime,ifclose,nowdate)  VALUES ('$username',$tiemb,1,'$nowdate')";
			 loaddb($sql);
			 $rsapply=loaddb("SELECT email FROM bw_usertable where username='$username'");
            while($row = mysqli_fetch_array($rsapply, MYSQLI_ASSOC))
         {
			$email=$row['email'];
  }
  if($timet==-1){
 SendMailToBanedUser($email,$username,"永久封禁");
  }else{
 SendMailToBanedUser($email,$username,unixtime_to_date($tiemb));
  }
			
	     	 echo  "ok"; 
         exit;
		 }
	}else{
		echo  "invild user"; 
         exit;
	}
  //echo $sql;

}else{
	  echo "no userlist";
	  exit;
}
  //删除
  break; 
//解封
  case "unbanuser":
  empty($_POST['username']) && $_POST['username']="";
if ($_POST['username'] != ""){
$username=test_input($_POST['username']);
$rsuser=loaddb("SELECT * FROM bw_usertable where username='".$username."'");
	if(mysqli_num_rows($rsuser) >0){
		 //更改用户权限
		 $sql="update bw_usertable SET permission=1 where username='$username'";
		 loaddb($sql);
		 //查找封禁记录
		 $rschk=loaddb("SELECT * FROM bw_baneduser where username='".$username."' and ifclose=1");
		 if(mysqli_num_rows($rschk) >0){
			$sql="update bw_baneduser SET ifclose=0 where username='$username' and ifclose=1";
			 loaddb($sql);
	     	 echo  "ok"; 
			 exit;
		 }else{
			 echo  "user unbaned"; 
         exit;
		 }
	}else{
		echo  "invild user"; 
         exit;
	}
  //echo $sql;

}else{
	  echo "no userlist";
	  exit;
}
  //删除
  break;
case"admituser":
empty($_POST['id']) && $_POST['id']="";
//empty($_POST['username']) && $_POST['username']="";
$applyid=$_POST['id'];
if($applyid==""){
	echo "no id";
	exit;
}
$rsapply=loaddb("SELECT id,username,newper FROM bw_admituser where id=$applyid and ifs=0");
while($row = mysqli_fetch_array($rsapply, MYSQLI_ASSOC))
         {
			$username=$row['username'];
			$newper=$row['newper'];
  }
$rschk=loaddb("SELECT id FROM bw_usertable where username='$username'");
//echo "SELECT id FROM bw_usertable where username='$username'";
if(mysqli_num_rows($rschk) <0){
echo "invaild user";
	exit;
	 }
if(mysqli_num_rows($rsapply) >0){
	 
			$sql="update bw_admituser SET ifs=1 where id=$applyid and ifs=0";
			loaddb($sql);
			 $sql="update bw_usertable SET permission=$newper where username='$username'";
			loaddb($sql);
	     	
			$rsemail=loaddb("SELECT email FROM bw_usertable where username='$username'");
            while($row = mysqli_fetch_array($rsemail, MYSQLI_ASSOC))
         {
			$email=$row['email'];
  }
		   SendMailToTellresult($email,$username,1); 
		    echo  "ok"; 
			 exit;
		 }else{
			 echo  "apply is error"; 
         exit;
		 }
break;  
case"rejectuser":
empty($_POST['id']) && $_POST['id']="";
//empty($_POST['username']) && $_POST['username']="";
$applyid=$_POST['id'];
if($applyid==""){
	echo "no id";
	exit;
}
$rsapply=loaddb("SELECT id,username,newper FROM bw_admituser where id=$applyid and ifs=0");
while($row = mysqli_fetch_array($rsapply, MYSQLI_ASSOC))
         {
			$username=$row['username'];
			$newper=$row['newper'];
  }
$rschk=loaddb("SELECT id FROM bw_usertable where username='$username'");
//echo "SELECT id FROM bw_usertable where username='$username'";
if(mysqli_num_rows($rschk) <0){
echo "invaild user";
	exit;
	 }
if(mysqli_num_rows($rsapply) >0){
	 
			$sql="update bw_admituser SET ifs=-1 where id=$applyid and ifs=0";
			loaddb($sql);
	     	 
			  $rsemail=loaddb("SELECT email FROM bw_usertable where username='$username'");
            while($row = mysqli_fetch_array($rsemail, MYSQLI_ASSOC))
         {
			$email=$row['email'];
  }
		   SendMailToTellresult($email,$username,0); 
		   echo  "ok"; 
			 exit;
		 }else{
			 echo  "apply is error"; 
         exit;
		 }
break;  
case "addfiles":
empty($_POST['zyname']) && $_POST['zyname']="";
empty($_POST['zylink']) && $_POST['zylink']="";
empty($_POST['zyqx']) && $_POST['zyqx']=99;
if($_POST['zyqx']==-1){$_POST['zyqx']=0;}
$zyname=test_input($_POST['zyname']);
$zylink=test_input($_POST['zylink']);
$zyqx=test_input($_POST['zyqx']);
$nowdate=date("Y-m-d");
if ($zyname != ""){
	if ($zylink == ""){
		  echo "no link";
	  exit;
	}
	if ($zyqx === 99){
		  echo "no qx";
	  exit;
	}
	$sql="INSERT INTO bw_downtable(FileName, Download,Permisson,adddate)  VALUES ('$zyname','$zylink',$zyqx,'$nowdate')";
	loaddb($sql);
	//echo $sql;
	echo "ok";
	}else{
	  echo "no name";
	  exit;
}
 //添加
  break;
  case "modfile":
empty($_POST['zyid']) && $_POST['zyid']="";
empty($_POST['zyname']) && $_POST['zyname']="";
empty($_POST['zylink']) && $_POST['zylink']="";
empty($_POST['zyqx']) && $_POST['zyqx']=99;
$zyid=test_input($_POST['zyid']);
$zyname=test_input($_POST['zyname']);
$zylink=test_input($_POST['zylink']);
$zyqx=test_input($_POST['zyqx']);
if ($zyname != ""){
	if ($zylink == ""){
		  echo "no link";
	  exit;
	}
	if ($zyqx === 99){
		  echo "no qx";
	  exit;
	}
	//获取源文件
	$sql="select * from bw_downtable where id in ($zyid)";
	 //echo $sql;
	 $rs=loaddb($sql);
	 $orgfilename="";
	 $orgdown="";
	$orgqx=0;
	 $addstr="";
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$orgfilename=$row['FileName'];
			$orgdown=$row['Download'];
			 $orgqx=$row['Permisson'];
  }
 if($orgfilename != $zyname){
	  $addstr=$addstr.",FileName = '$zyname'";
  }
   if($orgdown != $zylink){
	  $addstr=$addstr.",Download = '$zylink'";
  }
   if($orgqx != $zyqx){
	  $addstr=$addstr.",Permisson = '$zyqx'";
  }

	 if ($addstr != ""){
  $addstr=substr($addstr,1);
  $sql1="UPDATE bw_downtable SET $addstr where id=$zyid";
//echo $sql;
  loaddb($sql1);
  echo "ok";
  }else{
	  echo "no change";
	  exit;
  }
	}else{
	  echo "no name";
	  exit;
}
  break;
  case "moduser":
  empty($_POST['userid']) && $_POST['userid']="";
empty($_POST['useremail']) && $_POST['useremail']="";
empty($_POST['userpassword']) && $_POST['userpassword']="";
empty($_POST['userqx']) && $_POST['userqx']=0;
$userid=test_input($_POST['userid']);
$useremail=test_input($_POST['useremail']);
$userpassword=test_input($_POST['userpassword']);
$userqx=test_input($_POST['userqx']);
if($_POST['useremail'] ==""){
	echo "no email";
	exit;
}
if($_POST['userpassword']==""){
	echo "no password";
	exit;
}
if($_POST['userid']==""){
	echo "no usrid";
	exit;
}
if($_POST['userqx']==""){
	echo "no usrqx";
	exit;
}
 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$useremail)) {
  echo  "invaild email"; 
  exit;
}
//获取原权限
 $sql="select * from bw_usertable where id in ($userid)";
	 //echo $sql;
	 $rs=loaddb($sql);
	 $orgusername="";
	 $orgemail="";
	  $orgpassword="";
	 $orguserqx=0;
	 $addstr="";
	 	$optftp=getthesettings('optftp');
		$lowftp=getthesettings('lowftpper');
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$orgusername=$row['username'];
			$orgemail=$row['email'];
			 $orgpassword=$row['passmd5'];
			$orguserqx=$row['permission'];
  }
  if($orgemail != $useremail){
	  $addstr=$addstr.",email = '$useremail'";
  }
  if($userqx != $orguserqx ){
	  $addstr=$addstr.",permission =  $userqx";
	  if($optftp==1){
			if($lowftp<=$userqx){
			if(getthesettings('ftpmode')==1){
            $sqlx="UPDATE bw_ftp SET account='".getthesettings('ftpuser'.$userqx)."' where userid='$orgusername'";
			loaddb($sqlx);
			}else{
            $sqlx="UPDATE bw_ftp SET account='".getthesettings('ftpuser'.$userqx)."' where userid='$orgusername'";
			loaddb($sqlx);
            delftpuser($orgusername);
			regftpusernomd5($orgusername,$orgpassword,getthesettings('ftpuser'.$userqx));
			}
			
			}
		}
  }
    if($userpassword != "ok,it's a fake password."){
	if(md5($userpassword) !=$orgpassword){
	  $addstr=$addstr.",passmd5= '".md5($userpassword)."'";
	  //FTP部分
		if($optftp==1){
			
			if($lowftp<=$orguserqx){
			if(getthesettings('ftpmode')==1){
			$sqlx="UPDATE bw_ftp SET password='".md5($userpassword)."' where userid='$orgusername'";
			loaddb($sqlx);
			}else{
			$sqlx="UPDATE bw_ftp SET password='".md5($userpassword)."' where userid='$orgusername'";
			loaddb($sqlx);	
			setftpuserpass($orgusername,$userpassword);
			}
			}
		}
	  }
  }
    
  if ($addstr != ""){
  $addstr=substr($addstr,1);
  $sql1="UPDATE bw_usertable SET $addstr where id=$userid";
  loaddb($sql1);
  echo "ok";
  }else{
	  echo "no change";
	  exit;
  }
    break;
	case "adduser":
 empty($_POST['username']) && $_POST['username']="";
empty($_POST['useremail']) && $_POST['useremail']="";
empty($_POST['userpassword']) && $_POST['userpassword']="";
empty($_POST['userqx']) && $_POST['userqx']=0;
$username=test_input($_POST['username']);
$useremail=test_input($_POST['useremail']);
$userpassword=test_input($_POST['userpassword']);
$userqx=test_input($_POST['userqx']);
if($_POST['useremail'] ==""){
	echo "no email";
	exit;
}
if($_POST['userpassword']==""){
	echo "no password";
	exit;
}
if($_POST['username']==""){
	echo "no usrname";
	exit;
}
if($_POST['userqx']==""){
	echo "no usrqx";
	exit;
}
 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$useremail)) {
  echo  "invaild email"; 
  exit;
}
 //检测用户是否存在
    $rsuser=loaddb("SELECT * FROM bw_usertable where username='".$username."'");
	if(mysqli_num_rows($rsuser) >0){
		echo  "user added "."SELECT * FROM bw_usertable where username='".$username."'"; 
         exit;
	}
	$rsemail=loaddb("SELECT * FROM bw_usertable where email='".$useremail."'");
	if(mysqli_num_rows($rsemail) >0){
		echo  "email added"; 
		 exit;
	}
$md5pass=md5($userpassword);
$regdate=date('Y-m-d H:i:s');
	$sql="INSERT INTO bw_usertable(username, passmd5,email,permission,regdate)  VALUES ('$username','$md5pass','$useremail',$userqx,'$regdate')";
	//echo $sql;
	loaddb($sql);
	//FTP部分
	$optftp=getthesettings('optftp');
		$lowftp=getthesettings('lowftpper');
		if($optftp==1){
		if($lowftp<=$userqx){
			 if(getthesettings("ftpmode")==1){
			$sqlx="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser'.$userqx) ."', '".$username."','".$md5pass."')";
			loaddb($sqlx);
     }else{
      $sqlx="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser'.$userqx) ."', '".$username."','".$md5pass."')";
			loaddb($sqlx);
      regftpuser($username,$userpassword,getthesettings('ftpuser'.$userqx));
     }
			$sqlx="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser'.$userqx) ."', '".$username."','".$md5pass."')";
			loaddb($sqlx);
		}
		}
	//echo $sql;
	echo "ok";
 //添加
  break;
  //修改邮件信息
 case "modemail": 
 //获取信息
 $smtpserver=getthesettings('smtpserver');
$smtpport=getthesettings('smtpport');
$emailadress=getthesettings('emailadress');
$emailuser=getthesettings('emailuser');
$emailpass=getthesettings('emailpass');
//获取新信息
 empty($_POST['smtpserver']) && $_POST['smtpserver']="";
empty($_POST['smtpport']) && $_POST['smtpport']="";
empty($_POST['emailadress']) && $_POST['emailadress']="";
empty($_POST['emailuser']) && $_POST['emailuser']="";
empty($_POST['emailpass']) && $_POST['emailpass']="";
$newsmtpserver=test_input($_POST['smtpserver']);
$newsmtpport=test_input($_POST['smtpport']);
$newemailadress=test_input($_POST['emailadress']);
$newemailuser=test_input($_POST['emailuser']);
$newemailpass=test_input($_POST['emailpass']);
//比较
if($_POST['smtpserver'] ==""){
	echo "no smtpserver";
	exit;
}
if($_POST['smtpport'] ==""){
	echo "no smtpport";
	exit;
}
if($_POST['emailadress'] ==""){
	echo "no emailadress";
	exit;
}
if($_POST['emailuser'] ==""){
	echo "no emailuser";
	exit;
}
if($_POST['emailpass'] ==""){
	echo "no emailpass";
	exit;
}
 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['emailadress'])) {
  echo  "invaild email"; 
  exit;
}
$addstr="";
if($smtpserver!=$newsmtpserver){
savethesettings("smtpserver",$newsmtpserver);
}
if($smtpport!=$newsmtpport){
savethesettings("smtpport",$newsmtpport);
}
if($emailadress!=$newemailadress){
savethesettings("emailadress",$newemailadress);
}
if($emailuser!=$newemailuser){
savethesettings("emailuser",$newemailuser);
}
if($emailpass!=$newemailpass){
savethesettings("emailpass",$newemailpass);
}
	echo "ok";
	exit;
 break;
 //测试邮件
  case "mailtest":
  empty($_POST['smtpserver']) && $_POST['smtpserver']="";
empty($_POST['smtpport']) && $_POST['smtpport']="";
empty($_POST['emailadress']) && $_POST['emailadress']="";
empty($_POST['emailuser']) && $_POST['emailuser']="";
empty($_POST['emailpass']) && $_POST['emailpass']="";
empty($_POST['to']) && $_POST['to']="";
$newsmtpserver=test_input($_POST['smtpserver']);
$newsmtpport=test_input($_POST['smtpport']);
$newemailadress=test_input($_POST['emailadress']);
$newemailuser=test_input($_POST['emailuser']);
$newemailpass=test_input($_POST['emailpass']);
$toemail=test_input($_POST['to']);
//比较
if($_POST['smtpserver'] ==""){
	echo "no smtpserver";
	exit;
}
if($_POST['smtpport'] ==""){
	echo "no smtpport";
	exit;
}
if($_POST['emailadress'] ==""){
	echo "no emailadress";
	exit;
}
if($_POST['emailuser'] ==""){
	echo "no emailuser";
	exit;
}
if($_POST['emailpass'] ==""){
	echo "no emailpass";
	exit;
}
 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['emailadress'])) {
  echo  "invaild email"; 
  exit;
}
require_once dirname(dirname(__FILE__)).'/module/email.class.php';
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
<p>邮件测试</p>
<p>如果你看到这封邮件，那么你的邮件配置信息是正确的。</p>
<br>
BetaWorld资源区
<br>
%date%
</body>
</html>";
$content=str_replace("%date%",date('Y-m-d H:i:s'),$emailstr);
//******************** 配置信息 ********************************
	$smtpserver = $newsmtpserver;//SMTP服务器
	$smtpserverport =$newsmtpport;//SMTP服务器端口
	$smtpusermail = $newemailadress;//SMTP服务器的用户邮箱
	$smtpemailto = $toemail;//发送给谁
	$smtpuser = $newemailuser;//SMTP服务器的用户帐号
	$smtppass = $newemailpass;//SMTP服务器的用户密码
	$mailtitle = "邮件测试";//邮件主题
	$mailcontent =$content;//邮件内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug = true;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
  break;
  //修改反馈到邮箱
    case "modtofk":
	empty($_POST['to']) && $_POST['to']="";
	$tofkemail=test_input($_POST['to']);
	if($tofkemail!=""){
		 if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['to'])) {
            echo  "invaild email"; 
            exit;
           }
		   savethesettings("fkemail",$tofkemail);
		   echo "ok";
	}else{
		echo "no email";
		exit;
	}
	break;
	 case "modtoserverkey":
	empty($_POST['to']) && $_POST['to']="";
	$to=test_input($_POST['to']);
	if($to!=""){
		   savethesettings("serverkey",$to);
		   echo "ok";
	}else{
		echo "no key";
		exit;
	}
	break;
	 case "modtogocard":
	empty($_POST['to']) && $_POST['to']="";
	$to=test_input($_POST['to']);
	if($to!=""){
		   savethesettings("gocard",$to);
		   echo "ok";
	}else{
		echo "no address";
		exit;
	}
	break;
	 case "optthetj":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("optthetj",$cx);
	 echo "ok";
	 case "opt":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("optmode",$cx);
	 echo "ok";
	break;
	 case "modtjcode":
	empty($_POST['code']) && $_POST['code']="";
	$code=test_input($_POST['code']);
	if($code != ""){
		   savethesettings("tjcode",$code);
		   echo "ok";
	}else{
		echo "no code";
		exit;
	}
	break;
	case "modftp": 
 //获取信息
$lowftp=getthesettings('lowftpper');
$ftpserveradress=getthesettings('ftpserveradress');
$ftpuser1=getthesettings('ftpuser1');
$ftpuser2=getthesettings('ftpuser2');
$ftpuser3=getthesettings('ftpuser3');
$ftpuser4=getthesettings('ftpuser4');
//获取新信息
empty($_POST['lowftp']) && $_POST['lowftp']="";
empty($_POST['ftpserveradress']) && $_POST['ftpserveradress']="";
empty($_POST['ftpuser1']) && $_POST['ftpuser1']="";
empty($_POST['ftpuser2']) && $_POST['ftpuser2']="";
empty($_POST['ftpuser3']) && $_POST['ftpuser3']="";
empty($_POST['ftpuser4']) && $_POST['ftpuser4']="";
$newlowftp=test_input($_POST['lowftp']);
$newftpserveradress=test_input($_POST['ftpserveradress']);
$newftpuser1=test_input($_POST['ftpuser1']);
$newftpuser2=test_input($_POST['ftpuser2']);
$newftpuser3=test_input($_POST['ftpuser3']);
$newftpuser4=test_input($_POST['ftpuser4']);
//比较
if($_POST['lowftp'] ==""){
	echo "no lowftp";
	exit;
}
if($_POST['ftpserveradress'] ==""){
	echo "no ftpserveradress";
	exit;
}
if($_POST['ftpuser1'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser2'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser3'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser4'] ==""){
	echo "no ftpuser1";
	exit;
}
$addstr="";
if($lowftp!=$newlowftp){
savethesettings("lowftpper",$newlowftp);
}
if($ftpserveradress!=$newftpserveradress){
savethesettings("ftpserveradress",$newftpserveradress);
}
if($ftpuser1!=$newftpuser1){
savethesettings("ftpuser1",$newftpuser1);
}
if($ftpuser2!=$newftpuser2){
savethesettings("ftpuser2",$newftpuser2);
}
if($ftpuser3!=$newftpuser3){
savethesettings("ftpuser3",$newftpuser3);
}
if($ftpuser4!=$newftpuser4){
savethesettings("ftpuser4",$newftpuser4);
}
	echo "ok";
	exit;
 break;
 case "modftp2": 
 //获取信息
$lowftp=getthesettings('lowftpper');
$ftpserveradress=getthesettings('ftpserveradress');
$ftpuser1=getthesettings('ftpuser1');
$ftpuser2=getthesettings('ftpuser2');
$ftpuser3=getthesettings('ftpuser3');
$ftpuser4=getthesettings('ftpuser4');
$authpath=getthesettings('authpath');
//获取新信息
empty($_POST['lowftp']) && $_POST['lowftp']="";
empty($_POST['ftpserveradress']) && $_POST['ftpserveradress']="";
empty($_POST['ftpuser1']) && $_POST['ftpuser1']="";
empty($_POST['ftpuser2']) && $_POST['ftpuser2']="";
empty($_POST['ftpuser3']) && $_POST['ftpuser3']="";
empty($_POST['ftpuser4']) && $_POST['ftpuser4']="";
empty($_POST['auth']) && $_POST['auth']="";
$newlowftp=test_input($_POST['lowftp']);
$newftpserveradress=test_input($_POST['ftpserveradress']);
$newftpuser1=test_input($_POST['ftpuser1']);
$newftpuser2=test_input($_POST['ftpuser2']);
$newftpuser3=test_input($_POST['ftpuser3']);
$newftpuser4=test_input($_POST['ftpuser4']);
$newauth=test_input($_POST['auth']);
//比较
if($_POST['lowftp'] ==""){
	echo "no lowftp";
	exit;
}
if($_POST['ftpserveradress'] ==""){
	echo "no ftpserveradress";
	exit;
}
if($_POST['ftpuser1'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser2'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser3'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['ftpuser4'] ==""){
	echo "no ftpuser1";
	exit;
}
if($_POST['auth'] ==""){
	echo "no auth";
	exit;
}
$addstr="";
if($lowftp!=$newlowftp){
savethesettings("lowftpper",$newlowftp);
}
if($ftpserveradress!=$newftpserveradress){
savethesettings("ftpserveradress",$newftpserveradress);
}
if($ftpuser1!=$newftpuser1){
savethesettings("ftpuser1",$newftpuser1);
}
if($ftpuser2!=$newftpuser2){
savethesettings("ftpuser2",$newftpuser2);
}
if($ftpuser3!=$newftpuser3){
savethesettings("ftpuser3",$newftpuser3);
}
if($ftpuser4!=$newftpuser4){
savethesettings("ftpuser4",$newftpuser4);
}
if($authpath!=$newauth){
savethesettings("authpath",$newauth);
}
	echo "ok";
	exit;
 break;
 case "optftp":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("optftp",$cx);
	 echo "ok";
	break;
	 case "closereg":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("closereg",$cx);
	 echo "ok";
	break;
	case "opensh":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("opensh",$cx);
	 echo "ok";
	break;
	case "opencard":
	empty($_POST['t']) && $_POST['t']="";
	$cx=test_input($_POST['t']);
	if($cx=="off"){$cx=0;}
	savethesettings("opencard",$cx);
	 echo "ok";
	break;
	case "ftpmode":
	empty($_POST['mode']) && $_POST['mode']="";
	$cx=test_input($_POST['mode']);
	savethesettings("ftpmode",$cx);
	 echo "ok";
	break;
	//FTP重置
	 case "ftpreset":
	 if (getthesettings('ftpmode')==1){
loaddb("delete from bw_ftp");
	$lowftp=getthesettings("lowftpper");
	$sql="select username,passmd5,permission from bw_usertable where permission >=$lowftp";
	$rs=loaddb($sql);
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$orgusername=$row['username'];
			 $orgpassword=$row['passmd5'];
			 $per=$row['permission'];
            $sql1="INSERT INTO bw_ftp (account,userid,password) VALUES ('".getthesettings('ftpuser'.$per) ."', '".$orgusername."','".$orgpassword."')";
			loaddb($sql1);
  }
	 }else{
		 resetftp();
	 }
	 
  echo "ok";
  exit;
	break;
	case "pin":
	empty($_POST['fileid']) && $_POST['fileid']="";
	$fileid=test_input($_POST['fileid']);
	if($fileid==""){
		echo "no id";
		exit;
	}else{
		$rschk=loaddb("SELECT id FROM bw_pinfile where fileid='".$fileid."' and ifok=1");
	if(mysqli_num_rows($rschk) >0){
        echo "file pinned";
		exit;
	}else{
		$sql="INSERT INTO bw_pinfile (fileid,ifok) VALUES ($fileid,1) ";
		loaddb($sql);
		echo "ok";
		exit;
	}
	}
	break;
	case "unpin":
	empty($_POST['fileid']) && $_POST['fileid']="";
	$fileid=test_input($_POST['fileid']);
	if($fileid==""){
		echo "no id";
		exit;
	}else{
		$rschk=loaddb("SELECT id FROM bw_pinfile where fileid='".$fileid."' and ifok=1");
	if(mysqli_num_rows($rschk) >0){
       $sql="UPDATE bw_pinfile SET ifok=0 where fileid=$fileid ";
		loaddb($sql);
		echo "ok";
		exit;
	}else{
		echo "file is not pinned";
		exit;
	}
	}
	break;
default:
  	  echo "no type";
	  exit;
}
} catch (Exception $e) {   
echo 'Error：'.$e->getMessage();
exit();   
}  
function test_input($data) {
  //$data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function unixtime_to_date($unixtime, $timezone = 'PRC') {
    $datetime = new DateTime("@$unixtime"); //DateTime类的bug，加入@可以将Unix时间戳作为参数传入
    $datetime->setTimezone(new DateTimeZone($timezone));
    return $datetime->format("Y-m-d H:i:s");
}
?>