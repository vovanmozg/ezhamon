<?

if(!isset($_GET["url"]))
{
	die("����� ������ url");
}
include('../inc/modules/rambler_pages_index.php');


$rez = rambler_pages_index(array("url" => $_GET["url"]));

echo $rez["value"];

?>