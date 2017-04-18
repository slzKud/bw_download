<?php 
$pagenum=2;
$pagetitle="卡片管理";
include dirname(__FILE__).'/interface/head.php';
?>

                 <h1 class="text-light">卡片管理<span class="mif-drive-eta place-right"></span></h1>
                    <hr class="thin bg-grayLighter">
                    <button class="button primary" onclick="showMetroDialog('#dialog-ajax')"> 生成卡片</button>
                    <button class="button warning" onclick="selectid()">停用卡片</button>
                    <button class="button primary" onclick="pushMessage('warning')">导出卡片号</button>
                    <hr class="thin bg-grayLighter">
                    <table class="striped cell-hovered " id="th" >
                        <thead>
                        <tr>
                            <td style="width: 20px">
                <input type="checkbox" class="checkall" />
     
                            </td>
                            <td class="sortable-column">卡号</td>
                            <td class="sortable-column">卡片类型</td>
                            <td class="sortable-column">目前状态</td>
                        </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>

                <script>
              $(".checkall").click(function () {
      var check = $(this).prop("checked");
      $(".checkchild").prop("checked", check);
});
                    $(document).ready(function() {
    $('#th').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "query/getlist.php",
        "columns": [
   {
                 "sClass": "text-center",
                 "data": 1,
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
function selectid(){
      if ($(".checkchild:checked").length <1)           {alert("没有选择数据");                return;           }
    if ($(".checkchild:checked").length > 1)           {alert("一次只能修改一条数据");                return;           }
    var id = $(".checkchild:checked").val();
    if(confirm("确认停用卡片："+id+"吗")){
      $.post('query/todo.php?r='+Math.random(), {card:id,type:"bancard" }, function (text, status) {
			if(trim(text)=="ok"){
$.Notify({
    caption: '成功！',
    content: "卡号："+id+"已停用",
    type: 'success'
});
            }else{
              alert(text);
            }
            
      });
    }
   
}
function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }

        function showDialog(id){
            var dialog = $("#"+id).data('dialog');
            if (!dialog.element.data('opened')) {
                dialog.open();
            } else {
                dialog.close();
            }
        }
    
</script>    
   <div data-role="dialog" id="dialog-ajax" class="padding20"
    data-close-button="true"
    data-href="interface/window/addcard.php"
    data-width="600"
    data-overlay="true" data-overlay-color="op-dark"></div>          
<?php
include dirname(__FILE__).'/interface/foot.php';
?>