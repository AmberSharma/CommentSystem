<style>
ul li
{
	list-style-type:none;
}
</style>
<?php
$k=-1;
$count =0;
for($i =0 ;$i< count($result);$i++)
{
	if(empty($result[$i]['visited']) || $result[$i]['visited'] <> "true" )
	{
		$k=$i;
		if($i!=0)
		{
			if($result[$i]['parent'] <> $result[$i-1]['parent'])
			echo "<ul style='margin-left:".($count*20)."px;'>";
			else
			echo "<ul>";
		}
		else
			echo "<ul>"; 
			show($i , $result);
			echo "</ul>";
		$count++;
		for($j=$i+1;$j<count($result);$j++)
		{
			if($result[$k]['id'] == $result[$j]['parent'] )
			{
				echo "<ul style='margin-left:".($j*20)."px;'>";
				show($j , $result);
				echo "</ul>";
				$result[$j]['visited']="true";
				$k=$j;
			}
		}
	}
	
}

function show($i , $result)
{

	echo "<li>";
	echo "<div style='border:1px solid red;width:35%;border-radius:10px;padding:5px;'>";
	echo "Posted By:".ucfirst($result[$i]['name']);
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Date:".$result[$i]['created_on'];
	echo "<br/>";
	echo "<textarea rows='2' cols='50' disabled='true' style='color:#000000;overflow-x:auto;background:#66BBAA'>";
	echo $result[$i]['comment'];
	echo "</textarea> ";
	echo "<br/>";
	if(empty($result[$i]['likes']))
	{
		echo "Likes:0";
	}
	else {
		echo "Likes:".$result[$i]['likes'];
	}
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if(empty($result[$i]['dislike']))
	{
		echo "Dislikes:0";
	}
	else {
		echo "Dislikes:".$result[$i]['dislike'];
	}
	echo "<br/>";
	echo "<a href='replycomment.php?replyid=".$result[$i]['id']."&ques_id=".$_REQUEST['id']."' rel='#overlay' style='text-decoration:none'>";
	echo "<button type='button'>Reply</button>";
	echo "</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<input type='button' value='Like' onclick='likes(".$result[$i]['id'].")'/>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<input type='button' value='Unlike' onclick='unlike(".$result[$i]['id'].")'/>";
	echo "</div>";
	echo "</li>";
	
}
?>
<style>
#overlay
{
	color:#efefef;
	height:450px;
	width:400px;
}
  /* container for external content. uses vertical scrollbar, if needed */
div.contentWrap
{
    height:441px;
}
</style>
<script>
$(function()
{
	$("a[rel]").overlay
	({
	 	mask: 'darkred',
	        effect: 'apple',
	        onClose: function()
		{
			window.location.reload(true);
	        },        
		onBeforeLoad: function() 
		{
			var wrap = this.getOverlay().find(".contentWrap");
            		wrap.load(this.getTrigger().attr("href"));
        	}
	});
});
</script>
