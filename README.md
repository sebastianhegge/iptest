# iptest

A small tool to test several IP settings with the help of Apache Mod MaxMind, [peeringdb.com](https://www.peeringdb.com/apidocs/) and [ip-api.com](http://ip-api.com).
See a demo at [ipte.st](http://ipte.st).

## These values are determined
* Current connection (IPv4 or IPv6)
* DNS-Server (IP, Provider and Country)
* EDNS-Subnetz (Transmitted to DNS-Server (IP, Provider and Country))
* User agent
* Device type
* Operating system
* Browser
* IPv4 and IPv6 Address
* Hostname (IPv4 and IPv6)
* Network-MTU (IPv4 or IPv6)
* Resulting suspected connection type (IPv4 or IPv6)
* Hop amount from Client to Server (IPv4 or IPv6)
* Associated AS Network (IPv4 and IPv6)
* Resulting suspected internet service provider incl. postal address (IPv4 and IPv6)
* AS-informations (number, name and company), (IPv4 and IPv6)
* Google Maps Map for postal address (IPv4 and IPv6)

## Requirements

* webserver with:
  * PHP
  * PHP Curl extension
  * PHP Browscap extension [website](https://browscap.org) / [download lite version](https://browscap.org/stream?q=Lite_PHP_BrowsCapINI)
  * Apache Module RemoteIPHeader configured VHOSTs with `RemoteIPHeader X-Client-IP`
  * Apache Module MaxMind DB [GitHub](https://github.com/maxmind/mod_maxminddb) / [README](README-install-apache-mod-maxmind.md)
* one webserver vhost with:
  * production-domain (for example DOMAIN.de), reachable via IPv4 and IPv6 (with an A Record and an AAAA Record)
  * ipv4 subdomain (ipv4.DOMAIN.de), reachable only via IPv4 (only an A Record)
  * ipv6 subdomain (ipv6.DOMAIN.de), reachable only via IPv6 (only an AAAA Record)
* Google Maps API Key
* p0f-mtu running on same Server [GitHub](https://github.com/ValdikSS/p0f-mtu) / [README](README-p0f-mtu.md)

## Install
* [download](https://github.com/sebastianhegge/iptest/archive/master.zip) or clone the project
* copy `config.example.php` to `config.php` and include your Google Maps API Key

## Sources
* [jQuery 3.5.0 min](https://code.jquery.com/jquery-3.5.0.min.js) in `/jquery`
* [Bootstrap 4.1](https://getbootstrap.com/docs/4.1/getting-started/download/) in `/bootstrap`
* [flag-icon-css project](https://github.com/lipis/flag-icon-css/archive/master.zip) in `/flags` (the content of `/flags/4x3`)
* the API service of [ip-api.com](http://ip-api.com)
* the API service of [peeringdb.com](https://www.peeringdb.com/apidocs/)

## License
MIT
