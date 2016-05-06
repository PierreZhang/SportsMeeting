<div class="page-header">
	<h2><?php echo $data['site_name']; ?></h2>
</div>
<div class="row">
	<div class="col-sm-8" style="border-right:1px dotted #000; padding-bottom:50px" id="DR">
		<?php if($data['contribute_on']==1){ ?>
		<form method="POST" id="contribute">
			<div class="contribution-textarea">
				<span>稿件正文</span>
				<textarea name="text"></textarea>
				<div class="inscribe">——<?php echo $data['institutions'][0]->name;?>来稿</div>
			</div>
			<input type="submit" name="submit" onclick="javascript:return false;" value="提交" />
			<input type="reset" value="重新填写" />
		</form>
		<?php 
		} elseif($data['contribute_on']==0){
?>
<div class="alert alert-danger">现在不是提交稿件的时间。</div>
<?php
}
?>
	</div>
	<div class="col-sm-4">
		<div class="alert" style="display:none;"></div>
		<pre style="border:0; background:transparent;">您的单位一共提交了<?php echo $data['total-amount']; ?>篇稿件。<br />已初审：<?php echo $data['audit-1-amount']; ?>。初审通过：<?php echo $data['audit-1-pass-amount']; ?>。<br />已终审：<?php echo $data['audit-2-amount']; ?>。终审通过：<?php echo $data['audit-2-pass-amount']; ?>。<br />已播送：<?php echo $data['broadcast-amount']; ?>。<br />审批比率：<?php echo round($data['audit-rate']*100); ?>%。播送比率：<?php echo round($data['broadcast-rate']*100); ?>%。<br /><br />我要：<a href="contribution">提交稿件</a> <a class="chgDR_link" chgDR_value="/public/changepwd">修改密码</a> <a href="logout">注销</a>
		</pre>
	</div>
</div>
<div class="row" style="border-top:1px dotted #000">
<div class="col-sm-12">
<pre style="border:0; background:transparent;"><?php echo $data['emergency_contact']; ?></pre>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("form#contribute textarea[name=text]").flexText();
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
					institution: <?php echo $data['institutions'][0]->institution_id; ?>,
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