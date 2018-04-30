<?php
	include_once "regcrawl/regcrawl.php";
	$regex = new Regcrawl();
	$pages = file_get_contents("load/pages.load");
	$siteMenu = "";
	
	$pagesLoad = $regex->regexMatch("<title>([^<]*)<[^<]*<doc>load/([^\.]*)[^<]*<",$pages);
	
	
	for ($i=0; $i<sizeof($pagesLoad); $i++){
			$siteMenu = $siteMenu . '<a href="index.php?name='.$pagesLoad[$i][2].'" class="menubtn">'.$pagesLoad[$i][1].'</a><div class="menusep"></div>';
	}
	
	echo $siteMenu;
	