<?php
session_start();
 include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
 include_once dirname(dirname(__FILE__)).'/module/cookiesmaker.php'; 
 empty($_SESSION['chkid']) && $_SESSION['chkid']="";
//获取Datatables发送的参数 必要
$draw = $_GET['draw'];//这个值作者会直接返回给前台
$username=veifycookies($_COOKIE["bwuser"]);
//排序
$order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
$order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
 
//拼接排序sql
$orderSql = "";
if(isset($order_column)){
    $i = intval($order_column);
    switch($i){
        case 0;$orderSql = " order by Fileid ".$order_dir;break;
        case 1;$orderSql = " order by downtime ".$order_dir;break;
        default;$orderSql = '';
    }
}
//搜索
$search = $_GET['search']['value'];//获取前台传过来的过滤条件
$search=str_replace('\'', '', $search);
$search=str_replace('"', '', $search);
//分页
$start = $_GET['start'];//从多少开始
$length = $_GET['length'];//数据长度
$limitSql = '';
$limitFlag = isset($_GET['start']) && $length != -1 ;
if ($limitFlag ) {
    $limitSql = " LIMIT ".intval($start).", ".intval($length);
}
 
//定义查询数据总记录数sql
$sumSql = "SELECT count(id) as sum FROM bw_downloadhistory" ." where downuser='$username' and date_sub(curdate(), INTERVAL 7 DAY) <= date(`downtime`)";
//条件过滤后记录数 必要
$recordsFiltered = 0;
//表的总记录数 必要
$recordsTotal = 0;
$recordsTotalResult = loaddb($sumSql);
while ($row =mysqli_fetch_array($recordsTotalResult)) {
    $recordsTotal =  $row['sum'];
}
    $sumSqlWhere ="";

if(strlen($search)>0){
    $recordsFilteredResult = loaddb($sumSql.$sumSqlWhere);
    while ($row =mysqli_fetch_array($recordsFilteredResult)) {
        $recordsFiltered =  $row['sum'];
    }
}else{
    $recordsFiltered = $recordsTotal;
}
 
//query data

$totalResultSql =  "SELECT fileid,downtime FROM bw_downloadhistory" ." where downuser='$username' and date_sub(curdate(), INTERVAL 7 DAY) <= date(`downtime`)";
$infos = array();
$nowtime=time();
if(strlen($search)>0){
    //如果有搜索条件，按条件过滤找出记录
    $dataResult = loaddb($totalResultSql.$sumSqlWhere.$orderSql.$limitSql);
    //echo $totalResultSql.$sumSqlWhere.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult)) {
        $obj = array($row['fileid'], $row['downtime'], "<a href ='links.php?mode=l&fileid=".$row['fileid']."'><span class='glyphicon glyphicon-cloud-download' style='font-size: 20px;'></span></a></td>");
        array_push($infos,$obj);
    }
}else{
    //直接查询所有记录
    $dataResult = loaddb($totalResultSql.$orderSql.$limitSql);
    //echo $totalResultSql.$sumSqlWhere.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult, MYSQLI_ASSOC)) {
         $obj = array(getthename($row['fileid']), $row['downtime'], "<a href ='../links.php?mode=l&fileid=".$row['fileid']."'><span class='glyphicon glyphicon-cloud-download' style='font-size: 20px;'></span></a>");
        array_push($infos,$obj);
    }
}

 
/*
 * Output 包含的是必要的
 */
echo json_encode(array(
    "draw" => intval($draw),
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $infos
),JSON_UNESCAPED_UNICODE);
 
 
function fatal($msg)
{
    echo json_encode(array(
        "error" => $msg
    ));
    exit(0);
}
function getthename($id) {
    $sql="select Filename from bw_downtable where id=$id";
    $rs=loaddb($sql);
     //echo $sql.'<br>';
    if (mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
        return $row['Filename'];
    }else{
        return "error";
    } 
  }
?>