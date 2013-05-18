<style>
ul li
{
	list-style-type:none;
}
</style>
<?php
echo "<pre>";
print_r($result);
$k=-1;
$count =0;

for($i =0 ;$i< count($result);$i++)
{
	//echo "<li>";
	
	if(empty($result[$i]['visited']) || $result[$i]['visited'] <> "true" )
	{
		$k=$i;
		echo "<ul style='margin-left:".($count*20)."px;'>";	
		show($i , $result);
		echo "</ul>";
		$count++;
	
	//echo "<ul>";
	for($j=$i+1;$j<count($result);$j++)
	{

		//echo "<ul>";
		//echo "<li>";
		if($result[$k]['id'] == $result[$j]['parent'] )
		{
			
			//print_r($result[$j]);
			echo "<ul style='margin-left:".($j*20)."px;'>";
			
			show($j , $result);
			
			echo "</ul>";
			$result[$j]['visited']="true";
			$k=$j;
			//$result[$i]['id']=$result[$j]['id'];
			//print_r($result[$j]);
			
		}
		//echo "</li>";
		//echo "</ul>";
		
	}
	//echo "</ul>";
}
//echo $k;
//$i=$k;
	//echo "</li>";
	
	//echo count($result);
	
	
	
	
	
}

function show($i , $result)
{

	echo "<li>";
	
	echo "<div style='border:1px solid red;width:35%;border-radius:10px;;padding:-30px;'>";
	echo "Posted By:".ucfirst($result[$i]['name']);
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "Date:".$result[$i]['created_on'];
	echo "<br/>";
	echo "<br/>";
	echo "<label>".$result[$i]['comment']."</label>";
	echo "<br/>";
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
#overlay {
    
    color:#efefef;
    height:450px;
	width:400px;
  }
  /* container for external content. uses vertical scrollbar, if needed */
  div.contentWrap {
    height:441px;
    
  }
</style>
<script>
$(function() {
	 
    
    $("a[rel]").overlay({
 
        mask: 'darkred',
        effect: 'apple',
        onClose: function(){
            window.location.reload(true);
        },        onBeforeLoad: function() {
 
            
            var wrap = this.getOverlay().find(".contentWrap");
            
           
            wrap.load(this.getTrigger().attr("href"));
        }
 
    });
});
</script>
