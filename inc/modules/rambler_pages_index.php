<?

function rambler_pages_index($params)
{
	$url = $params["url"];
	if($_GET["debug"] == "7") {/* echo ""; */}
	
	$file=implode("",file("http://nova.rambler.ru/srch?query=+&sort=0&filter=http://$url"));
	//if(preg_match("!&nbsp;<B>(.*?)</B><BR>!si",$file,$ok))
	if(preg_match("!Результаты <b>[^<]*</b> из <b>([^<]*)</b>!si",$file,$ok))
	{
		$link = $ok[1]=="NaN"?0:$ok[1];
	}
	else
	{
		$link="x";
	}
	
	$link = str_replace("тыс.","000",$link);
	
	$outAr["value"] = $link;
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}

function rambler_pages_index_info($params)
{
	$url = $params["url"];	
	return array("link" => "http://nova.rambler.ru/srch?query=+&sort=0&filter=http://$url");
}
?>