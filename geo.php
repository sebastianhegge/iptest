<?php
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json;charset=utf-8');

if(isset($_GET['ip'])){
  $ip = $_GET['ip'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}

$response = get_web_page('http://ip-api.com/json/'.$ip.'?fields=19187&lang=de');
print_r($response);

function get_web_page($url) {
  $options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => "test",
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_TIMEOUT        => 120,
  );

  $ch = curl_init($url);
  curl_setopt_array($ch, $options);

  $content  = curl_exec($ch);

  curl_close($ch);

  return $content;
}
?>
