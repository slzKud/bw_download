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
      <h1>�ļ�����</small></h1>
	  <hr>
	   
		<div class="container">
		 <button type="button" class="btn btn-primary">����ļ�</button>         
		<button type="button" class="btn btn-danger">ɾ���ļ�</button>
		 <table class="table table-hover">
   <thead>
      <tr>
         <th>��Դ����</th>
         <th>���ʱ��</th>
       <th>����Ȩ��</th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <td>Windows 10 Build 14316 (English(US))<span class="label label-primary">New</span></td>
		 <td>2016-4-8</td>
	<th>������</th>
         
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

<!-- jQuery (Bootstrap �� JavaScript �����Ҫ���� jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- ���������ѱ���Ĳ�� -->
      <script src="js/bootstrap.min.js"></script>
	  <script>
		$(function(){
			function initTableCheckbox() {
				var $thr = $('table thead tr');
				var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
				/*��ȫѡ/��ѡ��ѡ����ӵ���ͷ��ǰ��������һ��*/
				$thr.prepend($checkAllTh);
				/*��ȫѡ/��ѡ����ѡ��*/
				var $checkAll = $thr.find('input');
				$checkAll.click(function(event){
					/*�������е�ѡ��״̬���ȫѡ���ѡ��״̬*/
					$tbr.find('input').prop('checked',$(this).prop('checked'));
					/*����������ѡ���е�CSS��ʽ*/
					if ($(this).prop('checked')) {
						$tbr.find('input').parent().parent().addClass('warning');
					} else{
						$tbr.find('input').parent().parent().removeClass('warning');
					}
					/*��ֹ����ð�ݣ��Է��ٴδ����������*/
					event.stopPropagation();
				});
				/*���ȫѡ�����ڵ�Ԫ��ʱҲ����ȫѡ��ĵ������*/
				$checkAllTh.click(function(){
					$(this).find('input').click();
				});
				var $tbr = $('table tbody tr');
				var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');
				/*ÿһ�ж�����ǰ�����һ��ѡ�и�ѡ��ĵ�Ԫ��*/
				$tbr.prepend($checkItemTd);
				/*���ÿһ�е�ѡ�и�ѡ��ʱ*/
				$tbr.find('input').click(function(event){
					/*����ѡ���е�CSS��ʽ*/
					$(this).parent().parent().toggleClass('warning');
					/*����Ѿ���ѡ���е��������ڱ���������������ȫѡ����Ϊѡ��״̬��������Ϊδѡ��״̬*/
					$checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.length ? true : false);
					/*��ֹ����ð�ݣ��Է��ٴδ����������*/
					event.stopPropagation();
				});
				/*���ÿһ��ʱҲ�������е�ѡ�в���*/
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
