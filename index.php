<?
/**
* Система автоматического мониторинга сайтов
* Ежамон (http://vovanmozg.com). 2010
*/
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
require_once('auth.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
		@import "style.css";
	</style>
	<script src="inc/jquery.js" ></script>
	<script src="inc/jquery.tablesorter.min.js" ></script>
	<script src="inc/ezhamon.js" ></script>
</head>
<body>

<?
require('config.php');
require('inc/_PEAR/JSON.php');
require('common.php');
require('topmenu.php'); // Отобразить шапку таблицы

// Получить список характеристик. Он нам нужен, чтобы сделать шапку таблицы, 
// а также для отображения значений в таблице.
// Список характеристик хранится в таблице ezhamon_fields. Можно добавлять свои
// поля в которых будут храниться значения собранные вашими плагинами.
// Плагины делаются по типу файлов из папки inc/modules
$fields = getAllFields();

// Получить теги
$tagsAr = getAllTags();

// Получить сайты
$sitesAr = getAllSites();

// Сайты какой группы показывать
$label = getLabel();


?>
<div id="filter_label_container">
	<form id="filter_label_form">Группа: 
		<select name="label" id="label">
			<option value="all" <? print ($label == 'all')?'selected="1"':'' ?> >Все</option>
			<option value="enabled" <? print ($label == 'enabled')?'selected="1"':'' ?> >Активные</option>
			<option value="disabled" <? print ($label == 'disabled')?'selected="1"':'' ?>>Неактивные</option>
	<?
	
foreach($tagsAr as $tagid => $tagname) {
	$selected = ($label == $tagid)?'selected="1"':'';
	echo '<option value="'.$tagid.'" '.$selected.'>'.$tagname.'</option>';
}	
	?>
		</select>
		<input type="submit" value="Показать" id="filter_label_submit" name="filter_label_submit">
	</form>
</div>

<?

$data = getSitesData($sitesAr);

/*
foreach($sitesAr as $sid => $site) {

  // Получить данные о сайтах
  if($label == "all" || !isset($label)) {
    $sql = "SELECT * FROM ezhamon_sites, ezhamon_monitor WHERE ezhamon_sites.sid = ezhamon_monitor.sid AND `active` <> 2 AND `ezhamon_monitor`.`sid` = ".$sid;
  }
  elseif($label == "enabled") {
    $sql = "SELECT * FROM ezhamon_sites, ezhamon_monitor WHERE ezhamon_sites.sid = ezhamon_monitor.sid AND `active` = 1 AND `ezhamon_monitor`.`sid` = ".$sid." GROUP BY ezhamon_monitor.timestamp";
  }
  elseif($label == "disabled") {
    $sql = "SELECT * FROM ezhamon_sites, ezhamon_monitor WHERE ezhamon_sites.sid = ezhamon_monitor.sid AND `active` = 0 AND `ezhamon_monitor`.`sid` = ".$sid;
  }
  else {
    $tagid = mysql_escape_string($label);
    $sql = "SELECT ezhamon_monitor.*, ezhamon_sites.*
            FROM ezhamon_sites
            LEFT JOIN ezhamon_monitor
            ON ezhamon_sites.sid = ezhamon_monitor.sid
            LEFT JOIN ezhamon_sitestags 
            ON ezhamon_sitestags.sid = ezhamon_sites.sid
            LEFT JOIN ezhamon_tags 
            ON ezhamon_sitestags.tid = ezhamon_tags.tid
            WHERE active <> 2 AND ezhamon_monitor.sid IS NOT NULL AND ezhamon_tags.tid = ".$tagid."  AND `ezhamon_monitor`.`sid` = ".$sid." GROUP BY ezhamon_monitor.timestamp";
  }
  $sql .= " ORDER BY ezhamon_monitor.timestamp DESC LIMIT 2";
  
  if($res = @mysql_query($sql, $db)) {
    if($row = @mysql_fetch_assoc($res)) {
      $data[$sid]["last"] = $row;
    }
    if($row = @mysql_fetch_assoc($res)) {
      $data[$sid]["beforelast"] = $row;
    }
    @mysql_free_result($res);
  }

}
*/

$json = new Services_JSON();
?>
<script>
  data = <? print $json->encode($data); ?>;
  fields = <? print $json->encode($fields); ?>;

document.write('<table id="main"><thead>');
document.write('	<tr>');
document.write('		<th>№</th>');
document.write('		<th>Сайтег</th>');
<?
foreach($fields as $field) {
	?> document.write('<th><span title="<?=$field["title"]?>"><?=$field["caption"]?></span></th>'); <?
}
?>
document.write('		<th>Дата</th>');
document.write('	</tr>');
document.write('</thead><tbody>');


i = 0;
for(sid in data) {
  record = data[sid];

  info = data[sid]["last"];
  //time = info["timestamp"];
  infoold = data[sid]["beforelast"];
  //timeold = infoold["timestamp"];
  
  //modulesInfo = getModulesInfo($info["url"]);
  
  document.write("<tr " + (info["active"]==0?'class="noactive"':'') + ">");
  document.write("<td>" + i + "</td>");
  document.write("<td><a href=\"detail.php?site=" + info["url"] + "\">" + info["url"] + "</a></td>");
  
  for(fid in fields) {
    field = fields[fid];

    class = (info[field["id"]] == infoold[field["id"]] ? "" : (info[field["id"]] < infoold[field["id"]] ? "fall" : "growth"));
    class = (info[field["id"]] == "x" || infoold[field["id"]] == "x") ? "x" : class;
    class = 'class="' + class + '"';

    document.write("<td><span " + class + ">" + info[field["id"]] + "</span><br /> <span class='gray'>" + infoold[field["id"]] + "</span></td>");
  }
  
/*
  foreach($fields as $field) {
    $hrefOpen = $hrefClose = "";
    if($modulesInfo[$field["id"]]["link"]) {
      $hrefOpen = '<a href="'.$modulesInfo[$field["id"]]["link"].'">';
      $hrefClose = '</a>';
    }
    echo "document.write('<td>".$hrefOpen."<span class='$className'>".$info[$field["id"]]."</span>".$hrefClose."<br /> <span class='gray'>".$infoold[$field["id"]]."</span></td>');";
  }*/
  
  //document.write("<td>" + d1.format("yyyy-mm-dd hh:nn") + "<br><span class=\"gray\">" + d2.format("yyyy-mm-dd hh:nn") + "</span></td>");
  document.write("<td>" + info["timestamp"] + "<br><span class=\"gray\">" + infoold["timestamp"] + "</span></td>");
  
  document.write('</tr>');
  i++;

}


</script>

<?
/*
// Вывести данные о сайтах
$i=1;
$data = is_array($data) ? $data : array();

foreach($data as $sid => $record) {

  $info = $data[$sid]["last"];
  $time = $info["timestamp"];
  $infoold = $data[$sid]["beforelast"];
  $timeold = $infoold["timestamp"];
  
  $modulesInfo = getModulesInfo($info["url"]);
  
  echo "document.write('<tr ".($info["active"]==0?'class="noactive"':'').">');";
  echo "document.write('<td>".$i."</td>')";
  echo "document.write('<td><a href=\"detail.php?site=".$info["url"]."\">".$info["url"]."</a></td>')";
  //echo "<td>".$info["url"]."</td>";
  foreach($fields as $field)
  {
    $className = ($info[$field["id"]]==$infoold[$field["id"]]?"":($info[$field["id"]]<$infoold[$field["id"]]?"fall":"growth"));
    $className = ($info[$field["id"]]=="x"||$infoold[$field["id"]]=="x")?"x":$className;
    $hrefOpen = $hrefClose = "";
    if($modulesInfo[$field["id"]]["link"])
    {
      $hrefOpen = '<a href="'.$modulesInfo[$field["id"]]["link"].'">';
      $hrefClose = '</a>';
    }
    echo "document.write('<td>".$hrefOpen."<span class='$className'>".$info[$field["id"]]."</span>".$hrefClose."<br /> <span class='gray'>".$infoold[$field["id"]]."</span></td>');";
  }
  echo "document.write('<td>".date("Y-m-d H:i",$info["timestamp"])."<br><span class=\"gray\">".date("Y-m-d H:i",$infoold["timestamp"])."</span></td>');";
  //echo "";
  echo "document.write('</tr>');";
  $i++;
}*/

/*
foreach($data as $sid => $record) {
	break;
	$info = $data[$sid]["last"];
	$time = $info["timestamp"];
	$infoold = $data[$sid]["beforelast"];
	$timeold = $infoold["timestamp"];
	
	$modulesInfo = getModulesInfo($info["url"]);
	
	echo "<tr ".($info["active"]==0?'class="noactive"':'').">";
	echo "<td>".$i."</td>";
	echo "<td><a href='detail.php?site=".$info["url"]."'>".$info["url"]."</a></td>";
	//echo "<td>".$info["url"]."</td>";
	foreach($fields as $field)
	{
		$className = ($info[$field["id"]]==$infoold[$field["id"]]?"":($info[$field["id"]]<$infoold[$field["id"]]?"fall":"growth"));
		$className = ($info[$field["id"]]=="x"||$infoold[$field["id"]]=="x")?"x":$className;
		$hrefOpen = $hrefClose = "";
		if($modulesInfo[$field["id"]]["link"])
		{
			$hrefOpen = '<a href="'.$modulesInfo[$field["id"]]["link"].'">';
			$hrefClose = '</a>';
		}
		echo "<td>".$hrefOpen."<span class='$className'>".$info[$field["id"]]."</span>".$hrefClose."<br /> <span class='gray'>".$infoold[$field["id"]]."</span></td>";
	}
	echo "<td>".date("Y-m-d H:i",$info["timestamp"])."<br><span class='gray'>".date("Y-m-d H:i",$infoold["timestamp"])."</span></td>";
	echo "";
	echo "</tr>";
	$i++;
}
*/	


?>
</tbody></table>
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