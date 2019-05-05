<?
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
require_once('auth.php');

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
		@import "style.css";
	</style>
	<script src="inc/jquery.js" ></script>
	<script src="inc/ezhamon.js" ></script>
</head>
<body>
<?
require('config.php');
require('common.php');
require('topmenu.php');

// Попытка соединения
$db = @mysql_connect($db_server, $db_user, $db_pass);
if(!$db)
{
	ShowDbError(@mysql_error());
	die();
}

// Попытка выбора БД
if(!@mysql_select_db($db_name))
{
	ShowDbError(@mysql_error());
	die();
}
//$db->setFetchMode(DB_FETCHMODE_ASSOC);
@mysql_query("SET NAMES utf8;", $db);

//var_dump($_POST);

// Получить данные о сайтах
$sql = "SELECT * FROM ezhamon_sites WHERE active <> '2';";
$res = @mysql_query($sql, $db);
if(!$res)
{
	die('Ошибка при работе с базой данных: '.@mysql_error($db));
}

while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	$data[$row["sid"]] = $row;
}
@mysql_free_result($res);


// Если отправлены данные на редактирование (удаление, отключение, включение, присвоение тегов...)
if($_POST["action"] == "edit")
{
		
	
	// Если добавился новая группв	
	if(isset($_POST["dosetlabel"]) && $_POST["selectsetlabel"] == "new" && $_POST["labelactiontype"] == "add")
	{
		if(strlen($_POST["newlabel"])>0)
		{
			$label_name = mysql_escape_string($_POST["newlabel"]);
			$sql = "INSERT INTO `ezhamon_tags` ( `name` ) VALUES ('".$label_name."')";
			@mysql_query($sql, $db);
			
			$new_label_id = mysql_insert_id($db);
		}
		/*
		// Получить ид нового тега
		$sql = "SELECT ezhamon_sites.active as active, ezhamon_sites.sid as sid, ezhamon_sites.url as url, ezhamon_tags.name as tag, ezhamon_tags.tid as tagid
		FROM ezhamon_sites 
		LEFT JOIN ezhamon_sitestags 
		ON ezhamon_sites.sid = ezhamon_sitestags.sid
		LEFT JOIN ezhamon_tags 
		ON ezhamon_sitestags.tid = ezhamon_tags.tid
		
		WHERE ezhamon_sites.active <> '2'
		";
		$res = @mysql_query($sql, $db);
		if(!$res)
		{
			die('Ошибка при работе с базой данных: '.@mysql_error());
		}
		$data = array();
		while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
		{
			$data[$row['sid']][] = $row;
		}
		@mysql_free_result($res);
		*/
	}	

	foreach($data as $site)
	{
		if($_POST["site".$site["sid"]] && $_POST["site".$site["sid"]] == "on")
		{
			$sql = "";

			if(isset($_POST["doactive"]))
			{ // Если поступил запрос на активацию строк
				$sql = "UPDATE `ezhamon_sites` SET `active` = '1' WHERE `sid` = ".$site["sid"];
				$data[$site["sid"]]["active"] = 1;
			}
			elseif(isset($_POST["dodeactive"]))
			{
				$sql = "UPDATE `ezhamon_sites` SET `active` = '0' WHERE `sid` = ".$site["sid"];
				$data[$site["sid"]]["active"] = 0;
			}
			elseif(isset($_POST["dodelete"]))
			{
				$sql = "UPDATE `ezhamon_sites` SET `active` = '2' WHERE `sid` = ".$site["sid"];
			}			

			elseif(isset($_POST["dosetlabel"]))
			{
				if($_POST["labelactiontype"]=="add")
				{
					$label_id = isset($new_label_id)?$new_label_id:$_POST["selectsetlabel"];
					$sql = "DELETE FROM `ezhamon_sitestags` WHERE `sid` = ".$site["sid"]." AND `tid` = ".mysql_escape_string($label_id);
					@mysql_query($sql, $db);
					echo $ssql;
					$sql = "INSERT INTO `ezhamon_sitestags` ( `sid`,`tid` ) VALUES (".$site["sid"].", ".mysql_escape_string($label_id).")";
				}	
				elseif($_POST["labelactiontype"]=="del")
				{
					$label_id = isset($new_label_id)?$new_label_id:$_POST["selectsetlabel"];
					$sql = "DELETE FROM `ezhamon_sitestags` WHERE `sid` = ".$site["sid"]." AND `tid` = ".mysql_escape_string($label_id);
				}
				else
				{
					$sql = '';
				}
					
			}	
			
			if(strlen($sql)>0)
			{
				@mysql_query($sql, $db);
			}
			$active = 1;
		}

		
		

		
	}
}
$newurl = "";
if($_POST["action"] == "add")
{
	if(strstr($_REQUEST["urls"],"http://"))
	{
		echo '<p class="error">Не нужно http://</p>';
		$newurls = str_replace("http://","",$_REQUEST["urls"]);
	}
	else
	{
		$urls = split("\n",$_REQUEST["urls"]);
		foreach($urls as $url)
		{
			$url = trim($url);
			$sql = "INSERT INTO `ezhamon_sites` SET url = '".mysql_escape_string(stripcslashes($url))."'";
			@mysql_query($sql, $db);
			//echo $sql."<br>";
		}
	}
}

