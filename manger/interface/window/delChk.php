<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             删除资源类型
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
}else{
  $sql="select chkname from bw_chkid where chkid='$temp'";
  $rs=loaddb($sql);
  $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
}      
echo "<input type='hidden' value='$temp' id='loadapp' />";
?>
  <div class="modal-body">
<form role="form">
  <div class="form-group">
    <label for="name">删除的类型：<?php echo($row['chkname']); ?>(类型ID：<?php echo($temp);?>)</label>
    
<div>
<label for="name">该类型所含资源的去留：</label>
    <label class="radio-inline">
        <input type="radio" name="opt" id="opt1" value="option1" checked> 保留，并转移到另一个类型中
    </label>
    <label class="radio-inline">
        <input type="radio" name="opt" id="opt2"  value="option2"> 全部删除（慎用！）
    </label>
</div>
    <label for="name">该类型所含资源要修改成的新资源类型（如果选择了第一个选项）：</label>
    <select class="form-control" id="chkselectA">
    <option value="fake">请选择新的分类类别</option>
   <?php
    $sql="select chkid,chkname from bw_chkid where motherid='' and chkid <> '$temp' order by chkname asc";
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
            <button type="button" class="btn btn-danger" onclick="delchk();">
               删除
</button>
<script src="../js/jquery.base64.js"></script>
<script>
function delchk(){
  chkid=$("#loadapp").val();
  if($("input[type='radio']:checked").val()=="option1"){flag=1;}else{flag=2;}
  newchkid=$("#chkselectA").val();
  if(newchkid=="fake" && flag==1){
    alert('请选择类型！');
    return 0;
  }
  if(flag==2){
    r=confirm("你确认要这样做吗？");
    if(!r){return 0;}
  }
  console.log(chkid+":"+flag+":"+newchkid);
  $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=delchk&chkid="+chkid+"&flag="+flag+"&newchkid="+newchkid,
    async:false,
    success:function(data){
       if(data=="ok"){
         alert("处理成功");
         window.location.reload();		
       }else{
         alert(data);
       }
    }
  });
}
</script>