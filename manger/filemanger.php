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
		 <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#AddModal">����ļ�</button>         
		<button type="button" class="btn btn-danger" data-toggle="modal"  data-target="#DELModal">ɾ���ļ�</button>
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
</div>
<!-- ���ģ̬��Modal�� -->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             �����Դ
            </h4>
         </div>
         <div class="modal-body">
            <form role="form">
  <div class="form-group">
    <label for="name">��Դ����</label>
    <input type="text" class="form-control" placeholder="��������Դ����" name="zytitle">
	</div>
	  <div class="form-group">
    <label for="name">��Դ��ַ</label>
    <input type="text" class="form-control" placeholder="��������Դ����ʱ��ת�����ص�ַ" name="zylink">
	</div>
	<div class="form-group">
	 <label for="name">��Դ����Ȩ��</label>
      <select class="form-control">
         <option>�ο�</option>
         <option>��ͨ�û�</option>
         <option>�߼��û�</option>
         <option>����</option>
      </select>

</div>
 </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">�ر�
            </button>
            <button type="button" class="btn btn-primary">
               ���
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
<!-- ɾ��ģ̬��Modal�� -->
<div class="modal fade" id="DELModal" tabindex="-2" role="dialog" aria-labelledby="DELModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             �����Դ
            </h4>
         </div>
         <div class="modal-body">
         ��ȷ��Ҫɾ��'XXXXXX'��
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">�ر�
            </button>
            <button type="button" class="btn btn-primary">
               ɾ��
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
<!-- jQuery (Bootstrap �� JavaScript �����Ҫ���� jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- ���������ѱ���Ĳ�� -->
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
			// dom�������
   
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
