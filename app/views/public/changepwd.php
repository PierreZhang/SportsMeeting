<div id="changepwdalert" class="alert" style="display:none; width: 400px;"></div>
<form method="POST" id="interval">
您的旧密码 <input type="text" name="oldpwd" /><br />
一个新的密码 <input type="text" name="newpwd" /><br />
确认您的新密码 <input type="text" name="repeatnewpwd" /><br />
<input type="submit" value="提交" onclick="javascript:return false;" />
</form>
<script type="text/javascript">
$(document).ready(function(){
	$("input[type=submit]").click(function(){
		if($("input[type=text][name=newpwd]").val()!=$("input[type=text][name=repeatnewpwd]").val()){
			$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("新的密码不一致，请重新输入。").hide().fadeIn(250);
		}
		else if($("input[type=text][name=newpwd]").val()==""){
			$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("密码不能为空！").hide().fadeIn(250);
		}
		else{
			$.ajax({
				url: "/public/changepwd1",
				datatype: "json",
				async: true, 
				type: "POST",
				data: {
					oldpwd: $("input[type=text][name=oldpwd]").val(),
					newpwd: $("input[type=text][name=newpwd]").val()
				},
				success: function(data){
					data=eval('('+data+')');
					if(data['STATUS']['ID']==0){
						$("div#changepwdalert").attr("class","alert").addClass("alert-success").html("已成功设置。").hide().fadeIn(250);
						alert("新的密码已成功设置。请您重新登陆");
						window.location.href="/logout";
					}
					else if (data['STATUS']['ID']==1){
						$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("旧的密码不正确。").hide().fadeIn(250);
					}
					else if (data['STATUS']['ID']==2){
						$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("不能修改其他人的密码。").hide().fadeIn(250);
					}
					else if (data['STATUS']['ID']==3){
						$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("旧的密码不能和新的密码一致。").hide().fadeIn(250);
					}
					else if (data['STATUS']['ID']==4){
						$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("新密码不能为空。").hide().fadeIn(250);
					}
					else {
						$("div#changepwdalert").attr("class","alert").addClass("alert-danger").html("未知错误。").hide().fadeIn(250);
					}
				}
			});
		}
	});
});

</script>