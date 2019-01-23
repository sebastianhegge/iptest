# iptest

A small tool to test several IP settings with the help of [ip-api.com](http://ip-api.com). See [demo](http://iptest.hegge.it).

## Requirements

* webserver with:
 * PHP
 * PHP Curl extension
 * PHP Browscap extension [website](https://browscap.org) / [download lite version](https://browscap.org/stream?q=Lite_PHP_BrowsCapINI)
* one webserver vhost with:
  * production-domain (for example DOMAIN.de), reachable via IPv4 and IPv6 (with an A Record and an AAAA Record)
  * ipv4 subdomain (ipv4.DOMAIN.de), reachable only via IPv4 (only an A Record)
  * ipv6 subdomain (ipv6.DOMAIN.de), reachable only via IPv6 (only an AAAA Record)
* Google Maps API Key

## Install
* [download](https://github.com/sebastianhegge/iptest/archive/master.zip) or clone the project
* copy `config.example.php` to `config.php` and include your Google Maps API Key

## Sources
* [jQuery 3.3.1 min](https://code.jquery.com/jquery-3.3.1.min.js) in `/jquery`
* [Bootstrap 4.0](https://getbootstrap.com/docs/4.0/getting-started/download/) in `/bootstrap`
* [flag-icon-css project](https://github.com/lipis/flag-icon-css/archive/master.zip) in `/flags` (the content of `/flags/4x3`)
* the service of [ip-api.com](http://ip-api.com)

## License
MIT
