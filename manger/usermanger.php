<html>
<?php 
$nowpageid=3;
include 'interface/header.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
?>
<body>
<div class="row">
<?php include 'interface/sidebar.php';?>

<div class="col-xs-10 text-left">
		  <div class="panel panel-default">

   <div class="panel-body">
    <div class="container">
      <h1>用户管理</small></h1>
	  <hr>
	   
		<div class="container">
		 <button type="button" class="btn btn-default">添加用户</button>    
<button type="button" class="btn btn-primary">修改用户信息</button>   		 
		<button type="button" class="btn btn-danger">删除用户</button>
		 <table class="table">
   <thead>
      <tr>
         <th>用户名称</th>
         <th>用户权限</th>
       
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>Admin</td>
		 <td>管理员</td>
      </tr>
         <tr>
         <td>Kud</td>
		 <td>VIP</td>
      </tr>
	     <tr>
         <td>6324</td>
		 <td>管理员</td>
      </tr>
	     <tr>
         <td>Test</td>
		 <td>普通用户</td>
      </tr>
	     <tr>
         <td>HAHAH</td>
		 <td>高级用户</td>
      </tr>
	   <tr>
         <td>HAHAH1</td>
		 <td>封禁</td>
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
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
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
		});
		</script>
</body>
<?php include 'interface/footer.php';?>
</html>
