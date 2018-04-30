<?php
class Regcrawl{
	private $regHtml;
  
  public function __construct($aURL=NULL){
		if ($aURL!=NULL)
			$this->urlGetContent($aURL);
	}
  
  //Get HTML from url
	public function urlGetContent($aURL){
		$tmp=file_get_contents($aURL);
		$this->regHtml=$tmp;
	}

	//Regex match function "my way"
	public function regexMatch($aKey=NULL,$aSearch){
		$tmpMatch="";
		$tmpNewArray = "";
			if ($aKey!=NULL){
					preg_match_all(
						"/".str_replace("/","\/",$aKey)."/s",
						$aSearch,$tmpMatch,
						PREG_SET_ORDER
					);
			}

		for ($i=0; $i<sizeof($tmpMatch); $i++){
			for ($j=1; $j<sizeof($tmpMatch[$i]); $j++){
				$tmpNewArray[$i][$j]=$tmpMatch[$i][$j];
				//print_r($tmpMatch[$i][$j]);
			}
		}	

		return $tmpNewArray;
	}
	
	//Match the html content
	public function regexHtml($aKey=NULL){
		return $this->regexMatch($aKey,$this->regexHtml);
	}
		
}