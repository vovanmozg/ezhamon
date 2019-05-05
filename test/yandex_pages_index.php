<pre>(<?
	
	error_reporting(E_ALL);
print(1);
include('../common.php');
print(2);
include('../inc/browser.class.php');
print(3);
include('../inc/modules/yandex_pages_index.php');
print(4);

$url = array_key_exists("url",$_GET)?$_GET["url"]:"www.sellcom.ru";
//print "Определение количества проиндексированных Яндексом страниц домена $url.";
$data = yandex_pages_index(array("url" => $url));
$file = $data['content'];
//$file = file_get_contents("../tmp/yandex_pages_index-2010-07-02-11-27-06-5ijZ82");
print(3);
//if(preg_match("!ашл[^0-9]+(\d+)(( |\&nbsp\;)тыс\.)?(( |\&nbsp\;)(млн))?( тыс.)!si",$file,$ok)) {
//if(preg_match("!наш[^0-9]+(\d+)( тыс\.)? ответ!si",$file,$ok)) {
//var_dump( $file);
//if(preg_match("![н|H]аш[^0-9]+([0-9]+)( тыс\.)?( |\&nbsp\;)+ответ!si",$file,$ok)){
print(4);
if(preg_match("!аш[^0-9]+([0-9]+)(&nbsp;| )+ответ!si",$file,$ok)){

	var_dump($ok);
}
else {
	print 0;
}
print(5);

?></pre>
end