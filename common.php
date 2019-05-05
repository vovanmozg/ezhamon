<?
global $EZHROOT;
$EZHROOT = preg_replace("%[\\\/]common.php$%","",__FILE__);

/**
* Соединиться с базой
*/
$db = @mysql_connect($db_server, $db_user, $db_pass);
if(!$db) {
  ShowDbError(@mysql_error());
  die();
}
// Попытка выбора БД
$res = @mysql_select_db($db_name);
if(!$res) {
  ShowDbError(@mysql_error());
  die();
}
//$db->setFetchMode(DB_FETCHMODE_ASSOC);
@mysql_query("SET NAMES utf8;", $db);
//$res =& $db->query("SET NAMES utf8;");


/*************************************************************************
* 
************************************************************************/

/**
* Показывает сообщение об ошибке с базой
* 
* @param mixed $err
*/
function ShowDbError($err) {
	?>
	<div id="box">
	<h2>Не удаётся соединиться с базой данных</h2>
	<p>Если хотите, можете <a href="install.php">запустить установку</a></p>
	<p>Если вы уже установили скрипт, проверьте правильность данных для доступа к базе. Их можно найти в файле <strong>config.php</strong></p>
	<p>Вопросы установки, настройки и использования Ежамона можно обсудить на <a href="http://forum.vovanmozg.com/">форуме</a>.</p>
	<p class="error"><strong>Подробности:</strong><br /><? print $err; ?></p>
	</div>
<?
}

function GetRandomProxy($filename = 'proxy.txt')
{
	global $EZHROOT;
	$file = "$EZHROOT/$filename";
	
	if(!file_exists($file))
	{
		return false;
	}
	
	$lc = filesize($file);
	$fp = fopen($file,'r');	
	$line = '';
	$counter = 0;
	
	
	//echo "[$line]<br>";
	//preg_match('/^(\d+\.){3}\:\d+/',$line)
	
	while(!preg_match('/^(\d+\.){3}\d+\:\d+/',$line) && $counter++ < 10)
	{
		$rnd_offset = floor(rand(0,$lc));
		fseek($fp, $rnd_offset);
		fgets($fp, 4096);
		$line = trim(fgets($fp, 4096));
	}

	fclose($fp);
	return $line;

}

/**
* Возвращает массив всех тегов
* 
*/
function getAllTags() {
  global $db;
  $sql = "SELECT * FROM ezhamon_tags ";
  $res = @mysql_query($sql, $db);
  if(!$res) {
    die('Ошибка при работе с базой данных: '.@mysql_error());
  }
  $tagsAr = array();
  while ($row = @mysql_fetch_array($res, MYSQL_ASSOC)) {
    $tagsAr[$row['tid']] = $row['name'];
  }
  @mysql_free_result($res);
  return $tagsAr;
}

/**
* Возвращает массив всех сайтов
* 
*/
function getAllSites() {
  global $db;
  $sql = "SELECT * FROM ezhamon_sites";
  $res = @mysql_query($sql, $db);
  if(!$res) {
    die('Ошибка при работе с базой данных: '.@mysql_error());
  }
  $sitesAr = array();
  while ($row = @mysql_fetch_array($res, MYSQL_ASSOC)) {
    $sitesAr[$row['sid']] = $row;
  }
  @mysql_free_result($res);
  return $sitesAr;
}

// Получить список характеристик. Он нам нужен, чтобы сделать шапку таблицы, 
// а также для отображения значений в таблице.
// Список характеристик хранится в таблице ezhamon_fields. Можно добавлять свои
// поля в которых будут храниться значения собранные вашими плагинами.
// Плагины делаются по типу файлов из папки inc/modules
function getAllFields() {
  global $db;
  $sql = "SELECT * FROM ezhamon_fields";
  $res = @mysql_query($sql, $db);

  if(!$res) {
    ShowDbError(@mysql_error());
    die();
  }
  while ($row = @mysql_fetch_array($res, MYSQL_ASSOC)) {
    $fields[$row["id"]] = $row;
  }
  @mysql_free_result($res);
  return $fields;
}


function getSitesData($sitesAr) {
  global $db;
  $label = getLabel();
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
        $data[$sid]["last"]['timestamp'] = date("Y-m-d H:i", $data[$sid]["last"]['timestamp']);                   // Преобразовать timestamp
      }
      if($row = @mysql_fetch_assoc($res)) {
        $data[$sid]["beforelast"] = $row;
        $data[$sid]["beforelast"]['timestamp'] = date("Y-m-d H:i", $data[$sid]["beforelast"]['timestamp']);       // Преобразовать timestamp
      } else {
        if($data[$sid]["last"]) {
          $data[$sid]["beforelast"] = $data[$sid]["last"];
        }
      }
      @mysql_free_result($res);
    }

  }
  return $data;
}

/**
* Получить текущую метку 
*/
function getLabel() {
  return $_REQUEST["label"] ? $_REQUEST["label"] : 'enabled';
}

function getModulesInfo($site){
  global $db;
  global $EZHROOT;
  global $MODULESINFO;
  if(isset($MODULESINFO)){
    $info = $MODULESINFO;
  }
  else {
    $info = array();
    
    // Получить список характеристик. Он нам нужен, чтобы получить список параметров
    $sql = "SELECT * FROM ezhamon_fields";
    $res = @mysql_query($sql, $db);  
    
    if(!$res)
    {
      ShowDbError(mysql_error());
      return false;
    }

    while ($row = mysql_fetch_array($res, MYSQL_ASSOC))
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
        include_once($module);
        if(function_exists($field["id"]."_info"))
        {
          $info[$field["id"]] = call_user_func_array($field["id"]."_info", array(array("url" => $site)));
        }
        
      }
    }
    //var_dump($info);
  }
  return $info;
}
?>