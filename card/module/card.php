<?php
include_once 'mysqlaction.php';
//makecardidtodb("30元5mb",15,0);
function makecardidtodb($type,$num,$flag){
    //获取typeid
    $sql1="select id from bw_cardtype where fname='$type'";
    $con=loaddb($sql1);
    $row=mysqli_fetch_array($con);
	$typeid=$row['id'];
    //循环生成并导入
    $card['x'] = "t";
    for ($x=0; $x<=$num; $x++) {
     //时间戳
    $t=time();
    $tdate=unixtime_to_date($t);
    $card=makecardid($typeid,$t);
    $sql1="INSERT INTO bw_card (cardid,cardtype,status,createdate) VALUES( '$card', '$type', 0, '$tdate')";
    //echo $sql1."<br>";
    loaddb($sql1);
    if($flag==1){
      if($x==0){echo $card;}
       if($x!=0){echo "\n".$card;}
    }
     }
}
function makecardid($typeid,$t){
    /*
    算法：BW+md5（"!@#thisthebestgirl."+typeid+t+rnd(2)+"bwcard2017/*-")（10)+rnd->char(2)+typeid->char(1)+S
    共16位
    */
    $n_rnd=mt_rand(10,100);
    $c_rnd=tochar(substr($n_rnd,0,1)).tochar(substr($n_rnd,1,1));
    $r="!@#thisthebestgirl.".$typeid.$t.$n_rnd."bwcard2017/*-";
    $md5r=substr(md5($r),0,10);
    $card="BW".$md5r.$c_rnd.tochar(substr($typeid,0,1))."S";
   // echo $typeid."<br>".$t."<br>".$n_rnd."<br>". $c_rnd."<br>".$r."<br>".$md5r."<br>";
    //echo strtoupper($card)."<br>";
    return strtoupper($card);
    
}
function verfiycardid($cardid,$t,$typeid){
    /*
    算法：BW+md5（"!@#thisthebestgirl."+typeid+t+rnd(2)+"bwcard2017/*-")（10)+rnd->char(2)+typeid->char(1)+S
    共16位
    */
    $c_rnd=substr($cardid,12,2);
    $n_rnd=tonum(substr($c_rnd,0,1))*10+tonum(substr($c_rnd,1,1));
    $r="!@#thisthebestgirl.".$typeid.$t.$n_rnd."bwcard2017/*-";
    $md5r=substr(md5($r),0,10);
    $card=strtoupper("BW".$md5r.$c_rnd.tochar(substr($typeid,0,1))."S");
    //echo $cardid."<br>".$n_rnd."<br>". $c_rnd."<br>".$r."<br>".$md5r."<br>";
    if($card==$cardid){
        //echo "OK"."<br>";
        return 1;
    }else{
        //echo "FALL"."<br>";
        return -1;
    }
    
    
}
function tochar($num){
    $charset = "QWERTYULOPASDFGHJKZXCVBNM";//随机因子
    return substr($charset,$num-1,1);
}
function tonum($char){

   $charset = "MQWERTYULOPASDFGHJKZXCVBN";//随机因子
return strpos($charset,$char);
}
function unixtime_to_date($unixtime, $timezone = 'PRC') {
    $datetime = new DateTime("@$unixtime"); //DateTime类的bug，加入@可以将Unix时间戳作为参数传入
    $datetime->setTimezone(new DateTimeZone($timezone));
    return $datetime->format("Y-m-d H:i:s");
}
?>