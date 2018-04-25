<?php
$nowpageid=2;
include dirname(__FILE__).'/module/mysqlaction.php';
include dirname(__FILE__).'/interface/header.php';
?>

<body>
 <div class="container">
 <br>
 <!--
 下载区标题
 -->
 <div class="row" id="titlebox">
      <div class="col-xs-6">
	  <h2>资源列表</h2> 
	  </div>
      <div class="col-xs-6">
	   <div class="form-inline text-right" >
    <p class='lead' ><a href='old-downlist.php'>切换到旧版下载列表</a></p>
    </div>	  
	  </div>      
   </div>
   <hr>
   <?php if($_SESSION['permission']==0){echo "<center><p class='lead' ><a href='user/reg.php'>注册</a>或<a href='user/login.php'>登入</a>账户可获取更多资源.</p></center>";} ?>
   <div class="row" id="t">
   <div class="col-xs-6">
   <b>类型筛选：</b><select class="form-control" id="chkselect" onchange="chksend();">
   <option value="fake">请选择类别</option>
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
    </div>
    <br>
<table class="table table-hover"  id="th">
                        <thead>
                        <tr>
                            <td class="sortable-column">资源名称</td>
                            <td class="sortable-column">添加时间</td>
                            <td>操作</td>
                        </thead>
                        <tbody>
                        <tr>
                        </tbody>
                    </table>
                  
</div></div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/dataTables.bootstrap.js"></script>
      <script src="js/fnReloadAjax.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
       <script src="./js/top.js" type="text/javascript"></script>
       <script>
       var dt;
    $(document).ready(function() {
        //第一次加载清除筛选
        $.ajax({
    type:"GET",
    url:"query/chkselect.php",
    data:"chkid=clean",
    async:false,
    success:function(data){
    }
  });
    dt=$('#th').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "query/download.php",
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
function chksend(){
    var chkid=$("#chkselect").val();
    if(chkid!="fake"){
        //占位
    }else{
        chkid="clean";
    }
    $.ajax({
    type:"GET",
    url:"query/chkselect.php",
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
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>