<?
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
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

//$db->setFetchMode(DB_FETCHMODE_ASSOC);
@mysql_query("SET NAMES utf8;", $db);
//$res =& $db->query("SET NAMES utf8;");
// Получить список характеристик. Он нам нужен, чтобы сделать шапку таблицы, а также для отображения значений в таблице

$sql = "SELECT * FROM ezhamon_fields";
$res = @mysql_query($sql, $db);

if(!$res)
{
	ShowDbError(@mysql_error());
	die();
}


while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	$fields[$row["id"]] = $row;
}

//$res =& $db->query($sql);
//if (PEAR::isError($res)) die($res->getMessage());
//while ($row =& $res->fetchRow()) {
//	$fields[$row["id"]] = $row;
//}
//$res->free();
@mysql_free_result($res);


?>
<table id="main">
	<tr>
		<th>Дата</th>
<?
foreach($fields as $field)
{
	echo "<th><span title='".$field["title"]."'>".$field["caption"]."</span></th>";
}
?>
		
	</tr>
<?

// Получить данные о сайте
$site = mysql_escape_string($_GET["site"]);

$sql = "SELECT * FROM ezhamon_sites, ezhamon_monitor WHERE ezhamon_sites.sid = ezhamon_monitor.sid AND ezhamon_sites.url = '".$site."';";
$res = @mysql_query($sql, $db);
if(!$res)
{
	ShowDbError(@mysql_error());
	die();
}
while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	$data[$row["timestamp"]] = $row;
}

@mysql_free_result($res);



// Вывести данные о сайтах

$data = is_array($data)?$data:array();
foreach($data as $time => $info){
	krsort($data[$time]);
	
	echo "<tr>";
	echo "<td>".date("Y-m-d",$info["timestamp"])."<br>".date("H:i:s",$info["timestamp"])."</td>";
	//echo "<td>".$info["url"]."</td>";
	foreach($fields as $field)
	{
		$className = "";
		//$className = ($info[$field["id"]]==$infoold[$field["id"]]?"":($info[$field["id"]]<$infoold[$field["id"]]?"fall":"growth"));
		echo "<td><span class='$className'>".$info[$field["id"]]."</span><br /> <span class='gray'>".$infoold[$field["id"]]."</span></td>";
	}
	echo "";
	echo "</tr>";
	
}
	


@mysql_close($db);

?>
</table>
<? require('footer.php'); ?>
</body>
</html>
<?
/*


--- для разработчиков ---

Если вы хотите чтобы система отслеживала другие показатели, например, количество
проиндексированных страниц в MSN для этого:

1) В таблицу ezhamon_monitor добавить поле типа varchar
2) В таблицу ezhamon_fields добавить запись с описанием этого поля
3) В папку inc/modules добавить обработчик с именем файла таким же как имя поля в
   таблице ezhamon_monitor. Пока мануала нет, делаем обработчик по типу тех, которые уже есть в системе.


*/?>