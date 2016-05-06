<div class="page-header">
	<h2>2016信息科大运动会空中宣传阵地</h2>
</div>
<div class="row">
	<div class="col-sm-3" id="DL">
		<ul style="list-style:none; margin:0; padding:0;">                          
			<li><a href="anchor">首页</a></li>
			<li><a class="chgDR_link" chgDR_value="anchor/query">我要播送</a></li>
			<li><a class="chgDR_link" chgDR_value="public/changepwd">修改我的密码</a></li>
			<li><a href="logout">注销</a></li>
      	</ul>
	</div>
	<div class="col-sm-9" id="DR">
		一共有<?php echo $data['query_contributions_amount_broadcasted']; ?>篇稿件已经播送。
		<!--（其中我播出了<?php //echo $data['query_contributions_amount_broadcasted_myself']; ?>篇。）--><br />
		一共还有<?php echo $data['broadcast_to_go_amount']; ?>篇稿件没有播送。<br />
	</div>
</div>


