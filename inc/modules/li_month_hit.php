<?

require("li.php");

function li_month_hit($params)
{
	$url = $params["url"];
	$info = liStat($url);
	$outAr["value"] = $info["month_hit"]?$info["month_hit"]:'x';
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = var_export($info,true);
	return $outAr;
}

function li_month_hit_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://www.liveinternet.ru/stat/$url/index.gif?total=yes;graph=yes");
}

?>