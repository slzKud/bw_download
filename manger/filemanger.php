<html>
<?php 
$nowpageid=2;
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
$nowpageid=2;
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

	  <div class="panel-body">
    <div class="container">
      <h1>文件管理</small></h1>
	  <hr>
      
		<div class="container">
	 <a onclick="selectid('interface/window/addfile.php');"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-Plus"></span> 添加文件</button></a>
				<a onclick="selectid('interface/window/modifyfile.php');" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-Pencil"></span> 修改文件基本信息</button></a>
                <a onclick="selectid('interface/window/modifylinks.php');" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-link"></span> 修改文件链接信息</button></a>
                <a onclick="selectid('interface/window/modifyChkA.php');" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-retweet"></span> 批量修改文件类型</button></a>
                    <a onclick="selectid('interface/window/pinfile.php');" ><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-Pushpin"></span> 文件置顶</button></a>
		<a onclick="selectid('interface/window/delfile.php');"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-Trash"></span> 删除文件</button></a>
        <select class="form-inline" id="chkselect" onchange="chksend();">
        <option value="fake">请选择筛选的类别</option>
        <?php
            $sql="select chkid,chkname from bw_chkid where motherid='' order by chkname asc";
            //echo $sql;
            $rs=loaddb($sql);
            if (mysqli_num_rows($rs)> 0){
                while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
                    {
			            echo "<option value = '".$row['chkid']."' >".$row['chkname']."</option>";
                    }
                }else{
                    echo "<option>分类未找到</option>";
                }
    ?>
    </select>
    </div>
<br>
 <table id="th"  class="table">
                        <thead>
                        <tr>
                            <td style="width: 20px">
                                 <input type="checkbox" class="checkall" />
                            </td>
                            <td class="sortable-column">资源名称</td>
                            <td class="sortable-column">添加时间</td>
							<td class="sortable-column">文件权限</td>
                            <td class="sortable-column">文件类别</td>
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
                             <td>30y100g.php</td>
                        </tr>
                        
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>999元B-side100G</td>
                            <td>999y1000gb.php</td>
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
     $(document).ready(function() {
        //第一次加载清除筛选
        $.ajax({
    type:"GET",
    url:"../query/chkselect.php",
    data:"chkid=clean",
    async:false,
    success:function(data){
    }
  });
  });
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
        "ajax": "query/files.php",
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
function chksend(){
    var chkid=$("#chkselect").val();
    if(chkid!="fake"){
        //占位
    }else{
        chkid="clean";
    }
    $.ajax({
    type:"GET",
    url:"../query/chkselect.php",
    data:"chkid="+chkid,
    async:false,
    success:function(data){
       if(data=="ok"){
        reftable();
       }else{
           alert("数据传输失败");
       }
    }
  });
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
