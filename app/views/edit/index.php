<div class="page-header">
	<h2>2016信息科大运动会空中宣传阵地</h2>
</div>
<div class="row">
	<div class="col-sm-3" id="DL">
		<ul style="list-style:none; margin:0; padding:0;">                          
			<li><a href="edit">首页</a></li>
			<li><a class="chgDR_link" chgDR_value="edit/smallbatch">我要审批：小批量模式</a></li>
			<li><a class="chgDR_link" chgDR_value="edit/seperately">我要审批：逐张模式</a></li>
			<li><a class="chgDR_link" chgDR_value="edit/interval">修改提交时间间隔</a></li>
			<li><a class="chgDR_link" chgDR_value="public/changepwd">修改我的密码</a></li>
			<li><a href="logout">注销</a></li>
      	</ul>
	</div>
	<div class="col-sm-9" id="DR">
		您负责的单位有：
		<?php 
		foreach($data['institutions_in_charge'] as $k_=>$a_)
			echo $a_[1].' ';
		$contributions_to_go=0;
		?>。<br />
		
		<!--<pre><?php var_dump($data); ?></pre>-->
		<table name="statistics" class="table table-striped table-condensed table-responsive tablesorter">
			<thead>
				<tr>
					<th>学院名称</th>
					<?php 
					if($data['edit_level']=='B6') {
					?>
					<th style="cursor:pointer;">提交总数<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经提交的稿件之和</span></th>
					<th style="cursor:pointer;">已初审总数<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经通过初审的稿件之和</span></th>
					<th style="cursor:pointer;">初审率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经初审/已经提交稿件</span></th>
					<th style="cursor:pointer;">初审通过率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经初审通过/已经初审</span></th>
					<?php
					} elseif ($data['edit_level']=='B3') {
					?>
					<th style="cursor:pointer;">初审通过总数<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经通过初审的稿件之和</span></th>
					<th style="cursor:pointer;">已终审总数<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经通过终审的稿件之和</span></th>
					<th style="cursor:pointer;">终审率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经终审/已经通过初审</span></th>
					<th style="cursor:pointer;">终审通过率<span style="display: block; font-size:11px; font-style:italic; font-weight: normal;">已经终审通过/已经终审</span></th>
					<?php 
					}
					?>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($data['edit_level']=='B6') {
				foreach ($data['statistics_for_institutions'] as $k_ => $a_){
					echo '<tr>';
					echo '<td>',$data['institutions_name'][$a_[0]->institution_id],'</td>';				
					echo '<td>',$a_[0]->A11,'</td>';
					echo '<td>',$a_[0]->A21+$a_[0]->A25,'</td>';
					echo '<td title=\'',$a_[0]->A21+$a_[0]->A25,'/',$a_[0]->A11,'\'>',($a_[0]->A11!=null)?round(($a_[0]->A21+$a_[0]->A25)/$a_[0]->A11*100, 2).'%':'0%','</td>';
					echo '<td title=\'',$a_[0]->A21,'/',$a_[0]->A21+$a_[0]->A25,'\'>',($a_[0]->A21!=null || $a_[0]->A25!=null)?round($a_[0]->A21/($a_[0]->A21+$a_[0]->A25)*100, 2).'%':'0%','</td>';
					echo '</tr>';
					$contributions_to_go+=$a_[0]->A11-$a_[0]->A21-$a_[0]->A25;
				}
			} elseif($data['edit_level']=='B3') {
				foreach ($data['statistics_for_institutions'] as $k_ => $a_){
					echo '<tr>';
					echo '<td>',$data['institutions_name'][$a_[0]->institution_id],'</td>';				
					echo '<td>',$a_[0]->A21,'</td>';
					echo '<td>',$a_[0]->A31+$a_[0]->A35,'</td>';
					echo '<td title=\'',$a_[0]->A31+$a_[0]->A35,'/',$a_[0]->A21,'\'>',($a_[0]->A21!=null)?round(($a_[0]->A31+$a_[0]->A35)/$a_[0]->A21*100, 2).'%':'0%','</td>';
					echo '<td title=\'',$a_[0]->A31,'/',$a_[0]->A31+$a_[0]->A35,'\'>',($a_[0]->A31!=null || $a_[0]->A35!=null)?round($a_[0]->A31/($a_[0]->A31+$a_[0]->A35)*100, 2).'%':'0%','</td>';
					echo '</tr>';
					$contributions_to_go+=$a_[0]->A21-$a_[0]->A31-$a_[0]->A35;
				}
			}

			?>
			</tbody>
		</table>
		您一共还有<?php echo $contributions_to_go; ?>篇稿件没有审查。<br />
	</div>
</div>


