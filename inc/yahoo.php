<?
function yahooGetPagesCount($url){
	
	if($_GET["debug"] == "7") {echo "http://siteexplorer.search.yahoo.com/search?ei=UTF-8&p=$url&bwm=p&bwmf=a&bwms=p&searchbwm=Explore+URL";}
	$file=implode("",file("http://siteexplorer.search.yahoo.com/search?ei=UTF-8&p=$url&bwm=p&bwmf=a&bwms=p&searchbwm=Explore+URL"));

	if(preg_match("!of about ([0-9 ]+) for!si",$file,$ok)){ 
		$str=$ok[1];	
	} 
	else {
		$str="x";
	}
	return $str;
}

function yahooGetLinksCount($url){
	if($_GET["debug"] == "7") {echo "http://search.yahoo.com/search?_adv_prop=web&x=op&va=linkdomain%3A$url+-site%3A$url&va_vt=any&vp_vt=any&vo_vt=any&ve_vt=any&vd=all&ei=UTF-8&vst=0&vf=all&vm=i&fl=0&n=40";}
	$file=implode("",file("http://search.yahoo.com/search?_adv_prop=web&x=op&va=linkdomain%3A$url+-site%3A$url&va_vt=any&vp_vt=any&vo_vt=any&ve_vt=any&vd=all&ei=UTF-8&vst=0&vf=all&vm=i&fl=0&n=40"));

	if(preg_match("!of about ([0-9 ]+) for!si",$file,$ok)){ 
		$str=$ok[1];
		
	} 
	else {
		$str="x";
	}
	return $str;
}

?>