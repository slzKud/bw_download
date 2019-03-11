<?php
include_once  dirname(dirname(dirname(__FILE__))).'/module/mysqlaction.php';
ini_set('memory_limit', '2G');
spl_autoload_register('go_class');
function go_class($class)
{
    if (strpos($class, 'ipip\db') !== FALSE)
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/module/' . implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';
    }
}
echo("IP所属地域快速生成\r\n感谢ipip.net的免费数据库\r\n删除记录中....\r\n");
loaddb("delete from bw_ip");
echo("开始遍历....\r\n");
$dataResult = loaddb("select lastip from bw_usertable");

    //echo $totalResultSql.$orderSql.$limitSql;
$i=0;
while ($row = mysqli_fetch_array($dataResult, MYSQLI_ASSOC)) {
    $c=getIPLoc($row['lastip']);
    echo($i." ".$row['lastip']." ".$c."\r\n");
    $i=$i+1;
    //sleep(1);
    }
function getIPLoc($queryIP){ 
    $arr=explode(".",$queryIP);
    if($arr[0]=="192" and $arr[1]="168"){
    return "The C-Type Insider";
    }elseif($arr[0]=="127"){
    return "This Computer";
    }elseif($arr[0]=="10" or $arr[0]=="172"){
    return "The A or B";
    } 
    if($queryIP==""){return "未知";}
        $city = new ipip\db\City(dirname(dirname(dirname(__FILE__))).'/module/ipip/db/ipipfree.ipdb');
        $sql="select loc from bw_ip where ip='$queryIP'";
        $rs=loaddb($sql);
        if (mysqli_num_rows($rs)>0){
              $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
              return $row['loc'];
          }else{
              $loc=$city->find($queryIP,'CN');
              $loc1=$loc[1].$loc[2];
              $sql1="INSERT INTO bw_ip (ip,loc) VALUES( '$queryIP', '$loc1')";
              loaddb($sql1);
              return $loc1;
} 
}

?>