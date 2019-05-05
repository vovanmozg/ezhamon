<?
function yandex_pages_index($params)
{
	$url = $params["url"];
	if(substr($url,0,4) == "www.")
	{
		$urlswww = $url;
		$urlbezwww = substr($url,4,strlen($url)-4);
	}
	else
	{
		$urlswww = "www.".$url;
		$urlbezwww = $url;
	}
	
	//$checkurl = "http://yandex.ru/yandsearch?text=&site=".$urlbezwww;
	$checkurl = "http://yandex.ru/yandsearch?text=&site=".$urlbezwww."&lr=11266";
	
	if($_GET["debug"] == "7") {echo $checkurl;}
	
	$br = new Browser('Mozilla/5.0 (Windows; U; Windows NT 5.0; us; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
	
	$str="x";
	$counter = 0;
	while($str=="x" && $counter++ < 1) 
	{
		if($counter == 1)
		{
			$br->PROXY = false; //сначала попробуем обратиться к яндексу напрямую без проксей
		}
		else
		{
			$br->PROXY = GetRandomProxy('proxy.txt');
		}
		
		$file = $br->Get($checkurl,10);
		//$file = file_get_contents('../tmp/yan2CEB.tmp');
		//$tmpfile = tempnam('../tmp','yandex_pages_index-' . date('Y-m-d-h-i-s-',time()));
		//file_put_contents($tmpfile,var_export($file, TRUE));
		//chmod($tmpfile,0777);
		//if(preg_match("!ашл[^0-9]+ (\d+)(( |\&nbsp\;)(тыс)\.)?(( |\&nbsp\;)(млн))? страниц!si",$file,$ok))
		//(( |\&nbsp\;)(тыс)\.)?(( |\&nbsp\;)(млн))?
		//Нашлось 218&nbsp;ответов
		//
		
	//if(preg_match("!аш[^0-9]+([0-9]+)(&nbsp;| )+ответ!si",$file,$ok))
		//if(preg_match("!аш[^0-9]+([0-9]+)(( |&nbsp;)(тыс)\.)?(( |&nbsp;)(млн))?(&nbsp;| )ответ!si",$file,$ok))
		if(preg_match("!аш[^0-9]+([0-9]+)(&nbsp;| )+ответ!si",$file,$ok)){
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
			//mail("vovanmozg@gmail.com","yandex_pages_index TROUBLE",$file);
			$str="x";
		}
	}
	
	$outAr["value"] = $str;
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}
function yandex_pages_index_info($params)
{
	$url = $params["url"];
	if(substr($url,0,4) == "www.")
	{
		$urlswww = $url;
		$urlbezwww = substr($url,4,strlen($url)-4);
	}
	else
	{
		$urlswww = "www.".$url;
		$urlbezwww = $url;
	}
	$checkurl = "http://yandex.ru/yandsearch?text=&site=".$urlbezwww;
	return array("link" => $checkurl);
}
?>