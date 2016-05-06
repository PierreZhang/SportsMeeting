<div class="page-header">
	<h2>管理员</h2>
</div>
<div class="row">
	<div class="col-sm-3" id="DL">
		<ul style="list-style:none; margin:0; padding:0;">                          
			<li><a class="chgDR_link" chgDR_value="admin">首页</a></li>
			<li><a class="chgDR_link" chgDR_value="admin/profiles">全部帐户</a></li>
			<li><a class="chgDR_link" chgDR_value="admin/institutions">全部单位</a></li>
			<li><a class="chgDR_link" chgDR_value="public/changepwd">修改我的密码</a></li>
			<li><a class="chgDR_link" chgDR_value="admin/configurations">系统设置</a></li>
			<li><a class="chgDR_link" chgDR_value="admin/database">数据库操作</a></li>
			<li><a href="director">->转到：台长功能</a></li>
			<li><a href="logout">注销</a></li>
      	</ul>
	</div>
	<div class="col-sm-9" id="DR">
	<?php print_r(\Helpers\Session::display()); ?>
	</div>
</div>


