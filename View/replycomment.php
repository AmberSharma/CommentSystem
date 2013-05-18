<div id='div1' style='border:1px solid red; width:35%;padding:50px;border-radius:10px;'>
<form id='frmid1'>
Name: <input type='text' name='name'>
<br/>
Email: <input type='text' name='email'>
<br/>
Comment:
<br/>
<textarea rows='4' cols='50' style='color:#000000' name='comment'>

</textarea> 
<br/>
<input type='button' value='Submit' onclick='handleReply(<?php echo $_REQUEST['replyid'];?>,<?php echo $_REQUEST['ques_id'];?>)'>
</form>
</div>
<script>
function handleReply(replyid , ques_id)
{
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=rereply&parentid='+replyid+"&id="+ques_id,
        data: $("#frmid1").serialize(), // serializes the form's elements.
        success: function(data)
        {
        	$("#output1").append($.trim(data));
            //alert(data);
        	//window.opener.CallAlert(); 
            //location.reload();
            
        }
      });
}
</script>
