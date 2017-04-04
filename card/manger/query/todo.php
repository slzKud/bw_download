 <?php
 include_once dirname(dirname(dirname(__FILE__))).'/module/mysqlaction.php';
  include_once dirname(dirname(dirname(__FILE__))).'/module/cookiesmaker.php';
 include_once dirname(dirname(dirname(__FILE__))).'/module/useraction.php';
  if (isset($_COOKIE["bwcard"])){
      if(veifycookies($_COOKIE["bwcard"])=="incorrect！"){
	       echo "no qx";
    exit;
	   }
if(getper()!=4){
    echo "no qx";
    exit;
}
empty($_POST['type']) && $_POST['type']="other";
        switch($_POST['type']){
            case "bancard":
            $card=$_POST['card'];
            $sqlup="UPDATE bw_card SET status=-1 WHERE cardid = '$card'";
            loaddb($sqlup);
            echo "ok";
            break;
  default:
            echo "no type";
            exit;

        }
  }else{
echo "no cookies";
    exit;
}
  
  ?>