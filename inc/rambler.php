<?
  
function ramblerGetLinksCount($url){
	if($_GET["debug"] == "7") {echo "http://www.google.com/search?hl=ru&q=link%3A$url&lr=";}
	$file=implode("",file("http://www.google.com/search?hl=en&q=link%3A$url&lr="));
	if(preg_match("!of (about )?<b>(.*?)</b> linking!si",$file,$ok)){
		$link=$ok[2];
		if($ok[1] == "about "){
			$link .= " ~";
		}
	} else {
		$link="0";
	}

	return $link;
}

function ramblerGetPagesCount($url){
	if($_GET["debug"] == "7") {echo "http://www.google.com/search?&q=allinurl:$url+site:$url&hl=en";}
	
	$file=implode("",file("http://search.rambler.ru/srch?sort=0&filter=$url&short=2&limit=1"));
	if(preg_match("!&nbsp;<B>(.*?)</B><BR>!si",$file,$ok)){
		$link=$ok[1];
	}
	else {
		$link=0;
	}
	
	return $link;
}

?>