// Получить данные о сайтах
$sql = "SELECT ezhamon_sites.active as active, ezhamon_sites.sid as sid, ezhamon_sites.url as url, ezhamon_tags.name as tag, ezhamon_tags.tid as tagid
FROM ezhamon_sites 
LEFT JOIN ezhamon_sitestags 
ON ezhamon_sites.sid = ezhamon_sitestags.sid
LEFT JOIN ezhamon_tags 
ON ezhamon_sitestags.tid = ezhamon_tags.tid

WHERE ezhamon_sites.active <> '2'
";
$res = @mysql_query($sql, $db);
if(!$res)
{
	die('Ошибка при работе с базой данных: '.@mysql_error());
}
$data = array();
while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	$data[$row['sid']][] = $row;
}
@mysql_free_result($res);


// Получить теги
$sql = "SELECT * FROM ezhamon_tags ";
$res = @mysql_query($sql, $db);
if(!$res)
{
	die('Ошибка при работе с базой данных: '.@mysql_error());
}
$tagsAr = array();
while ($row = @mysql_fetch_array($res, MYSQL_ASSOC))
{
	$tagsAr[$row['tid']] = $row['name'];
}
@mysql_free_result($res);

@mysql_close($db);


?>

<table id="main"><form method="post">
	<tr>
		<th width="10%">ID</td>
		<th>Сайт</td>
		<th><input type="checkbox" id="cb_select_all" /> Выбрать</td>
	</tr>
<?
$data = is_array($data)?$data:array();
foreach($data as $sitear)
{
	$tags = '';
	foreach($sitear as $site)
	{
		$tags .= '<span class="tag">'.$site["tag"] . '</span>,';
	}
	$tags = substr($tags,0,-1);
	$site = $sitear[0];
?>
	<tr <? echo $site["active"]==1?'class="active"':'class="noactive"' ?>>
		<td><? echo $site["sid"]; ?></td>
		<td><? echo $site["url"]; ?> (<? echo $tags; ?>)</td>
		<td><input name="site<? echo $site["sid"]; ?>" id="site<? echo $site["sid"]; ?>" type="checkbox" class="checkbox" /> </td>
	</tr>
<?
}
?>
</table>
<br />
&nbsp;
<select name="labelactiontype" id="labelactiontype">
	<option value="add" selected="1" >Добавить в группу</option>
	<option value="del" >Удалить из группы</option>
</select>
	: <select name="selectsetlabel" id="selectsetlabel">
	<?
	
foreach($tagsAr as $tagid => $tagname)
{
	echo '<option value="'.$tagid.'">'.$tagname.'</option>';
}	
	?>
	<option value="new" style="background-color:#CDF2C6;">Новая</option>
	<option value="" style=""></option>
</select>
<input type="text" name="newlabel" id="newlabel" value="" style="display:none;" />
<input type="submit" name="dosetlabel" value="ок"  />
<br /><br />
<input type="hidden" name="action" value="edit" />
<input type="submit" name="doactive" value="Активировать"  />
<input type="submit" name="dodeactive" value="Отключить"  />
<input type="submit" name="dodelete" value="Удалить" style="background-color:red;" />

</form>


<h3>Добавить сайты</h3>
В каждой строчке по сайту. Без http://
<form method="post">
	<textarea name="urls" cols="50" rows="15"><? echo $newurls; ?></textarea>
	<!-- http://<input type="text" name="url" size="40" value="<? echo $newurl; ?>" / --><br />
	<input type="hidden" name="action" value="add" />
	<input type="submit" value="Добавить" />
</form>

<? require('footer.php'); ?>
</body>
</html>

