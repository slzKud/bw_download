<?php
include_once dirname(dirname(__FILE__)).'/module/mysqlaction.php';
//echo(calcdowncountbyuser("slzkud",getnowdate()));
function calcdowncountbyuser($username,$downdate){
    $sql="select count(*) as timecount from bw_downloadhistory where downuser='$username' and downtime between '$downdate 00:00:00' and '$downdate 23:59:59' ";
    $rs=loaddb($sql);
    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    return $row['timecount'];
}
function calcdowncountbyip($ip,$downdate){
    $sql="select count(*) as timecount from bw_downloadhistory where ip='$ip' and downtime between '$downdate 00:00:00' and '$downdate 23:59:59' ";
    $rs=loaddb($sql);
    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    return $row['timecount'];
}
function getnowdate(){
    $t=time();
    $s=date("Y-m-d",$t);
    return $s;
}
function getusercount($per){
    switch($per){
        case 0:
        return(1);
        break;
        case 1:
        return(10);
        break;
        case 2:
        return(20);
        break;
        case 3:
        return(9999);
        break;
        case 4:
        return(9999);
        break;
    }
}
?>