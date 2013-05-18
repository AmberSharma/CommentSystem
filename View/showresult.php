<?php
echo "Article";
echo "<br/>";
echo "<textarea rows='4' cols='50' disabled='true' style='color:#000000'>";
echo $fetch[0]['question'];
echo "</textarea> ";


echo "<br/>";
echo "<br/>";

echo "<div id='div1' style='border:1px solid red; width:35%;padding:50px;border-radius:10px;'>";
echo "<form id='frmid'>";
echo "Name: <input type='text' name='name'>";
echo "<br/>";
echo "Email: <input type='text' name='email'>";
echo "<br/>";
echo "Comment:";
echo "<br/>";
echo "<textarea rows='4' cols='50' style='color:#000000' name='comment'>";

echo "</textarea> ";
echo "<br/>";
echo "<input type='button' value='Submit' onclick='handleReply()'>";
echo "</form>";
echo "</div>";

echo "<br/>";
echo "<br/>";

echo "<div id='div2'>";
echo "<table>";
echo "<tr>";
echo "<td>"; 
echo "<a href='javascript:void(0)' onclick='latestcreated()'>Latest</a>";
echo "</td>";
echo "<td>";
echo "<a href='#'>Oldest</a>";
echo "</td>";
echo "<td>";
echo "<a href='#'>Likes</a>";
echo "</td>";
echo "<td>";
echo "<a href='#'>Dislikes</a>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";

?>
