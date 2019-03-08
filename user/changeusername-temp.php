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
<div class="container" >

<br><br>
<div class='alert alert-danger'>提示：有效期至2019.5.1，只允许用户名存在问题的人进行更改！<br><br>新用户名要求至少3位以上，不含有特殊字符和空格。</div>
<!--
标题
-->
     <h2>用户名信息更改</h2> 
     <hr>
<div class="form-horizontal">
  <div class="form-group">
    <label for="firstname" class="col-sm-2 control-label">邮箱</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="useremail" placeholder="请输入你注册时所使用的邮箱地址以进行验证">
    </div>
  </div>
  <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">新用户名</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="newname" placeholder="请输入要更改新的用户名">
    </div>
  </div>
  <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">新用户名确认</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="confirmnew" placeholder="请输入再输入一次你要更改的新用户名">
    </div>
  </div>
  <div class="form-group">
      <label for="password" class="col-sm-2 control-label">验证码</label>
      <div class="col-sm-6">
         <input type="text" class="form-control" id="yzm" name="yzm"
            placeholder="请输入验证码">
	 
	  </div>
	 <div class="col-sm-4">
         <?php 
         $url="../module/captcha.cn.php";
         ?>
         <img  title="点击刷新" height="35px" src="<?php echo($url);?>"align="absbottom" onclick="this.src='<?php echo($url);?>?'+Math.random();"></img>
      </div>
   </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button onclick="checkandsend();" class="btn btn-default">登录</button>
    </div>
  </div>
  </div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="../js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="../js/bootstrap.min.js"></script>
      <script>
          function checkUserName(user){
　　　　　//特殊符号包含项,自行修改
      var arr=['<','>','#','?','!',' ','$','^','@','#','$','?','(',')','*','=','+','-','~',',','  ','|','[',']'];
        var user_length=user.length;
        var arr_length=arr.length;
        if (user.length<3){return false;}
            for(var i=0;i<user_length;i++){
                for(var j=0;j<arr_length;j++){
                
                    if(user.charAt(i)==arr[j]){
                         return false;
                    }
                } 
            }
        return true;
    }
    function checkandsend(){
      if($("#newname").val()==""){
        alert('新用户名为空。');
        return -1;
      }
      if($("#useremail").val()==""){
        alert('邮箱为空。');
        return -1;
      }
      if($("#confirmnew").val()==""){
        alert('确认用户名为空。');
        return -1;
      }
      if($("#yzm").val()==""){
        alert('验证码为空。');
        return -1;
      }
      if (checkUserName($("#newname").val())==false){
        alert('新用户名无效。');
        return -1;
      }
      if($("#newname").val()!=$("#confirmnew").val()){
        alert('新用户名和确认的用户名不一致。');
        return -1;
      }
      ischeckemail();
      //提交信息，需要写好TODO
      $.post('../user/todo.php', { type: "changeusername",useremail:$("#useremail").val(),newusername:$("#newname").val(),yzm:$("#yzm").val() }, function (text, status) {
			  if(text=='ok'){alert('更改完成，请重新以新用户名登录');window.location.href="login.php?type=logout";	}else{alert(text);}
			  console.log(text);
		  });
    }
    function ischeckemail(){
      var email = document.getElementById("useremail").value;
      if(email != "") {
          varreg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
          isok=varreg.test(email);
          if(!isok) {
            alert("邮箱格式不正确，请重新输入！");
            document.getElementById("useremail").focus();
            return false;
          } 
       };
    }

      </script>
</body>
<?php include dirname(dirname(__FILE__)).'/interface/footer.php';?>
