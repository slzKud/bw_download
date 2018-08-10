<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             批量修改资源类型
            </h4>
         </div>
<?php
 include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
 session_start();
 empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
//$_SESSION['transfer']="";
if ($temp =="")
{
	  echo '<div class="modal-body">
	  你咋啥都没选呢~
	  </div>
	  <div class="modal-footer"> 
	  <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
			</div>';
	  exit; 
}      
echo "<input type='hidden' value='$temp' id='loadapp' />";
?>
  <div class="modal-body">
<form role="form">
  <div class="form-group">
    <label for="name">修改的资源列表：</label>
    <select multiple class="form-control" >
      <?php
      $sql1="select Filename from bw_downtable where id in (".$temp.")";
      $rs=loaddb($sql1);
      while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
          {
            echo "<option>".$row['Filename']."</option>";
          }   
      ?>
    </select>
    <label for="name">要修改成的资源类型：</label>
    <select class="form-control" id="chkselectA">
    <option value="fake">请选择分类类别</option>
   <?php
    $sql="select chkid,chkname from bw_chkid where motherid='' order by chkname asc";
    //echo $sql;
    $rs=loaddb($sql);
    if (mysqli_num_rows($rs)> 0){
        while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			echo "<option value = '".$row['chkid']."' >".$row['chkname']."</option>";
  }
    }else{
        echo "<option>分类未找到</option>";
    }
    ?>
    </select>
  </div>
</form>
</div>
 <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="Movechk();">
               修改
</button>
<script src="../js/jquery.base64.js"></script>
<script>
function Movechk(){
  ids=$("#loadapp").val();
  ids_b64=$.base64.btoa(ids);
  chkid=$("#chkselectA").val();
  if(chkid=="fake"){
    alert('请选择类型！');
    return 0;
  }
  console.log(chkid+":"+ids+":"+ids_b64);
  $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=allmodifychk&chkid="+chkid+"&ids="+ids_b64,
    async:false,
    success:function(data){
       if(data=="ok"){
         alert("处理成功");
         window.location.reload();		
       }
    }
  });
}
</script>