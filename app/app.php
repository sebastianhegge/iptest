<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';
include_once 'header.php';

include_once 'manual.php';
include_once 'user_agent.php';
include_once 'ip_api.php';
include_once 'p0f.php';
include_once 'whois.php';
include_once 'peering_db.php';

if(!isset($ip)){
  if(isset($_GET['ip'])){
    $ip = $_GET['ip'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
}

$nonce = substr(bin2hex(random_bytes(20)), 0, 10);

$manual_data     = json_decode(get_pretty_manual_data($ip));
$user_agent_data = json_decode(get_pretty_user_agent_data($_SERVER['HTTP_USER_AGENT']));
$ip_api_data     = json_decode(get_pretty_ip_api_data($ip));
$p0f_data        = json_decode(get_pretty_p0f_data($ip));
$whois_data      = json_decode(get_pretty_whois_data($ip));
if(isset($ip_api_data->as_number)){
  $peering_db_data = json_decode(get_pretty_peering_db_data($ip_api_data->as_number));
} else {
  $peering_db_data = (object) Array();
}

(object) $data = array_merge(
  (array) $manual_data,
  (array) $user_agent_data,
  (array) $ip_api_data,
  (array) $p0f_data,
  (array) $whois_data,
  (array) $peering_db_data,
);
