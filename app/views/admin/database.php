<div class="alert" style="display:none"></div>
<div id="mask" style="display:none; position:absolute; top:0; left:0; width:100%; height: 100%; background:rgba(255,255,255,0.8);">
	<div id="mask-content"></div>
	<button class="broadcast" style="width:100px; height:55px;" contribution_id="">已播出</button>
</div>
<?php echo "SELECT `TABLE_NAME` FROM `information_schema`.`tables` WHERE `table_schema`='".DB_NAME."'"; ?>
<div class="row">
	<button name="backup">备份数据库</button><br />
	<button name="truncate">删除并初始化数据库</button>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("button[name=backup]").click(function(){
		$.ajax({
			url: "admin/database",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				backup: 'true'
			},
			success: function(data, status){
				alert('未实现');
			}
		});
	});
	$("button[name=truncate]").click(function(){
		var verification;
		if(confirm("-----------------------\n确定重置数据库吗？\n-----------------------\n1、数据库的重置行为是不能恢复的、不可逆转的！如果您需要备份数据库，请点击取消然后备份。\n2、如果您不知道您现在在做什么，同样点击取消。")){
			if(verification=prompt("如果您确认当前操作，请输入您当前账号的密码，并点击确定！\n点击确定后重置操作将被无情地执行。\n\n祝您好运，再见。当前用户密码：")){
				$.ajax({
					url: "admin/database",
					datatype: "json",
					async: true, 
					type: "POST",
					data: {
						truncate: 'true',
						verification: verification
					},
					success: function(data, status){
						if(data==0){
							$("div.alert").addClass("alert-success").html("数据库已经成功重置！").fadeIn(250).fadeOut(1500);
							alert("数据库已经成功重置！请知悉管理员登陆信息：ID=1，密码=peter。");
							alert("即将登出。请用管理员身份登陆：ID=1，密码=peter。");
							location.href = "logout";
						}
						else if (data==1)
							$("div.alert").addClass("alert-danger").html("密码错误，或者出现了一个未知的错误。").fadeIn(250).fadeOut(1500);
					}
				});
			}
			else{
				$("div.alert").addClass("alert-danger").html("重置任务被取消。").fadeIn(250).fadeOut(1500);
			}
		}
		else {
			$("div.alert").addClass("alert-danger").html("重置任务被取消。").fadeIn(250).fadeOut(1500);
		}
	});


})
</script>