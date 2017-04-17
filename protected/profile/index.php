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

	echo '<div onclick="select(this)" class="'.($elected?'selected-row':'rank-row').'" id="' . $row['email'] . '"><div class="rank-row-text">' . $row['name'] . '<br>';
	echo '<img src="images/ranks/' . rank_img($row['level']) .'"><b>' . $row['level'] . ': ' . rank($row['level']) .'</b><br>Points: ??';
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
}

if(isset($_POST['name1']))
{
	$names[0] = $_POST['name1'];
	$names[1] = $_POST['name2'];
	$names[2] = $_POST['name3'];
	$names[3] = $_POST['name4'];
	$names[4] = $_POST['name5'];
	
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	
	$mysqli->query("UPDATE `accounts` SET `names` =  '".serialize($names)."' WHERE `email` = '".$_SESSION['email']."'");
	$message = 'بسیار خوب! اکنون بیاغازید به فعالیت. می‌توانید گزینه‌های منوی بالا را از گزینش تا رتبه‌بندی بپیمایید.';
	
	$mysqli->close();
}
	
?>
	
<div id="main">
	<div id="mid">
		<div id="maintext" style="padding-bottom:40px;text-align:right" dir="rtl">
			
			<center><b>به دوره‌های ریاضی خوش آمدید</b></center><br><br>
			
			<?php
			if(!isset($_SESSION['email'])) echo "<center><span  dir=\"rtl\">شما هنوز وارد سیستم نشده‌اید. لطفن <a href=\"index.php?r=sign\">وارد شوید</a>.<br></span>";
			else
			{
				echo '<center><span  dir="rtl">شما وارد سیستم شده‌اید. در همه‌ی صفحه‌ها می‌توانید اطلاعات پروفایل خود را با کلیک روی <img src="images/main/profile.png"> در بالای صفحه ببینید.<br></span>';
				echo 'اگر نام اعضای تیم خود را وارد نکرده‌اید هم‌اکنون وارد کنید. وارد نکردن نام اعضای تیم سبب می‌شود در رتبه‌بندی‌ها شرکت‌ داده نشوید.';
				if(isset($message)) echo '<br><br>'.$message;
				echo '<br><br>';
				echo '<form method="post" action="index.php?r=profile"><input type="text" class="text1" dir="rtl" name="name1"><br><input type="text" class="text1" dir="rtl" name="name2"><br>';
				echo '<input type="text" class="text1" dir="rtl" name="name3"><br><input type="text" class="text1" dir="rtl" name="name4"><br><input type="text" class="text1" dir="rtl" name="name5">';
				echo '<br><br><input type="submit" class="non-green-button" name="Submit"></form>';
			}
			?>
		
		</div>
	</div>
</div>