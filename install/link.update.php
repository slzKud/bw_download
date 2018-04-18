<?php
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
cleanlinks();
$sql="select id,download from bw_downtable";
	$rs=loaddb($sql);
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			addlinks($row['id'],$row['download']);
  }
  echo "ok";
function cleanlinks(){
    loaddb("delete from bw_filelinks");
}
function addlinks($id,$link)
{
    $sql1="INSERT INTO bw_filelinks (fileid,LinkDesc,B64Links) VALUES (".$id.", '"."默认链接"."','".base64_encode($link)."')";
	//echo $sql1;
	loaddb($sql1);
}
?>