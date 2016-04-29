<?php
//mssql操作
	
//include_once $_SERVER['DOCUMENT_ROOT'].'/settings/db.php';
function connectdb() {
	$dblist=array (
'dbhost'=>"127.0.0.1",
'dbuser'=>"root",
'dbpass'=>"root",
'dbname'=>"bw_download"
);
  //$conc = mysql_connect($GLOBALS['dblist']['dbhost'],$GLOBALS['dblist']['dbuser'],$GLOBALS['dblist']['dbpass']);
  $conc = mysqli_connect($dblist['dbhost'],$dblist['dbuser'],$dblist['dbpass'],$dblist['dbname']);
  if (!$conc)
  {
  die('Could not connect: ' . mysqli_error());
  }
  return $conc;
}


function loaddb($sql) {
  $cona=connectdb();
  $result = mysqli_query($cona,$sql);
  closedb($cona);
  return $result;
}
function closedb($con) {
  mysqli_close($con);
}
  

?>