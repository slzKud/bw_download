<html>
<body>
<?php
//include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
//if(getthesettings("optmode")==="1"){echo 'checked';}
function unixtime_to_date($unixtime, $timezone = 'PRC') {
    $datetime = new DateTime("@$unixtime"); //DateTime类的bug，加入@可以将Unix时间戳作为参数传入
    $datetime->setTimezone(new DateTimeZone($timezone));
    return $datetime->format("Y-m-d H:i:s");
}
include dirname(__FILE__).'/interface/header-nomenu.php';
$endtime=time()+100000;
$time=unixtime_to_date($endtime);
?>
<div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>非常抱歉 I'm Sorry. Очень жаль</h2> 

	  <hr>
	  <br>

<h3>BetaWorld资源区在此地区不提供任何服务。<br><br>The BetaWorld resource center is unavailable in this area.<br><br>Ресурсный центр BetaWorld недоступен в этой области.
</h3>
	  <br><br>
	  
<br>
</div>

 <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>
