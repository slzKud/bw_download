<html>
<?php 
$nowpageid=3;
include 'interface/header.php';
include_once dirname(dirname(__FILE__)).'/module/cookiesmaker.php'; 
empty($tioajian)&&$tiaojian="";
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($_GET['px'])&&$_GET['px']="username";
empty($_GET['sc'])&&$_GET['sc']="desc";
$desc=$_GET['sc'];
if($desc!="asc" and $desc !="desc"){$desc="desc";}
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<body>
 <div class="container-fluid">
        <div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-md-10 text-left">
		  <div class="panel panel-default">

   <div class="panel-body">
    <div class="container">
      <h1>用户管理</small></h1>
	  <hr>
	   
		<div class="container">
		<form class="form-inline" role="form" action="usermanger.php" method="get">
		 <a href="interface/window/adduser.php"  data-toggle="modal"  data-target="#MyModal"><button type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加用户</button> </a>   
<a onclick="selectid('interface/window/modifyuser.php');" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span> 修改用户信息</button> </a>	 
		<a onclick="selectid('interface/window/deluser.php');"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> 删除用户</button></a>	 
		<a onclick="selectid('interface/window/banuser.php');"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-Ban-circle"></span> 封禁/解封用户</button></a>	 
		 <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="findstr" value='<?php echo $tiaojian;?>'>
         <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> 搜索</button>
</form>
</div>
</div>
<br>
	<table id="th"  class="table">
                        <thead>
                        <tr>
                            <td style="width: 20px">
                                 <input type="checkbox" class="checkall" />
                            </td>
                        
                            <td class="sortable-column">用户名</td>
														<td class="sortable-column">权限</td>
	
														<td class="sortable-column">注册时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>30元公共区100G</td>
                            <td>30y100g.php</td>
							 <td>30y100g.php</td>
                        </tr>
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>30元公共区100G</td>
                            <td>30y100g.php</td>
							 <td>30y100g.php</td>
                        </tr>
                        </tbody>
                    </table>
					
</div>
</div>

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
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
       <script src="docs/js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
	  <script src="/js/jquery.dataTables.min.js"></script>
      <script src="/js/dataTables.bootstrap.js"></script>
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

   $(document).ready(function() {
    $('#th').dataTable( {
		'language': {    
            'emptyTable': '没有可以显示的数据',    
            'loadingRecords': '加载中...',    
            'processing': '查询中...',    
            'search': '搜索:',    
            'lengthMenu': '每页 _MENU_ 条记录',    
            'zeroRecords': '没有数据',    
            'paginate': {      
                    'next':       '下一页',    
                    'previous':   '上一页'    
                    },    
            'info': '第 _PAGE_ 页 / 共 _PAGES_ 页',    
            'infoEmpty': '没有数据',    
            'infoFiltered': '(从 _MAX_ 条记录中筛选)'    
        } ,
        "processing": true,
        "serverSide": true,
        "ajax": "query/user.php",
        "columns": [
   {
                 "sClass": "text-center",
                 "data": 0,
                 "render": function (data, type, full, meta) {
                     return '<input type="checkbox"  class="checkchild"  value="' + data + '" />';
                 },
                 "bSortable": false
             },
             null,
             null,
						 null
						
  ]
    } );
} );
function selectid(page){
	var arrs=new Array();
	$(".checkchild:checked").each(function(index,data){ 
//console.info($( data ).val()); 
//或者console.info($(this).text()); 
arrs.push($( data ).val());
})
var id = arrs.join(",");
 $.post('todo.php?r='+Math.random(), {p:id,type:"transfer"}, function (text, status) {
			if(trim(text)=="ok"){
               //showDialog("dialog-ajaxa");
			   $("#MyModal").modal({  
               remote: page 
              });  
            }else{
              alert("传输文本失败");
            }
            
      });
}
function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
</script>
	  
</body>
<?php include 'interface/footer.php';?>
</html>
