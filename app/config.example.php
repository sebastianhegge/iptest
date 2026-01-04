<?php

if(false){
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}

############################
### database settings    ###
############################

define('DB_HOST', '');
define('DB_DATABASE', '');
define('DB_USER', '');
define('DB_PASSWORD', '');

############################



############################
### Google Maps settings ###
############################

# WARNING! will be exposed into javascript!
define('GOOGLE_MAPS_API_KEY', '');

############################



############################
### IP-API settings      ###
############################

define('IP_API_API_KEY', '');
define('IP_API_PAYED_VERSION', false);

############################



############################
### userstack settings   ###
############################

define('USERSTACK_API_KEY', '');
define('USERSTACK_PAYED_VERSION', false);

############################



############################
### p0f settings         ###
############################

define('P0F_CLIENT_PATH', '/var/www/iptest/bin/p0f-client');
define('P0F_SOCK_PATH', '/var/run/p0f.sock');

############################



############################
### header settings      ###
############################

# activate header: X-Frame-Options with "SAMEORIGIN"
define('HEADER_XFO', true);

# activate header: X-Content-Type-Options with "nosniff"
define('HEADER_XCTO', true);

# activate header: X-XSS-Protection with "1; mode=block"
define('HEADER_XXSSP', true);

# activate header: Referrer-Policy with "same-origin"
define('HEADER_RP', true);

# activate header Content-Security-Policy
define('HEADER_CSP', true);

# activate header Permissions-Policy
define('HEADER_PP', true);

# activate header Strict-Transport-Security with "max-age=31536000; includeSubDomains; preload"
# WARNING! once enabled, site will only be available over https!
define('HEADER_HSTS', false);

############################
