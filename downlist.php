<html>
<?php 
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
empty($tioajian)&&$tiaojian="";
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
$nowpageid=2;
include 'interface/header.php';
$flag=0;
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
 <div class="container">
 <br>
 <!--
 下载区标题
 -->
 <div class="row" id="titlebox">
      <div class="col-xs-6">
	  <h2>资源列表</h2> 
	  </div>
      <div class="col-xs-6">
	   <div class="form-inline text-right" >
    <form class="bs-example bs-example-form" role="form" action="downlist.php" method="get" id="PassForm">   
            <input type="text" class="form-control" placeholder="Search" name="findstr" value='<?php echo $tiaojian;?>'>
         <button type="submit" class="btn btn-default"><span class='glyphicon glyphicon-search' style="font-size: 20px;"></span></button>
      </form>   
    </div>	  
	  </div>      
   </div>
   <hr>
   
   
   <!--
 下载区列表
 -->
 <?php
 
 ////设定每一页显示的记录数
$pagesize=15;
 $con=connectdb();
  mysqli_query($con,"set names 'utf8'");
 //构建sql
 if(empty($tiaojian)){
	  $sql="select %tj% from bw_downtable where Permisson<= ".$_SESSION['permission']."";  
 }else{
	 $sql="select %tj% from bw_downtable where Permisson<= ".$_SESSION['permission']." and filename like '%".$tiaojian."%'";  
 }
 //计算页数
$res=mysqli_query($con,str_replace("%tj%","count(*) as count",$sql));
$myrow = mysqli_fetch_array($res);
$numrows=$myrow[0];
//计算总页数
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
$pages++;
//判断页数设置与否，如无则定义为首页
if (!isset($page))
$page=1;
//判断转到页数
if (isset($ys))
if ($ys>$pages)
$page=$pages;
else
$page=$ys;
//计算记录偏移量
$offset=$pagesize*($page-1);
$rs=mysqli_query($con,str_replace("%tj%","id,Filename,Download,adddate",$sql." order by id desc limit $offset,$pagesize"));
//echo $sql;
closedb($con);
?>
 <table class="table table-hover">
   <thead>
      <tr>
         <th>资源名称</th>
         <th>添加时间</th>
         <th></th>
      </tr>
   </thead>
   <tbody>
      <?php
      //置顶文件
  if(empty($tiaojian)){
      $sqlpin="select fileid from bw_pinfile where ifok=1";
      $rspin=loaddb($sqlpin);
      while($rowp = mysqli_fetch_array($rspin, MYSQL_ASSOC))
         {
           $sqlp="select id,Filename,Download,adddate from bw_downtable where id=".$rowp['fileid']." and Permisson<= ".$_SESSION['permission'].""; 
          //echo $sqlp;
          $rspinx=loaddb($sqlp);
          while($rowg = mysqli_fetch_array($rspinx, MYSQL_ASSOC))
         {
			$nowtime=time();
            echo "<tr>";
            echo "<td>" . $rowg['Filename'] . '<span class="label label-primary">置顶</span></td>';
            echo "<td>" . $rowg['adddate'] . "</td>";
			echo "<td> <a href ='http://".$_SERVER['HTTP_HOST']."/down.php?fileid=".$rowg['id']."&timestamp=".$nowtime."&yzcode=".md5("?fileid=".$rowg['id']."&timestamp=".$nowtime."BETAWORLD2016DDD!!!"). "'><span class='glyphicon glyphicon-cloud-download' style='font-size: 20px;'></span></a></td>";
            echo "</tr>";
			//$flag=1;
  }
         }
          }
	  while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$nowtime=time();
            echo "<tr>";
            echo "<td>" . $row['Filename'] . "</td>";
            echo "<td>" . $row['adddate'] . "</td>";
			echo "<td> <a href ='http://".$_SERVER['HTTP_HOST']."/down.php?fileid=".$row['id']."&timestamp=".$nowtime."&yzcode=".md5("?fileid=".$row['id']."&timestamp=".$nowtime."BETAWORLD2016DDD!!!"). "'><span class='glyphicon glyphicon-cloud-download' style='font-size: 20px;'></span></a></td>";
            echo "</tr>";
			$flag=1;
  }

	  ?>

   </tbody>
</table>
<?php if($flag==0){echo "<center><p class='lead' >啊哈，未找到哦~</p></center>";} ?>
<ul class="pagination">
<?php
if ($pages>1) {
//计算首页、上一页、下一页、尾页的页数值
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if(empty($tiaojian)){
	  $link="downlist.php?";  
 }else{
	 $link="downlist.php?findstr=$tiaojian&";  
 }
if ($page >1) echo "<li><a href='".$link."pageid=".$first."'>&laquo;</a></li>";
for ($x=1; $x<=$pages; $x++) {
	 $linka=$link."pageid=".$x;
	if($x==$page){
		echo "<li class='active'><a href='$linka'>$x</a></li>";
	}else{
	echo "<li><a href='$linka'>$x</a></li>";	
	}
  
} 
if ($page < $pages ) echo "<li><a href='".$link."pageid=".$last."'>&raquo;</a></li>";
}
?>

</ul>
</div>

</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>