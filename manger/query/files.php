<?php
session_start();
 include_once dirname(dirname(dirname(__FILE__))).'/module/mysqlaction.php';
 empty($_SESSION['chkid']) && $_SESSION['chkid']="";
//获取Datatables发送的参数 必要
$draw = $_GET['draw'];//这个值作者会直接返回给前台
$chkid=$_SESSION['chkid'];
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
        case 4;$orderSql = " order by chkid ".$order_dir;break;
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
if($_SESSION['chkid']!=""){
   
    $sumSql = "SELECT count(id) as sum FROM bw_downtable where chkid='$chkid'";
}else{
    $sumSql = "SELECT count(id) as sum FROM bw_downtable";
}

//条件过滤后记录数 必要
$recordsFiltered = 0;
//表的总记录数 必要
$recordsTotal = 0;
$recordsTotalResult = loaddb($sumSql);
while ($row =mysqli_fetch_array($recordsTotalResult)) {
    $recordsTotal =  $row['sum'];
}
//定义过滤条件查询过滤后的记录数sql
if($_SESSION['chkid']!=""){
   
    $sumSqlWhere =" and Filename LIKE '%".$search."%' ";
}else{
    $sumSqlWhere =" where Filename LIKE '%".$search."%' ";
}

if(strlen($search)>0){
    $recordsFilteredResult = loaddb($sumSql.$sumSqlWhere);
    while ($row =mysqli_fetch_array($recordsFilteredResult)) {
        $recordsFiltered =  $row['sum'];
    }
}else{
    $recordsFiltered = $recordsTotal;
}
 
//query data
if($_SESSION['chkid']!=""){
    $totalResultSql = "SELECT id,Filename,adddate,Permisson,chkid FROM bw_downtable where chkid='$chkid'";
}else{
    $totalResultSql = "SELECT id,Filename,adddate,Permisson,chkid FROM bw_downtable";
}
$infos = array();
if(strlen($search)>0){
    //如果有搜索条件，按条件过滤找出记录
    $dataResult = loaddb($totalResultSql.$sumSqlWhere.$orderSql.$limitSql);
    //echo $totalResultSql.$sumSqlWhere.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult)) {
        $obj = array($row['id'],$row['Filename'].showzd($row['id']),$row['adddate'],topername($row['Permisson']),findchkname($row['chkid']));
        array_push($infos,$obj);
    }
}else{
    //直接查询所有记录
    $dataResult = loaddb($totalResultSql.$orderSql.$limitSql);
    //echo $totalResultSql.$orderSql.$limitSql;
    while ($row = mysqli_fetch_array($dataResult, MYSQLI_ASSOC)) {
               $obj = array($row['id'],$row['Filename'].showzd($row['id']),$row['adddate'],topername($row['Permisson']),findchkname($row['chkid']));
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
 function findchkname($chkid){
     if($chkid==""){return "未知类型";}
     $sql="select chkname from bw_chkid where chkid='$chkid'";
     $rschk=loaddb($sql);
    if(mysqli_num_rows($rschk) >0){
        while ($row = mysqli_fetch_array($rschk, MYSQLI_ASSOC)) {
            return $row['chkname'];
        }  
    }else{
        return "未知类型";
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