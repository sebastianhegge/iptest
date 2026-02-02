<?php
function get_url_content($url) {
  $options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER         => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_ENCODING       => "",
    CURLOPT_USERAGENT      => CURL_USERAGENT,
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 10,
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
    'Connection via'                        => 'Verbindung über',
    'Device type'                           => 'Geräte-Typ',
    'Operating system'                      => 'Betriebssystem',
    'Language'                              => 'Sprache',
    'Address'                               => 'Adresse',
    'Connection type'                       => 'Anschluss-Typ',
    'Hop distance'                          => 'Hop-Distanz',
    'Network'                               => 'Netz',
    'Network name'                          => 'Netz-Name',
    'Network contact'                       => 'Netz-Kontakt',
    'Autonomous system'                     => 'Autonomes System',
    'Imprint & Privacy policy'              => 'Impressum & Datenschutz',
    'Source on GitHub'                      => 'Quellcode auf GitHub',
    'Cookie & Privacy Notice'               => 'Cookie- & Datenschutz-Hinweis',
    'This website uses cookies to store these settings.' => 'Diese Webseite setzt Cookies, um diese Einstellungen zu speichern.',
    'This website can only be used if consent is given to the use of all required services.' => 'Diese Seite kann nur genutzt werden, wenn der Nutzung aller erforderlicher Dienste zugestimmt wird.',
    'Please select and accept the usage of' => 'Bitte wählen und akzeptieren sie die Nutzung',
    'The services provided by'              => 'Die Dienste von',
    'required'                              => 'erforderlich',
    'Please select a Map Service'           => 'Bitte wählen sie einen Kartenservice',
    'No map service'                        => 'Kein Kartenservice',
    'Accept'                                => 'Akzeptieren',
    'Leave Website'                         => 'Webseite verlassen',
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

function export_vars_to_js($nonce){
  $js_config = [];
  $js_config['openstreetmap']['active'] = OPENSTREETMAP_ACTIVE;
  if(OPENSTREETMAP_ACTIVE){
    $js_config['openstreetmap']['domain'] = OPENSTREETMAP_DOMAIN;
    $js_config['openstreetmap']['subdomains'] = OPENSTREETMAP_SUBDOMAINS;
  }
  $js_config['applemaps']['active'] = APPLE_MAPS_ACTIVE;
  if(APPLE_MAPS_ACTIVE){
    $js_config['applemaps']['api_key'] = APPLE_MAPS_API_KEY;
  }
  $js_config['googlemaps']['active'] = GOOGLE_MAPS_ACTIVE;
  if(GOOGLE_MAPS_ACTIVE){
    $js_config['googlemaps']['api_key'] = GOOGLE_MAPS_API_KEY;
    $js_config['googlemaps']['map_id'] = GOOGLE_MAPS_MAP_ID;
  }

  print("<script nonce=\"".$nonce."\" type=\"text/javascript\">\n");
  print("const config = ".json_encode($js_config, JSON_UNESCAPED_SLASHES)."\n");
  print("</script>\n");
}

function activate_map_service($nonce){
  if(isset($_COOKIE['MAP_SERVICE'])){
    switch ($_COOKIE['MAP_SERVICE']){
      case 'openstreetmap':
        if(OPENSTREETMAP_ACTIVE){
          print("<link nonce=\"".$nonce."\" rel=\"stylesheet\" href=\"/assets/leaflet/leaflet.css?v=1.9.4\"></script>\n");
          print("<script nonce=\"".$nonce."\" src=\"/assets/leaflet/leaflet.js?v=1.9.4\"></script>\n");
        }
        break;
      case 'applemaps':
        if(APPLE_MAPS_ACTIVE){
          print("<script crossorigin async nonce=\"".$nonce."\" src=\"https://cdn.apple-mapkit.com/mk/5.x.x/mapkit.core.js\" data-callback=\"map_service_callback\" data-libraries=\"map,annotations\" data-language=\"".lang()."\" data-token=\"".APPLE_MAPS_API_KEY."\"></script>\n");
        }
        break;
      case 'googlemaps':
        if(GOOGLE_MAPS_ACTIVE){
          print("<script crossorigin async nonce=\"".$nonce."\" src=\"https://maps.googleapis.com/maps/api/js?key=".GOOGLE_MAPS_API_KEY."&callback=map_service_callback&loading=async&libraries=marker&region=".lang()."&language=".lang()."\"></script>\n");
        }
        break;
    }
  }
}

function redirect($path){
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  header('Location: '.$path, true, 301);
}
