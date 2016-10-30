 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             封禁用户
            </h4>
         </div>
 <?php
 include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
 include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
$_SESSION['transfer']="";
$temp=str_replace("Bwchkid","",$temp);
$temp=substr($temp,1);
if ($temp !="")
{
$sql1="select username,permission from bw_usertable where id in (".$temp.")";
$rs=loaddb($sql1);
$list="";
$i=1;
$per=0;
$ifd=0;
while($row = mysqli_fetch_array($rs, MYSQL_ASSOC))
         {
			$list=$row['username'];
			$per=$row['permission'];
			$i+=1;
  }
  }
  echo "<input type='hidden' value='$list' id='loaddapp' />";
 ?>
         <div class="modal-body">
		 <?php
		 if ($temp != ""){
			 if (strpos($temp,",") === false){
			if($list==veifycookies($_COOKIE["bwuser"])){
				echo "不可以封禁自己哦";
				$temp="";
			}else{ 
			if($per != -1) {
				echo "你确认要封禁'$list'吗？";
			 echo '<br>封禁时长：<br><select class="form-control" id="bwbantime" >
         <option>1天</option>
         <option>30天</option>
		   <option>1年</option>
         <option>永久</option>
      </select>';
			}else{
				$sql="SELECT count(*) as n FROM bw_baneduser where username='$list' and ifclose=1";
				$rschk=loaddb($sql);
		        $row = mysqli_fetch_array($rschk, MYSQL_ASSOC);
				$num=$row['n'];
				//echo $sql;
				//echo $num;
		       if($num !=0){
				   echo "你要解封'$list'吗？这无法撤回。";
				   $ifd=1;
			   }else{
				   echo "未知原因封禁，无法解封";
				$temp="";
			   }
			}
			
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
             <?php if ($temp != "" and $ifd==0 ){echo "<button type='button' class='btn btn-danger' onclick='DelSomething();'>封禁</button>";} ?>
			  <?php if ($temp != "" and $ifd==1 ){echo "<button type='button' class='btn btn-danger' onclick='openSomething();'>解封</button>";} ?>
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
		 
