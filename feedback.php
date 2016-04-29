<html>
<?php 
$nowpageid=1;
include 'interface/header-nomenu.php';
?>
<body>
 
   <div class="container">
   <h2>反馈</h2> 
 <hr>
    <div class="container">
  <form role="form">
  <div class="form-group">
    <label for="name">标题</label>
    <input type="text" class="form-control" placeholder="请输入反馈标题" name="fktitle">
	</div>
	<div class="form-group">
	 <label for="name">反馈类型</label>
      <select class="form-control">
         <option>资源失效</option>
         <option>服务器问题</option>
         <option>有关建议</option>
         <option>其他</option>
      </select>

</div>
	<div class="form-group">
    <label for="name">反馈内容</label>
    <textarea class="form-control" rows="8" name="fktext"></textarea>
  </div>

  <div class="form-group">
         <button name="submitbutton" class="btn btn-primary btn-lg btn-block" onclick="javascript:ok_user();">反馈</button>
   </div>
 </form>
 *这可能会收集一定你的信息（包括IP,地址等），请你留意
</div>

</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>