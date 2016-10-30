<?php

include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
empty($tocsv)&&$tocsv=0;
empty($_GET['csv'])&&$_GET['csv']="";
$tocsv=$_GET['csv'];

if($tocsv==1){
	
empty($userstr)&&$userstr="";
empty($reporttype)&&$reporttype="";
empty($dateflag)&&$dateflag="";
empty($ifuser)&&$ifuser="";
empty($tiaojian)&&$tiaojian="";
empty($_GET['userstr'])&&$_GET['userstr']="";
empty($_GET['flag'])&&$_GET['flag']=1;
empty($_GET['dateflag'])&&$_GET['dateflag']=1;
empty($_GET['ifuser'])&&$_GET['ifuser']=0;
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
$userstr=test_input($_GET['userstr']);
$reporttype=test_input($_GET['flag']);
$dateflag=test_input($_GET['dateflag']);
$ifuser=test_input($_GET['ifuser']);
//构建SQL

 if($reporttype==1){
	 $basesql="select downuser,fileid,ip,downtime from bw_downloadhistory";  
	
	 switch($dateflag){
		 case 1:
		 $secondsql=" where date_sub(curdate(), INTERVAL 7 DAY) <= date(`downtime`)";
		 break;
		  case 2:
		  $secondsql=" where date_sub(curdate(), INTERVAL 15 DAY) <= date(`downtime`)";
		 break;
		  case 3:
		  $secondsql=" where date_sub(curdate(), INTERVAL 30 DAY) <= date(`downtime`)";
		 break;
		  case 4:
		  $secondsql=" where date_sub(curdate(), INTERVAL 90 DAY) <= date(`downtime`)";
		 break;
		  case 5:
		  $secondsql=" where date_sub(curdate(), INTERVAL 180 DAY) <= date(`downtime`)";
		 break;
		  case 6:
		  $secondsql=" where date_sub(curdate(), INTERVAL 365 DAY) <= date(`downtime`)";
		 break;
		  case 7:
		  $secondsql="";
		 break;
		 default:
		  $secondsql="";
	 }
	 
	 if($ifuser==1){
		 
		if($secondsql!="") {
			$secondsql=$secondsql." and downuser like '$userstr'";
		}else{
			$secondsql=" where downuser like '$userstr'";
		}
	 }
	 
	 $sql=$basesql.$secondsql; 
 }
//生成CSV文本

date_default_timezone_set("Asia/Shanghai");
export_csv("export".date("YmdGms",time()).".csv",makecsv($sql));
exit();
}
$nowpageid=2;
include 'interface/header.php';
empty($userstr)&&$userstr="";
empty($reporttype)&&$reporttype="";
empty($dateflag)&&$dateflag="";
empty($ifuser)&&$ifuser="";
empty($tiaojian)&&$tiaojian="";
empty($_GET['userstr'])&&$_GET['userstr']="";
empty($_GET['flag'])&&$_GET['flag']=1;
empty($_GET['dateflag'])&&$_GET['dateflag']=1;
empty($_GET['ifuser'])&&$_GET['ifuser']=0;
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
$userstr=test_input($_GET['userstr']);
$reporttype=test_input($_GET['flag']);
$dateflag=test_input($_GET['dateflag']);
$ifuser=test_input($_GET['ifuser']);
$nowpageid=5;
$linkd="report.php?flag=$reporttype&dateflag=$dateflag&ifuser=$ifuser&userstr=$userstr&csv=1";
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function ShowTable($sql){   
$flag=false;
        $res=loaddb($sql);
		//echo $sql;
        $colums=mysqli_num_fields($res);//获取列数
        echo "<table class='table table-hover'><tr>";
		while ($fieldinfo=mysqli_fetch_field($res))
{
 printf( "<th>%s</th>",$fieldinfo->name);
}
        echo "</tr>";
        while($row=mysqli_fetch_row($res)){
            echo "<tr>";
            for($i=0; $i<$colums; $i++){
				$flag=true;
				if($i==1){
					$temp=getthename($row[1]);
					echo "<td>$temp</td>";	
				}else{
				echo "<td>$row[$i]</td>";	
				}
                
            }
            echo "</tr>";
        }
        echo "</table>";
		if($flag==false){
			echo "<center><p class='lead'>未找到,请重新输入条件~</p></center>";
		}
    }
	function MakeCsv($sql){
		
$tempstr="";
$tempz="";		
$flag=false;

        $res=loaddb($sql);
		
		//echo $sql;
        $colums=mysqli_num_fields($res);//获取列数
		while ($fieldinfo=mysqli_fetch_field($res))
{
	
         $temp1=$fieldinfo->name;
         $tempz=$tempz.",".$temp1;
}
 $tempstr=$tempstr.substr($tempz,1)."\n";

        while($row=mysqli_fetch_row($res)){
		$tempx="";
            for($i=0; $i<$colums; $i++){
				$tempx=$tempx.",".$row[$i];
            }
			 $tempstr=$tempstr.substr($tempx,1)."\n"; 
        }
		return $tempstr;
    }
	function export_csv($filename,$data) { 
    //header("Content-type:text/csv"); 
    header("Content-Disposition:attachment;filename=".$filename); 
    //header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
   // header('Expires:0'); 
   // header('Pragma:public'); 
	$text=str_replace(",,,","",$data);
	$text = trim($text);
	$text =  preg_replace("/[\s]{2,}/","",$text); 
    echo $text ; 
} 
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
<HTML>
<body>
 <div class="container-fluid">

        <div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-md-10 text-left">

	  <div class="panel-body">
    <div class="container">
      <h1>报表查询</small></h1>
	  <hr>
		<div class="container">
		 <div class="panel panel-primary">
   <div class="panel-heading">
      <h3 class="panel-title">查询面版</h3>
   </div>
   <div class="panel-body">
       <form class="form-inline" role="form" action="report.php" method="get">
	  <label for="name">报表类型</label>
      <select class="form-control" name="flag">
         <option value="1"  <?php if($reporttype==1) echo 'selected="selected"'; ?>>下载历史</option>
      </select>
	  <label for="name">日期范围</label>
      <select class="form-control" name="dateflag">
         <option  value="1" <?php if($dateflag==1) echo 'selected="selected"'; ?>>最近一周</option>
		 <option  value="2" <?php if($dateflag==2) echo 'selected="selected"'; ?>>最近15天</option>
		 <option  value="3" <?php if($dateflag==3) echo 'selected="selected"'; ?>>最近1月</option>
		 <option  value="4" <?php if($dateflag==4) echo 'selected="selected"'; ?>>最近3个月</option>
		 <option  value="5" <?php if($dateflag==5) echo 'selected="selected"'; ?>>最近半年</option>
		 <option  value="6" <?php if($dateflag==6) echo 'selected="selected"'; ?>>最近一年</option>
		 <option  value="7" <?php if($dateflag==7) echo 'selected="selected"'; ?>>全部记录</option>
      </select>
	  <label><input type="checkbox" value="1" name="ifuser" <?php if($ifuser==1) echo 'checked="checked"'; ?>>以用户名查询</label>
	  <input type="text" class="form-control" placeholder="用户名" name="userstr" value=" <?php echo $userstr; ?>"/>
     <div class="form-group">
         <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 生成报表</button>
		 </form>
		 <a href="<?php echo $linkd;?>" target="_blank" rel="nofollow"><button class="btn btn-default"><span class="glyphicon glyphicon-floppy-save"></span> 导出CSV（请右键新窗口）</button></a>
 </div>
		 
  
