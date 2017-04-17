<?php
if(isset($_POST["email"]))
{
	$mysqli = new mysqli("localhost", "angellan", "dhhH40s71V", "angellan_dros");
	if (!$mysqli)
	{
		$message = "Failed to connect to MySQL. ";
	}
	
	$result = $mysqli->query("SELECT * FROM `accounts` WHERE `email` = '" . $_POST["email"] . "'");
	$row = $result->fetch_array();
	
	if($_POST["submit"] == "Sign in")
	{
		if($row)
		{
			if($_POST['password'] == $row['password'])
			{
				$_SESSION["email"] = $_POST["email"];
				$_SESSION['name'] = $row['name'];
				$_SESSION['level'] = $row['level'];
				$_SESSION['progress'] = $row['progress'];
				$_SESSION['points'] = $row['points'];
				$_SESSION['ideas_sub'] = $row['ideas_sub'];
				$_SESSION['ideas_vot'] = $row['ideas_vot'];
				$_SESSION['probl_ask'] = $row['probl_ask'];
				$_SESSION['probl_ans'] = $row['probl_ans'];
				$message = 'کامیاب شدید. اکنون به <a href="index.php?r=profile">صفحه‌ی پروفایل خود</a> بروید.';
			}
			else
			{
				$message = 'گذرواژه نادرست است';
			}
		}
		else
			$message = 'شناسه نادرست است';
	}
	elseif($_POST["submit"] == "Sign up")
	{
		if($result->num_rows > 0)
			$message = "This email is already registered.";
		else
		{
			$query = "INSERT INTO `accounts` (`email`, `password`, `notes`)	VALUES ('" . $_POST["email"] . "',  '" . $_POST["password"] . "',  '')";
			$mysqli->query($query);
			$message = 'Successfully signed up. Now you can sign in.';
			if(mail($_POST["email"], "Registration", 'Password: '.$_POST["password"].'
			Plesae sign from www.angellandros.ir?r=sign','From:noreply@angellandros.ir'))
				$message .= '<br>An email containing password sent to your address.';
		}
	}
		
	$mysqli->close();
}
?>

<div id="main">
	<div id="mid">
		<div id="maintext" dir="rtl">
			<center><?php if(isset($message)) echo $message . '<br><br>'; ?></center>
		</div>
	
		<div id="login" style="font-family:tahoma" dir="rtl">
		
			<form action="index.php?r=sign" method="post" style="text-align:right">
				شناسه:
				<br><input class="text" type="text" name="email" dir="ltr"><br>
				گذرواژه:
				<br><input class="text" type="password" name="password" dir="ltr"><br>
				<br><center>
				<input class="button" type="submit" name="submit" value="Sign in">
				</center>
			</form>
			
		</div>
	</div>
</div>