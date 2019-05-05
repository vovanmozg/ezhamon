<?
function yahoo_links($params)
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
	//if($_GET["debug"] == "7") {echo "http://search.yahoo.com/search?_adv_prop=web&x=op&va=linkdomain%3A$url+-site%3A$url&va_vt=any&vp_vt=any&vo_vt=any&ve_vt=any&vd=all&ei=UTF-8&vst=0&vf=all&vm=i&fl=0&n=40";}
	$file=implode("",file("http://search.yahoo.com/search?p=%28linkdomain%3A$urlbezwww+OR+linkdomain%3A$urlswww%29+-site%3A$urlswww+-site%3A$urlbezwww&y=Search&fr=&ei=UTF-8&n=10&vf=all"));

	//if(preg_match("!of( about)? ([0-9 ,]+) for!si",$file,$ok)){ 
	if(preg_match('!<strong id="resultCount">([^<]*)</strong>!si',$file,$ok)){ 
		$str=$ok[1];
	} 
	else if(preg_match("!We did not find results for!si",$file))
	{
		$str = 0;
	}
	else {
		$str="x";
	}
	$outAr["value"] = $str;
	$outAr["link"] = "";
	$outAr["title"] = "";
	$outAr["status"] = "";
	$outAr["content"] = $file;
	return $outAr;
}

function yahoo_links_info($params)
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
	return array("link" => "http://search.yahoo.com/search?p=%28linkdomain%3A$urlbezwww+OR+linkdomain%3A$urlswww%29+-site%3A$urlswww+-site%3A$urlbezwww&y=Search&fr=&ei=UTF-8&n=10&vf=all");	
}

?>