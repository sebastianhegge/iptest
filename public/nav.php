<?php
function nav_post(){
  if(
    isset($_POST["checkbox_ipapi"]) && $_POST["checkbox_ipapi"] == '1' &&
    isset($_POST["checkbox_peeringdb"]) && $_POST["checkbox_peeringdb"] == '1' &&
    isset($_POST["checkbox_ripe"]) && $_POST["checkbox_ripe"] == '1' &&
    isset($_POST["checkbox_userstack"]) && $_POST["checkbox_userstack"] == '1'
  ){
    setcookie('TERMS_OF_SERVICE', 'accepted', time()+7884000);
  } else {
    setcookie('TERMS_OF_SERVICE', '', time()-1000);
  }

  if(isset($_POST["checkbox_mapservice"])){
    $mapservice = match ($_POST['checkbox_mapservice']) {
      'openstreetmap' => 'openstreetmap',
      'applemaps'     => 'applemaps',
      'googlemaps'    => 'googlemaps',
      default         => 'no_map'
    };
    setcookie('MAP_SERVICE', $mapservice, time()+7884000);
  } else {
    setcookie('MAP_SERVICE', '', time()-1000);
  }

  header('Location: /', true, 302);
}

function nav_web(){
  if(isset($_COOKIE['TERMS_OF_SERVICE']) && $_COOKIE['TERMS_OF_SERVICE'] == 'accepted'){
    setcookie('TERMS_OF_SERVICE', 'accepted', time()+7884000);
    include_once '../app/app_minimal.php';
    include_once '../templates/html.php';
  } else {
    include_once '../app/config.php';
    include_once '../app/language.php';
    include_once '../app/base.php';
    include_once '../app/header.php';
    $nonce = substr(bin2hex(random_bytes(10)), 0, 10);
    include_once '../templates/html-cookie.php';
  }
}

function nav_cli(){
  include_once '../app/app.php';
  include_once '../templates/cli.php';
}

function nav_api(){
  include_once '../app/app.php';
  include_once '../templates/api.php';
}

function nav_robots(){
  include_once '../templates/robots.txt.php';
}
