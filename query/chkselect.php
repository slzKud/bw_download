<?php
empty($_GET['chkid']) && $_GET['chkid']="";
session_start();
if($_GET['chkid']==""){
    exit("no chkid");
}
if($_GET['chkid']=="clean"){
    $_SESSION['chkid']="";
}else{
    $_SESSION['chkid']=$_GET['chkid'];
}

echo "ok";
?>