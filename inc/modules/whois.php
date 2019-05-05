<?

function whois($domen) {
	/*
Регистратор whois n_f
R01-REG-RIPN whois.r01.ru [Reply from server WHOIS.RIPN.NET]
REGRU-REG-RIPN whois.reg.ru not found
REGISTRATOR-REG-RIPN whois.mastername.ru not found
REGTIME-REG-RIPN whois.regtime.net not found
RTCOMM-REG-RIPN whois.rtcomm.ru [Reply from server WHOIS.RIPN.NET
SOVINTEL-REG-RIPN whois.gldn.net [Reply from server WHOIS.RIPN.NET]
CENTROHOST-REG-RIPN whois.centrohost.ru [Reply from server WHOIS.RIPN.NET]
ELVIS-REG-RIPN whois.getname.ru found
CT-REG-RIPN whois.regplanet.ru No entries found for the selected source(
DEMOS-REG-RIPN whois.demos.ru No entries found in the selected source(s)
CARAVAN-REG-RIPN whois.caravan.ru No entries found for the selected source
NAUNET-REG-RIPN whois.naunet.ru was not found
ZASTOLBI-REG-RIPN whois.zastolbi.ru No entries found for the selected sourc
FREENET-REG-RIPN whois.free.net entries found for the selected source(s
RUCENTER-REG-RIPN whois.nic.ru entries found for the selected source(s

*/

	$whoises = array(
		'whois.nic.ru',
		'whois.rtcomm.ru',
		'whois.centrohost.ru',
		'whois.ripn.net'
	);
	
	$whois = $whoises[array_rand($whoises)];
	$nf=false;
	$buf = "";
	if($fp = fsockopen($whois, 43)) {
		fputs($fp, "$domen\r\n");
		while(!feof($fp))
			$buf .= "".fgets($fp,128);
		fclose($fp);
		$rez = Parse($buf, array('condfree' => 'No entries found for the selected sourc'));
		$rez['#body'] = $buf;
	}	else {
		$rez['#status'] = 'fsockopen error';
	}
	
	return $rez;
}



function Parse($buf, $ws) {
	if(preg_match("/".$ws['condfree']."/",$buf)){
		$rez["#status"] = 'free';
	}
	elseif (preg_match("/domain\:/",$buf)){
		$rez["#status"] ='delegated';
	}
	else {
		$rez["#status"] = 'unknown';
	}

	if(preg_match("/person:(\s|&nbsp;)*([^\n]+)/",$buf,$m)){
			$rez["#person"] = $m[2];
	}
	if(preg_match("/free-date:(\s|&nbsp;)*([^\n]+)/",$buf,$m)){
			$rez["#free"] = $m[2];
	}
	//print $buf;
	
	if(preg_match_all("%\n(\S+):\s+([^\n]+)%s", $buf, $ok)) {
		for($i=0; $i<count($ok[1]); $i++) {
			$rez[$ok[1][$i]] = $ok[2][$i];
		}
	}
	
	return $rez;
}


?>