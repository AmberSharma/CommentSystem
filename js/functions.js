function handleReply()
{
	$.ajax
	({
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
	$.ajax
	({
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
	$.ajax
	({
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
function CallAlert()
{
	location.reload();
}
