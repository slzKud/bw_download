<?php
$nowpageid=2;
include $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include 'interface/header.php';
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
<table class="table table-hover"  id="th">
                        <thead>
                        <tr>
                            <td class="sortable-column">资源名称</td>
                            <td class="sortable-column">添加时间</td>
                            <td>操作</td>
                        </thead>
                        <tbody>
                        <tr>
                            
                            <td>2017-06-07 09:00:00</td>
                            <td>BW88SDF5FVSPC</td>
                            <td>BW88SDF5FVSPC</td>
                         
                        </tr>
                        <tr>
                           
                            <td>2017-07-21 00:00:00</td>
                            <td>BW85GDFRDESBS</td>
    <td>BW88SDF5FVSPC</td>
                        </tr>
                        </tbody>
                    </table>
                  
</div></div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/dataTables.bootstrap.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
       <script src="./js/top.js" type="text/javascript"></script>
       <script>
           $(document).ready(function() {
    $('#th').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "query/download.php"
    } );
} );
       </script>
</body>
<?php include 'interface/footer.php';?>
</html>