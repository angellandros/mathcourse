<?php
function print_quiz($row, $answered=0)
{
	$percent = ((time()-$row['created'])*100/($row['due']-$row['created']));
	$elsmsg = ($percent>=100?' [expired]':'');
	$percent = ($percent>=100?100:$percent);
	$function = ($percent>=100?'':' onclick="location.href=\'index.php?r=profile/quizzes&id='.$row['id'].'\'"');
	
	$days = intval(($row['due']-time())/(3600*24));
	$hours = ($row['due']-time())-($days*3600*24);
	$hours = intval($hours/3600);
	$mins = ($row['due']-time())-($days*3600*24)-($hours*3600);
	$mins = intval($mins/60);
	
	if(time() > $row['due'])
	{
		$days = 0;
		$hours = 0;
		$mins = 0;
	}
		

	echo '<div class="rank-row clickable"'.$function.'><div class="rank-row-text">' . $row['name'] . $elsmsg . '<br>';
	echo '<img src=""><b>Left: ' . $days . ' days, ' . $hours . 'h ' . $mins . 'min</b><br>Answers: ' . $row['answers']	. '';
	echo '</div><div class="rank-row-probar">';
	echo '<div id="progressbar"><div style="width:' . $percent . '%;background-color:RGB(239,58,68)"></div></div>';
	echo '<div id="progressbar"><div style="width:' . ($row['answers']>50?100:$row['answers']*2) . '%"></div></div>';
	echo '</div></div>';
}

function echo_quizzes($id=0)
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$where = ($id?'WHERE `id` = '.$id:'');
	
	$result = $mysqli->query("SELECT * FROM `quizzes`".$where);
	$lresult = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$me = $lresult->fetch_array();
	unset($lresult);
	$ac_quizzes = unserialize($me['quizzes']);
	
	while($row = $result->fetch_array())
	{
		if(!isset($ac_quizzes[$row['id']]))
			$ac_quizzes[$row['id']] = 0;
	
		print_quiz($row, $ac_quizzes[$row['id']]);
	}

	$mysqli->close();
}

function print_pro($row, $quiz_pros)
{
	echo '<span dir="rtl" style="text-align:right"><br>' . $row['text'] . '<br>';
	$choices = array($row['ch1'],$row['ch2'],$row['ch3'],$row['ch4'],$row['ch5']);
	for($i=0; isset($choices[$i]); $i++)
	{
		if($choices[$i])
		{
			$else = 1;
			if(isset($quiz_pros[$row['id']]))
				if($quiz_pros[$row['id']] == $i)
				{
					$else = 0;
					echo '<input type="radio" checked="checked" name="'.$row['id'].'" value="'.($i).'"> '.($i+1).'. '.$choices[$i].'<br>';
				}
			if($else)
				echo '<input type="radio" name="'.$row['id'].'" value="'.($i).'"> '.($i+1).'. '.$choices[$i].'<br>';
		}
	}
	echo "</span>";
}

function echo_quiz_pros($id)
{
	echo_quizzes($id);
	
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$me = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $me->fetch_array();
	
	if($row['quiz_pros'])
		$ac_quiz_pros = unserialize($row['quiz_pros']);
	else
		$ac_quiz_pros = array(0);
		
	unset($row);
	
	
	$where = ($id?" WHERE `quiz` = '".$id."'":'');
	
	$result = $mysqli->query("SELECT * FROM `quiz_pros`".$where);
	echo '<form action="index.php?r=profile/quizzes" method="post" style="text-align:right">';
	while($row = $result->fetch_array())
	{
		print_pro($row,$ac_quiz_pros);
	}
	echo '<input type="hidden" name="quiz" value="'.$id.'">';
	echo '<br><center><input type="submit" class="non-green-button" name="submit" value="Submit"></center></form>';

	$mysqli->close();
}

if(isset($_POST['quiz']))
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	
	if($row['quizzes'])
		$ac_quizzes = unserialize($row['quizzes']);
	else
		$ac_quizzes = array(0);
	
	if($row['quiz_pros'])
		$ac_quiz_pros = unserialize($row['quiz_pros']);
	else
		$ac_quiz_pros = array(0);
		
	if(isset($ac_quizzes[$_POST['quiz']]))
		$ac_quizzes[$_POST['quiz']]++;
	else
		$ac_quizzes[$_POST['quiz']] = 1;
	
	$mysqli->query("UPDATE `accounts` SET `quizzes` = '".serialize($ac_quizzes)."' WHERE `email` = '".$_SESSION['email']."'");

	$mysqli->query("UPDATE `accounts` SET `probl_ans` = `probl_ans`+1 WHERE `email` = '".$_SESSION['email']."'");
	$mysqli->query("UPDATE `quizzes` SET `answers` = `answers`+1 WHERE `id` = '".$_POST['quiz']."'");
	
	foreach($_POST as $id=>$answer)
	{	
		$result = $mysqli->query("SELECT * FROM `quiz_pros` WHERE `id`='".$id."'");
		$row = $result->fetch_array();
		if($row['answers'])
			$ranswers = unserialize($row['answers']);
		else
			$ranswers = array(0,0,0,0,0);
		
		$ac_quiz_pros[$row['id']] = $answer;
		
		if(isset($ranswers[intval($answer)]))
			$ranswers[intval($answer)]++;
		else
			$ranswers[intval($answer)] = 1;
		$mysqli->query("UPDATE `quiz_pros` SET `answers` = '".serialize($ranswers)."' WHERE `id`='".$id."'");
	}
	
	$mysqli->query("UPDATE `accounts` SET `quiz_pros` = '".serialize($ac_quiz_pros)."' WHERE `email` = '".$_SESSION['email']."'");
	
	$mysqli->close();
}
?>

<div id="main">
	<div id="mid">
		<div id="maintext">
			<?php
			if(!isset($_GET['id']))
				echo_quizzes();
			else
				echo_quiz_pros($_GET['id']);
			?>
		</div>
	</div>
</div>