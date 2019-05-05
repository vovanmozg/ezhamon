<?

if(is_file("version.txt"))
{
	$v = trim(file_get_contents("version.txt"));
	$version = "Версия $v. ";
	
	//$infoaboutnewversion = trim(file_get_contents("http://vovanmozg.com/ezhamon/version.txt"));
	if(!empty($infoaboutnewversion))
	{
		$vnewasnum = versionasnum($infoaboutnewversion);
		$vasnum = versionasnum($v);
	}
	if($vnewasnum > $vasnum)
	{
		$version .= "Доступна новая версия ($infoaboutnewversion).";
	}
}

function versionasnum($v)
{
	$ar = explode('.',trim($v));
	if(is_array($ar))
	{
		rsort($ar);
		$vnew = 0;
		$mul = 1;
		foreach($ar as $part)
		{
			$vnew += $part*$mul;
			$mul *= 100;
		}
	}
	return $vnew;
}

?>
<table id="menu">
	<tr>
		<td><a href="index.php">Просмотр</a></td>
		<td><a href="refresh.php">Обновление</a></td>
		<td><a href="manage_sites.php">Управление</a></td>
		<td><a href="help.php">Помощь</a></td>
		<td><a href="http://forum.vovanmozg.com/viewforum.php?f=2">Поддержка</a></td>
		<td width="100%" align="right"><?=$version?></td>
	</tr>
</table>