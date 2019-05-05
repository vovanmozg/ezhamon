<?

require("whois.php");

function whois_expired($params){
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

	$whois = whois($urlbezwww);

	$day_left = 'x';
	if(preg_match('/([0-9]{4})\.([0-9]{2})\.([0-9]{2})/', $whois['paid-till'], $ok)) {
		$paid_till = mktime(0, 0, 0, $ok[2], $ok[3], $ok[1]);
		$day_left = floor(($paid_till - time()) / (60*60*24));
	}

	$outAr["value"] = $day_left;
	$outAr["title"] = "Whois домена";
	$outAr["link"] = "https://www.nic.ru/whois/?query=$urlbezwww";
	$outAr["status"] = "";
	$outAr["content"] = $day_left;
	return $outAr;
}



?>