<?php
function nav_post(){
  if(isset($_POST["checkbox_googlemaps"])){
    setcookie('GOOGLE_MAPS_ACTIVE', '1', time()+7884000);
    $GLOBALS['GOOGLE_MAPS_ACTIVE'] = true;
  } else {
    setcookie('GOOGLE_MAPS_ACTIVE', '0', time()+2628000);
    $GLOBALS['GOOGLE_MAPS_ACTIVE'] = false;
  }
  header('Location: /', true, 302);
}

function nav_web(){
  if(!isset($_COOKIE['GOOGLE_MAPS_ACTIVE']) && !isset($GLOBALS['GOOGLE_MAPS_ACTIVE'])){
    include_once '../app/config.php';
    include_once '../app/language.php';
    include_once '../app/base.php';
    include_once '../app/header.php';
    $nonce = substr(bin2hex(random_bytes(10)), 0, 10);
    include_once '../templates/html-cookie.php';
  } else {
    if(
      (isset($_COOKIE['GOOGLE_MAPS_ACTIVE']) && $_COOKIE['GOOGLE_MAPS_ACTIVE'] == '1') ||
      (isset($GLOBALS['GOOGLE_MAPS_ACTIVE']) && $GLOBALS['GOOGLE_MAPS_ACTIVE'] == true)
    ){
      setcookie('GOOGLE_MAPS_ACTIVE', '1', time()+7884000);
      $GLOBALS['GOOGLE_MAPS_ACTIVE'] = true;
    } else {
      $GLOBALS['GOOGLE_MAPS_ACTIVE'] = false;
    }
    include_once '../app/app_minimal.php';
    include_once '../templates/html.php';
  }
}

function nav_cli(){
  $ip = $_SERVER['REMOTE_ADDR'];
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
