<?php

 include_once dirname(dirname(dirname(__FILE__))).'/module/mysqlaction.php';

//获取Datatables发送的参数 必要
$draw = $_GET['draw'];//这个值作者会直接返回给前台
 
//排序
$order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
$order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
 
//拼接排序sql
$orderSql = "";
if(isset($order_column)){
    $i = intval($order_column);
    switch($i){
        case 1;$orderSql = " order by Filename ".$order_dir;break;
        case 2;$orderSql = " order by adddate ".$order_dir;break;
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
$sumSql = "SELECT count(id) as sum FROM bw_downtable";
//条件过滤后记录数 必要
$recordsFiltered = 0;
//表的总记录数 必要
$recordsTotal = 0;
$recordsTotalResult = loaddb($sumSql);
while ($row =mysqli_fetch_array($recordsTotalResult)) {
    $recordsTotal =  $row['sum'];
}
//定义过滤条件查询过滤后的记录数sql
$sumSqlWhere =" where Filename LIKE '%".$search."%' ";
if(strlen($search)>0){
    $recordsFilteredResult = loaddb($sumSql.$sumSqlWhere);
    while ($row =mysqli_fetch_array($recordsFilteredResult)) {
        $recordsFiltered =  $row['sum'];
    }
}else{
    $recordsFiltered = $recordsTotal;
}
 
//query data
$totalResultSql = "SELECT id,Filename,adddate,Permisson FROM bw_downtable";
$infos = array();
if(strlen($search)>0){
    //如果有搜索条件，按条件过滤找出记录
    $dataResult = loaddb($totalResultSql.$sumSqlWhere.$orderSql.$limitSql);
    //echo $totalResultSql.$sumSqlWhere.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult)) {
        $obj = array($row['id'],$row['Filename'].showzd($row['id']),$row['adddate'],topername($row['Permisson']));
        array_push($infos,$obj);
    }
}else{
    //直接查询所有记录
    $dataResult = loaddb($totalResultSql.$orderSql.$limitSql);
    //echo $totalResultSql.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult, MYSQLI_ASSOC)) {
               $obj = array($row['id'],$row['Filename'].showzd($row['id']),$row['adddate'],topername($row['Permisson']));
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
 function topername($ustr){
     switch($ustr){
				case '0':
				return "游客";
				  break;
				case '1':
				return "普通用户";
				  break;
				case '2':
				return "高级用户";
				  break;
				case '3':
				return "VIP";
				  break;
				case '4':
				return "机密";
				  break;
				 default:
				return "未知";
				  break;
			}
 }
 function showzd($id){
     $sql1="select fileid from bw_pinfile where fileid in (".$id.") and ifok=1";
  $rschk=loaddb($sql1);
  if(mysqli_num_rows($rschk) >0){
return "<span class='label label-primary'>已置顶文件</span>";
  }else{
return "";
  }
 }
function fatal($msg)
{
    echo json_encode(array(
        "error" => $msg
    ));
    exit(0);
}
?>