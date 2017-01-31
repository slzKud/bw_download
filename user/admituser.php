<html>
<style>
#w
{
font-family : 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
font-size : 1em;
color : #C0C0C0;
}
</style>
<body>
<br>
<div class="container">
   <h2>用户组更改申请</h2> 
 <hr>
<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
//session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
empty($_POST['username']) && $_POST['username']="";
empty($_POST['old']) && $_POST['old']="";
empty($_POST['new']) && $_POST['new']="";
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
$LErr="";
$username =test_input($_POST['username']);
$useroldper =test_input($_POST['old']);
$usernewper =test_input($_POST['new']);
switch($useroldper){
	case '普通用户':
				$useroldqx=1;
				  break;
				case '高级用户':
				$useroldqx=2;
				  break;
				case 'VIP':
				$useroldqx=3;
				  break;
				 default:
				$useroldqx=0;
				  break;
			}
switch($usernewper){
				case '高级用户':
				$usernewqx=2;
				  break;
				case 'VIP':
				$usernewqx=3;
				  break;
				 default:
				$usernewqx=0;
				  break;
			}
$nowdate=date("Y-m-d h:i:s");
 $sql="INSERT INTO bw_admituser(username,oldper,newper,nowtime)  VALUES ('$username',$useroldqx,$usernewqx,'$nowdate')";
loaddb($sql);		
//echo $sql;
echo "<script>alert('你的用户权限更改申请已发送，请等待审批。');</script>"	;	
}
 include '../interface/header-user.php';
 if(getthesettings("opensh")!= "1"){
	   include '../interface/header-user.php';
	   $LErr="对不起，此功能已被管理员禁用。";
	   echo '
<div class="alert alert-danger">'.$LErr.'</div>
</div>';
include '../interface/footer.php';
exit;
   }
//自动判断cookie
	  if (isset($_COOKIE["bwuser"])){
	  //鉴别用户代码
	  if ($_SESSION['permission']==0){
	  $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
	  $row=mysqli_fetch_array($con);
     $_SESSION['permission']=$row['permission'];
	 }
	  if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
	       echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
		   exit;
	   }
		$username= veifycookies($_COOKIE["bwuser"]);
		switch($_SESSION['permission']){
				case '1':
				$userqx="普通用户";
				  break;
				case '2':
				$userqx="高级用户";
				  break;
				case '3':
				$userqx="VIP";
				  break;
				case '4':
				$userqx="管理员";
				  break;
				 default:
				$userqx="未知";
				  break;
			}
			if($_SESSION['permission']>3){
				 
	   $LErr="你的用户权限已经达到$userqx 级别，无需再提升。";
	   echo '
<div class="alert alert-danger">'.$LErr.'</div>
</div>';
include '../interface/footer.php';
exit;
			}
	  }else{
		  echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
			exit; 
	  }
$nowpageid=1;
function test_input($data) {
  //$data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
 <form role="form"action= "admituser.php" method="post" id="Fb">
 <input type='hidden' value='<?php echo $username;?>' name='username' />
  <input type='hidden' value='<?php echo $userqx;?>' name='old' />
  <div class="form-group">
    <label for="name">用户名</label>
    <p class="form-control-static" ><?php echo $username;?></p> 
	</div>
 <div class="form-group">
    <label for="name">用户现在权限</label>
    <p class="form-control-static"><?php echo $userqx;?></p> 
	</div>
	
	<div class="form-group">
	 <label for="name">想更改的用户组</label>
      <select class="form-control" name="new">
        <?php
		if($_SESSION['permission']<2){echo "<option>高级用户</option>";}
        //if($_SESSION['permission']<3){echo "<option>VIP</option>";}
		?>
      </select>

</div>
<button type="button" class="btn btn-primary btn-lg btn-block" onclick="ok_user();">申请</button>
 </div>
</form> 
 <script type="text/javascript">
function ok_user(){
	 var form = document.getElementById("Fb");
	 form.submit();
}
</script>	 
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include '../interface/footer.php';?>
</html>