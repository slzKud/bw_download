 <?php header("Pragma: no-cache"); ?>
<html>
 <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- ���� Bootstrap -->
      <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="css/default.css">
    <link href="/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
	    <link href="/css/highlight.css" rel="stylesheet">
    <link href="/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
    <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
      <!-- HTML5 Shim �� Respond.js ������ IE8 ֧�� HTML5Ԫ�غ�ý���ѯ -->
      <!-- ע�⣺ ���ͨ�� file://  ���� Respond.js �ļ�������ļ��޷���Ч�� -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
	  <style>
	  body {
			font-family: 'Microsoft YaHei UI','Microsoft YaHei', sans-serif;
		}
	  @media(max-width:767px) { 
 #user-info {
position: absolute;
top:0px;
right: 72px;
} }

</style>
   </head>
<body>
<button type="button" class="btn btn-primary btn-lg" onclick="Test();">
      Test
   </button>
               <p>
              <input id="switch-state" type="checkbox" checked>
            </p>
         <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
		 <script>
		 function Test(){
              $.post('todo.php', { type: "ftpreset"}, function (text, status) { 
			  alert(text);
			  });
	}
	</script>
      <!-- ���������ѱ���Ĳ�� -->
      <script src="/js/bootstrap.min.js"></script>
	    <script src="docs/js/jquery.min.js"></script>
    <script src="docs/js/highlight.js"></script>
    <script src="dist/js/bootstrap-switch.js"></script>
    <script src="docs/js/main.js"></script>
</body>
</html>