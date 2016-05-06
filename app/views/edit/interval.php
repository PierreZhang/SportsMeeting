<div class="alert" style="display:none"></div>
<form method="POST" id="interval">
<table class="table table-striped">
<tbody>
<tr>
<td>
单位用户提交稿件的时间间隔最小值（单位：秒，0为不限制）
</td>
<td>
<input type="text" name="interval" />
</td>
</tr>
</tbody>
</table>
<input type="submit" onclick="javascript:return false;" />
</form>
<script type="text/javascript">
var dt;
$(document).ready(function(){
	$.post("edit/interval",{
			get_interval:true
		}, function(data){
			$("input[type=text][name=interval]").val(data);
		});
	$("input[type=submit]").click(function(){
		$.ajax({
			url: "edit/interval",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				submit: true,
				interval: $("input[type=text][name=interval]").val()
			},
			success: function(data){
				data=eval('('+data+')');
				dt=data;
				if(data['STATUS']['ID']==0){
					$("div.alert").addClass("alert-success").html("设置已应用。").fadeIn(250).fadeOut(1500);
				}
				else{
					$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
				}
			}
		});
	});
});

</script>