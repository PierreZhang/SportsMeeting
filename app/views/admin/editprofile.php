<div class="page-header">
	<h2>修改已有用户资料</h2>
</div>
<div class="alert" style="display:none"></div>
<form method="POST" id="selectprofile">
	请选择一个现有用户： <div class="input-block"><select name="selectprofile">
		<?php
			foreach($data['profiles_core'] as $i_=>$o_)
				echo '<option value=\'',$o_->id,'\'>ID=',$o_->id,' | 用户名=',$o_->name,'</option>';

		?>
	</select></div><br />
</form>
<form method="POST" id="editprofile" style="display:none">
	用户名： <div class="input-block"><input type="text" name="name" placeholder="用户名" /></div><br />
	启用： <div class="input-block"><input type="checkbox" name="enabled" value="1" /></div><br />
	身份： <select name="authority">
			<option value="Z0">管理员</option>
			<option value="A3">台长</option>
			<option value="B3">总编辑</option>
			<option value="B6">副总编辑</option>
			<option value="C6">播音员</option>
			<option value="D6">单位用户</option>
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
	var id;

	$("form#selectprofile select[name=selectprofile]").change(function(){
		$("form#editprofile").css("display","none");
		$("form#editprofile input[name=enabled]").prop("checked", false);
		$("form#editprofile input[name=institution]").prop("checked", false);
		id=$("form#selectprofile select[name=selectprofile]").val();
		$.ajax({
			url: "admin/editprofile",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				getaprofile: "true",
				id: id
			},
			success: function(data, status){
				console.log(data);
				data=eval("("+data+")");
				//console.log(data);

				for(var i_=0, l_=data.length; i_<l_; i_++){
					//console.log(i_);
					for(var k_ in data[i_]){
						if(k_=='name') {
							$("form#editprofile input[name=name]").val(data[i_][k_]);
						}
						else if(k_=='enabled') {
							if(data[i_][k_]==1) {
								$("form#editprofile input[name=enabled]").prop("checked", true);
							}
						}						
						else if(k_=='authority_id'){
							$("form#editprofile select[name=authority]").val(data[i_][k_]);
						}
						else if(k_=='institution_id'){
							var institution_id=data[i_][k_];
							$("form#editprofile input[name=institution][value="+institution_id+"]").prop("checked", true);
						}
						else if(k_=='description'){
							$("form#editprofile textarea[name=description]").val(data[i_][k_]);
						}
					}
				}
				$("form#editprofile").css("display","block");
			}
		});
	});

	$("form#editprofile input[type=submit]").click(function(){
		$.ajax({
			url: "admin/editprofile",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				editprofile: "true",
				id: id,
				name: $("form#editprofile input[name=name]").val(),
				enabled: Number($("form#editprofile input[name=enabled]").is(":checked")),
				authority: $("form#editprofile select[name=authority]").val(),
				institution: $("form#editprofile input[name=institution]").serializeArray(),
				description: $("form#editprofile textarea[name=description]").val()
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("用户信息已成功修改。").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	});
});
</script>