<?php
include_once('include/profile.php');

function echo_row($row)
{
	echo '<div class="selected-row"><div class="rank-row-text">' . $row['name'] . '<br>';
	echo '<img src="images/ranks/' . rank_img($row['level']) .'"><b>' . $row['level'] . ': ' . rank($row['level']) .'</b><br>Points: ??';
	echo '</div><div class="rank-row-medalbar">';
	echomedals(unserialize($row['medals']));
	echo '</div></div>';
}

function echo_ranking()
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	$robserving = unserialize($row['observing']);
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` IN ('".$robserving[0]."','".$robserving[1]."','".$robserving[2]."','".$robserving[3]."') ORDER BY `points` DESC");
	while($row = $result->fetch_array())
	{
		echo_row($row);
	}
	
	$mysqli->close();
}
	
?>
	
<div id="main">
	<div id="mid">
		<div id="maintext">
			
			<?php echo_ranking(); ?>
		
		</div>
	</div>
</div>