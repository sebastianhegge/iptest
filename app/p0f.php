<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';

function get_p0f_data($ip){
  if(strpos($ip, ":") !== false){
    $bin = inet_pton($ip);
    $parts = unpack('n8', $bin);
    $ip = implode(':', array_map(fn($n) => sprintf('%04x', $n), $parts));
  }
  $a = shell_exec(P0F_CLIENT_PATH.' '.P0F_SOCK_PATH.' '.$ip);
  if (!isset($a) || strpos($a, "No matching host in p0f cache. That's all we know.") !== false){
    return json_encode(Array());
  }
  $b = explode("\n", trim($a));
  $data = Array();
  foreach($b as $current){
    $current_array = explode('=', $current);
    $data[trim($current_array[0])] = trim($current_array[1]);
  }

  return json_encode($data);
}

function get_pretty_p0f_data($ip){
  $data = (array)json_decode(get_p0f_data($ip));

  $pretty_array = Array();
  $pretty_array['connection_mtu']       = (isset($data) && isset($data['MTU']) && $data['MTU'] != NULL && $data['MTU'] != '') ? $data['MTU'] : '';
  $pretty_array['connection_link_type'] = (isset($data) && isset($data['Network link']) && $data['Network link'] != NULL && $data['Network link'] != '') ? translate_link_type($data['Network link']) : '';
  $pretty_array['connection_distance']  = (isset($data) && isset($data['Distance']) && $data['Distance'] != NULL && $data['Distance'] != '') ? $data['Distance'] : '';

  return json_encode($pretty_array);
}

function translate_link_type($link_type){
  if(lang() == 'de'){
    $link_types = array(
      'Ethernet or modem'           => 'Netzwerk oder Modem (vermutlich)',
      'L2TP'                        => 'L2TP oder PPPoE (vermutlich)',
      'Probably IPsec or other VPN' => 'IPsec oder anderes VPN (vermutlich)',
      'generic tunnel or VPN'       => 'Generischer Tunnel, VPN oder LTE (vermutlich)',
      'IPSec or GRE'                => 'IPSec oder Generic Routing Encapsulation (vermutlich)',
      'IPIP or SIT'                 => 'IPIP oder SIT (vermutlich)',
      '???'                         => 'unbekannt',
      ''                            => '',
    );
  } else {
    $link_types = array(
      'Ethernet or modem'           => 'Ethernet or Modem (probably)',
      'L2TP'                        => 'L2TP or PPPoE (probably)',
      'Probably IPsec or other VPN' => 'IPsec or other VPN (probably)',
      'generic tunnel or VPN'       => 'Generic Tunnel, VPN or LTE (probably)',
      'IPSec or GRE'                => 'IPSec or Generic Routing Encapsulation (probably)',
      '???'                         => 'unknown',
      ''                            => '',
    );
  }

  if(!array_key_exists($link_type, $link_types)){
    return $link_type;
  }

  return $link_types[$link_type];
}
