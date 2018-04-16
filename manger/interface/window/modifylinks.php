<?php
include_once  dirname(dirname(dirname(dirname(__FILE__)))).'/module/mysqlaction.php';
session_start();
empty($_SESSION['transfer'])&& $_SESSION['transfer']="";
empty($temp)&& $temp="";
$temp=$_SESSION['transfer'];
$sql="select LinkDesc,B64Links from bw_filelinks where fileID=".$temp."";
//echo $sql;
$links="";
$rs=loaddb($sql);
    if (mysqli_num_rows($rs)> 0){
        while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
         {
			$links=$links.$row['LinkDesc']." ".base64_decode($row['B64Links'])."\n";
  }
    }else{
      $links="";
    }
    echo "<input type='hidden' value='$temp' id='loadapp' />";
    ?>
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             修改文件链接信息
            </h4>
         </div>
         <div class="modal-body">
       <p>请在下面的文本框中添加更改自己的链接，链接名和链接以英文空格分割。(建议链接带上完整协议名）</p>
       <p>如：百度网盘 https://www.baidu.com</p>
       <p>快速添加：</p>
<div class="form-inline" role="form">
  <div class="form-group">
    <input type="text" class="form-control" id="linkname" placeholder="请输入链接名称">
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="link" placeholder="请输入链接">
  </div>
  <div class="form-group">
  <button onclick="addtext();" class="btn btn-success">添加</button>
  </div>
</div>
<br>
	   <textarea class="form-control " rows="6" id="codetext"><?php echo $links; ?></textarea>
</div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="submitNcheck();">
               保存
            </button>
            <script src="../js/jquery.base64.js"></script>
			<script>
      function addtext(){
        var l=$("#linkname").val();
        var s=$("#link").val();
        var k=$("#codetext").val();
        if(trim(l)=="" || trim(s)==""){
          alert("元素不能为空");
          return 0;
        }else{
          if(!isURL(s)){
            alert("链接不合法");
          return 0;
          }
          if(k.indexOf(l+" ")!=-1){
            alert("链接名已存在");
            return 0;
          }
          $("#codetext").append(l+" "+s+"\n");
          $("#linkname").val("");
          $("#link").val("");
        }
      }
      function submitNcheck(){
        //check
        var s=new Array();
        var links=$("#codetext").val();
        var f=$("#loadapp").val();
        if(trim(links)!=""){
          s=links.split("\n");
        }else{
          alert("文本为空");
          return 0;
        }
        cleanlinks(f);
        s.forEach(function(item,index){
          if(item.indexOf(" ")==-1 && trim(item)!=""){
            alert("第"+(index+1)+"行格式不合法。");
            return 0;
          }
          if(trim(item)!=""){
            //console.log(index+":"+item);
            var s1=item.split(" ");
            if(!isURL(s1[1])){
              alert("第"+(index+1)+"行链接不合法。");
              return 0;
            }
            //submit
            addlinks(f,s1[0],s1[1]);
            //console.log(s1[0]+":"+s1[1]);
          }
        });
        alert('修改成功！');
      }
      function cleanlinks(fileid){
           var f=-1;
       $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=cleanlinks&fileid="+fileid,
    async:false,
    success:function(data){
       if(data=="ok"){
         f=1;
       }
    }
  });
  return f;
      }
      function addlinks(fileid,d,l){
      var f=-1;
       $.ajax({
    type:"POST",
    url:"todo.php",
    data:"type=addlinks&fileid="+fileid+"&desc="+d+"&b64="+$.base64.btoa(l),
    async:false,
    success:function(data){
       if(data=="ok"){
         f=1;
       }
    }
  });
  return f;
      }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
function isURL(str){
    return !!str.match(/(((^https?:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)$/g);
  }
</script> 

         </div>

