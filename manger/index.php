<html>
<?php 
$nowpageid=1;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php'; 
$os=php_uname();
$phpv=PHP_VERSION;
$serverip=GetHostByName($_SERVER['SERVER_NAME']);
$serverpath=$_SERVER['DOCUMENT_ROOT'];
function getthename($id) {
  $sql="select Filename from bw_downtable where id=$id";
  $rs=loaddb($sql);
   //echo $sql.'<br>';
  if (mysqli_num_rows($rs)>0){
	  $row = mysqli_fetch_array($rs, MYSQL_ASSOC);
	  return $row['Filename'];
  }else{
	  return "error";
  }
}  
?>
<body>
 <div class="container-fluid">
        <div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-md-10 text-left">
	  <div class="panel panel-default">
   <div class="panel-heading">
      <h3 class="panel-title">
         仪表盘
      </h3>
   </div>
   <div class="panel-body">
    <div class="container">
      <h1>欢迎！<small><?php echo veifycookies($_COOKIE["bwuser"]);?></small></h1>
	  <div class="container">
	  </div>
	   <div class="container">
	   <div class="col-md-5 text-left">
	   <div class="panel panel-success">
   <div class="panel-heading">
      <h3 class="panel-title">30日内下载最多</h3>
   </div>
   <div class="panel-body">
     <ol>
	   <?php
	   $sql="SELECT fileid, count(1) AS counts FROM bw_downloadhistory  Where date_sub(curdate(), INTERVAL 30 DAY) <= date(`downtime`) GROUP BY fileid desc order by counts desc LIMIT 5";
	   $rs=loaddb($sql);
	   while($row=mysqli_fetch_row($rs)){
		   $temp=getthename($row[0]);
           echo "<li>$temp($row[1]次)</li>";
        }
	   ?>
        </ol>
   </div>
</div>
	   
	    
		</div>
		 <div class="col-md-5 text-left">
		  <div class="panel panel-primary">
       <div class="panel-heading">
      <h3 class="panel-title">累计下载最多</h3>
   </div>
   <div class="panel-body">
     <ol>
	   <?php
	   $sql="SELECT fileid, count(1) AS counts FROM bw_downloadhistory GROUP BY fileid desc order by counts desc LIMIT 5";
	   $rs=loaddb($sql);
	   while($row=mysqli_fetch_row($rs)){
		   $temp=getthename($row[0]);
           echo "<li>$temp($row[1]次)</li>";
        }
	   ?>
        </ol>
		</div>
		</div>
   </div>
    <div class="col-md-5 text-left">
		  <div class="panel panel-primary">
       <div class="panel-heading">
      <h3 class="panel-title">系统信息</h3>
   </div>
   <div class="panel-body">

	   <?php
	  echo "系统：$os<br>
	  PHP版本：$phpv<br>
	  服务器IP：$serverip<br>
	  网站路径：$serverpath<br>";
	   ?>
        </ol>
		</div>
		</div>
   </div>
		</div>
		 
	   </div>
	  </div>
   </div>
</div>
</div>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
    <script src="docs/js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="/js/highlight.js"></script>
    <script src="/js/bootstrap-switch.js"></script>
    <script src="/js/main.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>
