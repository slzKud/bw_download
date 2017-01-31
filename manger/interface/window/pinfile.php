 
 <?php
 include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
 include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
//$_SESSION['transfer']="";
$temp=str_replace("Bwchkid","",$temp);
$temp=substr($temp,1);
$i=0;
if ($temp !="")
{
$sql1="select filename from bw_downtable where id in (".$temp.")";
$rs=loaddb($sql1);
$list="";
while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$list=$row['filename'];
			$i+=1;
  }
  $sql1="select fileid from bw_pinfile where fileid in (".$temp.") and ifok=1";
  
  $rschk=loaddb($sql1);
  if(mysqli_num_rows($rschk) >0){
$flagx=1;
  }else{
$flagx=0;
  }
}
  echo "<input type='hidden' value='$temp' id='loaddapp' />";
 ?>
 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
			<?php
             if($flagx==0){
               echo "置顶文件";
			 }else{
              echo "反置顶文件";
			 } 
			?>
            </h4>
         </div>
         <div class="modal-body">
		 <?php
		 if ($temp != ""){
			 if (strpos($temp,",") === false){
		if($flagx==0){
               echo "你确认要置顶文件‘$list ’吗？";
			 }else{
              echo "你确认要取消文件‘$list ’的置顶状态吗？";
			 } 
			 }else{
				 echo "选太多了...";
				 $temp="";
			 }
		 }else{
			 echo "喂，你还没有选择呢...";
		 }
		 ?>
         </div>
         <div class="modal-footer">
		            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
             <?php if ($temp != "" and $flagx==0 ){echo "<button type='button' class='btn btn-danger' onclick='pinSomething();'>置顶</button>";} ?>
			  <?php if ($temp != "" and $flagx==1 ){echo "<button type='button' class='btn btn-danger' onclick='unpinSomething();'>取消置顶</button>";} ?>
			 <script>
		 function pinSomething(){
			 var delid=document.getElementById("loaddapp").value; 
		$.post('../manger/todo.php', { type: "pin", fileid:delid}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("成功！");
            window.location.reload();		
            break;
         default:
          alert(text);
}
			});
	}
	function unpinSomething(){
			 var delid=document.getElementById("loaddapp").value; 
	$.post('../manger/todo.php', { type: "unpin", fileid:delid}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("成功！");
            window.location.reload();		
            break;
         default:
          alert(text);
}
			});
	}
	function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
	</script>
         </div>
		 
