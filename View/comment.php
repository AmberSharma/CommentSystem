<?php ?>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script src="/var/www/CommentSystem/trunk/js/jquery.tools.min.js"></script>

<script>


$(document).ready(function() {
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
	 $.ajax({
         type: "POST",
         url: '../controller/controller.php?method=question&id='+<?php echo $id;?>,
         //data: $("#idForm").serialize(), // serializes the form's elements.
         success: function(data)
         {
             $("#output").html($.trim(data));
         }
       });
	});

function handleReply()
{
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=savereply&id='+<?php echo $id;?>,
        data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
        	$("#output1").append($.trim(data));
            location.reload();
            
        }
      });
}

function likes(replyid)
{
	
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=handlelikes&id='+<?php echo $id;?>+"&replyid="+replyid,
        //data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
            if($.trim(data[$.trim(data).length-1])=="1")
            {
            	location.reload();
            }
            
        }
      });
}
function unlike(replyid)
{
	
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=handleunlike&id='+<?php echo $id;?>+"&replyid="+replyid,
        //data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
            if($.trim(data[$.trim(data).length-1])=="1")
            {
            	location.reload();
            }
            
        }
      });
}

function latestcreated()
{
	//alert("dbvhjsd");
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=latest&id='+<?php echo $id;?>,
        //data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
alert(data);
            //$("#output1").append($.trim(data));
            //location.reload();
            
        }
      });
}
function CallAlert()
{
	location.reload();
}
</script>
<div id="output"></div>
<div id="output1"></div>
<div class="apple_overlay" id="overlay">
  
  <div class="contentWrap"></div>
</div>


