<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/module/cookiesmaker.php'; 
 if (isset($_COOKIE["bwuser"])){
     echo "raw cookies:".$_COOKIE["bwuser"]."<br>";
     $username=getSubstr($_COOKIE["bwuser"],"username=",";bwcode=");
	$bwcode=getSubstr($_COOKIE["bwuser"],"bwcode=",";end");
    echo "username:".$username."<br>";
     echo "bwcode:".$bwcode."<br>";
     $new=makebwcode($username,$bwcode);
     echo "new bwcode:".$new."<br>";
     $result=veifycookies($_COOKIE["bwuser"]);
      echo "result:".$result."<br>";
 }
 ?>