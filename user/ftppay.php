<?php 
//引入网页内容
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/bwftp.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/settings/card.php';
empty($_GET['links'])&&$_GET['links']="";
if(getthesettings("opencard")!="1"){
  include '../interface/header-user.php';
	   $LErr="对不起，此功能正在建设中，请等待开发。";
	   echo '
<div class="alert alert-danger">'.$LErr.'</div>
</div>';
include '../interface/footer.php';
exit;
    }
if($_GET['links']!=""){
  //echo $cardlinks[$_GET['links']]['link'];
  $url=getthesettings("gocard");
  $url=$url."/links.php?type=getlinks&links=".$_GET['links'];
  $re=curl_file_get_contents($url);
  echo $re;
  exit;
}
echo "<html>";
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-user.php';
?>
<body>
<div class="container">
<br>
<br>
<h2>购买流量充值卡</h2> 
<hr>
<div class="container">

<div class="container">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">购买流量</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
	 <label for="name">购买的卡片类型</label>
      <select class="form-control" name="new" id="n">
      <?php
      /*
      foreach($cardlinks as $v){
    echo "<option>".$v['name']."</option>";
}
*/  
   $url=getthesettings("gocard");
    $url=$url."/links.php?type=getlist";
    $list=curl_file_get_contents($url);
    echo $url;
    $a=explode(",",$list);
     foreach($a as $v){
    echo "<option>".$v."</option>";
}
      ?>
      </select>
</div>
        <button class="btn btn-default" onclick="go();">前往购买充值卡</button>
        <a href="gocard.php?type=pay"><button type="submit" class="btn btn-default">激活充值卡</button></a>
         <a href="gocard.php?type=history"><button type="submit" class="btn btn-default">查看充值历史</button></a>
  </div>
  
    </div>
</div>
</div>
</div>
</div>
</body>
<script>
function go(){
 var n = $('#n').val();
  $.get('ftppay.php', {links:n}, function (text, status) {
window.open(text);   
           });
}
</script>

  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';
?>

