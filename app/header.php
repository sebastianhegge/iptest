<?php
function header_web($nonce){
  if(HEADER_XFO){
    header("X-Frame-Options: SAMEORIGIN");
  }

  if(HEADER_XCTO){
    header("X-Content-Type-Options: nosniff");
  }

  if(HEADER_XXSSP){
    header("X-XSS-Protection: 1; mode=block");
  }

  if(HEADER_RP){
    header("Referrer-Policy: same-origin");
  }

  if(HEADER_CSP){
    $csp[] = "default-src 'none'";
    $csp[] =  "base-uri 'self'";
    if(isset($_COOKIE['MAP_SERVICE'])){
      switch ($_COOKIE['MAP_SERVICE']){
        case 'openstreetmap':
          $csp[] = "script-src 'self' 'nonce-".$nonce."'";
          $csp[] = "style-src 'self' 'nonce-".$nonce."'";
          $csp[] = "img-src 'self' data: *.".OPENSTREETMAP_DOMAIN;
          $csp[] = "connect-src 'self' ipv4.".$_SERVER['HTTP_HOST']." ipv6.".$_SERVER['HTTP_HOST']." *.edns.ip-api.com";
          break;
        case 'applemaps':
          $csp[] = "script-src 'self' 'nonce-".$nonce."' 'wasm-unsafe-eval'";
          $csp[] = "style-src 'self' 'nonce-".$nonce."'";
          $csp[] = "img-src 'self' data: blob: https://*.apple-mapkit.com";
          $csp[] = "connect-src 'self' blob: ipv4.".$_SERVER['HTTP_HOST']." ipv6.".$_SERVER['HTTP_HOST']." *.edns.ip-api.com https://*.apple-mapkit.com";
          $csp[] = "worker-src blob: https://*.apple-mapkit.com";
          $csp[] = "frame-src https://*.apple-mapkit.com";
          break;
        case 'googlemaps':
          $csp[] = "script-src 'nonce-".$nonce."' 'self' 'strict-dynamic' 'unsafe-inline' 'unsafe-eval' blob: https://*.googleapis.com https://*.gstatic.com *.google.com https://*.ggpht.com *.googleusercontent.com";
          $csp[] = "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com";
          $csp[] = "img-src 'self' data: https://*.googleapis.com https://*.gstatic.com *.google.com *.googleusercontent.com";
          $csp[] = "frame-src *.google.com";
          $csp[] = "connect-src 'self' ipv4.".$_SERVER['HTTP_HOST']." ipv6.".$_SERVER['HTTP_HOST']." *.edns.ip-api.com https://*.googleapis.com *.google.com https://*.gstatic.com data: blob:";
          $csp[] = "font-src https://fonts.gstatic.com";
          $csp[] = "worker-src blob:";
          break;
        default:
          $csp[] = "script-src 'self' 'nonce-".$nonce."'";
          $csp[] = "style-src 'self' 'nonce-".$nonce."'";
          $csp[] = "img-src 'self' data:";
          $csp[] = "connect-src 'self' ipv4.".$_SERVER['HTTP_HOST']." ipv6.".$_SERVER['HTTP_HOST']." *.edns.ip-api.com";
      }
    } else {
      $csp[] = "script-src 'self' 'nonce-".$nonce."'";
      $csp[] = "style-src 'self' 'nonce-".$nonce."'";
      $csp[] = "img-src 'self' data:";
      $csp[] = "connect-src 'self' ipv4.".$_SERVER['HTTP_HOST']." ipv6.".$_SERVER['HTTP_HOST']." *.edns.ip-api.com";
    }
    if(HEADER_CSP_REPORT_ONLY){
      header("Content-Security-Policy-Report-Only: ".implode('; ', $csp).";");
    } else {
      header("Content-Security-Policy: ".implode('; ', $csp).";");
    }
  }

  if(HEADER_PP){
    $pp[] = "accelerometer=()";
    $pp[] = "autoplay=()";
    $pp[] = "camera=()";
    $pp[] = "display-capture=()";
    $pp[] = "encrypted-media=()";
    $pp[] = "fullscreen=(self)";
    $pp[] = "geolocation=()";
    $pp[] = "gyroscope=()";
    $pp[] = "magnetometer=()";
    $pp[] = "microphone=()";
    $pp[] = "midi=()";
    $pp[] = "payment=()";
    $pp[] = "picture-in-picture=(self)";
    $pp[] = "publickey-credentials-get=()";
    $pp[] = "sync-xhr=(self)";
    $pp[] = "usb=()";
    $pp[] = "xr-spatial-tracking=()";
    header("Permissions-Policy: ".implode(', ', $pp));
  }

  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' && HEADER_HSTS){
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
  }
}
