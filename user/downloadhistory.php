<?php
include dirname(dirname(__FILE__)).'/interface/header-user.php';
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
include_once dirname(dirname(__FILE__)).'/module/cookiesmaker.php'; 
if (isset($_COOKIE["bwuser"])){
    //鉴别用户代码
    if ($_SESSION['permission']==0){
    $con=loaddb("select permission from bw_usertable where username='".veifycookies($_COOKIE["bwuser"])."'");
    $row=mysqli_fetch_array($con);
   $_SESSION['permission']=$row['permission'];
    }
    if(veifycookies($_COOKIE["bwuser"])=="incorrect！"){
         echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
         exit;
     }
    }else{
        echo "<meta http-equiv='refresh' content='1;url=../index.php'> ";
          exit; 
    }
?>
<body>

<div class="container" >
<br><br>
<!--
标题
-->
     <h2>近七天的下载历史</h2> 
     <hr><br>
     <table class="table table-hover"  id="th">
                        <thead>
                        <tr>
                            <td class="sortable-column">资源名称</td>
                            <td class="sortable-column">下载时间</td>
                            <td>操作</td>
                        </thead>
                        <tbody>
                        <tr>
                        </tbody>
                    </table>
</div>
                  
</body>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.js"></script>
<script src="../js/fnReloadAjax.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="../js/bootstrap.min.js"></script>
<script src="../js/top.js" type="text/javascript"></script>
<script>
    var dt;
    $(document).ready(function() {
    dt=$('#th').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "../query/downhistory.php",
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
        }  
    } );
} );
</script>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>