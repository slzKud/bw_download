<html>
<?php 
//引入网页内容
include $_SERVER['DOCUMENT_ROOT'].'/interface/header-user.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/ip.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/bwftp.php';
?>
<body>
<div class="container">
<br>
<br>
<h2>购买流量</h2> 
<hr>
<div class="container">
<h3>你现在当前流量%now%GB,还剩%limit%GB.当前流量费5元/G</h3><br>
<div class="container">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">购买流量</h3>
    </div>
    <div class="panel-body">
        <form role="form">
  <div class="form-group">
    <label for="name">流量购买额度</label>
    <input type="text" class="form-control" id="name" placeholder="请输入你需要购买的流量">
  <p class="help-block">以GB为单位，最少15G</p>
  </div>
  <div class="form-group">
    <label for="inputfile">支付方式</label>
   <div class="radio">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>支付婊
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">微信支付（二维码）
  </label>
</div>
   <div class="radio">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Paypal(美元支付)
  </label>
</div> 
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox">是的，以上信息我已经确认
    </label>
  </div>
   <div class="form-inline">
    <label for="name">总额：</label>
  <h4>￥50.00元</h4>
  </div>
  <button type="submit" class="btn btn-default">提交并支付</button>
</form>
    </div>
</div>
</div>
</div>
</div>
</body>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/interface/footer.php';
?>

