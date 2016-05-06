<div class="page-header">
	<h2>重置用户密码</h2>
</div>
<div class="alert" style="display:none"></div>
<form method="POST" id="resetpassword">
	请选择一个现有用户： <div class="input-block"><select name="selectprofile">
		<?php
			foreach($data['profiles_core'] as $i_=>$o_)
				echo '<option value=\'',$o_->id,'\'>ID=',$o_->id,' | 用户名=',$o_->name,'</option>';

		?>
	</select></div><br />
	<input type="submit" name="submit" onclick="javascript:return false;" />
</form>


<script type="text/javascript">
$(document).ready(function(){
	var id;

	$("form#resetpassword select[name=selectprofile]").change(function(){
		id=$("form#resetpassword select[name=selectprofile]").val();
	});

	$("form#resetpassword input[type=submit]").click(function(){
		$.ajax({
			url: "admin/resetpassword",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				verifiedtoresetpassword: "true",
				id: id
			},
			success: function(data, status){
				if(data==0)
					$("div.alert").addClass("alert-success").html("密码已成功修改。").fadeIn(250).fadeOut(1500);
				else if (data==1)
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
			}
		});
	});
});
</script>