</div>
</div>
		<?php
 ////设定每一页显示的记录数
$pagesize=15;
 $con=connectdb();
  mysqli_query($con,"set names 'utf8'");
 //构建sql
 if($reporttype==1){
	 $basesql="select %tj% from bw_downloadhistory";  
	 
	 switch($dateflag){
		 case 1:
		 $secondsql=" where date_sub(curdate(), INTERVAL 7 DAY) <= date(`downtime`)";
		 break;
		  case 2:
		  $secondsql=" where date_sub(curdate(), INTERVAL 15 DAY) <= date(`downtime`)";
		 
		 break;
		  case 3:
		  $secondsql=" where date_sub(curdate(), INTERVAL 30 DAY) <= date(`downtime`)";
		 break;
		  case 4:
		  $secondsql=" where date_sub(curdate(), INTERVAL 90 DAY) <= date(`downtime`)";
		 break;
		  case 5:
		  $secondsql=" where date_sub(curdate(), INTERVAL 180 DAY) <= date(`downtime`)";
		 break;
		  case 6:
		  $secondsql=" where date_sub(curdate(), INTERVAL 365 DAY) <= date(`downtime`)";
		 break;
		  case 7:
		  $secondsql="";
		 break;
		 default:
		  $secondsql="";
	 }
	 if($ifuser==1){
		if($secondsql!="") {
			$secondsql=$secondsql." and downuser like '$userstr'";
		}else{
			$secondsql=" where downuser like '$userstr'";
		}
	 }
	 $sql=$basesql.$secondsql; 
 }
 //计算页数
