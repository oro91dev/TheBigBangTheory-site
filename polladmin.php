<?php
	include_once "regcrawl/regcrawl.php";
	
	$regex = new Regcrawl();
	
	
	if (isset($_GET["name"])){
		$file=$_GET["name"];
		if (isset($_POST["update"])){
			$update = $_POST["update"];
			$tmpFile = fopen($file,'w');
			fwrite($tmpFile,$update);
			fclose($tmpFile);
		}
		if (file_exists($file)){
			$fileContent = file_get_contents($file);
		}else{
			$tmpFile = fopen($file,'w');
			$tmpFile = fopen($file.".vote",'w');
			fclose($tmpFile);
			fclose($tmpFile.".vote");
			$fileContent = file_get_contents($file);
		}
	}else{
		$file = "polls/polls.load";
		$fileContent = file_get_contents($file);
	}
	
	$pages = file_get_contents("polls/polls.load");
	$menu = "";

	$pagesLoad = $regex->regexMatch("<title>([^<]*)<[^<]*<doc>([^<]*)<[^<]*<active>([^<]*)<",$pages);

	if (is_array($pagesLoad)){
  	for ($i=0; $i<sizeof($pagesLoad); $i++){
  			$menu = $menu . '<a href="polladmin.php?name='.$pagesLoad[$i][2].'" class="profile-ext profile-page">'.$pagesLoad[$i][1].'</a>';
  			if (($i+1) % 6 == 0	){
  				$menu = $menu."<br/>";
  			}
  	}
  }
?>


<!DOCTYPE html>

<html>
	<head>
		<meta charset="ISO-8859-1" />
		<title>TBBT admin</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="script/dropdown.js"></script>
		<link rel="stylesheet" type="text/css" href="styleadmin/style.css" />
	</head>
	<body>
	
		<div class="bar-main">
			<div class="container-main">
				<a href="#" class="logobutton">TBBT admin</a>
				<div class="bgmenubutton">
					<a href="#" class="menubutton" id="menuButton">Meny</a>
				</div>
				<div class="dropdownbox" id="dropdownBox">
					<div class="dropdown">
						<a href="admin.php" class="dropdownbtn">Innhold</a>
						<a href="polladmin.php" class="dropdownbtn">Poll</a>
					</div>
				</div>
			</div>
		</div>

		<div class="gradient-background"></div>
		<div class="container-main">
			<div class="container-content">
				<h1>Poll <a href="polladmin.php?name=polls/polls.load" class="profile-ext profile-page">Rediger / Legg til</a></h1>
				<?php
					echo $menu;
					
					echo '<br /><br /><a href="javascript: document.getElementById(\'formUpdate\').submit()" class="profile-ext profile-page">Lagre</a>&nbsp;<strong>'.$file.'</strong>
								<form action="polladmin.php?name='.$file.'" method="post" id="formUpdate">
									<textarea name="update">'.$fileContent.'</textarea>
								</form>
							 ';
				?>

			</div>
		</div>
	
	</body>
</html>