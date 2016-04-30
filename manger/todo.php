<?php
//how?
include_once $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
try {  
switch ($_GET['type'])
{
case "delfiles":
  //É¾³ý
  $dellist=$_GET['filelist'];
  $sql="delete from bw_downtable where id in (".$filelist.")";
  loaddb($sql);
  echo "ok"
  break;  
case "addfiles":
 //Ìí¼Ó
  break;
default:
  code to be executed
  if expression is different 
  from both label1 and label2;
}
} catch (Exception $e) {   
echo "error!"  
exit();   
}  

?>