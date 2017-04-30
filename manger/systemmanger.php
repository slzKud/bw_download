<!DOCTYPE html>
<html lang="zh-cn">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Turn checkboxes and radio buttons into toggle switches.">
    <meta name="author" content="Mattia Larentis, Emanuele Marchi and Peter Stein">
    <link href="docs/css/bootstrap.min.css" rel="stylesheet">
    <link href="docs/css/highlight.css" rel="stylesheet">
    <link href="dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
    <link href="docs/css/main.css" rel="stylesheet">
  </head>
  <?php 
$nowpageid=4;
include 'interface/header.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
$nowpageid=4;
//echo getthesettings("optmode");
?>
  <body>
       <div class="container-fluid">
        <div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-md-10 text-left">

	  <div class="panel-body">
	  <div class="container">
      <h1>系统设置</small></h1>
	  <hr>
    <div class="container">
            <table class="table table-striped">
   <tbody>
      <tr>
         <td>维护模式（关闭网站）</td>
         <td><input id="switch-state" type="checkbox" name="testmode"  <?php if(getthesettings("optmode")==="1"){echo 'checked';} ?>></td>
      </tr>
	  <tr>
         <td>关闭注册</td>
         <td><input id="switch-state" type="checkbox" name="closereg" <?php if(getthesettings("closereg")==="1"){echo 'checked';} ?>></td>
      </tr>
	   <tr>
         <td>开启用户组审核</td>
         <td><input id="switch-state" type="checkbox" name="opensh" <?php if(getthesettings("opensh")==="1"){echo 'checked';} ?>></td>
      </tr>
      <tr>
         <td>邮件发送设置</td>
         <td><a href="interface/window/email.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-warning">设置</button></a></td>
      </tr>
	  <tr>
         <td>反馈到邮箱地址</td>
        <td> <form class="form-inline" role="form" ><input type="text" class="form-control" id="fkemail" name="username" value="<?php echo getthesettings("fkemail"); ?>"
            placeholder="请输入电子邮箱，输入即代表通过验证。" /><button type="button" class="btn btn-primary" onclick="Modthefkemail();" >保存</button></form></td>
      </tr>
	  <tr>
         <td>开启FTP服务器对接功能</td>
         <td><input id="mySwitch" type="checkbox" name="ftpon" <?php if(getthesettings("optftp")==="1"){echo 'checked';} ?> /></td>
      </tr>
       <tr>
         <td>FTP对接模式</td>
         <td><select class="form-control" name="new" onchange="s(this)">
         
        <option <?php if(getthesettings("ftpmode")==="1"){echo 'selected="selected"';} ?>> Gene6 Ftp DB 验证</option>
         <option  <?php if(getthesettings("ftpmode")==="2"){echo 'selected="selected"';} ?>  >Betaworld FTPWatchdog 增强认证</option>
      </select></td>
      </tr>
      
	   <tr>
         <td>FTP对接设置</td>
         <td><a href="interface/window/ftpset.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-warning">设置</button></a></td>
      </tr>
	   <tr>
         <td>FTP重置</td>
         <td><a href="interface/window/ftpreset.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-warning">重置</button></a></td>
      </tr>
	  <tr>
         <td>开启统计代码功能</td>
         <td><input id="mySwitch" type="checkbox" name="opentjcode" <?php if(getthesettings("optthetj")==="1"){echo 'checked';} ?> /></td>
      </tr>
	    <tr>
         <td>统计代码</td>
		
         <td> <a href="interface/window/tjdm.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-primary">设置</button></a></td>
      </tr>
      <tr>
         <td>服务器状态回调密钥</td>
        <td> <form class="form-inline" role="form" ><input type="password" class="form-control" id="serverkey" name="username" value="<?php echo getthesettings("serverkey"); ?>"
            placeholder="请输入密钥，建议6个字符以上。" /><button type="button" class="btn btn-primary" onclick="Modtheserverkey();" >保存</button></form></td>
      </tr>
      <tr>
         <td>登录充值卡回调页面</td>
        <td> <form class="form-inline" role="form" ><input type="text" class="form-control" id="gocard" name="username" value="<?php echo getthesettings("gocard"); ?>"
            placeholder="请输入回调地址，用于跳转到充值界面（仅FTP模式2下可用）。" /><button type="button" class="btn btn-primary" onclick="Modthecard();" >保存</button></form></td>
      </tr>
      <tr>
         <td>开启充值卡页面</td>
         <td><input id="mySwitch" type="checkbox" name="opencard" <?php if(getthesettings("opencard")==="1"){echo 'checked';} ?> /></td>
      </tr>
   </tbody>
