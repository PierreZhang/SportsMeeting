<div class="alert" style="display:none"></div>
<?php //var_dump($data['institutions_in_charge']);
foreach($data['institutions_in_charge'] as $k_ => $a_){
	echo "<a class=\"select_institution\" name=\"$a_[1]\" style=\"background: #1578DB; padding: 5px 8px; margin: 2px; display: inline-block; color: white;\" institution_id=\"$a_[0]\">$a_[1]</a>";
	} ?>
<form method="POST">
<table class="table table-striped table-condensed table-responsive">
<tbody>
<?php
$i_=1;
foreach($data['contributions'] as $k_=>$o_){
	echo "<tr seq=\"".$i_."\" style=\"display:table-row\"><td name=\"contribution\">".$o_->text."</td><td name=\"checkbox\"><input type=\"checkbox\" contribution_id=\"".$o_->id."\" /></td></tr>";
	$i_++;
}
?>

</tbody>
</table>
<input type="submit" onclick="javascript:return false;" style="width:250px;float:right;background:#48A627;color:white;border:0;height:30px;" class="audit" id="submit" audit_level="<?php echo str_replace("#","", \Helpers\Session::get('ROLES')); ?>" value="提交" />
</form>
<style>
input[type=checkbox]{
	width:55px;
	height:55px;
	border-radius:100%;
	background:green;
}
</style>

<script type="text/javascript">
//var dt;

$(document).ready(function(){
	$("a.select_institution").on("load1", function(){
		var institution_id=$(this).attr("institution_id");
		$.ajax({
			url: "edit/smallbatch",
			datatype: "json",
			async: false, 
			type: "POST",
			data: {
				select_institution_amount: true,
				institution_id: $(this).attr('institution_id')
			},
			success: function(data){
				data=eval(data);
				var name=$("a.select_institution[institution_id="+institution_id+"]").attr("name");
				if(data[0].amount!=0){
					$("a.select_institution[institution_id="+institution_id+"]").html(name+"<font style=\"color:red\">("+data[0].amount+")</font>");
				}
			}
		});
	});
	$("a.select_institution").trigger("load1");
	$("input.audit").click(function(){
		var audit_result={};
		$("input[type=checkbox]").each(function(){
			var a=$(this).attr("contribution_id");
			var b=$(this).is(':checked')?1:0;
			audit_result[a]=b;
		});
		//console.log(audit_result);
		$.ajax({
			url: "edit/smallbatch",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				submit: true,
				audit_result: audit_result,
				audit_level: 'B3'
			},
			success: function(data){
				$("div.alert").addClass("alert-success").html("稿件已成功审批。").fadeIn(250).fadeOut(1500);
				$("a.select_institution").trigger("load1");
				$("input[type=checkbox]").each(function(){
					$(this).prop("checked", false);
				});
				data=eval(data);
				//dt=data;
				//console.log(data);		
				if($(data).length!=0){
					for(var i_=1;i_<=5;i_++){
						//alert($(data).length+" "+(i_>$(data).length));
						if(i_>$(data).length){
							$("tr[seq="+i_+"]").attr("style", "display:none");
							data[i_-1]={"id":"","text":""};
						}
						else
							$("tr[seq="+i_+"]").attr("style", "display:table-row");
						$("tr[seq="+i_+"] td[name=contribution]").html(data[i_-1].text);
						$("tr[seq="+i_+"] td[name=checkbox] input[type=checkbox]").attr("contribution_id", data[i_-1].id);
					}
				}
				else{
					alert('没有更多的稿件了。请耐心等待。');
					window.location.reload();
				}
			}
		});
	});
	$("a.select_institution").click(function(){
		var institution_id=$(this).attr("institution_id");
		$.ajax({
			url: "edit/smallbatch",
			datatype: "json",
			async: true, 
			type: "POST",
			data: {
				select_institution: true,
				institution_id: institution_id
			},
			success: function(data){
				data=eval(data);
				//dt=data;
				//console.log(data);		
				if($(data).length!=0){
					for(var i_=1;i_<=5;i_++){
						//alert($(data).length+" "+(i_>$(data).length));
						if(i_>$(data).length){
							$("tr[seq="+i_+"]").attr("style", "display:none");
							data[i_-1]={"id":"","text":""};
						}
						else
							$("tr[seq="+i_+"]").attr("style", "display:table-row");
						$("tr[seq="+i_+"] td[name=contribution]").html(data[i_-1].text);
						$("tr[seq="+i_+"] td[name=checkbox] input[type=checkbox]").attr("contribution_id", data[i_-1].id);
					}
				}
				else{
					alert('没有更多的稿件了。请耐心等待。');
					window.location.reload();
				}
			}
		});
	});
});

</script>