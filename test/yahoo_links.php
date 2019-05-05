<?
if(!isset($_GET["url"]))
{
	die("Нужно задать url");
}
include('../inc/modules/yahoo_links.php');
$rez = yahoo_links(array("url" => $_GET["url"]));
echo $rez["value"];
?>