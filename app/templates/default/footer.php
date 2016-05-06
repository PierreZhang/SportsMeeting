<?php

use Helpers\Assets;
use Helpers\Url;

?>

</div>

<!-- JS -->
<?php
Assets::js([
	Url::templatePath() . 'js/bootstrap.min.js',
	Url::templatePath() . 'js/jquery.iphone-switch.js',
	Url::templatePath() . 'js/jquery.tablesorter.js',
	Url::templatePath() . 'js/jquery.flexText.min.js'
]);
?>
<script type="text/javascript">
$(document).ready(function(){
	$("a.chgDR_link").click(function(){
		var chgDR_value;
		//alert(chgDR_value);
		chgDR_value=$(this).attr("chgDR_value");
		if(chgDR_value !== null || chgDR_value !== ''){			
			$("#DR").load(chgDR_value);
		}
	});

	$("html").on("click", ".addMASK", function(){
		$("#mask").fadeIn();
		$("#masktop")
			.load($(this).attr("load"))
			.css("left", ($(document).width()-$("#masktop").width())/2);
		$("#masktop").slideDown();
	});

	$("#mask").click(function(){
		$("#mask").fadeOut();
		$("#masktop").fadeOut();
	});
});



</script>

</body>
</html>
