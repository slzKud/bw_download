 <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
             重置FTP设置
            </h4>
         </div>
         <div class="modal-body">
		 <?php
		  include_once  $_SERVER['DOCUMENT_ROOT'].'/module/mysqlaction.php';
		  $optftp=getthesettings('optftp');
		  if($optftp==1){
		echo "现在即将重置FTP数据库，系统会根据用户表信息自动重置FTP数据表。<br>对于你从管理界面修改了用户信息产生的FTP无法登陆问题非常有用。<br>你是否继续？";
		}else{
		echo "此功能被关闭，请开启FTP对接。";
		}
		?>
         </div>
         <div class="modal-footer">
		            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>
            <?php if($optftp==1){ echo "<button type='button' class='btn btn-danger' onclick='DelSomething();'>继续</button>"; }?>
			 <script>
		 function DelSomething(){
			$.post('todo.php', { type: "ftpreset"}, function (text, status) { 
			  alert(trim(text));
			  window.location.reload();	
			  });
	}
	function trim(str){ //删除左右两端的空格
　　     return str.replace(/\s/g,'');
　　 }
	</script>
         </div>
		 
