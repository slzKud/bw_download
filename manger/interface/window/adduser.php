 <meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             添加用户
            </h4>
         </div>
         <div class="modal-body">
            <form role="form">
   <div class="form-group">
      <label for="username" class="control-label">用户名</label>

         <input type="text" class="form-control" id="user" name="username"
            placeholder="请输入用户名">
  
   </div>
   <div class="form-group">
   <label for="useremail" class=" control-label">电子邮箱</label>
         <input type="text" class="form-control" id="useremail" name="username"
            placeholder="请输入电子邮箱，输入即代表通过验证。">
   </div>
   
   <div class="form-group">
      <label for="password"  class=" control-label ">密码</label>
 
         <input type="password" class="form-control" id="password" name="userpass"
            placeholder="请输入密码">

   </div>
    <div class="form-group">
      <label for="password"  class="control-label ">确认密码</label>
  
         <input type="password" class="form-control" id="passwordagain" name="userpassagain"
            placeholder="请再次输入密码">
 
   </div>
	<div class="form-group">
	 <label for="name">用户权限</label>
      <select class="form-control" id='bwqx'>
         <option>普通用户</option>
         <option>高级用户</option>
		   <option>VIP</option>
         <option>管理员</option>
      </select>
 
</div>
 </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="AddSomething();">
               添加
            </button>
				<script>
		 function AddSomething(){
		 var username=document.getElementById("user").value; 
		  var userpassword=document.getElementById("password").value; 
		   var userpasswordagain=document.getElementById("passwordagain").value; 
		var useremail=document.getElementById("useremail").value; 
		 //var zylink=document.getElementById("bwlink").value; 
		 var userqxname=document.getElementById("bwqx").value; 
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
     if(trim(username)==""){
      alert("欸，密码无效啊！");
      return 0;
     }
     if(trim(userpassword)==""){
      alert("欸，密码无效啊！");
      return 0;
     }
     if(trim(useremail)==""){
      alert("欸，密码无效啊！");
      return 0;
     }
     		 if(userpassword==userpasswordagain){
		    //alert('用户名:'+username+'\n用户密码：'+userpassword+'\n用户邮箱：'+useremail+'\n用户权限：'+userqx);
			$.post('../manger/todo.php', {type: "adduser",username:username,userpassword:userpassword,useremail:useremail,userqx:userqx }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("添加成功！");
            //window.location.reload();		
            break;
           case "no usrname":
            alert("欸，用户名无效啊！");
          break;id无
		  case "no password":
            alert("欸，密码无效啊！");
          break;
		  case "no userqx":
            alert("欸，权限不对啊！");
          break;
		  case "no email":
            alert("欸，邮箱不对啊！");
          break;
		  case "user added":
            alert("你已经创建过了，换个用户名吧！");
          break;
		  		  case "email added":
            alert("你已经创建过了，换个邮箱吧！");
          break;
		    case "invaild email":
            alert("欸，邮箱不对啊！");
          break;
		   case "Error":
            alert("Opps,发生错误！");
          break;
         default:
          alert("这是啥啊@#￥！\n"+text);
}
			});
		 }else{
		 alert('密码不一致！');
		 }
//alert('资源名称:'+zyname+'\n资源链接:'+zylink+'\n资源权限：'+zyqx);
		 }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
		 </script>
         </div>

