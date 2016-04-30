<?php
session_start();
if (strpos($_SESSION['transfer'],$_GET['item']) === false){
	$_SESSION['tempa']="IMCINA";
	$_SESSION['transfer']=$_SESSION['transfer'].",".$_GET['item'];
}else{
	$_SESSION['tempa']="IMCINB";
	$temp=",".$_GET['item'];
	$_SESSION['transfer']=str_replace($temp,"",$_SESSION['transfer']);
}
$_SESSION['tempa']="IMCIN";
?>