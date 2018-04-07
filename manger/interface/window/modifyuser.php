 <?php header("Pragma: no-cache"); ?>
 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             修改用户信息
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
	 echo "<input type='hidden' value='$temp' id='loaddapp' />";
	 $sql="select * from bw_usertable where id in ($temp)";
	 //echo $sql;
	 $rs=loaddb($sql);
	 $username="";
	 $email="";
	 $userqx=0;
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$username=$row['username'];
			$email=$row['email'];
			switch($row['permission']){
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
  }
  //echo $userqx;
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
 
 ?>
 
         <div class="modal-body">
            <form role="form">
      <div class="form-group">
	  <label for="useremail" class=" control-label">用户名:<?php echo $username; ?></label>
	  </div>
   <div class="form-group">
   <label for="useremail" class=" control-label">电子邮箱</label>
         <input type="text" class="form-control" id="useremail" name="username" value="<?php echo $email; ?>"
            placeholder="请输入电子邮箱，输入即代表通过验证。">
   </div>
   
   <div class="form-group">
      <label for="password"  class=" control-label ">密码</label>
 
         <input type="password" class="form-control" id="password" name="userpass"
            placeholder="请输入新密码" value="ok,it's a fake password.">

   </div>
	<div class="form-group">
	 <label for="name">用户权限</label>
      <select class="form-control" id='bwqx' >
         <option <?php if($userqx=="普通用户") echo 'selected="selected"'; ?>>普通用户</option>
         <option <?php if($userqx=="高级用户") echo 'selected="selected"'; ?>>高级用户</option>
		   <option <?php if($userqx=="VIP") echo 'selected="selected"'; ?>>VIP</option>
         <option<?php if($userqx=="管理员") echo 'selected="selected"'; ?> >管理员</option>
      </select>
 <script>
		 function ModSomething(){
			 var userid=document.getElementById("loaddapp").value; 
			  var userpassword=document.getElementById("password").value; 
			  var useremail=document.getElementById("useremail").value; 
			  var userqxname=document.getElementById("bwqx").value; 
		  //alert('用户ID:'+userid+'\n用户新密码：'+userpassword+'\n用户邮箱地址：'+useremail+'\n用户权限：'+userqx);
             switch(userqxname)
            {
           case "普通用户":
            var userqx=1;
          break;
		  case "高级用户":
           var userqx=2;
          break;
		   case "VIP":
           var userqx=3;
          break;
		    case "管理员":
          var userqx=4;
          break;
         default:
         var userqx=1;
		 }
		  $.post('../manger/todo.php', {type: "moduser",userid:userid,userpassword:userpassword,useremail:useremail,userqx:userqx }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("修改成功！");
            window.location.reload();		
            break;
           case "no usrid":
            alert("欸，id无效啊！");
          break;
		  case "no password":
            alert("欸，密码无效啊！");
          break;
		  case "no userqx":
            alert("欸，权限不对啊！");
          break;
		    case "no userqx":
            alert("欸，权限不对啊！");
          break;
		  case "no email":
            alert("欸，邮箱不对啊！");
          break;
		  case "no change":
            alert("万物皆未改变！");
          break;
		    case "invaild email":
            alert("欸，邮箱不对啊！");
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
 </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="ModSomething();">
               修改
            </button>
         </div>
		 

