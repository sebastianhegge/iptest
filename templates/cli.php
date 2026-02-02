<?php
function print_data($current_data){
  $spacer = get_max_array_key_length($current_data) + 2;
  foreach ($current_data as $key => $value) {
    p(str_pad(str_replace('_', ' ', $key).':', $spacer, ' ').str_replace("\n", ', ', $value)."\n");
  }
}

function print_color($value, $color = '', $bold = false){
  print("\033[");
  if($bold){
    print('1;');
  }
  switch ($color) {
    case 'red':
      print('31');
      break;
    case 'green':
      print('32');
      break;
    case 'yellow':
      print('33');
      break;
    case 'blue':
      print('34');
      break;
  }
  print('m'.$value."\033[0m");
}

if(isset($data['ip']) && $data['ip'] != NULL && $data['ip'] != ''){
  print_color($data['ip']."\n", 'green');
}

if(isset($data['hostname']) && $data['hostname'] != NULL && $data['hostname'] != ''){
  print($data['hostname']."\n");
}

if(isset($data['connection_mtu']) && $data['connection_mtu'] != NULL && $data['connection_mtu'] != ''){
  print_color("MTU ".$data['connection_mtu']."\n", 'green');
}

if(isset($data['connection_distance']) && $data['connection_distance'] != NULL && $data['connection_distance'] != ''){
  print_color($data['connection_distance'].' hops'."\n", 'green');
}

if(isset($data['isp']) && $data['isp'] != NULL && $data['isp'] != ''){
  print('ISP: '.$data['isp']."\n");
}

$address = '';
if(isset($data['zip']) && $data['zip'] != NULL && $data['zip'] != ''){
  $address .= $data['zip'];
}
if(isset($data['city']) && $data['city'] != NULL && $data['city'] != ''){
  if($address != ''){
    $address .= ' ';
  }
  $address .= $data['city'];
}
if(isset($data['country']) && $data['country'] != NULL && $data['country'] != ''){
  if($address != ''){
    $address .= ', ';
  }
  $address .= $data['country'];
}
if($address != ''){
  print($address."\n");
}

if(
  isset($data['network_start_address']) && $data['network_start_address'] != NULL && $data['network_start_address'] != '' &&
  isset($data['network_end_address']) && $data['network_end_address'] != NULL && $data['network_end_address'] != ''
){
  print($data['network_start_address'].' - '.$data['network_end_address']."\n");
}

if(isset($data['as_number']) && $data['as_number'] != NULL && $data['as_number'] != ''){
  print("AS ".$data['as_number']."\n");
}

print("\n");

print("to get ".($data['ip_version'] == 'v4' ? 'v6' : 'v4')." address do:\n");
print_color("  curl -".($data['ip_version'] == 'v4' ? '6 ' : '4 ').$_SERVER['HTTP_HOST']."\n", 'blue', true);
print("\n");
print("to get your DNS resolver do:\n");
#print_color('  dig +short TXT dns.ipte.st'."\n", 'blue', true);
#print("or\n");
print_color('  curl -L edns.ip-api.com'."\n", 'blue', true);
print("\n");
print("afterwards do:\n");
print_color('  curl '.$_SERVER['HTTP_HOST'].'?ip=', 'blue', true);
print_color('<IP>'."\n", 'red');
