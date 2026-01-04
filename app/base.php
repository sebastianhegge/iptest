<?php
function get_url_content($url) {
  $options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => "",
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 10,
    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
  );

  $ch = curl_init($url);
  curl_setopt_array($ch, $options);

  $content = curl_exec($ch);

  curl_close($ch);

  return $content;
}

function get_max_array_key_length($data){
  $data_length = 0;
  foreach ($data as $key => $value) {
    if(mb_strlen($key) > $data_length){
      $data_length = mb_strlen($key);
    }
  }
  return $data_length;
}

function string_ends_with($string, $end_string){
  $len = strlen($end_string);
  if ($len == 0) {
    return true;
  }
  return (substr($string, -$len) === $end_string);
}

function string_starts_with ($string, $start_string){
  $len = strlen($start_string);
  return (substr($string, 0, $len) === $start_string);
}

function translate($string){
  if(lang() != 'de'){
    return $string;
  }

  $strings = array(
    'Connection via'           => 'Verbindung über',
    'Device type'              => 'Geräte-Typ',
    'Operating system'         => 'Betriebssystem',
    'Language'                 => 'Sprache',
    'Address'                  => 'Adresse',
    'Connection type'          => 'Anschluss-Typ',
    'Hop distance'             => 'Hop-Distanz',
    'Network'                  => 'Netz',
    'Network name'             => 'Netz-Name',
    'Network contact'          => 'Netz-Kontakt',
    'Autonomous system'        => 'Autonomes System',
    'Imprint & Privacy policy' => 'Impressum & Datenschutz',
    'Source on GitHub'         => 'Quellcode auf GitHub',
    'Accept'                   => 'Akzeptieren',
    'Leave Website'            => 'Webseite verlassen',
  );

  if(!array_key_exists($string, $strings)){
    return $string;
  }

  return $strings[$string];
}

function t($string){
  return translate($string);
}

function tp($string){
  if(isset($string) && $string != NULL && $string != ''){
    print(translate($string));
  } else {
    print('-');
  }
}

function p($string){
  if(isset($string) && $string != NULL && $string != ''){
    print($string);
  } else {
    print('-');
  }
}

function mp($array, $glue = ' '){
  $array = array_filter($array, fn($value) => !is_null($value) && $value !== '');
  if(count($array) > 0){
    print(implode($glue, $array));
  } else {
    print('-');
  }
}

function activate_google_maps($nonce){
  if($GLOBALS['GOOGLE_MAPS_ACTIVE']){
    print("<script async nonce=\"".$nonce."\" src=\"https://maps.googleapis.com/maps/api/js?key=".GOOGLE_MAPS_API_KEY."&callback=maps_callback&region=".lang()."&language=".lang()."\"></script>\n");
  }
}

function redirect($path){
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header('Location: '.$path, true, 301);
}
