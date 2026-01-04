<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';

function get_ip_api_data_from_db($ip){
  db_delete_old('ip_api');

  $ip = mb_strtolower($ip);
  $lang = lang();

  $ip_api_data = $GLOBALS['db']->prepare("SELECT * FROM `ip_api` WHERE ip = :ip AND lang = :lang LIMIT 1");
  $ip_api_data->bindParam(':ip', $ip, PDO::PARAM_STR, 39);
  $ip_api_data->bindParam(':lang', $lang, PDO::PARAM_STR, 5);
  $ip_api_data->execute();

  $result = $ip_api_data->fetch(PDO::FETCH_ASSOC);
  if(is_array($result)){
    return $result['result'];
  } else {
    return NULL;
  }
}

function get_ip_api_data_from_api($ip){
  $url = 'ip-api.com/json/'.$ip.'?fields=536608767&lang='.lang();
  if(IP_API_PAYED_VERSION){
    $url = 'https://pro.'.$url.'&key='.IP_API_API_KEY;
  } else {
    $url = 'http://'.$url;
  }
  return get_url_content($url);
}

function get_ip_api_data($ip){
  $ip_api_data_from_db = get_ip_api_data_from_db($ip);
  if(isset($ip_api_data_from_db) && $ip_api_data_from_db != NULL && $ip_api_data_from_db != ''){
    return $ip_api_data_from_db;
  } else {
    $ip_api_data_from_api = get_ip_api_data_from_api($ip);
    $lang = lang();

    if(isset($ip_api_data_from_api) && $ip_api_data_from_api != NULL && $ip_api_data_from_api != ''){
      $ip_api_data = $GLOBALS['db']->prepare("INSERT INTO `ip_api` (ip, lang, result) VALUES (:ip, :lang, :result)");
      $ip_api_data->bindParam(':ip', $ip);
      $ip_api_data->bindParam(':lang', $lang);
      $ip_api_data->bindParam(':result', $ip_api_data_from_api);
      $ip_api_data->execute();
    }

    return $ip_api_data_from_api;
  }
}

function get_pretty_ip_api_data($ip){
  $data = json_decode(get_ip_api_data($ip));

  if($data->status != 'success'){
    $pretty_array = Array();
    $pretty_array['isp'] = '';
    $pretty_array['zip'] = '';
    $pretty_array['city'] = '';
    $pretty_array['country'] = '';
    $pretty_array['country_code'] = '';
    $pretty_array['lat'] = '';
    $pretty_array['lon'] = '';
    $pretty_array['as_number'] = '';

    return json_encode($pretty_array);
  }

  (isset($data) && isset($data) && $data != NULL && $data != '') ? $data : '';

  $pretty_array = Array();
  $pretty_array['isp'] = (isset($data) && isset($data->isp) && $data->isp != NULL && $data->isp != '') ? $data->isp : '';
  $pretty_array['zip'] = (isset($data) && isset($data->zip) && $data->zip != NULL && $data->zip != '') ? $data->zip : '';
  $pretty_array['city'] = (isset($data) && isset($data->city) && $data->city != NULL && $data->city != '') ? $data->city : '';
  $pretty_array['country'] = (isset($data) && isset($data->country) && $data->country != NULL && $data->country != '') ? $data->country : '';
  $pretty_array['country_code'] = (isset($data) && isset($data->countryCode) && $data->countryCode != NULL && $data->countryCode != '') ? mb_strtolower($data->countryCode) : '';
  $pretty_array['lat'] = (isset($data) && isset($data->lat) && $data->lat != NULL && $data->lat != '') ? $data->lat : '';
  $pretty_array['lon'] = (isset($data) && isset($data->lon) && $data->lon != NULL && $data->lon != '') ? $data->lon : '';
  $pretty_array['as_number'] = (isset($data) && isset($data->as) && $data->as != NULL && $data->as != '') ? substr(explode(' ', $data->as)[0], 2) : '';

  return json_encode($pretty_array);
}
