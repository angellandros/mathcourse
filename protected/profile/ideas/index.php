<?php
include_once('include/profile.php');

function print_cat($row, $answered=0)
{
	$percent = ((time()-$row['created'])*100/($row['due']-$row['created']));
	$elsmsg = ($percent>=100?' [expired]':'');
	$percent = ($percent>=100?100:$percent);
	$function = ($percent>=100?'':' onclick="location.href=\'index.php?r=profile/ideas&id='.$row['id'].'\'"');

	echo '<div class="rank-row clickable"'.$function.'><div class="rank-row-text">' . $row['name'] . $elsmsg . '<br>';
	echo '<img src=""><b>Due: ' . date('Y-m-d H:i:s',$row['due']) . '</b><br>Submits: ' . $row['submits']	. '';
	echo '</div><div class="rank-row-probar">';
	echo '<div id="progressbar"><div style="width:' . $percent . '%;background-color:RGB(239,58,68)"></div></div>';
	echo '<div id="progressbar"><div style="width:' . ($answered * 50) . '%"></div></div>';
	echo '</div></div>';
}

function echo_cats($id=0)
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$where = ($id?'WHERE `id` = '.$id:'');
	
	$result = $mysqli->query("SELECT * FROM `idea_cats`".$where);
	$lresult = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$me = $lresult->fetch_array();
	unset($lresult);
	$ac_quizzes = unserialize($me['idea_cats']);
	
	while($row = $result->fetch_array())
	{
		if(!isset($ac_quizzes[$row['id']]))
			$ac_quizzes[$row['id']] = 0;
	
		print_cat($row, $ac_quizzes[$row['id']]);
	}

	$mysqli->close();
}

function print_idea($row, $me, $yes=0)
{
	echo '<div onclick="select(this)" id="'.$row['id'].'" class="rank-row"><div class="rank-row-text">';
	if($yes)
		echo '<img src="images/ranks/' . rank_img($me['level']) .'"><b>' . $me['level'] . ': ' . rank_fa($me['level']) .'</b><br>Votes: ' . $row['votes']	. '';
	echo '<img src=""><b></b><br>';
	echo '</div><div class="rank-row-probar" dir="rtl" style="text-align:right">';
	echo $row['text'];
	echo '</div></div>';
}

function echo_ideas($id)
{
	//echo_cats($id);
	
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$me = $result->fetch_array();
	$idea_cats = unserialize($me['idea_cats']);
	$else = 1;
	
	if(isset($idea_cats[$id]))
	{
		if($idea_cats[$id] == 2)
		{
			$else = 0;
			
			$where = ($id?" WHERE `cat` = '".$id."'":'');
			
			$result = $mysqli->query("SELECT * FROM `ideas`".$where);
						
			while($row = $result->fetch_array())
			{
				print_idea($row, $me, 1);
			}
		}
	}
	
	if(isset($idea_cats[$id]))
	{
		if($idea_cats[$id] == 1)
		{
			$else = 0;
			
			$where = ($id?" WHERE `cat` = '".$id."'":'');
			
			$result = $mysqli->query("SELECT * FROM `ideas`".$where);
			
			echo '<center>Please select the 4 teams ypu want to compare yourself with.<br>This selection won\'t apply immediately, you must wait until the next turn.<br>	
				<b>Selections left: <span id="var-selected">?</span></b></center>
				<center>
				<div class="green-button" onclick="refresh()"><p>Clear</p></div>
				</center>
				<br>';
			
			while($row = $result->fetch_array())
			{
				print_idea($row, $me);
			}
			
			echo '<br>
				<form name="hiddenForm" id="hiddenForm" action="index.php?r=profile/ideas" method="post" onsubmit="return check();">
					<input type="hidden" id="hiddenSel1" name="sel1" value="">
					<input type="hidden" id="hiddenSel2" name="sel2" value="">
					<input type="hidden" id="hiddenSel3" name="sel3" value="">
					<input type="hidden" id="hiddenSel4" name="sel4" value="">
					<input type="hidden" name="cat" value="'.$id.'">
					<center><input type="submit" class="non-green-button" name="submit" value="Submit"></center>
				</form>';
		}
	}
	
	if($else)
	{	
		$result = $mysqli->query("SELECT * FROM `ideas` WHERE `email` = 'admin'");
					
		while($row = $result->fetch_array())
		{
			print_idea($row, $me, 0);
		}
		
		echo '<br>
			<form action="index.php?r=profile/ideas" method="post">
				<input type="text" class="text" name="text" value="" style="font-family:calibri;width:100%;font-size:12pt;"><br>
				<input type="hidden" name="cat" value="'.$id.'">
				<center><input type="submit" class="non-green-button" name="submit" value="Submit"></center>
			</form>';
	}
	

	$mysqli->close();
}

if(isset($_POST['sel1']))
{
	$emails[0] = $_POST['sel1'];
	$emails[1] = $_POST['sel2'];
	$emails[2] = $_POST['sel3'];
	$emails[3] = $_POST['sel4'];
	
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	
	if($row['ideas'])
		$ideas = unserialize($row['ideas']);
	else
		$ideas = array(0);
		
	for($i=0; $i<4; $i++)
	{
		$ideas[$emails[$i]] = 1;
	}
	
	$mysqli->query("UPDATE `accounts` SET `ideas` = '".serialize($ideas)."' WHERE `email` = '".$_SESSION['email']."'");
	
	if($row['idea_cats'])
		$idea_cats = unserialize($row['idea_cats']);
	else
		$idea_cats = array(0);
		
	if($idea_cats[$_POST['cat']] != 2)
	{
		$mysqli->query("UPDATE `accounts` SET `ideas_vot` = `ideas_vot`+4 WHERE `email` = '".$_SESSION['email']."'");
		
		$idea_cats[$_POST['cat']] = 2;
		$mysqli->query("UPDATE `accounts` SET `idea_cats` = '".serialize($idea_cats)."' WHERE `email` = '".$_SESSION['email']."'");
		
		
		foreach($emails as $id)
			$mysqli->query("UPDATE `ideas` SET `votes` = `votes`+1 WHERE `id` = '".$id."'");			
	}
	
	$mysqli->close();
}

if(isset($_POST['text']))
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$mysqli->query("UPDATE `idea_cats` SET `submits` = `submits`+1 WHERE `id` = '".$_POST['cat']."'");
	$mysqli->query("UPDATE `accounts` SET `ideas_sub` = `ideas_sub`+1 WHERE `email` = '".$_SESSION['email']."'");
	
	$result = $mysqli->query("SELECT * FROM `ideas` ORDER BY `id`");
	while($row = $result->fetch_array())
		$lrow = $row;
	
	$id = $lrow['id']+1;
		
	$mysqli->query("INSERT INTO `ideas` (`id`, `cat` ,`email` ,`text`) VALUES ('".$id."', '".$_POST['cat']."', '".$_SESSION['email']."', '".$_POST['text']."')");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	if($row['idea_cats'])
		$idea_cats = unserialize($row['idea_cats']);
	else
		$idea_cats = array(0);
		
	$idea_cats[$_POST['cat']] = 1;
		$mysqli->query("UPDATE `accounts` SET `idea_cats` = '".serialize($idea_cats)."' WHERE `email` = '".$_SESSION['email']."'");
}
?>

<div id="main">
	<div id="mid">
		<div id="maintext">
			<?php
			if(!isset($_GET['id']))
				echo_cats();
			else
				echo_ideas($_GET['id']);
			?>
		</div>
	</div>
</div>