<?php
$emptychkid="abe07991317031b5bbd93b40814007";
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
//$str="Windows Essential Business Server 2008 (6.0.5609.2) [Japanese (Japan)]";
$sql="select id,Filename from bw_downtable where chkid='$emptychkid'";
	$rs=loaddb($sql);
	 while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
            $a=explode(" (",$row['Filename']);
            $ckid=getchkid($a[0]);
            echo $row['Filename']." -> ".$a[0]." -> ".$ckid;
            loaddb("UPDATE `bw_download`.`bw_downtable` SET `chkid` = '$ckid' WHERE id=".$row['id']);
            echo " -> ok<br>";
  }

function getchkid($chkname){
    //如果存在 返回chkid 不存在则调用程序新建
    $rschk=loaddb("SELECT chkid FROM bw_chkid where chkname='$chkname'");
	if(mysqli_num_rows($rschk) >0){
        $rowg = mysqli_fetch_array($rschk, MYSQLI_ASSOC);
        return $rowg['chkid'];
	}else{
    $chkid=md5($chkname.time()."!!!");
	$sql1="INSERT INTO bw_chkid (chkid,chkname) VALUES ('$chkid','$chkname')";
    loaddb($sql1);
    return $chkid;
    }
}
?>