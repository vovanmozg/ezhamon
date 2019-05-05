<?

function sape_pages($params){
	$url = $params["url"];
	if($_GET["debug"] == "7") {echo "";}
	$file=implode("",file("http://dms.net.ru/services/sapestat/pagescountnow.php?url=$url"));

	$outAr["value"] = $file;
	$outAr["title"] = "Количество ссылок проиндексированных сапой";
	$outAr["link"] = "http://dms.net.ru/services/sapestat/pagescountnow.php?url=$url";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}

function sape_pages_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://dms.net.ru/services/sapestat/pagescountnow.php?url=$url");
}

?>