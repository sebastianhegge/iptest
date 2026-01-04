<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';

function get_user_agent_data_from_db($user_agent){
  db_delete_old('user_agent');

  $user_agent_data = $GLOBALS['db']->prepare("SELECT * FROM `user_agent` WHERE user_agent = :user_agent LIMIT 1");
  $user_agent_data->bindParam(':user_agent', $user_agent, PDO::PARAM_STR, 500);
  $user_agent_data->execute();

  $result = $user_agent_data->fetch(PDO::FETCH_ASSOC);
  if(is_array($result)){
    return $result['result'];
  } else {
    return NULL;
  }
}

function get_user_agent_data_from_api($user_agent){
  $url = '://api.userstack.com/detect?access_key='.USERSTACK_API_KEY.'&ua='.urlencode($user_agent);
  if(USERSTACK_PAYED_VERSION){
    $url = 'https'.$url;
  } else {
    $url = 'http'.$url;
  }
  return get_url_content($url);
}

function get_user_agent_data($user_agent){
  $user_agent_data_from_db = get_user_agent_data_from_db($user_agent);
  if(isset($user_agent_data_from_db) && $user_agent_data_from_db != NULL && $user_agent_data_from_db != ''){
    return $user_agent_data_from_db;
  } else {
    $user_agent_data_from_api = get_user_agent_data_from_api($user_agent);

    if(isset($user_agent_data_from_api) && $user_agent_data_from_api != NULL && $user_agent_data_from_api != ''){
      $user_agent_data = $GLOBALS['db']->prepare("INSERT INTO `user_agent` (user_agent, result) VALUES (:user_agent, :result)");
      $user_agent_data->bindParam(':user_agent', $user_agent);
      $user_agent_data->bindParam(':result', $user_agent_data_from_api);
      $user_agent_data->execute();
    }

    return $user_agent_data_from_api;
  }
}

function get_pretty_user_agent_data($user_agent){
  $data = json_decode(get_user_agent_data($user_agent));

  $pretty_array = Array();
  $pretty_array['client_user_agent'] = (isset($user_agent) && $user_agent != NULL && $user_agent != '') ? $user_agent : '';
  $pretty_array['client_device_type'] = (isset($data) && isset($data->device) && isset($data->device->type) && $data->device->type != NULL && $data->device->type != '') ? ($data->device->type == 'unknown' ? $data->device->type : mb_convert_case($data->device->type, MB_CASE_TITLE)) : '';
  $pretty_array['client_device_brand'] = (isset($data) && isset($data->device) && isset($data->device->brand) && $data->device->brand != NULL && $data->device->brand != '') ? $data->device->brand : '';
  $pretty_array['client_device'] = (isset($data) && isset($data->name) && $data->name != NULL && $data->name != '') ? $data->name : '';
  $pretty_array['client_device_os'] = (isset($data) && isset($data->os) && isset($data->os->family) && $data->os->family != NULL && $data->os->family != '') ? $data->os->family : '';
  $pretty_array['client_browser_name'] = (isset($data) && isset($data->browser) && isset($data->browser->name) && $data->browser->name != NULL && $data->browser->name != '') ? $data->browser->name : '';
  $pretty_array['client_browser_major_version'] = (isset($data) && isset($data->browser) && isset($data->browser->version_major) && $data->browser->version_major != NULL && $data->browser->version_major != '') ? $data->browser->version_major : '';
  $pretty_array['client_browser_version'] = (isset($data) && isset($data->browser) && isset($data->browser->version) && $data->browser->version != NULL && $data->browser->version != '') ? $data->browser->version : '';

  return json_encode($pretty_array);
}
