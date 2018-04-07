 
 <?php
 include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
 include_once dirname(dirname(dirname(dirname(__FILE__)))).'/module/cookiesmaker.php';
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


if ($temp !="")
{
$sql1="select id,username from bw_admituser where id in (".$temp.")";
$rs=loaddb($sql1);
$list="";
$i=1;
$per=0;
//$ifd=0;
while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$list=$list."<br>".$i.".审核ID号'".$row['id']."'：关于'".$row['username']."'用户的更改用户组审核";
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
             <?php if ($temp != "" and $ifd==0 ){echo "<button type='button' class='btn btn-primary' onclick='openSomething();'>同意</button>";} ?>
			  <?php if ($temp != "" and $ifd==1 ){echo "<button type='button' class='btn btn-primary' onclick='rejectSomething();'>否决</button>";} ?>
			 <script>
	function openSomething(){
			 var delid=document.getElementById("loaddapp").value; 
			 var strs= new Array(); //定义一数组 
			 var k=0;
			 var j=0;
            strs=delid.split(","); 
            for (i=0;i<strs.length ;i++ ) 
{ 
	k=k+1;
$.ajax({ 
type:"POST", 
cache : false, 
async : false,
url:'../manger/todo.php', 
data:"type=admituser&id="+strs[i], 
success:function (text, status) {
			switch(trim(text))
            {
            case "ok":
            j=j+1;	
            break;
         default:
          alert(text);
}
			}});

}
console.log(j);
console.log(k);
if(j==k){
alert('操作成功！');
window.location.reload();
}else{
	alert('操作失败！');
}
	
	window.location.reload();	
	}
	function rejectSomething(){
			 var delid=document.getElementById("loaddapp").value; 
			 var strs= new Array(); //定义一数组 
			 var k=0;
			 var j=0;
            strs=delid.split(","); 
            for (i=0;i<strs.length ;i++ ) 
{ 
	k=k+1;
$.ajax({ 
type:"POST", 
cache : false, 
async : false,
url:'../manger/todo.php', 
data:"type=rejectuser&id="+strs[i], 
success:function (text, status) {
			switch(trim(text))
            {
            case "ok":
            j=j+1;	
            break;
         default:
        // alert(text);
		console.log(text);
}
			}});

}
console.log(j);
console.log(k);
if(j==k){
alert('操作成功！');
window.location.reload();
}else{
	alert('操作失败！');
}
	
	window.location.reload();	
	}
	function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
	</script>
         </div>
		 
