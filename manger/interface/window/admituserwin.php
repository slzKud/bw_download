 
 <?php
 include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
 include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
empty($_GET['mode'])&& $_GET['mode']="a";
$temp=$_SESSION['transfer'];
//echo $_GET['mode'];
$ifd=2;
if($_GET['mode']=="a"){
	$ifd=0;
}
if($_GET['mode']=="d"){
	$ifd=1;
}
$_SESSION['transfer']="";
$temp=str_replace("Bwchkid","",$temp);
$temp=substr($temp,1);
if ($temp !="")
{
$sql1="select id,username from bw_admituser where id in (".$temp.")";
$rs=loaddb($sql1);
$list="";
$i=1;
$per=0;
//$ifd=0;
while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$list=$list."<br>".$i.".审核ID号'".$row['id']."'：关于'".$row['username']."'用户的提升用户组审核";
			$i+=1;
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
			if($ifd==0){
				echo "同意用户审核";	 
		
			 }
		if($ifd==1){
				echo "否决用户审核";	 

			 }
			 ?>
            </h4>
         </div>
         <div class="modal-body">
		 <?php
		 if ($temp != ""){
			 if($ifd==0){
				echo "你确认要同意以下用户的审核吗？";	 
		echo $list; 
			 }
		if($ifd==1){
				echo "你确认要否决以下用户的审核吗？";	 
		echo $list; 
			 }
		 }else{
			 echo "喂，你还没有选择呢...";
			 $temp="";
		 }
		 ?>
         </div>
         <div class="modal-footer">
		            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
             <?php if ($temp != "" and $ifd==0 ){echo "<button type='button' class='btn btn-primary' onclick='DelSomething();'>同意</button>";} ?>
			  <?php if ($temp != "" and $ifd==1 ){echo "<button type='button' class='btn btn-primary' onclick='openSomething();'>否决</button>";} ?>
			 <script>
		 function DelSomething(){
			 var delid=document.getElementById("loaddapp").value; 
			 var btimes=document.getElementById("bwbantime").value; 
			  switch(btimes)
            {
           case "1天":
            var btime=24*60*60;
          break;
		  case "30天":
           var  btime=24*60*60*30;
          break;
		   case "1年":
           var  btime=3;
          break;
		    case "永久":
          var  btime=-1;
          break;
         default:
         var btime=24*60*60;
		 }
		$.post('../manger/todo.php', { type: "banuser", username: delid ,timeplus: btime}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("封禁成功！");
            window.location.reload();		
            break;
           
         default:
          alert(text);
}
			});
	}
	function openSomething(){
			 var delid=document.getElementById("loaddapp").value; 
		$.post('../manger/todo.php', { type: "unbanuser", username: delid}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("解封成功！");
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
		 
