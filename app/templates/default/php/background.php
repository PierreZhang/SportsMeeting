<?php
header("content-type:text/html;charset=utf-8");

$bgp=array('banjiang.jpg','jianxiangqiao.jpg','liuxuesheng.jpg','qinghe.jpg','quanjing.jpg','xiaohuifangzhen.jpg','xuewu.jpg','yundonghui.jpg','zhanshi.jpg');
shuffle($bgp);
echo "<style type=\"text/css\">
body{
	background-image:url(".\Helpers\Url::templatePath()."img/".$bgp[0].");
	background-repeat:no-repeat;
	background-attachment:fixed;
	background-clip:content-box;
	background-size:cover;
}
</style>";