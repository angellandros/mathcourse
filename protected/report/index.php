<?php

$message='';

if(isset($_POST['text']))
{
	$to = "angellandros@yahoo.com";
	$subject = "Report MathCourse";
	$text = $_POST['text'];
	$from = $_POST['email'];
	$headers = "From:" . $from;
	mail($to,$subject,$text,$headers);
	$message = 'پیام فرستاده شد.';
}

?>

<div id="main">
	<div id="mid">
		<div id="login" dir="rtl" style="text-align:right">
		
			<center><?php echo $message; ?></center><br>
			
			<form action="index.php?r=report" method="post">
				ایمیل:
				<br><input type="text" class="text1" name="email" dir="ltr">
				<br>متن:
				<br><textarea rows="10" name="text" style="width:396px"></textarea>
				<br><center><input type="submit" class="non-green-button" name="submit" value="Submit"><center>
			</form>
			
		</div>
	</div>
</div>