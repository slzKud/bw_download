<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
$smtpserver=getthesettings('smtpserver');
$smtpport=getthesettings('smtpport');
$emailadress=getthesettings('emailadress');
$emailuser=getthesettings('emailuser');
$emailpass=getthesettings('emailpass');
?>
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             邮件设置
            </h4>
         </div>
         <div class="modal-body">
  <div class="form-group">
    <label for="name">邮箱地址</label>
    <input type="text" class="form-control" placeholder="请输入发送的邮箱,如test@betaworld.cn" name="zytitle" id='emailadress'  value="<?php echo $emailadress; ?>" />
	</div>
	 <div class="form-group">
    <label for="name">SMTP服务器地址</label>
    <input type="text" class="form-control" placeholder="请输入SMTP服务器地址，如smtp.betaworld.cn" name="zytitle" id='smtpserver'  value="<?php echo $smtpserver; ?>" /> 
	</div>  
	 <div class="form-group">
    <label for="name">SMTP服务器端口</label>
    <input type="text" class="form-control" placeholder="请输入SMTP服务器端口，如25" name="zytitle" id='smtpport' value="<?php echo $smtpport; ?>" />
	</div>  
  <div class="form-group">
    <label for="name">邮箱用户名</label>
    <input type="text" class="form-control" placeholder="请输入邮箱用户名，一般是@前面的部分，如test" name="zytitle" id='emailuser' value="<?php echo $emailuser; ?>" />
	</div>  
	<div class="form-group">
    <label for="name">邮箱密码</label>
    <input type="password" class="form-control" placeholder="请输入邮箱密码" name="zytitle" id='emailpass' value="<?php echo $emailpass; ?>" />
	</div>   
	 <button type="button" class="btn btn-success" onclick="TestSomething();">
               测试发送
            </button>
</div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="ModSomething();">
               保存
            </button>
			<script>
			function TestSomething(){
		var toemail=prompt("请输入发送到的邮件地址")
		if (toemail!=""){
		 var emailadress=document.getElementById("emailadress").value; 
		  var smtpserver=document.getElementById("smtpserver").value; 
		  var smtpport=document.getElementById("smtpport").value; 
		   var emailuser=document.getElementById("emailuser").value; 
		    var emailpass=document.getElementById("emailpass").value; 
			 $.post('../manger/todo.php', {type: "mailtest",smtpserver:smtpserver,smtpport:smtpport,emailadress:emailadress,emailuser:emailuser,emailpass:emailpass,to:toemail}, function (text, status) {
			 alert("调试信息:\n"+text);}
			);
			}
		 }
		 function ModSomething(){
		 var emailadress=document.getElementById("emailadress").value; 
		  var smtpserver=document.getElementById("smtpserver").value; 
		  var smtpport=document.getElementById("smtpport").value; 
		   var emailuser=document.getElementById("emailuser").value; 
		    var emailpass=document.getElementById("emailpass").value; 
			 $.post('../manger/todo.php', {type: "modemail",smtpserver:smtpserver,smtpport:smtpport,emailadress:emailadress,emailuser:emailuser,emailpass:emailpass}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("修改成功！");		
            break;
         default:
          alert("修改过程中发生错误，请检查！");
}
			});
		 }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
</script> 
         </div>

