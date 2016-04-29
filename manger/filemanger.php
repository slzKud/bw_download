<html>
<?php 
$nowpageid=2;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
?>
<body>
<div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-xs-8 text-left">

	  <div class="panel-body">
    <div class="container">
      <h1>文件管理</small></h1>
	  <hr>
	   
		<div class="container">
		 <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#AddModal">添加文件</button>         
		<button type="button" class="btn btn-danger" data-toggle="modal"  data-target="#DELModal">删除文件</button>
		 <table class="table table-hover">
   <thead>
      <tr>
         <th>资源名称</th>
         <th>添加时间</th>
       <th>下载权限</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>Windows 10 Build 14316 (English(US))<span class="label label-primary">New</span></td>
		 <td>2016-4-8</td>
	<th>所有人</th>
         
      </tr>
      <tr>
         <td>Windows Server 2003 Build 3615 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
      <tr>
        <td>Windows XP Build 2442 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
	  <tr>
        <td>Windows XP Build 2442 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
	  <tr>
        <td>Windows XP Build 2442 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
	  <tr>
        <td>Windows XP Build 2442 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
	  <tr>
        <td>Windows XP Build 2442 (English(US))</td>
         <td>2016-4-8</td>
         <th>VIP</th>
      </tr>
	  

   </tbody>
</table>
<ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- 添加模态框（Modal） -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             添加资源
            </h4>
         </div>
         <div class="modal-body">
            <form role="form">
  <div class="form-group">
    <label for="name">资源名称</label>
    <input type="text" class="form-control" placeholder="请输入资源名称" name="zytitle">
	</div>
	  <div class="form-group">
    <label for="name">资源地址</label>
    <input type="text" class="form-control" placeholder="请输入资源下载时跳转的下载地址" name="zylink">
	</div>
	<div class="form-group">
	 <label for="name">资源下载权限</label>
      <select class="form-control">
         <option>游客</option>
         <option>普通用户</option>
         <option>高级用户</option>
         <option>机密</option>
      </select>

</div>
 </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary">
               添加
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
<!-- 删除模态框（Modal） -->
<div class="modal fade" id="DELModal" tabindex="-2" role="dialog" aria-labelledby="DELModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             添加资源
            </h4>
         </div>
         <div class="modal-body">
         你确认要删除'XXXXXX'吗？
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary">
               删除
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="/js/bootstrap.min.js"></script>
	  <Script>
	  function LoadAddWindows(){
			$('#ModalAdd').modal('show');
		}
	  </script>
	  <script>
		$(function(){
			function initTableCheckbox() {
				var $thr = $('table thead tr');
				var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
				/*将全选/反选复选框添加到表头最前，即增加一列*/
				$thr.prepend($checkAllTh);
				/*“全选/反选”复选框*/
				var $checkAll = $thr.find('input');
				$checkAll.click(function(event){
					/*将所有行的选中状态设成全选框的选中状态*/
					$tbr.find('input').prop('checked',$(this).prop('checked'));
					/*并调整所有选中行的CSS样式*/
					if ($(this).prop('checked')) {
						$tbr.find('input').parent().parent().addClass('warning');
					} else{
						$tbr.find('input').parent().parent().removeClass('warning');
					}
					/*阻止向上冒泡，以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击全选框所在单元格时也触发全选框的点击操作*/
				$checkAllTh.click(function(){
					$(this).find('input').click();
				});
				var $tbr = $('table tbody tr');
				var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');
				/*每一行都在最前面插入一个选中复选框的单元格*/
				$tbr.prepend($checkItemTd);
				/*点击每一行的选中复选框时*/
				$tbr.find('input').click(function(event){
					/*调整选中行的CSS样式*/
					$(this).parent().parent().toggleClass('warning');
					/*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/
					$checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
					/*阻止向上冒泡，以防再次触发点击操作*/
					event.stopPropagation();
				});
				/*点击每一行时也触发该行的选中操作*/
				$tbr.click(function(){
					$(this).find('input').click();
				});
			}
			initTableCheckbox();
			// dom加载完毕
   
		});
		$("[data-toggle='modal']").click(function(){
 var _target = $(this).attr('data-target')
 t=setTimeout(function () {
 var _modal = $(_target).find(".modal-dialog")
 _modal.animate({'margin-top': parseInt(($(window).height() - _modal.height())/2)}, 300 )},200)
 })
		</script>
		

</body>
<?php include 'interface/footer.php';?>
</html>
