<?php
	if (isset($_GET["name"])){
		$name=$_GET["name"];
		$file="load/".$name.".load";

		if (file_exists($file)){
			$fileContent = file_get_contents($file);
		}else{
			$fileContent = "<h1 style='color: red'>Du har kommet til en side som ikke eksisterer! <br/> --> ELLER så er det fordi addressen har blitt forandret, venligst se etter dokumentet i menyen! <-- </h1>";
		}
	}else{
		$file = "load/forside.load";
		$fileContent = file_get_contents($file);
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="windows-1252" />
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="script/background.js"></script>
		<title>The Big Bang Theory - Norsk fanside</title>
		<?php
		  function w3c(){
        if((stristr($_SERVER["HTTP_USER_AGENT"],'w3c') === FALSE))
        return true;
      }
      if (w3c()){
        echo '
      		<meta property="fb:admins" content="100003075717493" />
          <meta property="fb:app_id" content="238372749561654" />';
      }
    ?>
	</head>
	<body>
	 <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

		<div class="container-main">
			<div class="mainlogo">&nbsp;</div>
			<div class="menubar bar-background">
				<?php
				  include "menu.php";
				?>
			</div>

			<div class="big-left">
				<?php
				  echo $fileContent;
				?>
			</div>
			<div class="spacing">&nbsp;</div>
			<div class="small-left">
        <?php
          include "sidemenu.php";
        ?>
			</div>
			<?php
			 include "footer.php";
			?>
		</div>
	</body>
</html>