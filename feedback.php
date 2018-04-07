<?php header("Pragma: no-cache"); ?>
<?php 
include_once dirname(__FILE__).'/module/mysqlaction.php';
include_once dirname(__FILE__).'/module/sendmail.api.php';
$LErr="";
$fktitle ="";
$fktype ="";
$fktext ="";
empty($_GET["fktype"]) && $_GET["fktype"]="";
$fkid =0;
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
     $fktype = test_input($_GET["fktype"]);
   if($fktype=="filelost"){
    if (empty($_GET["fileid"])) {
     echo "no id";
	 exit();
   } else {
     $fkid = test_input($_GET["fileid"]);
   }
   $fktitle="资源失效，请求补充";
   $con=loaddb("select filename from bw_downtable where id=".$fkid);
   $row=mysqli_fetch_array($con);
   $fktext="资源'".$row['filename']."'（文件ID：".$fkid."）已失效，请进行确认并更新。";
   $fktype="资源失效";
   $toemail=getthesettings("fkemail");
   $title="BetaWorld 资源区 - 新反馈：".$fktitle;
    //include 'module/sendfkmail.php';
	SendMailToFk($toemail,$title,$fktitle,$fktype,$fktext);
	echo "ok";
	exit();
	}
}
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
   if (empty($_POST["fktitle"])) {
     $LErr .="反馈标题是必填的<br>";
   } else {
     $fktitle = test_input($_POST["fktitle"]);
   }
    if (empty($_POST["fktype"])) {
     $LErr .="反馈类型是必填的<br>";
   } else {
     $fktype = test_input($_POST["fktype"]);
   }
       if (empty($_POST["fktext"])) {
     $LErr .="反馈内容是必填的<br>";
   } else {
     $fktext = str_replace("\n","<br>",test_input($_POST["fktext"]));
   }
   //echo $fktitle." ".$fktype." ".$fktext;
   //后续对接设置
   $toemail=getthesettings("fkemail");
   $title="BetaWorld 资源区 - 新反馈：".$fktext;
    //include 'module/sendfkmail.php';
	SendMailToFk($toemail,$title,$fktitle,$fktype,$fktext);
	echo "<script>alert('发送成功！');</script>";
}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<html>
<?php 
$nowpageid=1;
include dirname(__FILE__).'/interface/header-nomenu.php';
?>
<body>
 <script type="text/javascript">
function ok_user(){
	 var form = document.getElementById("Fb");
	 form.submit();
}
</script>
   <div class="container">
   <h2>反馈</h2> 
 <hr>
    <div class="container">
	<?php
//输出错误信息
if($LErr != ""){
	echo "<div class='alert alert-danger'>".$LErr."</div>";
}
?>

  <form role="form"action= "feedback.php" method="post" id="Fb">
  <div class="form-group">
    <label for="name">标题</label>
    <input type="text" class="form-control" placeholder="请输入反馈标题" name="fktitle" value="<?php echo $fktitle; ?>">
	</div>
	<div class="form-group">
	 <label for="name">反馈类型</label>
      <select class="form-control" name="fktype">
         <option <?php if($fktype=="资源失效") echo 'selected="selected"'; ?>>资源失效</option>
         <option <?php if($fktype=="服务器问题") echo 'selected="selected"'; ?>>服务器问题</option>
         <option <?php if($fktype=="有关建议") echo 'selected="selected"'; ?>>有关建议</option>
         <option <?php if($fktype=="其他") echo 'selected="selected"'; ?>>其他</option>
      </select>

</div>
	<div class="form-group">
    <label for="name">反馈内容</label>
    <textarea class="form-control" rows="8" name="fktext" ><?php echo str_replace("<br>","",$fktext) ; ?></textarea>
  </div>

  <div class="form-group">
         <button name="submitbutton" class="btn btn-primary btn-lg btn-block" onclick="javascript:ok_user();">反馈</button>
   </div>
 </form>
 *这可能会收集一定你的信息（包括IP,地址等），请你留意
</div>

</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>