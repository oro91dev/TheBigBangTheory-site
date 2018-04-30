<!DOCTYPE html>

<html>
<head>
  <title>Poll</title>
  <meta charset="windows-1252" />
	<link rel="stylesheet" type="text/css" href="style/poll.css" />
</head>
<body>
<?php
  error_reporting(0);
  include_once "regcrawl/regcrawl.php";
	
	//Last regex interface
	$regex = new Regcrawl();
	
	//Last inn korekt filer for polls
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
			fclose($tmpFile);
			$fileContent = file_get_contents($file);
		}
	}else{
		$file = "polls/polls.load";
		$fileContent = file_get_contents($file);
	}
	
	//Få innholdet til pollfilen
	$pages = file_get_contents("polls/polls.load");
	$menu = "";
	$total = 0;
	$ipaddr = $_SERVER['REMOTE_ADDR'];
	$hasvote = false;

  //Få ut all data fra xml filen med regex
	$pollLoad = $regex->regexMatch("<title>([^<]*)<[^<]*<doc>([^<]*)<[^<]*<active>([^<]*)<",$pages);
	
	//Sjekk om (filen eksisterer) pollLoad faktisk er en array
	if (is_array($pollLoad)){
  	for ($i=0; $i<sizeof($pollLoad); $i++){
			if ($pollLoad[$i][3]=="true"){
        $poll = file_get_contents($pollLoad[$i][2]);
        $result = file_get_contents($pollLoad[$i][2].".vote");
        $title = $pollLoad[$i][1];
        $filename = $pollLoad[$i][2];
        break;
      }
  	}
  }
  
  //Sjekk om stemme filen eksisterer
  if (file_exists($filename.".vote")){
    //Hent ut data fra xml filen med regex
    $votes = $regex->regexMatch("<vote\s*id=\"([^\"]*)\"\s*option=\"([^\"]*)\"[^>]*>(.*?)</vote>",$result);

    //Loop gjennom stemmene
    for ($i=0; $i<sizeof($votes); $i++){
      $count[$i][0] = $votes[$i][1]; //Option ID
      $count[$i][1] = $regex->regexMatch("<count>([^<]*)<",$votes[$i][3]); //Users IP
      $count[$i][2] = $votes[$i][2]; //Option Text

      //Sjekk om det er stemmer under alternativet
      if ($count[$i][1]!=""){
        //Legg til antal stemmer til totalen
        $total = $total + sizeof($count[$i][1]);
      }
      //Loop gjennom stemmene for å se om personene allerede
      //har stemt eller ikke
      for ($j=0; $j<sizeof($count[$i][1]); $j++){
        if (is_array($count[$i][1][$j])){
          if ($ipaddr==$count[$i][1][$j][1]){
            $hasvote = true;
            break;
          }
        }
      }
    }
  }

  //Hent ut spørsmålene med regex
  $questions = $regex->regexMatch("<question>([^<]*)<",$poll);
  //Måtte være med...
  $options = $regex->regexMatch("<option\s*id=\"([^\"]*)\">([^<]*)<",$poll);
  
  //Sjekk om en stemme er sendt inn og om personen 
  //allerede har stemt eller ikke (for å ungå hacking)
  if (isset($_GET["vote"]) && $hasvote==false){
    //Generer den nye stemmen
    $newvote = "<count>".$ipaddr."</count>";
    $newfile="";
    //Loop gjennom eksisterende stemmer
    for ($j=0; $j<sizeof($options); $j++){
      $newfile=$newfile."<vote id=\"".$options[$j][1]."\" option=\"".$options[$j][2]."\">\n";
      //Sjekk om count er en array
      //om den er skal den
      if (is_array($count[$j][1])){
        for ($i=0; $i<sizeof($count[$j][1]); $i++){
          $newfile=$newfile."\t<count>".$count[$j][1][$i][1]."</count>\n";
        }
      }
      if ($options[$j][1]==$_GET["vote"])
        $newfile=$newfile."\t".$newvote."\n";

      $newfile=$newfile."</vote>\n";
    }
    if (!file_exists($filename.".vote")){
      $tmpFile = fopen($filename.".vote",'w');
		  fwrite($tmpFile,"");
		  fclose($tmpFile);
    }
    $tmpFile = fopen($filename.".vote",'w');
		fwrite($tmpFile,$newfile);
		fclose($tmpFile);
    /*$strold=array("<",">");
    $strnew=array("&lt;","&gt;");
    echo str_replace($strold,$strnew,$newfile);*/
    //$hasvote=true;
    echo '<META HTTP-EQUIV="Refresh" CONTENT="2; URL=poll.php">';
  }



  if ($hasvote == false){
    $options = $regex->regexMatch("<option\s*id=\"([^\"]*)\">([^<]*)<",$poll);

    echo "<form action='poll.php' method='GET'>";
    echo "<h1 class='poll-head'>".$questions[0][1]."</h1>";
    echo "<table class='poll-table'>";
    for ($i=0; $i<sizeof($options); $i++){
      echo "<tr>";
      echo "<td><input type='radio' style='width: 40px;' name='vote' value='".$options[$i][1]."' /></td>";
      echo "<td>".$options[$i][2]."</td>";
      echo "</tr>";
    }
    echo "</table><input type='submit' value='Send inn!' /></form>";
  }
  else{
    echo "<h1 class='poll-head'>".$questions[0][1]."</h1>";
    echo "<table class='poll-table'>";
    for ($j=0; $j<sizeof($votes); $j++){
      for ($i=0; $i<sizeof($count[$j][0]); $i++){
        if ($count[$j][1]>0){
          $res = (round((sizeof($count[$j][1])*100)/$total,1));
          $ammount = sizeof($count[$j][1]);
        }
        else{
          $res = 0;
          $ammount = 0;
        }

        echo "<tr>";
        echo "<td>".$count[$j][2]." (".$ammount.")</td></tr><tr>";
        echo "<td style='width: 200px;'><div style='background-color: red; width: ".$res."%; height: 10px;'></div></td>";
        echo "</tr>";
      }
    }
    echo "</table><br />Stemmer totalt: <strong>".$total."</strong>";
  }

?>
</body>
</html>