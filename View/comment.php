<?php ?>
<script src="http://localhost/CommentSystem/trunk/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="/var/www/CommentSystem/trunk/js/functions.js"></script>
<script>
$(document).ready(function()
{
	<?php
		if(isset($_REQUEST['id']))
		{
			$id=$_REQUEST['id'];
		}
		else 
		{
			$id=1;
		}
	?>
	$.ajax
	({
		type: "POST",
	        url: '../controller/controller.php?method=question&id='+<?php echo $id;?>,
         	success: function(data)
         	{
			$("#output").html($.trim(data));
         	}
	});
});

</script>
<div id="output"></div>
<div id="output1"></div>
<div class="apple_overlay" id="overlay">
<div class="contentWrap"></div>
</div>
