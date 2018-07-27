<?php include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php'; ?>
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Cache" content="no-cache">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             添加资源
            </h4>
         </div>
         <div class="modal-body">
            <form role="form">
  <div class="form-group">
    <label for="name">资源名称</label>
    <input type="text" class="form-control" placeholder="请输入资源名称" name="zytitle" id='bwname'>
	</div>
	  <div class="form-group">
    <label for="name">资源地址</label>
    <input type="text" class="form-control" placeholder="请输入资源下载时跳转的下载地址" name="zylink" id="bwlink">
	</div>
	<div class="form-group">
	 <label for="name">资源下载权限</label>
      <select class="form-control" id='bwqx'>
         <option>游客</option>
         <option>普通用户</option>
         <option>高级用户</option>
		   <option>VIP</option>
         <option>机密</option>
      </select>
 
</div>
<div class="form-group">
    <label for="name">资源分类选择</label>
    <select class="form-control" id="chkselect">
   <option value="fake">请选择分类类别</option>
   <?php
    $sql="select chkid,chkname from bw_chkid where motherid=''";
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
            <button type="button" class="btn btn-primary" onclick="AddSomething();">
               添加
            </button>
			<script>
		 function AddSomething(){
		 var zyname=document.getElementById("bwname").value; 
		 var zylink=document.getElementById("bwlink").value; 
     var zyqxname=document.getElementById("bwqx").value; 
     var chkid=$("#chkselect").val();
     var sf=scanfile(zyname);
     if(chkid=="fake"){
       alert("必须选择一个类型");
       return 0;
     }
     if(sf=="yes"){
       alert("文件已重复，请换个文件名吧～");
       return 0;
     }
		 switch(zyqxname)
            {
            case "游客":
            var zyqx=-1;
            break;
           case "普通用户":
            var zyqx=1;
          break;
		  case "高级用户":
           var zyqx=2;
          break;
		   case "VIP":
           var zyqx=3;
          break;
		    case "机密":
          var zyqx=4;
          break;
         default:
         var zyqx=0;
		 }
		    $.post('../manger/todo.php', { type: "addfiles", zyname:zyname,zylink:zylink,zyqx:zyqx,chkid:chkid }, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("添加成功！");
            window.location.reload();		
            break;
           case "no name":
            alert("欸，你没写名字啊！");
          break;
		  case "no link":
            alert("欸，链接无效啊！");
          break;
		  case "no qx":
            alert("欸，权限不对啊！");
          break;
		   case "Error":
            alert("Opps,发生错误！");
          break;
         default:
          alert("这是啥啊@#￥！");
}
			});

//alert('资源名称:'+zyname+'\n资源链接:'+zylink+'\n资源权限：'+zyqx);
		 }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
    function scanfile(filename){
      var f="";
    $.ajax({
        type:"POST",
        url:"todo.php",
        data:"type=scanfile&chkname="+filename,
        async:false,
        success:function(data){
            f=trim(data);
        }
      });
      return f;
    }
</script> 
         </div>

