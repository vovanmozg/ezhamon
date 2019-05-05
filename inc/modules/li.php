<?
/*
LI_site = 'vovanmozg.com';
LI_month_hit = 865;
LI_month_vis = 458;
LI_week_hit = 367;
LI_week_vis = 189;
LI_day_hit = 97;
LI_day_vis = 39;
LI_today_hit = 51;
LI_today_vis = 18;
LI_online_hit = 6;
LI_online_vis = 1;
*/
function liStat($url){
	
	if($_GET["debug"] == "7") {echo "http://counter.yadro.ru/values?site=".$url;}
	
	$lines = file("http://counter.yadro.ru/values?site=".$url);
	$info = array();
	foreach($lines as $line){
		if(preg_match("|LI_([^ ]+) = (\d*);|",$line,$ok)){
			$info[$ok[1]] = $ok[2];
		}
	}

	return $info;
}


?>