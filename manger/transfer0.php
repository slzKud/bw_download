<?php
session_start();
	$temp=",".$_GET['item'].",";
if (strpos($_SESSION['transfer'],$temp) === false){
	$_SESSION['tempa']="IMCINA";
	$_SESSION['transfer']=$_SESSION['transfer'].",".$_GET['item'];
}else{
	$_SESSION['tempa']="IMCINB";
	$_SESSION['transfer']=str_replace($temp,",",$_SESSION['transfer']);
}
?>