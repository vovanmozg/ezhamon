<pre><?
include('../inc/modules/whois_expired.php');

$data = whois_expired(array('url' => 'mail.ru'));
var_dump($data);

?>