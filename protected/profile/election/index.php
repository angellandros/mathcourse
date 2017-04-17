<?php
include_once('include/profile.php');

function print_row($row, $remails)
{
	$elected = 0;
	foreach($remails as $remail)
	{
		if(trim($remail) == trim($row['email']))
		{
			$elected = 1;
			echo '<script>clicked--;</script>';
		}
	}
	
	if(!$row['names']) return;
	$names = unserialize($row['names']);
	for($i=0;$i<4;$i++)
	{
		if(!isset($names[$i]))
			return;
		$names[$i] = strstr($names[$i], ' ');
	}
			
	$sep = '، ';
	$conames = $names[0].$sep.$names[1].$sep.$names[2].$sep.$names[3];
	if(isset($names[4]))
		if($names[4])
			$conames .= $sep.strstr($names[4], ' ');
		

	echo '<div onclick="select(this)" class="'.($elected?'selected-row':'rank-row').'" id="' . $row['email'] . '"><div class="rank-row-text">' . $row['name'] . '<br>';
	echo '<img src="images/ranks/' . rank_img($row['level']) .'"><b>' . $row['level'] . ': ' . rank($row['level']) .'</b><br>'.$conames;
	echo '</div><div class="rank-row-medalbar">';
	echomedals(unserialize($row['medals']));
	echo '</div></div>';
}

function print_database()
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	$remails = unserialize($row['observe']);
	
	$result = $mysqli->query("SELECT * FROM `accounts`");
	while($row = $result->fetch_array())
	{
		print_row($row, $remails);
	}

	$mysqli->close();
}

$message = "شما می‌توانید در پایان هر نوبت خود را با 3 گروه دیگر بسنجید.<br>
 اکنون از سیاهه‌ی زیر خود را و 3 گروه دیگر را برگزینید، و دکمه‌ی Submit را بزنید.<br>";

if(isset($_POST['sel1']))
{
	$emails[0] = $_POST['sel1'];
	$emails[1] = $_POST['sel2'];
	$emails[2] = $_POST['sel3'];
	$emails[3] = $_POST['sel4'];
	
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$mysqli->query("UPDATE `accounts` SET `observe` =  '".serialize($emails)."' WHERE `email` = '".$_SESSION['email']."'");
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '".$_SESSION['email']."'");
	$row = $result->fetch_array();
	$remails = unserialize($row['observe']);
	
	$mysqli->close();
	
	$message = "بسیار خوب.<br>
	اکنون شما گروه‌ها را گزیدید. باید شکیبا باشید تا گزینش شما اعمال شود.<br>
	سپس خواهید توانست در صفحه‌ی Ranking رتبه‌ی خود را در میان این گروه‌ها ببنید.<br>
	اکنون به <a href=\"index.php?r=profile\">Profile</a> برگردید.<br>";
}
	
?>
	
<div id="main">
	<div id="mid">
		<div id="maintext" style="padding-bottom:40px">
			
			<?php if(!isset($_SESSION['email'])) echo "<center><span  dir=\"rtl\">شما هنوز وارد سیستم نشده‌اید. لطفن <a href=\"index.php?r=sign\">Sign in</a> کنید.<br></span>"; ?>
			
			<center><span  dir="rtl"><?php echo $message; ?><br>	
			<b>گزینه‌های مانده: <span id="var-selected">?</span></b></span></center>
			<center>
			<div class="green-button" onclick="refresh()"><p>Clear</p></div>
			</center>
			<br>
			
			<?php if(isset($_SESSION['email']))	print_database(); ?>
			
			<br>
			<form name="hiddenForm" id="hiddenForm" action="index.php?r=profile/election" method="post" onsubmit="return check();">
				<input type="hidden" id="hiddenSel1" name="sel1" value="">
				<input type="hidden" id="hiddenSel2" name="sel2" value="">
				<input type="hidden" id="hiddenSel3" name="sel3" value="">
				<input type="hidden" id="hiddenSel4" name="sel4" value="">
				<center><input type="submit" class="non-green-button" name="submit" value="Submit"></center>
			</form>
		
		</div>
	</div>
</div>