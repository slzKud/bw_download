<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             修改资源
            </h4>
         </div>
         <?php
 include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
//$_SESSION['transfer']="";
if ($temp =="")
{
	  echo '<div class="modal-body">
	  你咋啥都没选呢~
	  </div>
	  <div class="modal-footer"> 
	  <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
			</div>';
	  exit; 
	  }
if (strpos($temp,",") === false){
	 echo "<input type='hidden' value='$temp' id='loadapp' />";
	 $sql="select * from bw_downtable where id in ($temp)";
	 //echo $sql;
	 $rs=loaddb($sql);
	 $filename="";
	 $downaddress="";
   $fileqx=0;
   $chkid="fake";
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$filename=$row['FileName'];
      $downaddress=$row['Download'];
      $chkid=$row['chkid'];
			switch($row['Permisson']){
        case '0':
				$fileqx="普通用户";
				  break;
				case '1':
				$fileqx="普通用户";
				  break;
				case '2':
				$fileqx="高级用户";
				  break;
				case '3':
				$fileqx="VIP";
				  break;
				case '4':
				$fileqx="机密";
				  break;
				 default:
				$fileqx="未知";
				  break;
			}
  }
  //echo $fileqx;
}else{
	echo '<div class="modal-body">
	哎呀，怎么选了好多个咯~只能选一个的啊，哇乎~</div>
	  <div class="modal-footer"> 
	  <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
			</div>';
	exit;
  }
  echo "<input type='hidden' value='$filename' id='yuanwj' />";
 ?>
         <div class="modal-body">
            <form role="form">
  <div class="form-group">
    <label for="name">资源名称</label>
    <input type="text" class="form-control" placeholder="请输入资源名称" name="zytitle" id='bwname' value='<?php echo $filename; ?>'>
	</div>
	  <div class="form-group">
    <label for="name">资源地址</label>
    <input type="text" class="form-control" placeholder="请输入资源下载时跳转的下载地址" name="zylink" id="bwlink" value='<?php echo $downaddress; ?>'>
	</div>
	<div class="form-group">
	 <label for="name">资源下载权限</label>
      <select class="form-control" id='bwqx'>
         <option <?php if($fileqx=="游客") echo 'selected="selected"'; ?>>游客</option>
         <option <?php if($fileqx=="普通用户") echo 'selected="selected"'; ?>>普通用户</option>
         <option <?php if($fileqx=="高级用户") echo 'selected="selected"'; ?>>高级用户</option>
		   <option <?php if($fileqx=="VIP") echo 'selected="selected"'; ?>>VIP</option>
         <option <?php if($fileqx=="机密") echo 'selected="selected"'; ?>>机密</option>
      </select>
 
</div>
<div class="form-group">
    <label for="name">资源分类选择</label>
    <select class="form-control" id="chkselect">
   <option value="fake">请选择分类类别</option>
   <?php
    $sql="select chkid,chkname from bw_chkid where motherid=''";
    //echo $sql;
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)> 0){
        while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
           if($row['chkid']==$chkid){
            echo "<option value = '".$row['chkid']."' selected='selected'>".$row['chkname']."</option>";
           }else{
            echo "<option value = '".$row['chkid']."' >".$row['chkname']."</option>";
           }
			
  }
    }else{
        echo "<option>分类未找到</option>";
    }
    ?>
    </select>
	</div>
 </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="ModSomething();">
               修改
            </button>
			<script>
		 function ModSomething(){
      var zyid=document.getElementById("loadapp").value;
		 var zyname=document.getElementById("bwname").value; 
		 var zylink=document.getElementById("bwlink").value; 
     var zyqxname=document.getElementById("bwqx").value; 
     var chkid=$("#chkselect").val();
     var sf=scanfile(zyname);
     if(chkid=="fake"){
       alert("必须选择一个类型");
       return 0;
     }
     if(sf=="yes"){
       alert("文件名已重复，请换个文件名吧～");
       return 0;
     }
		 switch(zyqxname)
            {
            case "游客":
            var zyqx=0;
            break;
           case "普通用户":
            var zyqx=1;
          break;
		  case "高级用户":
           var zyqx=2;
          break;
		   case "VIP":
           var zyqx=3;
          break;
		    case "机密":
          var zyqx=4;
          break;
         default:
         var zyqx=0;
		 }
		    $.post('../manger/todo.php', { type: "modfile",zyid:zyid,zyname:zyname,zylink:zylink,zyqx:zyqx,chkid:chkid }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("修改成功！");
            window.location.reload();		
            break;
           case "no name":
            alert("欸，你没写名字啊！");
          break;
		  case "no link":
            alert("欸，链接无效啊！");
          break;
		  case "no qx":
            alert("欸，权限不对啊！");
          break;
		   case "Error":
            alert("Opps,发生错误！");
          break;
         default:
          alert("这是啥啊@#￥！");
}
			});

//alert('资源名称:'+zyname+'\n资源链接:'+zylink+'\n资源权限：'+zyqx);
		 }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
function scanfile(filename){
  var zyoldname=document.getElementById("yuanwj").value; 
  if(zyoldname==filename){
    return "no";
  }
      var f="";
    $.ajax({
        type:"POST",
        url:"todo.php",
        data:"type=scanfile&chkname="+filename,
        async:false,
        success:function(data){
            f=trim(data);
        }
      });
      return f;
    }
</script> 
         </div>

