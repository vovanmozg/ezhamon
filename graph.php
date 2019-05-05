<?
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
require_once('auth.php');
?>
<?

/*

Ежамон от Вована Полухина (vovanmozg.com).
Система автоматического мониторинга сайтов. 2010

*/
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
		@import "style.css";
	</style>
</head>
<body>

<?
require('config.php');
require('common.php');
// Отобразить шапку таблицы
require('topmenu.php');




/* На вход скрипта должны поступать
- сайт
- параметр для отслеживания

например так:

graph.php?site=x28.ru&value=yandex_cy



 */

if(!$_REQUEST["site"])
{
	die("Не указан сайт для отслеживания");
}

if(!$_REQUEST["value"])
{
	die("Не указан параметр для отслеживание");
}

$site = stripcslashes(trim($_REQUEST["site"]));
$value = stripcslashes(trim($_REQUEST["value"]));

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

// Получить данные о сайтах
$sql = "SELECT * FROM ezhamon_sites, ezhamon_monitor WHERE ezhamon_sites.sid = ezhamon_monitor.sid AND ezhamon_sites.active <> '2' AND ezhamon_sites.url = '".$site."';";
$res = @mysql_query($sql, $db);
if(!$res)
{
	ShowDbError(@mysql_error());
	die();
}
while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	//$date = date("Y:m:d",$row["timestamp"]);
	$date = date("d.m.Y",$row["timestamp"]);
	$data[$date] = is_numeric($row[$value])?$row[$value]:0;
	
	
}

/*
c=5
c2=5
step=1

c=10
c2=10
step=1

c=30
c2=10
step=3

c=100
c2=10
step=10

*/


if(count($data) <= 6)
{
	$step = 1;
}
else 
{
	$step = round(count($data)/6);
}

$i=1;
$maxvalue = 0;
foreach($data as $date => $value)
{
	
	$maxvalue = $value > $maxvalue ? $value : $maxvalue;
	$values .= $value . ',';
	$i++;
	if($i > $step)
	{
		$i=1;
		$dates .= $date . "|";
	}
}

$values = substr($values,0,strlen($values)-1);

//$dates = "2008.10.06|2008.10.07|2008.10.08|2008.10.09|2008.10.10|";
//$values = "10,10,10,10,0,10,60,60,60,60,50,0,60";

//var_dump($data);

@mysql_free_result($res);
@mysql_close($db);

?>

<img src="http://chart.apis.google.com/chart?
chs=600x400
&amp;chd=t:<? echo $values; ?>
&amp;cht=lc
&amp;chg=20,50,1,0
&amp;chxt=x,y
&amp;chxl=0:|<? echo $dates . "1:||".$maxvalue; ?>" 
alt="Sample chart" />

<?
/*

array(14) {
  ["sid"]=>
  string(1) "8"
  ["url"]=>
  string(4) "test"
  ["active"]=>
  string(1) "1"
  ["google_pr"]=>
  string(1) "x"
  ["yandex_cy"]=>
  string(1) "0"
  ["yandex_pages_index"]=>
  string(7) "2000000"
  ["google_pages_index"]=>
  string(1) "0"
  ["rambler_pages_index"]=>
  string(3) "NaN"
  ["yandex_references"]=>
  string(9) "108000000"
  ["google_links"]=>
  string(1) "x"
  ["yahoo_pages_index"]=>
  string(1) "x"
  ["yahoo_links"]=>
  string(1) "0"
  ["li_day_vis"]=>
  string(1) "x"
  ["timestamp"]=>
  string(10) "1223275278"
}
*/

?>
</table>
<? require('footer.php'); ?>
</body>
</html>
