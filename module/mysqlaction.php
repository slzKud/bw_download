<?php
//mssql操作
include_once dirname(dirname(__FILE__)).'/settings/db.php';
function connectdb() {
	/* $dblist=array (
'dbhost'=>"127.0.0.1",
'dbuser'=>"root",
'dbpass'=>"root",
'dbname'=>"bw_download"
); */
  //$conc = mysql_connect($GLOBALS['dblist']['dbhost'],$GLOBALS['dblist']['dbuser'],$GLOBALS['dblist']['dbpass']);
 
try { 
 $conc = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
  if (!$conc)
  {
  echo "<meta http-equiv='refresh' content='0;url=../error.php?err=1'> ";
  }
  return $conc;
  }catch(Exception $e) {
	  echo "<meta http-equiv='refresh' content='0;url=../error.php?base64=".base64_encode($e->getMessage())."'> ";
	  }
}
function loaddb($sql) {
  $cona=connectdb();
  mysqli_query($cona,"set names 'utf8'");
  $result = mysqli_query($cona,$sql);
  closedb($cona);
  return $result;
}
function closedb($con) {
  mysqli_close($con);
}
  function getthesettings($name) {
  $sql="select setvalue from bw_settings where setname='$name'";
  $rs=loaddb($sql);
  //echo $sql.'<br>';
  if (mysqli_num_rows($rs)>0){
	  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
	  return $row['setvalue'];
  }else{
	  return "error";
  } 
}
 function savethesettings($name,$setvalue) {
  $sql="select id from bw_settings where setname='$name'";
  $rs=loaddb($sql);
  $sql1="";
  if (mysqli_num_rows($rs)>0){
	 $sql1="UPDATE bw_settings SET setvalue = '$setvalue' WHERE setname = '$name'";
  }else{
	  $sql1="INSERT INTO bw_settings (setname,setvalue) VALUES( '$name', '$setvalue')";
  } 
  //echo $sql1;
  loaddb($sql1);
}
?>