<? /*
Ежамон от Вована Полухина (vovanmozg.com).
Система автоматического мониторинга сайтов. 2010
*/
ini_set("session.gc_maxlifetime",200000);
session_start();
header("Content-type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") ." GMT");
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
//var_dump($_SESSION);
//Auth();

/*
Как должна работать эта функция?
Если юзер залогинен, то функция просто завершается.
Если юзер не залогинен, то надо вывести форму авторизации
*/
function Auth()
{
	if($_REQUEST["authlogin"])
	{
		require('config.php');
		$login = mysql_escape_string($_REQUEST["authlogin"]);
		$pass = md5($_REQUEST["authpass"]);
		// Попытка соединения
		$db = mysql_connect($db_server, $db_user, $db_pass);
		$res = @mysql_select_db($db_name);
		mysql_query("SET NAMES utf8;", $db);
		// Получить данные о сайтах
		$sql = "SELECT * FROM ezhamon_users WHERE login='".$login."';";
		$res = mysql_query($sql, $db);
		$loginOk = false;
		$passOk = false;
		if($res)
		{
			while($row = mysql_fetch_array($res, MYSQL_ASSOC))
			{ 
				$loginOk = true;
				if($row["pass"] == $pass)
				{
					$passOk = true;
				}
			}
		}
		@mysql_free_result($res);
		@mysql_close($db);
		
		if($loginOk && $passOk)
		{
			$_SESSION["logged"] = 1;
			return true;
		}
		else if($loginOk && !$passOk)
		{
			echo "Пароль неверен.";
			authForm();
			die();	
		}
		else if(!$loginOk)
		{
			echo "Имя не правильно.";
			authForm();
			die();			
		}
	}
	elseif($_REQUEST["logout"]==1)
	{
		session_unregister("logged");
	}
	
	if(!is_array($_SESSION))
	{
		authForm();
		die();
	}
	else {
		if(!in_array('logged',array_keys($_SESSION)))
		{
			authForm();
			die();
		}
		else
		{
			return true;
		}
	}
	
}

function authForm()
{
?>
<form method="post" action="index.php">
	<label>Логин</label><br />
	<input type="text" name="authlogin" id="authlogin" value="<? echo $_REQUEST["authlogin"]?$_REQUEST["authlogin"]:''; ?>" class="text"  /><br />
	<label>Пароль</label><br />
	<input type="password" name="authpass" id="authpass" class="text" value="" /><br />
	<input type="submit" value="Войти" />
</form>
<?
}
?>
