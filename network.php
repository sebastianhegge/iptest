<?php
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json;charset=utf-8');

$a = shell_exec('/var/www/p0f/p0f-client /var/run/p0f.sock '.$_SERVER['REMOTE_ADDR']);
$b = explode("\n", trim($a));

$data = Array();
foreach($b as $current){
  $current_array = explode('=', $current);
  $data[trim($current_array[0])] = trim($current_array[1]);
}

$pretty_array = Array();
$pretty_array['ip'] = $_SERVER['REMOTE_ADDR'];
$pretty_array['mtu'] = $data['MTU'];
$pretty_array['link_type'] = $data['Network link'];
$pretty_array['distance'] = $data['Distance'];

print_r(json_encode($pretty_array));
?>
