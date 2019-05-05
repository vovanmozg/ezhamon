<?
function yahoo_pages_index($params)
{
	$url = $params["url"];
	//if($_GET["debug"] == "7") {echo "http://siteexplorer.search.yahoo.com/search?ei=UTF-8&p=$url&bwm=p&bwmf=a&bwms=p&searchbwm=Explore+URL";}
	$file=implode("",file("http://siteexplorer.search.yahoo.com/search?ei=UTF-8&p=$url&bwm=p&bwmf=a&bwms=p&searchbwm=Explore+URL"));
 
	if(preg_match('!<span class="btn">Pages \(([0-9 ,]+)\)<i!si',$file,$ok))
	{ 
		$str=$ok[1];
	} 
	else if(preg_match("!<h2>No Results</h2>!si",$file))
	{
		$str = 0;
	}
	else
	{
		$str="x";
	}
	$outAr["value"] = $str;
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
	
}

function yahoo_pages_index_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://siteexplorer.search.yahoo.com/search?ei=UTF-8&p=$url&bwm=p&bwmf=a&bwms=p&searchbwm=Explore+URL");
}

?>