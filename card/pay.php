<?php
session_start();
include_once dirname(__FILE__).'/module/mysqlaction.php';
include_once dirname(__FILE__).'/module/cookiesmaker.php';
include_once dirname(__FILE__).'/module/useraction.php';
include_once dirname(__FILE__).'/module/card.php';
  if (isset($_COOKIE["bwcard"])){
 if(veifycookies($_COOKIE["bwcard"])=="incorrect！"){
     echo "<h3>你未登录资源区，请登录后资源区后从资源区跳转。</h3>";
     exit;
 }
  }else{
      echo "<h3>你未登录资源区，请登录后资源区后从资源区跳转。</h3>";
     exit; 
  }
 
//开始处理
empty($_GET['do'])&&$_GET['do']=0;
empty($_POST['card'])&&$_POST['card']="";
empty($_POST['auth'])&&$_POST['auth']="";
//判断参数
if($_GET['do']==1){
    if($_POST['card']==""){
       echo "no card";
     exit; 
    }
     if($_POST['auth']==""){
    echo "no yzm";
    exit;
    }
    if($_SESSION['authnum_session']!=strtolower($_POST['auth'])){
echo "invlid yzm";
 exit;
}
//查询卡片
$card=$_POST['card'];
$sql="select id,cardtype,createdate,status from bw_card where cardid='$card'";
//echo $sql;
$rs1=loaddb($sql);
$row1=mysqli_fetch_array($rs1);
$sql2="select count(*) as n from bw_card where cardid='$card'";
//echo $sql2;
$rs2=loaddb($sql2);
$row2=mysqli_fetch_array($rs2);
//echo $row2['n'];
if($row2['n']>0){
if($row1['status']==0){
$type=$row1['cardtype'];
$tdate=$row1['createdate'];
$t=strtotime($tdate);
//获取typeid
$sql1="select * from bw_cardtype where fname='$type'";
//echo $sql1;
$con=loaddb($sql1);
$row=mysqli_fetch_array($con);
$typeid=$row['Id'];
$v=verfiycardid($card,$t,$typeid);
if($v==1){
    $mod=$row['modname'];
    if (strpos($mod,"../")!=FALSE){
       echo "mod error"; 
    exit;
    }
    $modfile=dirname(__FILE__).'/cards/'.$row['modname'];
    if (file_exists($modfile)) {
        $doflag=1;
       include_once $modfile;
       if(s_do($card)==1){
        $sqlup="UPDATE bw_card SET status=1 WHERE cardid = '$card'";
        loaddb($sqlup);
       echo "ok"; 
    exit;
       }else{
         echo "unknown error"; 
    exit;  
       }
    }else{
        echo "invild mod"; 
    exit;
    }

}else{
    echo "card error"; 
    exit;
}
}else{
    echo "card is used.";
     exit;
}
}else{
    echo "invlid card";
 exit;
}
}
?>
 <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BetaWorld充值卡充值</title>

    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
 
    <style>
        .login-form {
            width: 25rem;
            height: 20rem;
            position: fixed;
            top: 50%;
            margin-top: -13.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>

    <script>

        


        $(function(){
            var form = $(".login-form");

            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });
        });
        function pushMessage(t){
            var mes = 'alert|Error!';
            $.Notify({
                caption: mes.split("|")[1],
                content: t,
                type: mes.split("|")[0]
            });
        }
        function pushOKMessage(t){
            var mes = 'success|恭喜!';
            $.Notify({
                caption: mes.split("|")[1],
                content: t,
                type: mes.split("|")[0]
            });
        }
    </script>
</head>
  
<body class="bg-darkCyan">
    <div class="login-form padding20 block-shadow">
      
            <h1 class="text-light">充值卡充值</h1>
            <hr class="thin"/>
            <br />
            <div class="text-light" data-role="input">
                <label for="user_login">当前已登录用户名:<?php echo veifycookies($_COOKIE["bwcard"]);if(getper()==4){echo "  <a href='manger/index.php'>访问后台点我</a>";}?> </label>
            </div>
            <br />
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="user_password">充值卡号:</label>
                <input  name="card" id="card">
                <button class="button helper-button reveal"><span class="mif-looks"></span></button>
            </div>
            <br />
			<div class="input-control full-size" data-role="input">
			<label for="user_password">验证码:</label><br />
			<div class="flex-grid">
    <div class="row cells2 input-control full-size">
	<div class="cell size7">
				<input name="card" id="auth">
	</div>
    <br />
      <br />
	<div class="cell size1 "> </div>
                <div class="cell size4">
				<img title="点击刷新" style="width:100px;height:35px;" src="../module/captcha.php"align="absbottom" onclick="this.src='../module/captcha.php?'+Math.random();" />
				</div>
           </div>
		  </div>
		   </div>
			  <br />
                <br />
          
                <button onclick="dos();" class="button primary">充值</button>
      
        
    </div>
<script>
   function dos(){
        var cardid=document.getElementById("card").value; 
         var auth=document.getElementById("auth").value; 
         if(cardid==""){
pushMessage("没有卡号！");
 return 0;
         }
         if(auth==""){
             pushMessage("没有验证码！");
             return 0;
         }
          $.post('pay.php?do=1&r='+Math.random(), {card:cardid,auth:auth }, function (text, status) {
			switch(trim(text))
            {
           
            case "nocard":
            pushMessage("没有卡号！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "noyzm":
            pushMessage("没有验证码！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "invlidyzm":
            pushMessage("验证码错误！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "invlidcard":
            pushMessage("卡片无效！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "cardisused.":
            pushMessage("卡片已被使用！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "carderror":
            pushMessage("卡片可能已被停用！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
            case "unknownerror":
            pushMessage("未知错误！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
             case "ok":
            pushOKMessage("账户充值成功！");
			//$.post('todo.php', { type: "ftpreset"}); //重置FTP
           // window.location.reload();		
            break;
         default:
          alert("这是啥啊@#￥！\n"+text);
}
			});
   }
    function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
    </script>

</body>
</html>