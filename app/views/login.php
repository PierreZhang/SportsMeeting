<!DOCTYPE html>
<html lang="zh" xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
use Helpers\Assets;
use Helpers\Url;
require_once \Helpers\Url::templatePath_withoutDomain()."php\background.php";
Assets::css([
	Url::templatePath() . 'css/bootstrap.min.css',
	Url::templatePath() . 'css/style.css',
	Url::templatePath() . 'css/login.css'
]);
?>

<title><?php echo $data['site_name']; ?></title>
</head>
<body>

<table id="login">
<th>
	<p><img src="<?php echo \Helpers\Url::templatePath(); ?>img/logo-new.png" class="logo"/>
	</p>
	<span><?php echo $data['site_name']; ?></span></th>
<tr>
<td>
<div id="form">


<?php
if($data['status']!==null){
echo "<div class=\"alert alert-danger\">";
switch($data['status']){
	case 1: echo "登陆成功。"; break;
	case 2: echo "系统关闭。请您稍候再试。"; break;
	case 3: echo "用户名或密码不正确哦。"; break;
	case 4: echo "只允许一台设备登陆。"; break;
	default: break;
}
echo '</div>';
} else{
if($data['system_on']==0){
 echo "<div class=\"alert alert-danger\">系统关闭。</div>";
}
}

?>

<form method="post">

<p>
ID
<br /><input type="text" name="id" class="input" placeholder="在这里输入ID">
</p>

<p>
密码
<br />
<input type="password" name="credential" class="input" placeholder="在这里输入密码">
</p>

<p>
<input type="submit" name="submit" class="button" value="登录" style="width:60px;">
</p>

</form>

</div>
</td>
</tr>
<tr>
<td>
<p class="footer">校园之声广播台隶属于党委宣传部。
<br />任何问题，请联系学院联络人或广播台运动会宣传阵地负责人。</p>
</table>



</body>
</html>
