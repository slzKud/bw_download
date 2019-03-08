<?php
/*代码来源自：https://jingyan.baidu.com/article/3d69c5518fe7e2f0cf02d70d.html。经稍加修改而成。*/
/*定义头文件为图片*/
session_start();
header("Content-type: image/PNG");

/*调用生成验证码函数*/

$c=getCode(4, 130, 50);
$_SESSION['authnum_session'] = $c;
/**

 * 定义生成验证码图片函数

 * @param int $num 生成验证码个数

 * @param int $w 图片宽

 * @param int $h 图片高

 */
function getCode($num, $w, $h) {

    $w = $w;
    
    $h = $h;
    
    /* 字体文件:注意路径
    
    * 如果没有字体文件，是无法输入显示图片的
    
    * */
    
    $fontface=dirname(dirname(__FILE__)).'/fonts/STXINGKA.TTF';
    
    /*随便找了篇新闻搞的*/
    
    $str = "希望广大干部群众贯彻新时代特色主义思想和的十九大精神坚持稳中求进工作总基调坚定贯彻新发展理念全面做好稳增长促改革调结构惠民生防风险保稳定各项工作着力深化改革开放增强经济发展新动能加大环境保护和整治力度加快社会事业发展不断开创富民兴陇新局面指出现在距离年完成脱贫攻坚目标任务只有两年时间正是最吃劲的时候必须坚持不懈做好工作不获全胜决不收兵要坚定信心不动摇贝塔沃德测试一二三四五六七八测试零章子怡汪峰薛之谦鲁迅郑苏海南楠男女";
    
    /**
    
    * 字符编码转换 UTF-8 == GBK
    
    * 如果不转换，图片将无法输出显示
    
    */
    
    $str = iconv('utf-8','gbk',$str);
    /*生成验证码*/

$code="";

for($i=0;$i<$num;$i++){

$Xi=mt_rand(0,strlen($str)/2);

if($Xi%2) $Xi+=1;

$code.=substr($str,$Xi,2);

}

/*创建图片*/

$im=imagecreatetruecolor($w,$h);

$bkcolor=imagecolorallocate($im,250,250,250);

imagefill($im,0,0,$bkcolor);
/*创建干扰线等*/

for($i=0;$i<15;$i++){

    $fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    
    imagearc($im,mt_rand(-10,$w),mt_rand(-10,$h),mt_rand(30,300),mt_rand(20,200),55,44,$fontcolor);
    
    }
    
    for($i=0;$i<255;$i++){
    
    $fontcolor=imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    
    imagesetpixel($im,mt_rand(0,$w),mt_rand(0,$h),$fontcolor);
    
    }
    
    /*将验证码写入到图片中*/
    
    for($i=0;$i<4;$i++){
    
    $fontcolor=imagecolorallocate($im,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
    
    $codex=iconv("GB2312","UTF-8",substr($code,$i*2,2));
    
    imagettftext($im,mt_rand(20,22),mt_rand(-60,60),30*$i+20,mt_rand(30,35),$fontcolor,$fontface,$codex);
    
    }
    
    /*输入图片*/
    
    imagepng($im);
    
    imagedestroy($im);

    return base64_encode($code);
    
    }