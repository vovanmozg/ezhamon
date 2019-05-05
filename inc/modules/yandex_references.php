<?


function yandex_references($params)
{
	$url = $params["url"];

	//$file=implode("",file("http://www.yandex.ru/yandsearch?numdoc=10&text=%23url%3D%22$url*%22&pag=d&rd=0"));
	if($_GET["debug"] == "7") {echo "http://www.yandex.ru/yandsearch?text=%22$url%22";}
	$file=implode("",file("http://www.yandex.ru/yandsearch?text=%22$url%22"));

	if(preg_match("!ашл[^0-9]+ (\d+)(( |\&nbsp\;)(тыс)\.)?(( |\&nbsp\;)(млн))? страниц!si",$file,$ok))
	{ 
		
		if($ok[4] == "тыс")
		{
			$str = $ok[1] * 1000;
		}
		elseif($ok[7] == "млн")
		{
			$str = $ok[1] * 1000000;
		}
		else
		{
			$str = $ok[1];
		}
		
	} 
	elseif (preg_match("!<title>.*?ничего не найдено.*?</title>!si",$file,$ok))
	{
		$str="0";
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

function yandex_references_info($params)
{
	return array("link" => "http://www.yandex.ru/yandsearch?text=%22".$params["url"]."%22");
}
?>