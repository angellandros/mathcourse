<?php 
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Angellandros">
		<title>Angellandros</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<LINK href="SquareAngellandros.ico" rel="SHORTCUT ICON">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	</head>
	<body>
		<div id="topnav">
			<ul>
				<li class="active"><a href="index.php"><strong>Angellandros</strong></a></li>
				<li><a href="chatrang.php"><strong>Chatrang</strong></a></li>
				<li><a href="dodeca.php"><strong>Dodeca</strong></a></li>
				<li class="last"><a href="press/index.php"><strong>Press</strong></a></li>
			</ul>
		</div>
		
		<div id="main">
			<div id="mid">
				<div id="maintext">
					<center><img src="integrate.png"></center>
				</div>
			</div>
		</div>
		<?php echo file_get_contents("texts/bottom.html"); ?>
		
</body>
</html>