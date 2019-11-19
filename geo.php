<?php
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json;charset=utf-8');

if(isset($_GET['ip'])){
  $ip = $_GET['ip'];
  $response = get_web_page('http://ip-api.com/json/'.$ip.'?fields=19187&lang=de');
  print_r($response);
}
else {
  $asn = getenv('MM_ASN');

  $asn_response = get_web_page('https://peeringdb.com/api/net?asn='.$asn);
  $asn_response_obj = json_decode($asn_response);
  $asn_org_id = $asn_response_obj->data[0]->org_id;
  $org_response = get_web_page('https://www.peeringdb.com/api/org/'.$asn_org_id);
  $org_response_obj = json_decode($org_response);
  //print_r($org_response);

  $ret_obj['status'] = 'success';
  $ret_obj['ip_network'] = getenv('MM_ASN_DB_NETWORK');
  $ret_obj['country'] = getenv('MM_COUNTRY_NAME');
  $ret_obj['country_code'] = getenv('MM_COUNTRY_CODE_CITY_DB');
  $ret_obj['city'] = $org_response_obj->data[0]->city;
  $ret_obj['zip'] = $org_response_obj->data[0]->zipcode;
  $ret_obj['lat'] = (float)getenv('MM_LATITUDE');
  $ret_obj['lon'] = (float)getenv('MM_LONGITUDE');
  $ret_obj['isp'] = getenv('MM_AS_ORG');
  $ret_obj['isp_website'] = $org_response_obj->data[0]->website;
  $ret_obj['street'] = $org_response_obj->data[0]->address1;
  $ret_obj['state'] = $org_response_obj->data[0]->state;
  $ret_obj['as_number'] = $asn;
  $ret_obj['as_name'] = $asn_response_obj->data[0]->irr_as_set;
  $ret_obj['as_organisation'] = $org_response_obj->data[0]->name;

  print_r(json_encode($ret_obj));
}


function get_web_page($url) {
  $options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => "test",
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_TIMEOUT        => 120,
  );

  $ch = curl_init($url);
  curl_setopt_array($ch, $options);

  $content  = curl_exec($ch);

  curl_close($ch);

  return $content;
}
?>

