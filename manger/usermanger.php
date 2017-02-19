<html>
<?php 
$nowpageid=3;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
empty($tioajian)&&$tiaojian="";
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($_GET['px'])&&$_GET['px']="username";
empty($_GET['sc'])&&$_GET['sc']="desc";
$desc=$_GET['sc'];
if($desc!="asc" and $desc !="desc"){$desc="desc";}
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
 <div class="container-fluid">
        <div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-md-10 text-left">
		  <div class="panel panel-default">

   <div class="panel-body">
    <div class="container">
      <h1>用户管理</small></h1>
	  <hr>
	   
		<div class="container">
		<form class="form-inline" role="form" action="usermanger.php" method="get">
		 <a href="interface/window/adduser.html"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加用户</button> </a>   
<a href="interface/window/modifyuser.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> 修改用户信息</button> </a>	 
		<a href="interface/window/deluser.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> 删除用户</button></a>	 
		<a href="interface/window/banuser.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-Ban-circle"></span> 封禁/解封用户</button></a>	 
		 <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="findstr" value='<?php echo $tiaojian;?>'>
         <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 搜索</button>
</form>
</div>
		<?php
 ////设定每一页显示的记录数
$pagesize=8;
 $con=connectdb();
  mysqli_query($con,"set names 'utf8'");
 //构建sql
 if(empty($tiaojian)){
	  $sql="select %tj% from bw_usertable ";  
 }else{
	 $sql="select %tj% from bw_usertable where username like '%".$tiaojian."%'";  
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
if ($ys>$pages){
$page=$pages;
}else{
$page=$ys;
}
//计算记录偏移量
$offset=$pagesize*($page-1);
$rs=mysqli_query($con,str_replace("%tj%","id,username,permission,regdate",$sql." order by ".$_GET['px']." ".$desc." limit $offset,$pagesize"));
//echo str_replace("%tj%","id,username,permission,regdate",$sql." order by ".$_GET['px']." ".$desc." limit $offset,$pagesize");
closedb($con);
?>
		 <table class="table">
   <thead>
      <tr>
         <th><a onclick="topx('username');">用户名称<?php if($_GET['px']=="username"){echo "（按此排序）";}?></a></th>
         <th>用户权限</th>
         <th><a onclick="topx('regdate');">注册时间<?php if($_GET['px']=="regdate"){echo "（按此排序）";}?></a></th>
      </tr>
   </thead>
   <tbody>
       <?php
	  $i=1;
	  while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$nowtime=time();
            echo "<tr>";
			echo "<td><input type='checkbox' name='checkItem' id='Bwchkid".$row['id']."'  /></td>";
            echo "<td id ='BwStrid".$row['id']."'>" . $row['username'] . "</td>";
			switch($row['permission']){
				case '-1':
				$userqx="已封禁";
				  break;
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
			echo "<td>" .$userqx."</td>";
			echo "<td>" . $row['regdate']."</td>";
            echo "</tr>";
			$i+=1;
  }

	  ?>

   </tbody>
</table>
<ul class="pagination">
  <?php
if ($pages>1) {
//计算首页、上一页、下一页、尾页的页数值
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if(empty($tiaojian)){
	  $link="usermanger.php?";  
 }else{
	 $link="usermanger.php?findstr=$tiaojian&";  
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

	  </div>
</div>
</div>
<!-- 添加模态框（Modal） -->
<div  id="MyModal"  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none;">
   <div class="modal-dialog">
  <div class="modal-content">
 
 </div>
     </div>
</div><!-- /.modal -->
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
       <script src="docs/js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
	  <script>
	  $nowid="aaa"
	 var $tempstr="";

	//传递信息
	$("[data-toggle='modal']").click(function(){
 var _target = $(this).attr('data-target')
 t=setTimeout(function () {
 var _modal = $(_target).find(".modal-dialog")
 _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
 },200)
 })


   $(function () { $('#MyModal').on('hide.bs.modal', function () {
	    $(this).removeData("bs.modal");
	  })
   });
</script>
	  <script>
		$(function(){
			function initTableCheckbox() {
				var $thr = $('table thead tr');
				var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
				/*将全选/反选复选框添加到表头最前，即增加一列*/
				$thr.prepend($checkAllTh);
				/*“全选/反选”复选框*/
				var $checkAll = $thr.find('input');
				$checkAll.click(function(event){
					/*将所有行的选中状态设成全选框的选中状态*/
					$tbr.find('input').prop('checked',$(this).prop('checked'));
					/*并调整所有选中行的CSS样式*/
					if ($(this).prop('checked')) {
						$tbr.find('input').parent().parent().addClass('warning');
					} else{
						$tbr.find('input').parent().parent().removeClass('warning');
					}
					/*阻止向上冒泡，以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击全选框所在单元格时也触发全选框的点击操作*/
				$checkAllTh.click(function(){
					$(this).find('input').click();
				});
				var $tbr = $('table tbody tr');
				var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');
				/*每一行都在最前面插入一个选中复选框的单元格*/
				//$tbr.prepend($checkItemTd);
				/*点击每一行的选中复选框时*/
				$tbr.find('input').click(function(event){
					//传送数据给后台
				    $.get("transfer.php?item="+$( this)[0].id);
					/*调整选中行的CSS样式*/
					$(this).parent().parent().toggleClass('warning');
					/*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/
					$checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
					/*阻止向上冒泡，以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击每一行时也触发该行的选中操作*/
				$tbr.click(function(){
					$(this).find('input').click();
				});
			}
			initTableCheckbox();
		});
		function topx(field){
			var uri="";
			uri=this.location.href;
			if(right(uri,3)=="php"){
              //alert(uri+"?px="+field);
			  window.location.href=uri+"?px="+field;
			}else{
             //alert(uri+"&px="+field);
			 window.location.href=uri+"&px="+field;
			}
			
		}
		function right(mainStr,lngLen) { 
// alert(mainStr.length) 
 if (mainStr.length-lngLen>=0 && mainStr.length>=0 && mainStr.length-lngLen<=mainStr.length) { 
 return mainStr.substring(mainStr.length-lngLen,mainStr.length)} 
 else{return null} 
 } 
		</script>
</body>
<?php include 'interface/footer.php';?>
</html>
