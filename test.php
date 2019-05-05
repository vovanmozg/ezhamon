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
</head>
<body>

<script>
var v = <?
  require('inc/_PEAR/JSON.php');
  $json = new Services_JSON();
  // convert a complexe value to JSON notation, and send it to the browser
  $value = array('name' => 'Вася');
  $output = $json->encode($value);
  print($output);
?>;

  alert(v['name']);

</script>
</tbody></table>
<? require('footer.php'); ?>
</body>
</html>
     