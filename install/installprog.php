<?php
ob_start();
echo "Preapring Install....";
echo '<br />'.str_repeat(' ', 1024*4);
sleep(1);
 ob_flush();
 flush();
empty($_POST['mysql']) && $_POST['mysql']="";
empty($_POST['port']) && $_POST['port']="3306";
empty($_POST['muser']) && $_POST['muser']="";
empty($_POST['mpass']) && $_POST['mpass']="";
empty($_POST['mname']) && $_POST['mname']="";
empty($_POST['username']) && $_POST['username']="";
empty($_POST['userpass']) && $_POST['userpass']="";
empty($_POST['useremail']) && $_POST['useremail']="";
if(file_exists("install.lock")){
	echo 'Install failed,please delete install.lock and install again.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['mysql']==""){
	echo 'The Mysql adress is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['port']==""){
	echo 'The Mysql port is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['muser']==""){
	echo 'The Mysql username is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['mpass']==""){
	echo 'The Mysql password is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['username']==""){
	echo 'The administrator name is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['userpass']==""){
	echo 'The administrator password is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['useremail']==""){
	echo 'The administrator email is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
if($_POST['mname']==""){
	echo 'The database name is invilad.';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
	exit();
}
$sql_array=preg_split("/;[\r\n]+/", file_get_contents('./bwinstall.sql'));  
$i=0;
echo 'Installing......';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
file_put_contents('log.txt', "[INFO]开始安装\n");
echo 'Connecting database......';
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
$cona=connectdb($_POST['mysql'].":".$_POST['port'],$_POST['muser'],$_POST['mpass'],$_POST['mname']);
foreach ($sql_array as $k => $v) { 
$i=$i+1; 
           loaddb($v,$cona);  
		   //echo $v;
		   echo "Installing......$i";
	echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
		   file_put_contents('log.txt', "执行第$i 条语句中\n", FILE_APPEND|LOCK_EX);
		   sleep(1);
		   //echo "执行第$i 条语句中<br>";  
		   //echo file_put_contents('log.txt', mysqli_error()."\n", FILE_APPEND|LOCK_EX);
           //echo mysql_error().'<br>';  
}
   echo "Installing......OK!";
   echo '<br />'.str_repeat(' ', 1024*4);
 ob_flush();
 flush();
 sleep(1);
   echo "Setting......";
   echo '<br />'.str_repeat(' ', 1024*4);
   loaddb("INSERT INTO `bw_usertable` VALUES (1,'".$_POST["username"]."','".md5($_POST["userpass"])."','".$_POST["useremail"]."',4,'127.0.0.1','2016-06-07 09:00:00','2016-06-07 09:00:00')",$cona);
   loaddb("INSERT INTO `bw_settings` VALUES (3,'fkemail','".$_POST["useremail"]."')",$cona);
    loaddb("INSERT INTO `bw_settings` VALUES (999,'ftpmode','1')",$cona);
	loaddb("INSERT INTO `bw_settings` VALUES (998,'optftp','0')",$cona);
   file_put_contents('../settings/db.php', "<?php
define(\"DBHOST\", \"".$_POST['mysql'].":".$_POST['port']."\");
define(\"DBUSER\", \"".$_POST['muser']."\");
define(\"DBPASS\", \"".$_POST['mpass']."\");
define(\"DBNAME\", \"".$_POST['mname']."\");
?>");
file_put_contents("install.lock","");
 ob_flush();
 flush();
  sleep(2);
   echo "Done.<a href=\"../index.php\">Next</a>";
   echo '<br />'.str_repeat(' ', 1024*4);
    ob_flush();
 flush();
 closedb($cona);
function connectdb($DBHOST,$DBUSER,$DBPASS,$DBNAME) {
	
try { 
 $conc = mysqli_connect($DBHOST,$DBUSER,$DBPASS,$DBNAME);
  if (!$conc)
  {
  echo file_put_contents('log.txt', "数据库链接失败"."\n", FILE_APPEND|LOCK_EX);
		   echo "数据库链接失败<br>";  
		   exit();
  }
  return $conc;
  }catch(Exception $e) {
	  echo file_put_contents('log.txt', $e->getMessage()."\n", FILE_APPEND|LOCK_EX);
		   echo $e->getMessage()."<br>";  
		     exit();
	  }
}
function loaddb($sql,$cona) {
	
	try { 
  mysqli_query($cona,"set names 'utf8'");
  $result = mysqli_query($cona,$sql);

  return $result;
  }catch(Exception $e) {
	  echo file_put_contents('log.txt', $e->getMessage()."\n", FILE_APPEND|LOCK_EX);
		   echo $e->getMessage()."<br>";  
		     exit();
	  }
}
function closedb($con) {
  mysqli_close($con);
}
?>
