<?
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta HTTP-EQUIV="Refresh" Content="15; URL=?next">
	<style type="text/css" media="all">
		@import "style.css";
	</style>
</head>
<body>
<?
/*
Ежамон от Вована Полухина (vovanmozg.com).
Система автоматического мониторинга сайтов. 2010
*/

require('config.php');
require('common.php');
require('topmenu.php');
require('utf/utf8.class.php');
require('inc/browser.class.php');


global $db;


$db = @mysql_connect($db_server, $db_user, $db_pass);

if(!$db)
{
	ShowDbError(@mysql_error());
	die();
}

// Попытка выбора БД
$res = @mysql_select_db($db_name);
if(!$res)
{
	ShowDbError(@mysql_error());
	die();
}
@mysql_query("SET NAMES utf8;", $db);

$site = getReadySite();
if($site["sid"]){
	$params = processSite($site["url"]);
	saveParams($site["sid"],$params);
}

@mysql_close($db);

function getReadySite(){
	global $db;
	print "Получение очередного сайта...<br>";
	
	// Получить список всех сайтов
	$res = @mysql_query("SELECT * FROM ezhamon_sites WHERE active='1'", $db);
	if(!$res)
	{
		ShowDbError(@mysql_error());
		return false;
	}
	
	while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
	{
		$sites[$row["sid"]] = $row["url"];
	}
	@mysql_free_result($res);

	// Надо найти сайт, который не проверялся за последние сутки
	// Для этого по очереди выбираем все сайты до тех пор, пока не найдём подходящий
	$fora = time()-24*60*60;
	//$fora = time()-30;
	
	$sites = is_array($sites)?$sites:array();
	
	while(list($sid, $url) = each($sites)){ // понимаю, что тут что-то нехорошее... В следующих релизах пофиксим
		
		$res = @mysql_query("SELECT * FROM ezhamon_monitor WHERE sid = $sid AND timestamp > $fora", $db);
		if(!$res)
		{
			ShowDbError(@mysql_error());
			return false;
		}
		
		if(mysql_num_rows($res) == 0)
		{
			@mysql_free_result($res);
			$sites[$row["sid"]] = $row["url"];
			$rez = array("url"=>$url, "sid"=>$sid);
			return $rez;
		}
		@mysql_free_result($res);		
	}
	
	return false;
}

function saveParams($sid, $params){
	global $db;
	print "Сохранение в базу данных...<br>";
	foreach($params as $key => $info){
		$val = $info["value"];
		$values .= "$key = '$val', ";
	}
	//$values = substr($values,0,strlen($values)-2);

	$res = @mysql_query("INSERT INTO ezhamon_monitor SET $values timestamp=".time().", sid=$sid;", $db);
	if(!$res)
	{
		ShowDbError(@mysql_error());
		return false;
	}
}

function processSite($site){
	global $db;
	global $EZHROOT;
	print "Получение параметров...<br>";
	$info = array();
	
	
	// Получить список характеристик. Он нам нужен, чтобы получить список параметров
	$sql = "SELECT * FROM ezhamon_fields";
	$res = @mysql_query($sql, $db);
	
	if(!$res)
	{
		ShowDbError(@mysql_error());
		return false;
	}
		
	while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
	{
		$fields[$row["id"]] = $row;
	}
	@mysql_free_result($res);
	
	// в цикле перебираем модули и вызываем функции получения параметров сайтов (ИЦ, PR ...)
	foreach($fields as $field)
	{
		$module = 'inc/modules/'.$field["id"].'.php';
		if(is_file($module))
		{
			include($module);
			if(function_exists($field["id"]))
			{
				$info[$field["id"]] = call_user_func_array($field["id"], array(array("url" => $site)));
				/*
				if($f = fopen("$EZHROOT/tmp/".$field["id"]."-$site.htm","w"))
				{
					fwrite($f, $info[$field["id"]]["content"]);
					fclose($f);
				}
				*/
			}
			
		}
	}
	//var_dump($info);
	return $info;
}


?>
<? require('footer.php'); ?>
</body>
</html>