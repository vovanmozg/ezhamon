<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css" media="all">
		@import "style.css";
		body {background-color:#80926D; font-size:100%;}
	</style>
</head>
<body>

<div id="box">

  <b class="v1"></b><b class="v2"></b><b class="v3"></b><b class="v4"></b><b class="v5"></b>
  <div class="text">

<?
if(!$_REQUEST["step"])
{
?>

<p>Ежамон — это система мониторинга SEO-параметров сайта, таких как индекс цитирования, Google PageRank и прочих. Скрипт позволяет отслеживать параметры сразу нескольких сайтов. </p>
<p>Стандартный комплект проверяет следующие параметры:</p>
	<ul>
		<li>Индекс цитирования;</li>
		<li>Google PageRank;</li>
		<li>количество страниц в индексе Яндекса, Google, Рабмлера, Yahoo;</li>
		<li>количество ссылок на сайт по данным Google, Yahoo;</li>
		<li>количество упоминаний сайта по данным Яндекса.</li>
	</ul>
<p>Для работы скрипта потребуется PHP и MySQL.</p>
	<h1><a href="?step=1"> Начать установку</a></h1>
 
<?
}
else if ($_REQUEST["step"] == 1)
{
?>
<h2>Выбор базы данных</h2>
<?
if(is_file("config.php"))
{
?><p class="error">Внимание! Файл конфигурации <strong>config.php</strong> уже существует. Если вы нажмёте кнопку «Далее», в файл будут записаны новые данные. Вы можете отредактировать файл вручную через FTP.</p><?
}
renderForm1();
?>
<p>В базе данных будут созданы нужные таблицы.</p>
<?
}
else if ($_REQUEST["step"] == 2)
{
	
	$db_name = strip_tags($_REQUEST["dbname"]);
	$db_pass = strip_tags($_REQUEST["dbpass"]);
	$db_user = strip_tags($_REQUEST["dbuser"]);
	$db_server = strip_tags($_REQUEST["dbserver"]);
	//$db_url = "mysql://".$_REQUEST["dbuser"].":".$_REQUEST["dbpass"]."@".$_REQUEST["dbserver"]."/".$_REQUEST["dbname"];
	$f = fopen("config.php","w");
	fwrite($f, "<"."? \n");
	
	fwrite($f, "\$db_name = '$db_name';\n");
	fwrite($f, "\$db_pass = '$db_pass';\n");
	fwrite($f, "\$db_user = '$db_user';\n");
	fwrite($f, "\$db_server = '$db_server';\n");
	
	fwrite($f, "?".">");
	fclose($f);
	// подключить PEAR и создать базу
	//$ROOT_DIR = preg_replace("%[\\\/][^\\\/]*$%","",__FILE__);
	//set_include_path(get_include_path() . PATH_SEPARATOR . $ROOT_DIR.'/_PEAR');
	//require("DB.php");
	//$db =& DB::connect($db_url);
	
	$db = @mysql_connect($_REQUEST["dbserver"], $_REQUEST["dbuser"], $_REQUEST["dbpass"]);

	if (!$db) {
		$merr = @mysql_error();
		switch($merr)
		{
			case "DB Error: connect failed":
				$errMsg = "Ошибка соединения с базой данных. Проверьте, действительно ли сервер базы данных — ".$_REQUEST["dbserver"] . " и другие данные";
				break;
			case "DB Error: no such database":
				$errMsg = "База данных не найдена. Проверьте, действительно ли есть база данных с именем ".$_REQUEST["dbname"];
				break;
			case "dDB Error: connect failed":
				break;
			default:
				$errMsg = "Ошибка базы данных: ".$merr;
		}
		echo '<h2>Ошибка</h2>';
		echo '<p class="error">'.$errMsg.'</p>';
		renderForm1();
	}
	else
	{
	// Попытка выбора БД
		$res = @mysql_select_db($_REQUEST["dbname"]);
		if(!$res)
		{
			$errors[] = @mysql_error();
			die();
		}
		@mysql_query("SET NAMES utf8;", $db);

		$sqls = file("data.sql");
		
		foreach($sqls as $sql)
		{
			@mysql_query($sql, $db);
			if(!$res)
			{
				$errors[] = @mysql_error();
			}
		}
		
		if(is_array($errors))
		{
			echo '<h2>При установке обнаружились ошибки</h2>';
			foreach($errors as $er)
			{
				echo '<p class="error">'.$er.'</p>';
			}
			echo '<p>Попробуйте открыть <a href="index.php">главную страницу</a>. Авось получится.</p>';
		}
		else {
			echo '<h2>Ежамон установлен!</h2>';
			echo '<p>Теперь можно <a href="manage_sites.php">добавить</a> сайты.</p>';
			echo '<p>Для обновления seo-параметров необходимо запускать скрипт refresh.php. </p>';
		}
	}

?>
<?
}
?>
  </div>
  <b class="v5"></b><b class="v4"></b><b class="v3"></b><b class="v2"></b><b class="v1"></b>


</div>
<?



?>

</body>
</html>

<?

function renderForm1()
{
?>
<form method="post">
	<label>Сервер базы данных</label><br />
	<input type="text" name="dbserver" id="dbserver" value="<? echo $_REQUEST["dbserver"]?$_REQUEST["dbserver"]:'localhost'; ?>" class="text"  /><br />
	<label>База данных</label><br />
	<input type="text" name="dbname" id="dbname" class="text" value="<? echo $_REQUEST["dbname"]; ?>" /><br />
	<label>Имя пользователя базы данных</label><br />
	<input type="text" name="dbuser" id="dbuser" class="text" value="<? echo $_REQUEST["dbuser"]; ?>" /><br />
	<label>Пароль</label><br />
	<input type="text" name="dbpass" id="dbpass" class="text" value="<? echo $_REQUEST["dbpass"]; ?>" /><br />
	
	<input type="hidden" name="step" id="step" value="2" />
	<input type="submit" value="Далее" />
</form>
<?
}
?>