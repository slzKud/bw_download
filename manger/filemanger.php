<html>
<?php 
$nowpageid=2;
include 'interface/header.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
empty($tioajian)&&$tiaojian="";
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
$nowpageid=2;
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
<div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-xs-8 text-left">

	  <div class="panel-body">
    <div class="container">
      <h1>�ļ�����</small></h1>
	  <hr>
	   
		<div class="container">
		 <a href="interface/window/add.html"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-primary">����ļ�</button></a>
		<a href="interface/window/del.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-danger">ɾ���ļ�</button></a>
		<?php
 
 ////�趨ÿһҳ��ʾ�ļ�¼��
$pagesize=8;
 $con=connectdb();
  mysqli_query($con,"set names 'utf8'");
 //����sql
 if(empty($tiaojian)){
	  $sql="select %tj% from bw_downtable ";  
 }else{
	 $sql="select %tj% from bw_downtable and filename like '%".$tiaojian."%'";  
 }
 //����ҳ��
$res=mysqli_query($con,str_replace("%tj%","count(*) as count",$sql));
$myrow = mysqli_fetch_array($res);
$numrows=$myrow[0];
//������ҳ��
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
$pages++;
//�ж�ҳ�����������������Ϊ��ҳ
if (!isset($page))
$page=1;
//�ж�ת��ҳ��
if (isset($ys))
if ($ys>$pages)
$page=$pages;
else
$page=$ys;
//�����¼ƫ����
$offset=$pagesize*($page-1);
$rs=mysqli_query($con,str_replace("%tj%","id,Filename,Download,adddate,Permisson",$sql." order by id desc limit $offset,$pagesize"));
//echo $sql;
closedb($con);
?>
 <table class="table table-hover">
   <thead>
      <tr>
	     
         <th>��Դ����</th>
         <th>���ʱ��</th>
         <th>����Ȩ��</th>
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
            echo "<td id ='BwStrid".$row['id']."'>" . $row['Filename'] . "</td>";
            echo "<td>" . $row['adddate'] . "</td>";
			echo "<td>" .$row['Permisson']."</td>";
            echo "</tr>";
			$i+=1;
  }

	  ?>

   </tbody>
</table>

<ul class="pagination">
<?php
if ($pages>1) {
//������ҳ����һҳ����һҳ��βҳ��ҳ��ֵ
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if(empty($tiaojian)){
	  $link="filemanger.php?";  
 }else{
	 $link="filemanger.php?findstr=$tiaojian&";  
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
</div>
</div>
<!-- ���ģ̬��Modal�� -->
<div  id="MyModal"  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none;">
   <div class="modal-dialog">
  <div class="modal-content">
 
 </div>
     </div>
</div><!-- /.modal -->
<!-- jQuery (Bootstrap �� JavaScript �����Ҫ���� jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- ���������ѱ���Ĳ�� -->
      <script src="/js/bootstrap.min.js"></script>
	  <script>
	  $nowid="aaa"
	 var $tempstr="";

	//������Ϣ
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
	  function LoadAddWindows(){
		$("#myModal").modal({  
    remote: "interface/window/del.php?temp="+$tempstr 
	});  

		}
		function setCookie(name,value)
{
var exp = new Date();
exp.setTime(exp.getTime() + 2*60*1000);
document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function delCookie(name)
{
var exp = new Date();
exp.setTime(exp.getTime() - 1);
var cval=getCookie(name);
if(cval!=null)
document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

	  </script>
	  <script>
		$(function(){
			  var $i=1;
			function initTableCheckbox() {
				var $thr = $('table thead tr');
								var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
				
				/*��ȫѡ/��ѡ��ѡ����ӵ���ͷ��ǰ��������һ��*/
				$thr.prepend($checkAllTh);
				/*��ȫѡ/��ѡ����ѡ��*/
				var $checkAll = $thr.find('input');
				$checkAll.click(function(event){
					/*�������е�ѡ��״̬���ȫѡ���ѡ��״̬*/
					$tbr.find('input').prop('checked',$(this).prop('checked'));
					/*����������ѡ���е�CSS��ʽ*/
					if ($(this).prop('checked')) {
						$tbr.find('input').parent().parent().addClass('warning');
					} else{
						$tbr.find('input').parent().parent().removeClass('warning');
					}
					/*��ֹ����ð�ݣ��Է��ٴδ����������*/
					event.stopPropagation();
				});
				/*���ȫѡ�����ڵ�Ԫ��ʱҲ����ȫѡ��ĵ������*/
				$checkAllTh.click(function(){
					$(this).find('input').click();
				});
				var $tbr = $('table tbody tr');
				var $aaa="bwoption";
				var $checkItemTd = $('<td><input type="checkbox" name="checkItem"  /></td>');
				/*ÿһ�ж�����ǰ�����һ��ѡ�и�ѡ��ĵ�Ԫ��*/
				//$tbr.prepend($checkItemTd);
				/*���ÿһ�е�ѡ�и�ѡ��ʱ*/
				$tbr.find('input').click(function(event){
					//$tempstr=$tempstr+","+$( this)[0].id);
					$.get("transfer.php?item="+$( this)[0].id);
					/*����ѡ���е�CSS��ʽ*/
					$(this).parent().parent().toggleClass('warning');
					/*����Ѿ���ѡ���е��������ڱ���������������ȫѡ����Ϊѡ��״̬��������Ϊδѡ��״̬*/
					$checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
					/*��ֹ����ð�ݣ��Է��ٴδ����������*/
					event.stopPropagation();
				});
				/*���ÿһ��ʱҲ�������е�ѡ�в���*/
				$tbr.click(function(){
					$(this).find('input').click();
				});
			}
			initTableCheckbox();
			// dom�������

		});
		
 		</script>
 


		

</body>
<?php include 'interface/footer.php';?>
</html>
