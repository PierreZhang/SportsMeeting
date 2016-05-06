<div class="page-header">
	<h2>添加一个新的用户</h2>
</div>
<div class="alert" style="display:none"></div>
<form method="POST" id="newprofile">
	用户名： <div class="input-block"><input type="text" name="name" placeholder="用户名" /></div><br />
	密码： <div class="input-block"><input type="text" name="credential_raw" placeholder="密码" /></div><br />
	启用： <div class="input-block"><input type="checkbox" name="enabled" value="1" checked /></div><br />
	身份： <select name="authority">
			<option value="false">=====</option>
				<optgroup label="管理人员">
					<option value="Z0">管理员</option>
					<option value="A3">台长</option>
				</optgroup>
				<optgroup label="工作人员">
					<option value="B3">总编辑</option>
					<option value="B6">副总编辑</option>
					<option value="C6">播音员</option>
				</optgroup>
				<optgroup label="客户">
					<option value="D6">学院用户</option>
				</optgroup>
		</select></div><br />
	所属单位： <div class="input-block"><?php
		//echo '<pre>';
		//var_dump($data['institutions'][1]);
		//echo '</pre>';
		foreach($data['institutions'][1] as $k_=>$o_){
			echo '<input type=\'checkbox\' name=\'institution\' value=\'',$o_->id,'\' title=\'',$o_->description,'\' /><font title=\'',$o_->description,'\'>',$o_->name,'</font>  ';
			if($k_%4==0 && $k_!=0)
				echo '<br />';
		}?></div><br />
	其他说明： <div class="input-block"><textarea name="description"></textarea></div><br />
	<input type="submit" name="submit" onclick="javascript:return false;" />
	<input type="reset" />
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("form#newprofile input[type=submit]").click(function(){
		if($("form#newprofile input[name=name]").val()==null || $("form#newprofile input[name=name]").val()=="")
			$("div.alert").addClass("alert-danger").html("请填写用户名").fadeIn(250).fadeOut(1500);
		if($("form#newprofile input[name=credential_raw]").val()==null || $("form#newprofile input[name=credential_raw]").val()=="")
			$("div.alert").addClass("alert-danger").html("请填写登陆密码").fadeIn(250).fadeOut(1500);
		if(($("select[name=authority]").val()=='Z0' || $("select[name=authority]").val()=='A3' || $("select[name=authority]").val()=='B3' || $("select[name=authority]").val()=='C3' || $("select[name=authority]").val()=='D6') && $("form#newprofile input[name=institution]").serializeArray().length!=1){
			$("div.alert").addClass("alert-danger").html("该身份只能选择一个单位。").fadeIn(250).fadeOut(1500);
		} else
			$.ajax({
				url: "admin/newprofile",
				datatype: "json",
				async: true, 
				type: "POST",
				data: {
					submit: "true",
					name: $("form#newprofile input[name=name]").val(),
					credential_raw: $("form#newprofile input[name=credential_raw]").val(),
					enabled: Number($("form#newprofile input[name=enabled]").is(":checked")),
					authority: $("form#newprofile select[name=authority]").val(),
					institution: $("form#newprofile input[name=institution]").serializeArray(),
					description: $("form#newprofile textarea[name=description]").val()
				},
				success: function(data, status){
					if(data==0)
						$("div.alert").addClass("alert-success").html("用户已成功添加。").fadeIn(250).fadeOut(1500);
					else if (data==1)
						$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
				}
			});
	});

	$("select[name=authority]").change(function(){
		if($(this).val()=='Z0' || $(this).val()=='A3' || $(this).val()=='B3' || $(this).val()=='C6'){//管理员，台长，总编辑，播音员
			$("input[type=checkbox][name=institution]").prop("checked",false);
			$("input[type=checkbox][name=institution][value=1]").prop("checked",true);
		}
		else{
			$("input[type=checkbox][name=institution]").prop("checked",false);
		}
	});
});
</script>