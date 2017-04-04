<?php
/*
调用范例
程序内调用，不可直接访问。
Info:显示信息
SDO(卡号)：程序调用的正式程序 1为成功 -1为失败
Test(卡号):用于测试,实际数据不影响。
*/
empty($doflag)&&$doflag=0;
if($doflag!=1){
    echo info();
    exit;
}
function info(){
    return"实例调用文件，不可直接访问！";
}

function s_do($card){
    //echo "DO!!!!!!!!12471234!";
    return 1;
}
function s_test($card){
    return 1;
}
?>