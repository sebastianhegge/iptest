<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';
include_once 'header.php';

include_once 'manual.php';
include_once 'user_agent.php';

if(!isset($ip)){
  if(isset($_GET['ip'])){
    $ip = $_GET['ip'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
}

$nonce = substr(bin2hex(random_bytes(10)), 0, 10);

$manual_data     = json_decode(get_pretty_manual_data($ip));
$user_agent_data = json_decode(get_pretty_user_agent_data($_SERVER['HTTP_USER_AGENT']));

(object) $data = array_merge(
  (array) $manual_data,
  (array) $user_agent_data,
);
