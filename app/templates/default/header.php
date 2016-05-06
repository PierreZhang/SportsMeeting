<?php

use Helpers\Assets;
use Helpers\Url;

?>
<!DOCTYPE html>
<html lang="zh" xmlns="http://www.w3.org/1999/xhtml">
<head>

	<!-- Site meta -->
	<meta charset="utf-8">
	<title><?php echo $data['title'].' | '.SITETITLE; //SITETITLE defined in app/core/config.php ?></title>

	<!-- CSS -->
	<?php
	Assets::css([
		Url::templatePath() . 'css/style.css',
		Url::templatePath() . 'css/bootstrap.min.css',		
		Url::templatePath() . 'css/login.css',
		Url::templatePath() . 'css/flexText.css'
	]);
	Assets::js([
		Url::templatePath() . 'js/jquery-1.11.1.js'
	]);
	?>


</head>
<body>
<div id="mask"></div>
<div id="masktop"></div>
<div class="container">
