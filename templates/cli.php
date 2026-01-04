<?php
function print_data($current_data){
  $spacer = get_max_array_key_length($current_data) + 2;
  foreach ($current_data as $key => $value) {
    p(str_pad(str_replace('_', ' ', $key).':', $spacer, ' ').str_replace("\n", ', ', $value)."\n");
  }
}

$current_data = Array();

if(isset($data['ip']) && $data['ip'] != NULL && $data['ip'] != ''){
  $current_data['ip'] = $data['ip'];
}

if(isset($data['hostname']) && $data['hostname'] != NULL && $data['hostname'] != ''){
  $current_data['hostname'] = $data['hostname'];
}

if(isset($data['isp']) && $data['isp'] != NULL && $data['isp'] != ''){
  $current_data['isp'] = $data['isp'];
}

if(isset($data['zip']) && $data['zip'] != NULL && $data['zip'] != ''){
  $current_data['address'] = $data['zip'];
}
if(isset($data['city']) && $data['city'] != NULL && $data['city'] != ''){
  if(!string_ends_with($current_data['address'], ', ') && !string_ends_with($current_data['address'], $data['zip'])){
    $current_data['address'] .= ',';
  }
  $current_data['address'] .= ' '.$data['city'];
}
if(isset($data['country']) && $data['country'] != NULL && $data['country'] != ''){
  if(!string_ends_with($current_data['address'], ', ')){
    $current_data['address'] .= ', ';
  }
  $current_data['address'] .= $data['country'];
}

if(
  isset($data['network_start_address']) && $data['network_start_address'] != NULL && $data['network_start_address'] != '' &&
  isset($data['network_end_address']) && $data['network_end_address'] != NULL && $data['network_end_address'] != ''
){
  $current_data['network_range'] = $data['network_start_address'].' - '.$data['network_end_address'];
}

if(isset($data['as_number']) && $data['as_number'] != NULL && $data['as_number'] != ''){
  $current_data['as_number'] = $data['as_number'];
}

if(isset($data['connection_mtu']) && $data['connection_mtu'] != NULL && $data['connection_mtu'] != ''){
  $current_data['connection_mtu'] = $data['connection_mtu'];
}

if(isset($data['connection_distance']) && $data['connection_distance'] != NULL && $data['connection_distance'] != ''){
  $current_data['connection_distance'] = $data['connection_distance'];
}

print_data($current_data);
