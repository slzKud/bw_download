<?php include_once dirname(dirname(dirname(__FILE__))).'/module/mysqlaction.php'; ?>
            <div class="col-md-2">
      
	  <ul class="nav nav-pills nav-stacked">
     <li <?php if ($nowpageid==1){echo "class='active'";}?>><a href="index.php"><span class="glyphicon glyphicon-dashboard"></span> 仪表板</a></li>
     <li <?php if ($nowpageid==2){echo "class='active'";}?>><a href="filemanger.php"><span class="glyphicon glyphicon-file"></span> 下载资源管理</a></li>
	 <li <?php if ($nowpageid==7){echo "class='active'";}?>><a href="chkmanger.php"><span class="glyphicon glyphicon-th"></span> 下载资源类别管理</a></li>
     <li <?php if ($nowpageid==3){echo "class='active'";}?>><a href="usermanger.php"><span class="glyphicon glyphicon-user"></span> 用户管理</a></li>
	<?php
	 if(getthesettings("opensh")==="1"){
		 if ($nowpageid==6){
			 echo '<li class="active" ><a href="admituser.php"><span class="glyphicon glyphicon-check"></span> 用户组审核</a></li>';
		 }else{
			 echo '<li ><a href="admituser.php"><span class="glyphicon glyphicon-check"></span> 用户组审核</a></li>';
		 }
		 
		 }
	?>
	 <li <?php if ($nowpageid==5){echo "class='active'";}?>><a href="report.php"><span class="glyphicon glyphicon-list-alt" ></span> 报表查询</a></li>
     <li <?php if ($nowpageid==4){echo "class='active'";}?>><a href="systemmanger.php"><span class="glyphicon glyphicon-wrench" ></span> 系统基本设置</a></li>
	 <li><a href="../"><span class="glyphicon glyphicon-chevron-left"></span> 返回资源区</a></li>
</ul>
</div>

	  