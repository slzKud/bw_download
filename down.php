<html>
<?php 
session_start();
include dirname(__FILE__).'/module/mysqlaction.php';
include dirname(__FILE__).'/module/cookiesmaker.php';
include dirname(__FILE__).'/module/downcount.php';
include dirname(__FILE__).'/interface/header-nomenu.php';
empty($id)&&$id="";
empty($LErr)&&$LErr="";
empty($_GET['yuanid'])&&$_GET['yuanid']="";
//var_dump ($_GET);
if (empty($_GET["fileid"])) {
     $LErr .= "文件ID是必须的<br>";
   } else {
    $id=test_input($_GET['fileid']);
   }
   //echo "a";
   if (empty($_GET["timestamp"])) {
     $LErr .= "时间戳是必须的<br>";
   } else {
     $timestamp= test_input($_GET["timestamp"]);
   }
   //echo "b";
   if (empty($_GET["yzcode"])) {
     $LErr .= "验证码是必须的<br>";
   } else {
     $yzcode= test_input($_GET["yzcode"]);
   }
   //echo "c";
   if($LErr==""){
   $nowtime=time();
   if ($nowtime-$timestamp <= 1800){
	   $newcode=md5("?fileid=".$id."&timestamp=".$timestamp."BETAWORLD2016DDD!!!");
	   if($newcode!=$yzcode){
		   $LErr .= "验证码无效，参数可能遭到了篡改<br>";
	   }
   }else{
	   $LErr .= "此链接已过期，请重新申请。<br>";
   }
   }
if ($LErr==""){
	//echo "d";
	if (isset($_COOKIE["bwuser"])){
	  if(veifycookies($_COOKIE["bwuser"])!="incorrect！"){
     $downuser=veifycookies($_COOKIE["bwuser"]);
       }else{
		   $downuser="dangeruser";
	   }
	   }else{
		   	 $downuser="Anonymous";
  }
  if( $downuser!="Anonymous" &&  $downuser!="dangeruser"){
    $username=veifycookies($_COOKIE["bwuser"]);
    $uc=getusercount($_SESSION['permission']);
    $userdowncount=calcdowncountbyuser($username,getnowdate());
    if($userdowncount>=$uc){
      $LErr .= "你今日下载次数已超限（当前下载次数:$userdowncount  次,日配额：$uc 次/日），请第二天再试。<br>";
    }
  }else{
    $ip=getIP();
    $uc=getusercount(0);
    $userdowncount=calcdowncountbyip($ip,getnowdate());
    if($userdowncount>=$uc){
      $LErr .= "你今日下载次数已超限（当前下载次数:$userdowncount 次,日配额：$uc 次/日），请第二天再试。<br>";
    }
  }
	$ip=getIP();
	$downdate=date('Y-m-d H:i:s');
$sqlhistory="INSERT INTO bw_downloadhistory (fileid, downuser,ip,downtime) VALUES ($id,'$downuser','$ip','$downdate')";
loaddb($sqlhistory);
$sql="select Filename,Download from bw_downtable where id=".$id."  and permisson<=".$_SESSION['permission'];
//echo $sql;
$rs=loaddb($sql);
if (mysqli_num_rows($rs)> 0 ){
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
  $filename=$row['Filename'];
  if($_GET['yuanid']!=""){
    $sql="select B64Links from bw_filelinks where fileID=".$_GET['fileid']." and LinkDesc='".$_GET['yuanid']."'";
    //echo $sql;
    $rs=loaddb($sql);
    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
	  $link=base64_decode($row['B64Links']);
  }else{
	  $link=$row['Download'];
  }
	
}else{
    $LErr .= "没有相关资源可供下载。<br>这可能是因为：<br>1）你无权下载此资源<br>2）资源已经被删除 <br>3）其他不明原因<br>如想解决此问题，请与管理员反馈。";
}
}else{
	//报错
	
}

if ($LErr !=""){
	echo "  <div class='container'><h2>Opps...</h2> 
	  <hr>
	  <h3>发生了一点小错误</h3>
	  <br>";
	  echo "<div class='alert alert-danger'>".$LErr."</div>";
	  exit();
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function getIP(){
global $ip;
if (getenv("HTTP_CLIENT_IP"))
$ip = getenv("HTTP_CLIENT_IP");
else if(getenv("HTTP_X_FORWARDED_FOR"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if(getenv("REMOTE_ADDR"))
$ip = getenv("REMOTE_ADDR");
else $ip = "Unknow";
return $ip;
}
?>
<body>

<?php 
echo "<input type='hidden' value='$id' id='loaddapp' />";
 echo "<script>setTimeout( 'window.open(\"$link\");  ',5000); </script> "; 
		/* php echo "<meta http-equiv='refresh' content='5;url=".$link."'> ";  */?>
		<script>
		 function feedback(){
			 var  fileid=document.getElementById("loaddapp").value; 
			 $.ajaxSetup({cache:false});
		  $.get('feedback.php?fktype=filelost&fileid='+fileid,function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("反馈成功！");
            //window.location.reload();		
            break;
           case "no id":
            alert("欸，id无效啊！");
          break;
         default:
          alert("这是啥啊@#￥！");
}
			});
		 }
		  function trim(str){ //删除左右两端的空格
 　　     return str.replace(/(^\s*)|(\s*$)/g, "");
 　　 }
 
		 </script>
   <div class="container">
<div class="page-header">
   <h1>准备下载
   </h1>
</div> 
  <div class="container">
  <p class="lead">你下载的资源'<?php echo($filename); ?>'已经就绪，5秒之后自动跳转到下载地址....<br>如果未能跳转，请点击<a href="<?php echo($link); ?>" target="_blank">这里</a>。<br>如果资源无法下载，请<a onclick="feedback();">反馈</a>。</p>
   </div>
   </div>

  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>