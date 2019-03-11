<!-- 模态框（Modal） -->
<div class="modal fade" id="SiteNotice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					站点公告
				</h4>
			</div>
			<div class="modal-body">
				因软件升级原因，新的用户名规范已经确认为：<br><br>
				<p>1.用户名为3位以上并不超过12位，且不能包括<b>特殊符号和空格</b>，如#等</p>
				对此，我们将启用临时修改用户名的通道：<a href='user/changeusername-temp.php'target="_blank">点我</a>.<br><br>请尽快更改用户名以符合规范,以免损失你的账户。
				<br><br>BetaWorld 管理组 2019.3.10
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" onclick="closei();">不再显示此公告
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭并稍后提醒我
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
<script>
    function setCookie(c_name,value,expiredays)
    {
        var exdate=new Date();
        exdate.setDate(exdate.getDate()+expiredays);
        document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
    }
    function getCookie(c_name)
    {
        if (document.cookie.length>0)
        {
            c_start=document.cookie.indexOf(c_name + "=")
            if (c_start!=-1)
            { 
                c_start=c_start + c_name.length+1;
                c_end=document.cookie.indexOf(";",c_start);
                if (c_end==-1) c_end=document.cookie.length;
                return unescape(document.cookie.substring(c_start,c_end));
            } 
         }
    return "";
    }
    function closei(){
        setCookie("bwnotice","checked",45)
        $('#SiteNotice').modal('hide');
    }
    window.onload = function(){
        if (getCookie('bwuser')!="" && getCookie('bwnotice')==""){$('#SiteNotice').modal('show');}
    };
</script>