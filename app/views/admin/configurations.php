<div class="page-header">
	<h2>系统开关</h2>
</div>
<div class="alert" style="display:none"></div>
<div class="row">
	允许登陆： <div id="Login"></div>
	允许提交稿件： <div id="Contribute"></div>
	站点名称：<input type="text" name="site_name" value="<?php echo $data['site_name'];?>" /><button name="site_name">提交站点名称</button><br />
	紧急联络人信息：<textarea name="emergency_contact"><?php echo $data['emergency_contact'];?></textarea><button name="emergency_contact">提交紧急联络人信息</button>
</div>
<script type="text/javascript">
$('#Login').iphoneSwitch(
	<?php echo $data['login']; ?>, function() {
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				loginswitch: "true",
				value: "1"
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("“允许登陆”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	}, function() {
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				loginswitch: "true",
				value: "0"
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("“禁止登陆”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	}, {
		switch_on_container_path: '/app/templates/default/img/iphone_switch_container_off.png'
	});
$('#Contribute').iphoneSwitch(
	<?php echo $data['contribute']; ?>, function() {
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				contributeswitch: "true",
				value: "1"
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("“允许提交稿件”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	}, function() {
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				contributeswitch: "true",
				value: "0"
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("“禁止提交稿件”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	}, {
		switch_on_container_path: '/app/templates/default/img/iphone_switch_container_off.png'
	});
$(document).ready(function(){
	$("button[name=site_name]").click(function(){
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				site_name: 'true',
				value: $("input[name=site_name]").val()
			},
			success: function(data, status){
				console.log(data);
				if(data==0)
					$("div.alert").addClass("alert-success").html("“站点名称”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	});
	$("button[name=emergency_contact]").click(function(){
		$.ajax({
			url: "admin/configurations",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				emergency_contact: 'true',
				value: $("textarea[name=emergency_contact]").val()
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("“紧急联络人信息”设置成功！").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	});


})
</script>