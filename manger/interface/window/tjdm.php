<?php
include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
$code=getthesettings('tjcode');
?>
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             统计代码
            </h4>
         </div>
         <div class="modal-body">
       <p>请在下面的文本框中输入自己网站的统计代码，一般可以从统计网站中得到。</p>
	   <textarea class="form-control" rows="6" id="codetxt"><?php echo $code; ?></textarea>
</div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <button type="button" class="btn btn-primary" onclick="AddSomething();">
               保存
            </button>
			<script>
		 function AddSomething(){
		 var code=document.getElementById("codetxt").value; 
		 //alert(code);
		  $.post('../manger/todo.php', {type: "modtjcode",code:code}, function (text, status) {
			switch(trim(text))
            {
            case "ok":
            alert("修改成功！");		
            break;
         default:
          alert("修改过程中发生错误，请检查！\n"+text);
}
			});
		 }
		 function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
</script> 
         </div>

