<html>
<?php 
$nowpageid=3;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($page)&&$page=1;
$page=$_GET['pageid'];
$nowpageid=2;
$flag=0;
?>
<body>
 <div class="container">
 <div class="row" id="titlebox">
      <div class="col-xs-6">
	  <h2>最近新增</h2> 
	  </div>     
   </div>
   <hr>
   
   
   <!--
 下载区列表
 -->
 <?php
 
 ////设定每一页显示的记录数
$pagesize=8;
 $con=connectdb();
  mysqli_query($con,"set names 'utf8'");
 //构建sql
 $sql=" select %tj% from bw_downtable where date_sub(curdate(), INTERVAL 7 DAY) <= date(`adddate`)";  
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
$rs=mysqli_query($con,str_replace("%tj%","Filename,adddate",$sql." order by adddate desc limit $offset,$pagesize"));
//echo $sql;
closedb($con);
?>
 <table class="table table-hover">
   <thead>
      <tr>
         <th>新增资源名称</th>
         <th>更新日期</th>
      </tr>
   </thead>
   <tbody>
      <?php
	  while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$nowtime=time();
            echo "<tr>";
            echo "<td>" . $row['Filename'] . "</td>";
            echo "<td>" . $row['adddate'] . "</td>";
            echo "</tr>";
			$flag=1;
  }

	  ?>
   </tbody>
</table>
<?php if($flag==0){echo "<center><p class='lead' >最近没有变动，提醒管理员多加点吧！~</p></center>";} ?>
<ul class="pagination">
  <?php
if ($pages>1) {
//计算首页、上一页、下一页、尾页的页数值
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
$link="nowdiff.php?"; 
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