</table>
        </div>
      </div>
	  </div>
	  <!-- 添加模态框（Modal） -->
<div  id="MyModal"  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display:none;">
   <div class="modal-dialog">
  <div class="modal-content">
 
 </div>
     </div>
</div><!-- /.modal -->
    <script src="docs/js/jquery.min.js"></script>
    <script src="docs/js/bootstrap.min.js"></script>
    <script src="docs/js/highlight.js"></script>
    <script src="dist/js/bootstrap-switch.js"></script>
    <script src="docs/js/main.js"></script>
	<?php include 'interface/footer.php';?>
  </body>
  	  <script>
	  $nowid="aaa"
	 var $tempstr="";

	//传递信息
	$("[data-toggle='modal']").click(function(){
 var _target = $(this).attr('data-target')
 t=setTimeout(function () {
 var _modal = $(_target).find(".modal-dialog")
 _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )
 },200)
 })


   $(function () { $('#MyModal').on('hide.bs.modal', function () {
	    $(this).removeData("bs.modal");
	  })
   });
   
 //绑定开关事件
 $('input[name="testmode"]').on('switchChange.bootstrapSwitch', function(event, state) {
  console.log(state); // true | false
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "opt",t:s});
});
$('input[name="ftpon"]').on('switchChange.bootstrapSwitch', function(event, state) {
  console.log(state);
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "optftp",t:s});
});

$('input[name="closereg"]').on('switchChange.bootstrapSwitch', function(event, state) {
	console.log(state);
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "closereg",t:s});
});
$('input[name="opencard"]').on('switchChange.bootstrapSwitch', function(event, state) {
	console.log(state);
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "opencard",t:s});
});
$('input[name="opensh"]').on('switchChange.bootstrapSwitch', function(event, state) {
	console.log(state);
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "opensh",t:s});
});
$('input[name="opentjcode"]').on('switchChange.bootstrapSwitch', function(event, state) {
	console.log(state);
  if (state==false){
	  var s="off"
  }else{
	  var s=1
  }
   $.post('todo.php', {type: "optthetj",t:s});
});
</script>
 <script>
 	function Modthefkemail(){
		var toemail=document.getElementById("fkemail").value; 
		if (toemail!=""){
			 $.post('todo.php', {type: "modtofk",to:toemail}, function (text, status) {
			 alert("保存成功");}
			);
			}
		 }
function Modtheserverkey(){
		var toemail=document.getElementById("serverkey").value; 
		if (toemail!=""){
			 $.post('todo.php', {type: "modtoserverkey",to:toemail}, function (text, status) {
			 alert("保存成功");}
			);
			}
		 }
     function Modthecard(){
		var toemail=document.getElementById("gocard").value; 
		if (toemail!=""){
			 $.post('todo.php', {type: "modtogocard",to:toemail}, function (text, status) {
			 alert("保存成功");}
			);
			}
		 }
		function s(obj){
		var t=obj.value; 
   	//alert(t);
    if (t=="Gene6 Ftp DB 验证"){
  var s=1;
}else{
  var s=2;
}
	 $.post('todo.php', {type: "ftpmode",mode:s}, function (text, status) {
			 alert("保存成功!请刷新后进行配置");
       });
			}

 </script>
</html>