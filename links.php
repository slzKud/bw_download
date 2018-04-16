<?php 
session_start();
include dirname(__FILE__).'/module/mysqlaction.php';
include dirname(__FILE__).'/module/cookiesmaker.php';
include dirname(__FILE__).'/interface/header-nomenu.php';
$Lerr="";
empty($_GET['fileid'])&& $_GET['fileid']="";
empty($_GET['yuanid'])  && $_GET['yuanid']="";
empty($_GET['mode'])  && $_GET['mode']="l";
//print_r($_GET);
if($_GET['fileid']==""){
    GtE("参数不完全或非法");
}
$sql="select FileName from bw_downtable where id=".$_GET['fileid']."  and permisson<=".$_SESSION['permission'];
//echo $sql;
$rs=loaddb($sql);
if (mysqli_num_rows($rs)> 0){
	$row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
}else{
    GtE("没有相关资源可供下载。<br>这可能是因为：<br>1）你无权下载此资源<br>2）资源已经被删除 <br>3）其他不明原因<br>如想解决此问题，请与管理员反馈。");
}
switch($_GET['mode']){
    case "r":
    if($_GET['yuanid']==""){
        GtE("未指定下载源");
    }
    $sql="select B64Links from bw_filelinks where fileID=".$_GET['fileid']." and LinkDesc='".$_GET['yuanid']."'";
    //echo $sql;
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)> 0){
        $nowtime=time();
        $code="down.php?fileid=".$_GET['fileid']."&timestamp=".$nowtime."&yzcode=".md5("?fileid=".$_GET['fileid']."&timestamp=".$nowtime."BETAWORLD2016DDD!!!")."&yuanid=".$_GET['yuanid'];
        header("Location:".$code);
    }else{
        GtE("找不到下载源记录");
    }
    break;
    case "l":
    break;
    default:
    GtE("模式参数不合法");
    break;
}
function GtE($Lerr){
    if($Lerr!=""){
        echo "  <div class='container'><h2>Opps...</h2> 
        <hr>
        <h3>发生了一点小错误</h3>
        <br>";
        echo "<div class='alert alert-danger'>".$Lerr."</div>";
        exit();
    }
}
?>
<body>
<?php echo "<input type='hidden' value='".$_GET['fileid']."' id='loaddapp' />"; ?>
 <div class="container">
 <br>
 <!--
 下载区标题
 思路大致
 打开links.php?id=fileid显示选择下载源链接
 然后js直接跳转links.php?id=fileid&u=yuanid&mode=r 由此跳转down.php(后附yuanid)
 down.php从数据表中读取base64编码过的url 解码 然后跳转
 -->
 <div class="row" id="titlebox">
      <div class="col-xs-6">
	  <h2>选择一个下载源</h2> 
	  </div>    
   </div>
   <hr>
   <p class="lead">请选择一个下载源，你可以通过更改选项框的内容从而进行下载</p>
   <div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">选择下载源</h3>
    </div>
    <div class="panel-body">
    <div class="form-group">
    <label for="name">下载源列表</label>
    <select class="form-control" id="yuan">
    <?php
    $sql="select LinkDesc from bw_filelinks where fileID=".$_GET['fileid']."";
    //echo $sql;
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)> 0){
        while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			echo "<option>".$row['LinkDesc']."</option>";
  }
    }else{
        echo "<option>资源未找到</option>";
    }
    ?>
    </select>
    </div>
    <button type="button" class="btn btn-primary" onclick="GTl();">下载</button>
    <a href="downlist.php"><button type="button" class="btn btn-link">返回下载列表</button></a>
    </div>
</div>
  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
  <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<script>
function GTl(){
    var yuanid="";
    var fileid="";
    var link="";
    yuanid=$("#yuan").val();
    fileid=$("#loaddapp").val();
    link="links.php?mode=r&fileid="+fileid+"&yuanid="+yuanid;
    //console.log(link);
    location.href=link;
}
</script>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>