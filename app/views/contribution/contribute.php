
<?php 
if($data['contribute_on']==1){
?>
<div class="alert" style="display:none" onsubmit="return false"></div>
<form method="POST" id="contribute">
<div class="row">
	<div class="col-sm-2">原创：<input type="checkbox" name="originality" value="1" style="width:20px; height:20px; vertical-align:middle;" /></div>
	<div class="col-sm-4">单位：<select name="institution" style="vertical-align:middle;">
			<option value="none">--------</option>
			<?php
				foreach($data['institutions'] as $i_=>$o_)
					echo '<option value="',$o_->institution_id,'">',$o_->name,'</option>';
			?>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">稿件：<div class="input-block"><textarea name="text"></textarea></div></div>
</div>
	<input type="submit" name="submit" onclick="javascript:return false;" />
	<input type="reset" />
</form>
<p>提示：<br />
（1）稿件应在30-300字之间。<br />
（2）支持原创作品：<font color="red">如果您的稿件是原创，请您标记【原创】。</font><br />
（3）稿件中不要出现自己的学院名称。如：“——计算机学院来稿。”<br />
（4）<font color="red">请不要插入特殊字符，如单引号、美元符号等。</font><br />
（5）<font color="red">添加后不可查看与修改。</font>
</p>

<script type="text/javascript">
var dt;
$(document).ready(function(){
	$("form#contribute input[type=submit]").click(function(){
		if($("form#contribute select[name=institution]").val()!="none" && $("form#contribute textarea[name=text]").val()!=""){
			$.ajax({
				url: "contribution/contribute",
				datatype: "json",
				async: true, 
				type: "POST",
				data: {
					submit: "true",
					originality: Number($("form#contribute input[name=originality]").is(":checked")),
					institution: $("form#contribute select[name=institution]").val(),
					text: $("form#contribute textarea[name=text]").val()
				},
				success: function(data, status){
					console.log(data);
					data=eval('('+data+')');
					dt=data;
					if(data["STATUS"]["ID"]==0) {
						$("div.alert").attr("class", "alert alert-success").html("稿件已成功提交。").fadeIn(250).fadeOut(1500);
						$("form#contribute input[name=originality]").prop("checked", false);
						$("form#contribute select[name=institution]").val("none");
						$("form#contribute textarea[name=text]").val("");
					}
					else if (data["STATUS"]["ID"]==1)
						$("div.alert").addClass("alert-danger").html("未知错误。").fadeIn(250).fadeOut(1500);
					else if (data["STATUS"]["ID"]==11)
						$("div.alert").addClass("alert-danger").html("您提交过于迅速。请过几秒再试。").fadeIn(250).fadeOut(1500);
					else if (data["STATUS"]["ID"]==12)
						$("div.alert").addClass("alert-danger").html("现在不是提交稿件的时间。请稍候再试。").fadeIn(250).fadeOut(1500);
					

				}
			});
		}
		else if($("form#contribute select[name=institution]").val()=="none")
			$("div.alert").attr("class", "alert alert-danger").html("请填写单位。").fadeIn(250).fadeOut(1500);
		else if($("form#contribute textarea[name=text]").val()=="")
			$("div.alert").attr("class", "alert alert-danger").html("稿件不能为空。").fadeIn(250).fadeOut(1500);
		else
			$("div.alert").attr("class", "alert alert-danger").html("前端未知错误。").fadeIn(250).fadeOut(1500);
	});
});
</script>

<?php 
} elseif($data['contribute_on']==0){
?>
<div class="alert alert-danger">现在不是提交稿件的时间。</div>
<?php
}
?>