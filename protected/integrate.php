<?php session_start();function user(){	if(isset($_SESSION['email']))		echo "<a href=\"profile.php\">" . $_SESSION["email"] . "</a>";	else		echo "<a href=\"sign.php\">Sign in</a>";}?><!doctype html>
<html lang="en">
	<head>		<?php echo file_get_contents("texts/head.html"); ?>
		<meta charset="utf-8">
		<meta name="description" content="Angellandros">
		<title>Angellandros</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<LINK href="SquareAngellandros.ico" rel="SHORTCUT ICON">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	</head>
	<body>			<?php 		include('include/profile.php');		if(!isset($_SESSION['email']))			showout();		else			showin($_SESSION['email']);		?>	
		<div id="topnav">
			<ul>
				<li class="active"><a href="index.php"><strong>Angellandros</strong></a></li>				<li><img src="menu-arrow.png"></li>
				<li><a href="chatrang.php"><strong>Chatrang</strong></a></li>
				<li><a href="dodeca.php"><strong>Dodeca</strong></a></li>				<li><a href="games.php"><strong>Games</strong></a></li>
				<li class="last"><a href="press/index.php"><strong>Press</strong></a></li>
			</ul>						<div id="topright">				<?php user(); ?>			</div>
		</div>
		
		<div id="main">
			<div id="mid">
				<div id="maintext">
					<center><img src="integrate.png"></center>										<div id="button-container">						<br><br>						<div id="button" onclick="window.open('chatrang.php','mywindow');">							<div id="button-cont">								<center>								<b>Chatrang</b>								<br>								</center>								Chatrang is the branch for linguistics, mathematics, and computation.<br>								<ul>									<li>Computational linguistics: <a>Persian VerbLab</a> is a service for word-formation.</li>									<li>Mathematical education: <a>Karzar</a> is a competition uses <a>KCMS</a>.</li>									<li>Discrete mathematics.</li>								</ul>							</div>						</div>						<div id="button" class="b2" onclick="window.open('dodeca.php','mywindow');">							<div id="button-cont">								<center>								<b>Dodeca</b>								<br>								</center>								Dodeca is the branch for academic communities and services.<br>								<ul>									<li><a>Dodecahedron</a>: a model for scientific associations, and also a forum based on it.</li>									<li><a>Dodeca LaTeX</a>: an stand-alone mathematics editor.</li>									<li><a>TeaMaS</a>: teaching management service.</li>								</ul>							</div>						</div>						<div id="button" class="b3" onclick="window.open('games.php','mywindow');">							<div id="button-cont">								<center>								<b>Games</b>								<br>								</center>								The video games developement and publishing branch.<br>								<ul>									<li>Platform games: <a>Pacman 2 — the Fall of Pacman</a>, a Pacman game with guns; <a>Sepehr</a>, a puzzle-action game; etc.</li>									<li>FPS games: <a>No killing</a>, a different shooter game.</li>									<li>Strategy games.</li>								</ul>							</div>						</div>						<div id="button" class="b4" onclick="window.open('press/index.php','mywindow');">							<div id="button-cont">								<center>								<b>Press</b>								<br>								</center>								The branch for self-publishing services, including e- and print.<br>								<ul>									<li><a>POD</a>: print-on-demand services.</li>									<li><a>eShop</a>: online shop for electronic self-publishing.</li>									<li><a>None-for-profit publishing</a>: services for publishing online magazines, etc.</li>								</ul>							</div>						</div>					</div>					
				</div>
			</div>
		</div>
		<?php echo file_get_contents("texts/bottom.html"); ?>
		
</body>
</html>