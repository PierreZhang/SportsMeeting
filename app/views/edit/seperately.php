<div class="alert" style="display:none"></div>
<table class="table table-striped table-condensed table-responsive">
<thead>
<tr>
<th>
稿件ID
</th>
<th>
提交用户ID
</th>
<th>
学院ID
</th>
<th>
原创标签
</th>
<th>
提交时间
</th>
</thead>
<tbody>
<tr>
<td name="id">
<?php echo $data['contribution'][0] -> id; ?>
</td>
<td name="user_id">
<?php echo $data['contribution'][0] -> user_id; ?>
</td>
<td name="institution_id">
<?php echo $data['contribution'][0] -> institution_id; ?>
</td>
<td name="originality">
<?php echo $data['contribution'][0] -> originality; ?>
</td>
<td name="created">
<?php echo $data['contribution'][0] -> created; ?>
</td>
</tr>
<tr>
<td colspan="5" name="text">
<?php echo $data['contribution'][0] -> text; ?></td>
</tr>
<tr>
<td colspan="5">
<button style="width:250px;float:left;background:#48A627;color:white;border:0;height:30px;" class="audit" id="accept" contribution_id="<?php echo $data['contribution'][0] -> id;?>" audit_level="<?php echo str_replace("#","", \Helpers\Session::get('ROLES')); ?>">通过</button>
<button style="width:250px;float:right;background:#A62727;color:white;border:0;height:30px;" class="audit" id="reject" contribution_id="<?php echo $data['contribution'][0] -> id;?>" audit_level="<?php echo str_replace("#","", \Helpers\Session::get('ROLES')); ?>">驳回</button>
</td>
</tr>
</tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$("button.audit").click(function(){
		$.ajax({
			url: "edit/seperately",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				submit: true,
				contribution_id: $(this).attr("contribution_id"),
				accept: ($(this).attr("id")=="accept")?1:0,
				audit_level: $(this).attr("audit_level")
			},
			success: function(data){
				data=eval(data);
				if($(data).length!=0){
					$("div.alert").addClass("alert-success").html("稿件已成功审批。").fadeIn(250).fadeOut(1500);
					$("td[name=id]").html(data[0].id);
					$("td[name=user_id]").html(data[0].user_id);
					$("td[name=institution_id]").html(data[0].institution_id);
					$("td[name=originality]").html(data[0].originality);
					$("td[name=created]").html(data[0].created);
					$("td[name=text]").html(data[0].text);
					$("button#accept").attr("contribution_id",data[0].id);
					$("button#reject").attr("contribution_id",data[0].id);
				}
				else{
					alert('稿件已成功审批。没有更多的稿件了。请耐心等待。');
					window.location.reload();
				}
			}
		});
	});
});

</script>