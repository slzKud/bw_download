 <?php header("Pragma: no-cache"); ?>
<html>
 <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- 引入 Bootstrap -->
      <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
	  <link rel="stylesheet" type="text/css" href="css/default.css">
    <link href="/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
	    <link href="/css/highlight.css" rel="stylesheet">
    <link href="/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
    <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
      <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
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
      <!-- 包括所有已编译的插件 -->
      <script src="/js/bootstrap.min.js"></script>
	    <script src="docs/js/jquery.min.js"></script>
    <script src="docs/js/highlight.js"></script>
    <script src="dist/js/bootstrap-switch.js"></script>
    <script src="docs/js/main.js"></script>
</body>
</html>