<?
function google_pages_index($params)
{
	$url = $params["url"];
	
	if($_GET["debug"] == "7") {echo "http://www.google.com/search?&q=allinurl:$url+site:$url&hl=en";}
	//$file=implode("",file("http://www.google.com/search?&q=allinurl:$url+site:$url&hl=en"));
	$file=implode("",file("http://www.google.com/search?&q=site:$url&hl=en"));
	//$file=implode("",file("../tmp/google3.htm"));
	
	if(preg_match("!<div id=resultStats>(About)?(.*?)result!si",$file,$ok))
	{
		$link=trim($ok[2]);
		$link=str_replace(",", "", $link);
		if($ok[1] == "about ")
		{
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
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}

function google_pages_index_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://www.google.com/search?&q=site:$url&hl=en");
}

?>