$res=mysqli_query($con,str_replace("%tj%","count(*) as count",$sql));
$myrow = mysqli_fetch_array($res);
$numrows=$myrow[0];
//计算总页数
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
$pages++;
//判断页数设置与否,如无则定义为首页
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
$rs=mysqli_query($con,str_replace("%tj%","downuser as 下载用户名,fileid,downtime as 下载时间",$sql." order by id desc limit $offset,$pagesize"));
//echo $sql;
closedb($con);
showtable(str_replace("%tj%","downuser as 下载用户名,fileid as 资源名称,ip as 下载IP地址,downtime as 下载时间",$sql." order by id desc limit $offset,$pagesize"));
?>
<ul class="pagination">
<?php
if ($pages>1) {
//计算首页、上一页、下一页、尾页的页数值
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;

	 $link="report.php?flag=$reporttype&dateflag=$dateflag&ifuser=$ifuser&userstr=$userstr&";  

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
      <script src="/js/bootstrap.min.js"></script>
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
	  <Script>
	  </script>
	  <script>
		$(function(){
			  var $i=1;
			function initTableCheckbox() {
				var $thr = $('table thead tr');
								var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
				
				/*将全选/反选复选框添加到表头最前,即增加一列*/
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
					/*阻止向上冒泡,以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击全选框所在单元格时也触发全选框的点击操作*/
				$checkAllTh.click(function(){
					$(this).find('input').click();
				});
				var $tbr = $('table tbody tr');
				var $aaa="bwoption";
				var $checkItemTd = $('<td><input type="checkbox" name="checkItem"  /></td>');
				/*每一行都在最前面插入一个选中复选框的单元格*/
				//$tbr.prepend($checkItemTd);
				/*点击每一行的选中复选框时*/
				$tbr.find('input').click(function(event){
					//$tempstr=$tempstr+","+$( this)[0].id);
					$.get("transfer.php?item="+$( this)[0].id);
					/*调整选中行的CSS样式*/
					$(this).parent().parent().toggleClass('warning');
					/*如果已经被选中行的行数等于表格的数据行数,将全选框设为选中状态,否则设为未选中状态*/
					$checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
					/*阻止向上冒泡,以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击每一行时也触发该行的选中操作*/
				$tbr.click(function(){
					$(this).find('input').click();
				});
			}
			initTableCheckbox();
			// dom加载完毕

		});
		
 		</script>
</body>
<?php include 'interface/footer.php';?>
</html>
