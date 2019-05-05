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
?>
