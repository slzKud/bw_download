<html>
<?php
$nowpageid=7;
//echo $nowpageid;
include dirname(__FILE__).'/interface/header.php';
include_once  dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once dirname(dirname(__FILE__)).'/module/cookiesmaker.php'; 
empty($tioajian)&&$tiaojian="";
empty($_GET['findstr'])&&$_GET['findstr']="";
empty($_GET['px'])&&$_GET['px']="filename";
empty($_GET['sc'])&&$_GET['sc']="desc";
$desc=$_GET['sc'];
if($desc!="asc" and $desc !="desc"){$desc="desc";}
empty($_GET['pageid'])&&$_GET['pageid']=1;
empty($page)&&$page=1;
$tiaojian=test_input($_GET['findstr']);
$page=$_GET['pageid'];
$nowpageid=7;
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
<?php include 'interface/sidebar.php';//echo $nowpageid;?>

<div class="col-md-10 text-left">

	  <div class="panel-body">
    <div class="container">
      <h1>资源类型管理</small></h1>
	  <hr>
	   
		<div class="container">
	 <a onclick="addchk();"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-Plus"></span> 添加类型</button></a>
	<a onclick="modchk();" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-Pencil"></span> 修改类型名称</button></a>
    <a onclick="alert('施工中...');" ><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-Trash"></span> 删除类型</button></a>
</div>
<br>
 <table id="th"  class="table">
                        <thead>
                        <tr>
                            <td style="width: 20px">
                                 <input type="checkbox" class="checkall" />
                            </td>
                            <td class="sortable-column">类型名称</td>
                            <td>类型ID</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="width: 20px">
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>30元公共区100G</td>
                            <td>30y100g.php</td>
                        </tr>
                        <tr>
                            <td style="width: 20px">
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>999元B-side100G</td>
                            <td>999y1000gb.php</td>
                        </tr>
                        </tbody>
                    </table>
</div>
</div>
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
      <script src="/js/bootstrap.min.js"></script>

	  <script src="/js/jquery.dataTables.min.js"></script>
      <script src="/js/dataTables.bootstrap.js"></script>
      <script src="/js/fnReloadAjax.js"></script>
	  <script>
	  $nowid="aaa"
	 var $tempstr="";
    var dt;
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
   
     $(".checkall").click(function () {
      var check = $(this).prop("checked");
      $(".checkchild").prop("checked", check);
});

                    $(document).ready(function() {
    dt=$('#th').dataTable( {
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
        "ajax": "query/chk.php",
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
             null
  ]
    } );
});

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
			   $("#addMyModal").modal({  
               remote: page 
              });  
            }else{
              alert("传输文本失败");
            }
            
      });
}
function addchk(){
var chkid=prompt("请输入类型名称");
if(trim(chkid)==""){
    alert("类型输入为空！");
    return 0;
}else{
    $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=addchk&chkname="+chkid,
    async:false,
    success:function(data){
       if(data=="ok"){
        alert('修改成功！');
        reftable();
       }
       if(data=="exists"){
        alert('要添加的类型已经存在');
        return 0;
       }
    }
  });
}
}
function modchk(){
var arrs=new Array();
	$(".checkchild:checked").each(function(index,data){ 
arrs.push($( data ).val());
})
var id = arrs.join(",");
if(id==""){
    alert("未选择要更改的项");
    return 0;
}
if(id.indexOf(",")!=-1){
    alert("选择项目过多");
    return 0;
}
var modchkid=prompt("请输入修改后的类型名字：");
if(trim(modchkid)==""){
    alert("类型输入为空！");
    return 0;
}else{
    $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=modchk&chkid="+id+"&chkname="+modchkid,
    async:false,
    success:function(data){
       if(data=="ok"){
        alert('修改成功！');
        reftable();
       }
       if(data=="chk invild"){
        alert('修改的类型不存在');
        return 0;
       }
    }
  });
}
}
function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
function reftable(){
    dt.fnReloadAjax();
}
</script>
	  <Script>
	  </script>
	


		

</body>
<?php include 'interface/footer.php';?>
</html>
