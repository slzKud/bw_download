<?php
ini_set('memory_limit', '2G');
spl_autoload_register('go_class');
function go_class($class)
{
    if (strpos($class, 'ipip\db') !== FALSE)
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/module/' . implode(DIRECTORY_SEPARATOR, explode('\\', $class)) . '.php';
    }
}

function getIPLocCode_ipip($queryIP){ 
    if($queryIP==""){return "XX";}
        $city = new ipip\db\City(dirname(dirname(dirname(__FILE__))).'/module/ipip/db/ipipfree.ipdb');
        $loc=$city->find($queryIP,'CN');
        if($loc[0]=='中国'){
            return 'CN';
        }else{
            return 'XX';
        }
} 
function getIPLoc_ipip($queryIP){ 
    if($queryIP==""){return "未知";}
    $city = new ipip\db\City(dirname(dirname(dirname(__FILE__))).'/module/ipip/db/ipipfree.ipdb');
    $loc=$city->find($queryIP,'CN');
    $loc1=$loc[1].$loc[2];
    return $loc1;
} 
?>