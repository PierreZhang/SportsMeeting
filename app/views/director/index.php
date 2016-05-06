<div class="page-header">
	<h2>2016信息科大运动会空中宣传阵地</h2>
</div>
<div class="row">
	<div class="col-sm-3" id="DL">
		<ul style="list-style:none; margin:0; padding:0;">                          
			<li><a href="director">首页</a></li>
			<li><a class="chgDR_link" chgDR_value="director/statistics_for_institutions">查看各学院统计信息</a></li>
			<li><a class="chgDR_link" chgDR_value="public/changepwd">修改我的密码</a></li>
			<li><a href="admin">管理工具</a></li>
			<li><a href="logout">注销</a></li>
      	</ul>
	</div>
	<div class="col-sm-9" id="DR">
		<table name="users" class="table table-striped table-condensed table-responsive">
			<thead>
				<tr>
					<th>总提交<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">所有学院提交稿件之和（A）</span></th>
					<th>总审批（终审）通过<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">所有学院通过的稿件之和（B）</span></th>
					<th>总审批（终审）通过率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">A/B</span></th>
					<th>总播出<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">全部播出的稿件（C）</span></th>
					<th>总播出率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">C/B</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo ($data['statistics'][0]->SUM_A11!=null)?($data['statistics'][0]->SUM_A11.'篇'):'0'.'篇'; ?></td>
					<td><?php echo ($data['statistics'][0]->SUM_A35!=null)?($data['statistics'][0]->SUM_A35.'篇'):'0'.'篇'; ?></td>
					<td><?php echo ($data['statistics'][0]->SUM_A11!=null)?(round($data['statistics'][0]->SUM_A35/$data['statistics'][0]->SUM_A11*100, 2).'%'):'0%'; ?></td>
					<td><?php echo ($data['statistics'][0]->SUM_A55!=null)?($data['statistics'][0]->SUM_A55.'篇'):'0'.'篇'; ?></td>
					<td><?php echo ($data['statistics'][0]->SUM_A35!=null)?(round($data['statistics'][0]->SUM_A55/$data['statistics'][0]->SUM_A35*100, 2).'%'):'0%'; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- JS -->
<?php
use Helpers\Assets;
use Helpers\Url;

Assets::js([
	Url::templatePath() . 'js/jquery.tablesorter.min.js'
]);
?>

<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
</script>