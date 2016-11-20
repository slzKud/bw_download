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
include 'interface/header-nomenu.php';
$endtime=time()+100000;
$time=unixtime_to_date($endtime);
?>
<div class="container" >

 <br>
 <!--
 标题
 -->
	  <h2>稍等片刻</h2> 
	  <hr>
	  <br>

<h3>BetaWorld资源区正在进行一场维护<br><br>
喝杯茶就好。</h3>
	  <br><br>
	  
<br>
</div>

 <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
</body>
<?php include 'interface/footer.php';?>
</html>
