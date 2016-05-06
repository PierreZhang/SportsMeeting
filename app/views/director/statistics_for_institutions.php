<table name="statistics" class="table table-striped table-condensed table-responsive tablesorter">
			<thead>
				<tr>
					<th>学院名称</th>
					<th style="cursor:pointer;">提交总数<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经提交的稿件之和</span></th>
					<th style="cursor:pointer;">初审率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经初审/已经提交稿件</span></th>
					<th style="cursor:pointer;">初审通过率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经初审通过/已经初审</span></th>
					<th style="cursor:pointer;">终审率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经终审/已初审</span></th>
					<th style="cursor:pointer;">终审通过率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经终审通过/已经终审</span></th>
					<th style="cursor:pointer;">播出率1<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经播出/已经终审通过</span></th>
					<th style="cursor:pointer;">播出率2<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经播出/已经提交</span></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			foreach ($data['statistics_for_institutions'] as $k_ => $o_){
				echo '<tr>';
				echo '<td>',$data['institutions_name'][$o_->institution_id],'</td>';				
				echo '<td>',$o_->A11,'</td>';
				echo '<td title=\'',$o_->A21+$o_->A25,'/',$o_->A11,'\'>',($o_->A11!=null)?round(($o_->A21+$o_->A25)/$o_->A11*100, 2).'%':'0%','</td>';
				echo '<td title=\'',$o_->A21,'/',$o_->A21+$o_->A25,'\'>',($o_->A21!=null || $o_->A25!=null)?round($o_->A21/($o_->A21+$o_->A25)*100, 2).'%':'0%','</td>';
				echo '<td title=\'',$o_->A31+$o_->A35,'/',$o_->A21,'\'>',($o_->A21!=null)?round(($o_->A31+$o_->A35)/$o_->A21*100, 2).'%':'0%','</td>';
				echo '<td title=\'',$o_->A31,'/',$o_->A31+$o_->A35,'\'>',($o_->A31!=null || $o_->A35!=null)?round($o_->A31/($o_->A31+$o_->A35)*100, 2).'%':'0%','</td>';
				echo '<td title=\'',$o_->A55,'/',$o_->A31,'\'>',($o_->A31!=null)?round($o_->A55/$o_->A31*100, 2).'%':'0%','</td>';
				echo '<td title=\'',$o_->A55,'/',$o_->A11,'\'>',round($o_->A55/$o_->A11*100, 2),'%','</td>';

				echo '</tr>';
			}
			?>
			</tbody>
		</table>

<script type="text/javascript">
var dt;
$(document).ready(function(){
	$("table[name=statistics]").tablesorter(); 
});
</script>