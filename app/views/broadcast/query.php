<div class="alert" style="display:none"></div>

<?php //var_dump($data); ?>
<div id="prepare" style="display:none; position:absolute; top:0; left:0; width:100%; height: 100%; background:rgba(255,255,255,0.8); font-size: 20px;">请准备：<br /><div id="prepare-contribution"></div>——<div id="prepare-institution"></div>来稿<br /><br /><button class="broadcast" style="width:100px; height:55px;" contribution_id="">已播出</button></div>

<table class="table table-striped table-condensed table-responsive">
<tbody>
<?php
$i_=1;
foreach($data['broadcast_query'] as $k_=>$o_){
	echo "<tr seq=\"".$i_."\" style=\"display:table-row\"><td name=\"contribution\">".$o_->text."</td><td><button class=\"prepare\" style=\"width:80px; height:55px;\" contribution_id=\"".$o_->id."\">备稿</button></td></tr>";
	$i_++;
}
?>

</tbody>
</table>

<script type="text/javascript">
//var dt;
$(document).ready(function(){
	$("button.prepare").click(function(){
		if(confirm("确认开始备稿，确认后将不可回滚：\n\n"+$(this).parent().siblings("td[name=contribution]").html())){
			$.ajax({
				url: "anchor/prepare",
				datatype: "json",
				async: true, 
				type: "POST",
				data: {
					contribution_id: $(this).attr("contribution_id")
				},
				success: function(data){
					data=eval('('+data+')');
					//dt=data;
					//console.log(dt);
					if(data["ERROR"]==null){
						$("div#prepare div#prepare-contribution").html(data[0].text);
						$("div#prepare div#prepare-institution").html(data[0].name);
						$("div#prepare button.broadcast").attr("contribution_id", data[0].id);
						$("div#prepare").slideDown();
					}
					else{
						alert('稿件已被播出，请选择其他稿件！');
						$("div#DR").load("anchor/query");
					}
				}
			});
		}
	});
	$("button.broadcast").click(function(){
		if(confirm("确认播出完成，确认后将不可回滚。")){
			$.ajax({
				url: "anchor/broadcast",
				datatype: "json",
				async: true, 
				type: "POST",
				data: {
					contribution_id: $(this).attr("contribution_id")
				},
				success: function(data){
					console.log(data);
					dt=data;
					if(data=="55"){
						alert("稿件已成功播送！");
						$("div#DR").load("anchor/query");
					}
				}
			});
		}
	});
});
</script>