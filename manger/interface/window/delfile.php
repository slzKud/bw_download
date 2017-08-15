 <?php
 include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
//$_SESSION['transfer']="";
if ($temp !="")
{
$sql1="select Filename from bw_downtable where id in (".$temp.")";
$rs=loaddb($sql1);
$list="";
$i=1;
while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$list=$list."<br>".$i.".".$row['Filename'];
			$i+=1;
  }
  }
  echo "<input type='hidden' value='$temp' id='loaddapp' />";
  function showzd($id){
     $sql1="select fileid from bw_pinfile where fileid in (".$id.") and ifok=1";
  $rschk=loaddb($sql1);
  if(mysqli_num_rows($rschk) >0){
return 1;
  }else{
return -1;
  }
 }
 ?>
 
 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             删除
            </h4>
         </div>
         <div class="modal-body">
		 <?php
		 if ($temp != ""){
			 echo 'Are you Ok?你确认要删除下面的东西吗：'.$list;
		 }else{
			 echo "喂，你还没有选择呢...";
		 }
		 ?>
         </div>
         <div class="modal-footer">
		            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
             <?php if ($temp != ""){echo "<button type='button' class='btn btn-danger' onclick='DelSomething();'>删除</button>";} ?>
			 <script>
		 function DelSomething(){
			 var delid=document.getElementById("loaddapp").value; 
		$.post('../manger/todo.php', { type: "delfiles", filelist: delid }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("删除成功！");
            window.location.reload();		
            break;
           case "no filelist":
            alert("欸，你没写删除列表哦！");
          break;
		   case "Error":
            alert("Opps,发生错误！");
          break;
         default:
          alert("这是啥啊@#￥！");
}
			});
	}
	function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
	</script>
         </div>
		 
