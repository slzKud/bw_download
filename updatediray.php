<html>
<style>
.morecon{ cursor:pointer;font-size:1em;}
.content {margin:1em;}
.content .text{overflow: hidden;}
</style>
<?php 
$nowpageid=3;
include dirname(__FILE__).'/interface/header.php';
include_once dirname(__FILE__).'/module/mysqlaction.php';
empty($_GET['d'])&&$_GET['d']="all";
$showdate=$_GET['d'];
$nowpageid=2;
$flag=0;
$con=connectdb();
mysqli_query($con,"set names 'utf8'");
//构建sql
$sql=" select %tj% from bw_downtable where date_sub(curdate(), INTERVAL 7 DAY) <= date(`adddate`) order by adddate desc";  
//计算页数
$res=loaddb(str_replace("%tj%","count(*) as count",$sql));
//echo str_replace("%tj%","count(*) as count",$sql);;
$myrow = mysqli_fetch_array($res);
$numrows=$myrow[0];//总项目数
$nr=loaddb(str_replace("%tj%","DISTINCT adddate as sumdate",$sql));
?>
<body>
 <div class="container">
 <div class="row" id="titlebox">
      <div class="col-xs-6">
	  <h2>更新日志</h2> 
	  </div>     
   </div>
   <hr>
   <form role="form">
  <div class="form-inline" action="updatediray.php" method="get">
    <label for="name">显示日期选择:</label>
    <select class="form-control" name="d">
    <?php
     while($row = mysqli_fetch_array($nr, MYSQLI_ASSOC))
     {
         if($showdate==$row['sumdate']){
            echo "<option selected='selected'>" . $row['sumdate'] . "</option>";
         }else{
            echo "<option>" . $row['sumdate'] . "</option>";
         }
        
}

    ?>
    <option value="all">显示全部</option>
    </select>
    <button type="submit" class="btn btn-default">提交</button>
  </div>
</form>

<?php
$flag=-1;
if($showdate=="" or $showdate=="all"){
    $nr=loaddb(str_replace("%tj%","DISTINCT adddate as sumdate",$sql));
    while($rowg = mysqli_fetch_array($nr, MYSQLI_ASSOC))
    {
        $n=1;
        $d=$rowg['sumdate'];
        //echo $d;
        echo '<div class="panel panel-primary ">';
        echo '<div class="panel-heading">';
        echo ' <h3 class="panel-title" name="'.$d.'">'.$d.'</h3>';
        echo ' </div>';
        echo ' <div class="panel-body">  <div class="content"> <div class="text">';
        $nd=loaddb("select filename from bw_downtable where adddate='$d'");
        while($rowx = mysqli_fetch_array($nd, MYSQLI_ASSOC))
        {
            $flag=0;
            $x=$rowx['filename'];
            echo "$n.新增了文件: <a href='old-downlist.php?findstr=$x' target='_black'><b>".$rowx['filename']."</b></a><br>";
            $n=$n+1;
        }
        echo ' </div></div></div>';
        echo ' </div>';
    }
}else{
    $n=1;
    $d=$showdate;
    //echo $d;
    echo '<div class="panel panel-primary ">';
    echo '<div class="panel-heading">';
    echo ' <h3 class="panel-title" name="'.$d.'">'.$d.'</h3>';
    echo ' </div>';
    echo ' <div class="panel-body">  <div class="content"> <div class="text">';
    $nd=loaddb("select filename from bw_downtable where adddate='$d'");
    while($rowx = mysqli_fetch_array($nd, MYSQLI_ASSOC))
    {
        $flag=0;
        $x=$rowx['filename'];
        echo "$n.新增了文件: <a href='old-downlist.php?findstr=$x' target='_black'><b>".$rowx['filename']."</b></a><br>";
        $n=$n+1;
    }
    echo ' </div></div></div>';
    echo ' </div>';
}
if($flag==-1){
    echo "<center><p class='lead' >";
    echo "哇乎， 近期没有更新噢。催一下管理吧～";
    echo "</p></center>";
}
?>

  <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="js/jquery.min.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="js/bootstrap.min.js"></script>
      <script>
$(document).ready( function() {
$(".content .text").each(function(){
height=$(this).height();
if(height>120) {
$(this).css("height","120");
$(this).after("<p class=\"morecon text-primary\" >...显示更多内容</p>");
}
});
$(".morecon").click(function(){
$(this).parent().children("div.text").css("height","auto");
$(this).css("display","none");
});
});
</script>
</body>
<?php include dirname(__FILE__).'/interface/footer.php';?>
</html>