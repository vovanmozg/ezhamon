<?
if(!isset($_GET["url"]))
{
	die("����� ������ url");
}
include('../inc/modules/yahoo_pages_index.php');
$rez = yahoo_pages_index(array("url" => $_GET["url"]));
echo $rez["value"];
?>