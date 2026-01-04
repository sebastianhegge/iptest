<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';

function get_whois_data_from_db($ip){
  db_delete_old('whois');

  $whois_data = $GLOBALS['db']->prepare("SELECT * FROM `whois` WHERE ip = :ip LIMIT 1");
  $whois_data->bindParam(':ip', $ip, PDO::PARAM_STR, 39);
  $whois_data->execute();

  $result = $whois_data->fetch(PDO::FETCH_ASSOC);
  if(is_array($result)){
    return $result['result'];
  } else {
    return NULL;
  }
}

function get_whois_data_from_api($ip){
  return get_url_content('https://rdap.db.ripe.net/ip/'.$ip);
}

function get_whois_data($ip){
  $whois_data_from_db = get_whois_data_from_db($ip);
  if(isset($whois_data_from_db) && $whois_data_from_db != NULL && $whois_data_from_db != ''){
    return $whois_data_from_db;
  } else {
    $whois_data_from_api = get_whois_data_from_api($ip);

    if(isset($whois_data_from_api) && $whois_data_from_api != NULL && $whois_data_from_api != ''){
      $data = json_decode($whois_data_from_api);
      if(isset($data) && !isset($data->errorCode)){
        $whois_data = $GLOBALS['db']->prepare("INSERT INTO `whois` (ip, result) VALUES (:ip, :result)");
        $whois_data->bindParam(':ip', $ip);
        $whois_data->bindParam(':result', $whois_data_from_api);
        $whois_data->execute();
      }
    }

    return $whois_data_from_api;
  }
}

function get_pretty_whois_data($ip){
  $data = json_decode(get_whois_data($ip));

  if(isset($data->errorCode)){
    $pretty_array = Array();
    $pretty_array['network_start_address'] = '';
    $pretty_array['network_end_address'] = '';
    $pretty_array['network_handle'] = '';
    $pretty_array['network_country_code'] = '';
    $pretty_array['network_name'] = '';
    $pretty_array['network_description'] = '';
    $pretty_array['network_contact_email'] = '';
    $pretty_array['network_contact_abuse'] = '';
    $pretty_array['network_contact_address'] = '';
    return json_encode($pretty_array);
  }

  $contact_email   = '';
  $contact_abuse   = '';
  $contact_address = '';
  $description     = '';
  if(isset($data) && isset($data->remarks[0]) && isset($data->remarks[0]->description[0])){
    $description = $data->remarks[0]->description[0];
  }

  if(isset($data) && isset($data->entities)){
    foreach($data->entities as $entity) {
      if(isset($entity->vcardArray)){
        foreach($entity->vcardArray[1] as $vcard_entry){
          if($vcard_entry[0] == 'email' && is_object($vcard_entry[1]) && isset($vcard_entry[1]->type) && $vcard_entry[1]->type == 'email'){
            $contact_email = $vcard_entry[3];
          }
          if($vcard_entry[0] == 'email' && is_object($vcard_entry[1]) && isset($vcard_entry[1]->type) && $vcard_entry[1]->type == 'abuse'){
            $contact_abuse = $vcard_entry[3];
          }
          if($vcard_entry[0] == 'adr' && is_object($vcard_entry[1]) && isset($vcard_entry[1]->label)){
            $contact_address = $vcard_entry[1]->label;
          }
        }
      }
    }
  }

  $pretty_array = Array();
  $pretty_array['network_start_address'] = (isset($data) && isset($data->startAddress) && $data->startAddress != NULL && $data->startAddress != '') ? $data->startAddress : '';
  $pretty_array['network_end_address'] = (isset($data) && isset($data->endAddress) && $data->endAddress != NULL && $data->endAddress != '') ? $data->endAddress : '';
  $pretty_array['network_handle'] = (isset($data) && isset($data->handle) && $data->handle != NULL && $data->handle != '') ? $data->handle : '';
  $pretty_array['network_country_code'] = (isset($data) && isset($data->country) && $data->country != NULL && $data->country != '') ? mb_strtolower($data->country) : '';
  $pretty_array['network_name'] = (isset($data) && isset($data->name) && $data->name != NULL && $data->name != '') ? $data->name : '';
  $pretty_array['network_description'] = (isset($data) && isset($data->description) && $data->description != NULL && $data->description != '') ? $data->description : '';
  $pretty_array['network_contact_email']   = (isset($contact_email) && $contact_email != NULL && $contact_email != '') ? $contact_email : '';
  $pretty_array['network_contact_abuse']   = (isset($contact_abuse) && $contact_abuse != NULL && $contact_abuse != '') ? $contact_abuse : '';
  $pretty_array['network_contact_address'] = (isset($contact_address) && $contact_address != NULL && $contact_address != '') ? $contact_address : '';

  return json_encode($pretty_array);
}
