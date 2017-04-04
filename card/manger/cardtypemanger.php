<?php 
$pagenum=6;
$pagetitle="卡片类型管理";
include dirname(__FILE__).'/interface/head.php';
?>

                <h1 class="text-light">卡片类型管理<span class="mif-drive-eta place-right"></span></h1>
                    <hr class="thin bg-grayLighter">
                    <button class="button primary" onclick="pushMessage('info')"><span class="mif-plus"></span> 新增卡片类型</button>
                    <button class="button success" onclick="pushMessage('success')"><span class="mif-play"></span> 修改卡片类型</button>
                    <button class="button warning" onclick="pushMessage('warning')"><span class="mif-loop2"></span> 删除卡片类型并停用对应卡片</button>
                    <hr class="thin bg-grayLighter">
                    <table class="striped cell-hovered " id="th">
                        <thead>
                        <tr>
                            <td style="width: 20px">
                                 <input type="checkbox" class="checkall" />
     
                            </td>
                            <td class="sortable-column">卡片类型名称</td>
                            <td class="sortable-column">调用的操作文件</td>
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
                        </tr>
                        <tr>
                            <td>
                                <label class="input-control checkbox small-check no-margin">
                                    <input type="checkbox">
                                    <span class="check"></span>
                                </label>
                            </td>
                            <td>999元B-side100G</td>
                            <td>999y1000gb.php</a></td>
                        
                        </tr>
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
        "ajax": "query/gettype.php",
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
} );
function selectid(){
      if ($(".checkchild:checked").length <1)           {alert("没有选择数据");                return;           }
    if ($(".checkchild:checked").length > 1)           {alert("一次只能修改一条数据");                return;           }
    var id = $(".checkchild:checked").val();
    alert (id);
}
</script>    
             
<?php
include dirname(__FILE__).'/interface/foot.php';
?>