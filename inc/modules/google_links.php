<?

function google_links($params){
	$url = $params["url"];
	if($_GET["debug"] == "7") {echo "http://www.google.com/search?hl=ru&q=link%3A$url&lr=";}
	$file=implode("",file("http://www.google.com/search?hl=en&q=link%3A$url&lr="));
	if(preg_match("!of (about )?<b>(.*?)</b> linking!si",$file,$ok)){
		$link=$ok[2];
		if($ok[1] == "about "){
			$link .= " ~";
		}
	}
	else if(preg_match("!No results found|did not match any documents!si",$file))
	{
		$link="0";
	}
	else
	{
		$link="x";
	}
	$outAr["value"] = $link;
	$outAr["title"] = "Количество ссылок на сайт по данным Google";
	$outAr["link"] = "http://www.google.com/search?hl=en&q=link%3A$url&lr=";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}

function google_links_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://www.google.com/search?hl=en&q=link%3A$url&lr=");
}

?>