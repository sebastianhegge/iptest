<?php
include_once 'config.php';
include_once 'language.php';
include_once 'database.php';
include_once 'base.php';

function get_peering_db_data_from_db($asn){
  db_delete_old('peering_db');

  $asn = mb_strtolower($asn);

  $peering_db_data = $GLOBALS['db']->prepare("SELECT * FROM `peering_db` WHERE asn = :asn LIMIT 1");
  $peering_db_data->bindParam(':asn', $asn, PDO::PARAM_STR, 20);
  $peering_db_data->execute();

  $result = $peering_db_data->fetch(PDO::FETCH_ASSOC);
  if(is_array($result)){
    return $result['result'];
  } else {
    return NULL;
  }
}

function get_peering_db_data_from_api($asn){
  $asn_data = json_decode(get_url_content('https://www.peeringdb.com/api/net?asn='.$asn));
  $org_data = json_decode(get_url_content('https://www.peeringdb.com/api/org/'.$asn_data->data[0]->org_id));

  $data = Array();
  $data['asn'] = $asn_data;
  $data['org'] = $org_data;
  return json_encode($data);
}

function get_peering_db_data($asn){
  $peering_db_data_from_db = get_peering_db_data_from_db($asn);
  if(isset($peering_db_data_from_db) && $peering_db_data_from_db != NULL && $peering_db_data_from_db != ''){
    return $peering_db_data_from_db;
  } else {
    $peering_db_data_from_api = get_peering_db_data_from_api($asn);
    $peering_db_data_from_api_decoded = json_decode($peering_db_data_from_api);

    if(isset($peering_db_data_from_api_decoded->asn) && $peering_db_data_from_api_decoded->asn != NULL && $peering_db_data_from_api_decoded->asn != ''){
      $peering_db_data = $GLOBALS['db']->prepare("INSERT INTO `peering_db` (asn, result) VALUES (:asn, :result)");
      $peering_db_data->bindParam(':asn', $asn);
      $peering_db_data->bindParam(':result', $peering_db_data_from_api);
      $peering_db_data->execute();
    }

    return $peering_db_data_from_api;
  }
}

function get_pretty_peering_db_data($asn){
  $data = json_decode(get_peering_db_data($asn));

  if(isset($data->asn) && isset($data->asn->meta) && isset($data->asn->meta->error)){
    $pretty_array = Array();
    #$pretty_array['asn'] = '';
    $pretty_array['as_peering_name'] = '';
    $pretty_array['as_peering_alias'] = '';
    $pretty_array['as_peering_website'] = '';
    $pretty_array['as_peering_street'] = '';
    $pretty_array['as_peering_city'] = '';
    $pretty_array['as_peering_zip'] = '';
    $pretty_array['as_peering_state'] = '';
    $pretty_array['as_peering_country_code'] = '';
    $pretty_array['as_peering_traffic_info'] = '';
    return json_encode($pretty_array);
  }

  if(
    isset($data->org->data[0]->net_set) &&
    is_array($data->org->data[0]->net_set)
  ){
    foreach ($data->org->data[0]->net_set as $item) {
      if ($item->asn == $asn){
        $net_set = $item;
      }
    }
  }

#  print('<pre>');
#  var_dump($data);
#  print('</pre>');
#  die();

  if(
    isset($data->org->data[0]->address1) &&
    $data->org->data[0]->address1 != NULL &&
    $data->org->data[0]->address1 != '' &&
    isset($data->org->data[0]->address2) &&
    $data->org->data[0]->address2 != NULL &&
    $data->org->data[0]->address2 != ''
  ){
    $address = implode(', ', [$data->org->data[0]->address1, $data->org->data[0]->address2]);
  } else if(
    isset($data->org->data[0]->address1) &&
    $data->org->data[0]->address1 != NULL &&
    $data->org->data[0]->address1 != '' &&
    (
      !isset($data->org->data[0]->address2) ||
      $data->org->data[0]->address2 == NULL ||
      $data->org->data[0]->address2 == ''
    )
  ){
    $address = $data->org->data[0]->address1;
  } else if(
    (
      !isset($data->org->data[0]->address1) ||
      $data->org->data[0]->address1 == NULL ||
      $data->org->data[0]->address1 == ''
    ) &&
    isset($data->org->data[0]->address2) &&
    $data->org->data[0]->address2 != NULL &&
    $data->org->data[0]->address2 != ''
  ){
    $address = $data->org->data[0]->address2;
  } else {
    $address = '';
  }

  (isset($data) && isset($data) && $data != NULL && $data != '') ? $data : '';

  $pretty_array = Array();
  #$pretty_array['asn'] = (isset($data) && isset($data->org) && isset($data->org->data[0]) && isset($data->org->data[0]->net_set[0]) && isset($data->org->data[0]->net_set[0]->asn) && $data->org->data[0]->net_set[0]->asn != NULL && $data->org->data[0]->net_set[0]->asn != '') ? $data->org->data[0]->net_set[0]->asn : '';
  $pretty_array['as_peering_name'] = (isset($data) && isset($data->asn) && isset($data->asn->data[0]) && isset($data->asn->data[0]->name) && $data->asn->data[0]->name != NULL && $data->asn->data[0]->name != '') ? $data->asn->data[0]->name : '';
  $pretty_array['as_peering_alias'] = (isset($data) && isset($data->asn) && isset($data->asn->data[0]) && isset($data->asn->data[0]->aka) && $data->asn->data[0]->aka != NULL && $data->asn->data[0]->aka != '') ? $data->asn->data[0]->aka : '';
  $pretty_array['as_peering_website'] = (isset($data) && isset($data->asn) && isset($data->asn->data[0]) && isset($data->asn->data[0]->website) && $data->asn->data[0]->website != NULL && $data->asn->data[0]->website != '') ? $data->asn->data[0]->website : '';
  $pretty_array['as_peering_street'] = (isset($address) && $address != NULL && $address != '') ? $address : '';
  $pretty_array['as_peering_city'] = (isset($data) && isset($data->org) && isset($data->org->data[0]) && isset($data->org->data[0]->city) && $data->org->data[0]->city != NULL && $data->org->data[0]->city != '') ? $data->org->data[0]->city : '';
  $pretty_array['as_peering_zip'] = (isset($data) && isset($data->org) && isset($data->org->data[0]) && isset($data->org->data[0]->zipcode) && $data->org->data[0]->zipcode != NULL && $data->org->data[0]->zipcode != '') ? $data->org->data[0]->zipcode : '';
  $pretty_array['as_peering_state'] = (isset($data) && isset($data->org) && isset($data->org->data[0]) && isset($data->org->data[0]->state) && $data->org->data[0]->state != NULL && $data->org->data[0]->state != '') ? $data->org->data[0]->state : '';
  $pretty_array['as_peering_country_code'] = (isset($data) && isset($data->org) && isset($data->org->data[0]) && isset($data->org->data[0]->country) && $data->org->data[0]->country != NULL && $data->org->data[0]->country != '') ? mb_strtolower($data->org->data[0]->country) : '';
  $pretty_array['as_peering_traffic_info'] = (isset($data) && isset($data->asn) && isset($data->asn->data[0]) && isset($data->asn->data[0]->info_traffic) && $data->asn->data[0]->info_traffic != NULL && $data->asn->data[0]->info_traffic != '') ? $data->asn->data[0]->info_traffic : '';

  return json_encode($pretty_array);
}
