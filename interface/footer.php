<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
include_once  $_SERVER['DOCUMENT_ROOT'].'/settings/ver.php';
$tjon=getthesettings('optthetj');
$code=getthesettings('tjcode');
?>
<script type="text/javascript" src="../module/oneword.php?encode=js"></script>
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
   <p><center>BetaWorld资源区(Version <?php echo DVER; ?> Build <?php echo BUILDDATE; ?> )<?php if($tjon==1){echo $code;} ?></center> </P>
</nav>