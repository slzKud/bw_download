<?php
include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
$lowftp=getthesettings('lowftpper','0');
$ftpserveradress=getthesettings('ftpserveradress','');
$ftpuser1=getthesettings('ftpuser1','');
$ftpuser2=getthesettings('ftpuser2','');
$ftpuser3=getthesettings('ftpuser3','');
$ftpuser4=getthesettings('ftpuser4','');
?>
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             FTP对接设置  - Gene 6
            </h4>
         </div>
         <div class="modal-body">
  <div class="form-group">
    <label for="name">FTP服务器地址</label>
    <input type="text" class="form-control" placeholder="FTP服务器地址，显示在FTP信息页面" name="zytitle" id='ftpadress' value="<?php echo $ftpserveradress; ?>">
	</div>
	<div class="form-group">
	 <label for="name">最低拥有FTP的用户组</label>
      <select class="form-control" id='bwqx'>
         <option <?php if($lowftp==1) echo 'selected="selected"'; ?>>普通用户</option>
         <option <?php if($lowftp==2) echo 'selected="selected"'; ?>>高级用户</option>
		   <option <?php if($lowftp==3) echo 'selected="selected"'; ?>>VIP</option>
         <option <?php if($lowftp==4) echo 'selected="selected"'; ?>>管理员</option>
      </select>
</div> 
	 <div class="form-group">
    <label for="name">普通用户组的公用FTP账户</label>
    <input type="text" class="form-control" placeholder="请输入普通用户组的公用FTP账户，登录FTP服务器时的设置以该用户的设置为准。" name="zytitle" id='ftp1' value="<?php echo $ftpuser1; ?>">
	</div> 
<div class="form-group">
    <label for="name">高级用户组的公用FTP账户</label>
    <input type="text" class="form-control" placeholder="请输入高级用户组的公用FTP账户，登录FTP服务器时设置以该用户的设置为准。" name="zytitle" id='ftp2' value="<?php echo $ftpuser2; ?>">
	</div>  
<div class="form-group">
    <label for="name">VIP用户组的公用FTP账户</label>
    <input type="text" class="form-control" placeholder="请输入VIP用户组的公用FTP账户，登录FTP服务器时候的设置以该用户的设置为准。" name="zytitle" id='ftp3' value="<?php echo $ftpuser3; ?>">
	</div>  
<div class="form-group">
    <label for="name">管理员用户组的公用FTP账户</label>
    <input type="text" class="form-control" placeholder="请输入管理员组的公用FTP账户，登录FTP服务器时的设置以该用户的设置为准。" name="zytitle" id='ftp4' value="<?php echo $ftpuser4; ?>">
	</div>  	
	<div class="form-group">
    *最低用户组如果设置为普通用户以外的组别，低于此组别的FTP公用账户设置无法应用。<br>
	*此设置只适用于使用Gene6 FTP server搭建的FTP服务器;关于FTP服务器端的设置，请参照安装文档。
	</div>  	
	
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
		  function ModSomething(){
			 var ftpadress=document.getElementById("ftpadress").value; 
			  var userqxname=document.getElementById("bwqx").value; 
			  var ftpuser1=document.getElementById("ftp1").value; 
			  var ftpuser2=document.getElementById("ftp2").value; 
			  var ftpuser3=document.getElementById("ftp3").value; 
			  var ftpuser4=document.getElementById("ftp4").value; 
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
		  $.post('../manger/todo.php', {type: "modftp",ftpserveradress:ftpadress,lowftp:userqx,ftpuser1:ftpuser1,ftpuser2:ftpuser2,ftpuser3:ftpuser3,ftpuser4:ftpuser4 }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("修改成功！");
			$.post('todo.php', { type: "ftpreset"}); //重置FTP
            window.location.reload();		
            break;
         default:
          alert("这是啥啊@#￥！\n"+text);
}
			});
		 }
		  function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
</script> 
         </div>

