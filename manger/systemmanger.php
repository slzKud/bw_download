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
         <td>测试模式</td>
         <td><input id="switch-state" type="checkbox" name="testmode" checked></td>
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
		
 </script>
</html>