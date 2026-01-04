<?php
function get_pretty_manual_data($ip){
  $pretty_array = array(
    'ip' => $ip,
    'hostname' => (gethostbyaddr($ip) == $ip ? '' : gethostbyaddr($ip)),
    'ip_version' => (strpos($ip, ":") === false ? 'v4' : 'v6'),
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'request_scheme' => $_SERVER['REQUEST_SCHEME'],
    'protocol_version' => $_SERVER['SERVER_PROTOCOL'],
    'client_header' => getallheaders(),
    'cookies' => $_COOKIE,
  );

  return json_encode($pretty_array);
}
