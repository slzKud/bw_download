<html>
<?php 
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include 'interface/header-nomenu.php';
empty($id)&&$id="";
empty($LErr)&&$LErr="";
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
$sql="select Filename,Download from bw_downtable where id=".$id."  and permisson<=".$_SESSION['permission'];
//echo $sql;
$rs=loaddb($sql);
if (mysqli_num_rows($rs)> 0 ){
	$row = mysqli_fetch_array($rs, MYSQL_ASSOC);
	$filename=$row['Filename'];
	$link=$row['Download'];
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
?>
<body>
		<?php echo "<meta http-equiv='refresh' content='5;url=".$link."'> "; ?>
   <div class="container">
<div class="page-header">
   <h1>准备下载
   </h1>
</div> 
  <div class="container">
  <p class="lead">你下载的资源'<?php echo($filename); ?>'已经就绪，5秒之后自动跳转到下载地址....<br>如果未能跳转，请点击<a href="<?php echo($link); ?>">这里</a>。<br>如果资源无法下载，请<a href='feedback.php'>反馈</a>。</p>
   </div>
   </div>

  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>