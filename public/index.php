<?php
include_once 'nav.php';

if($_SERVER['REQUEST_METHOD'] === 'HEAD'){
  header('X-Notice: don\'t use method HEAD, use GET!');
} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
  nav_post();
} else if($_SERVER['REQUEST_METHOD'] === 'GET') {
  $parsed_url = parse_url($_SERVER['REQUEST_URI']);
  $url_path = strtolower($parsed_url['path']);
  switch (true) {
    case $url_path == '/': {
      if(stripos($_SERVER['HTTP_USER_AGENT'], 'curl') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'httpie') !== false){
        nav_cli();
      } else if(stripos($_SERVER['HTTP_USER_AGENT'], 'postman') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'insomnia') !== false){
        redirect('/api/');
      } else {
        nav_web();
      }
      break;
    }
    case $url_path == '/api' || $url_path == '/api/': {
      nav_api();
      break;
    }
    case $url_path == '/robots.txt': {
      nav_robots();
      break;
    }
    case in_array(substr(strtolower($_SERVER['HTTP_HOST']), 0, 5), ['ipv4.', 'ipv6.']) && $url_path == '/': {
      redirect(substr(strtolower($_SERVER['HTTP_HOST']), 5));
      break;
    }
    default:  {
      redirect('/');
      break;
    }
  }
} else {
  redirect('/');
}
