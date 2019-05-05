<?

require("li.php");

function li_day_vis($params)
{
	$url = $params["url"];
	$info = liStat($url);
	$outAr["value"] = $info["day_vis"]?$info["day_vis"]:'x';
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = var_export($info, true);
	return $outAr;
}

function li_day_vis_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://www.liveinternet.ru/stat/$url/index.gif?total=yes;graph=yes");
}

?>