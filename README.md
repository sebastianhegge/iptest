# iptest

A small tool to test several IP settings with the help of:
* [ip-api.com](http://ip-api.com)
* [peeringdb.com](https://www.peeringdb.com/apidocs/)
* [RIPE RDAP-API](https://www.ripe.net/manage-ips-and-asns/db/registration-data-access-protocol-rdap)
* [userstack](https://userstack.com/)
* [p0f-tool](https://lcamtuf.coredump.cx/p0f3/)

It caches all API responses and is available in DE and EN. See a demo at [ipte.st](http://ipte.st).

## These values are determined
* Connection (IPv4 or IPv6)
* IPv4 and IPv6 address
* Hostname (IPv4 and IPv6)
* DNS-Server (IP, Provider and Country)
* EDNS-Subnetz (Transmitted to DNS-Server (IP, Provider and Country))
* User agent
 * Device type
 * Device brand
 * Device operating system
* Browser and its version
* Network-MTU (IPv4 and IPv6)
* Resulting suspected connection type (IPv4 and IPv6)
* Hop amount from Client to Server (IPv4 and IPv6)
* Associated network (IPv4 and IPv6) with:
 * Start- and endaddress
 * Name
 * Contact- and abuse email-address
 * postal address
* Associated autonomous system (IPv4 and IPv6) with:
 * Name
 * Alias / aka / description
 * Website
 * postal address (street, zip, city, state, country code)
 * Traffic info
* Resulting suspected internet service provider incl. postal address (IPv4 and IPv6)
* AS-informations (number, name and company), (IPv4 and IPv6)
* Map Service for postal address (IPv4 and IPv6), you (and also the client) can select between OpenStreetMap, Apple Maps, Google Maps or no Map

## Requirements

* webserver with:
  * PHP
  * PHP Curl extension
* one webserver vhost with:
  * production-domain (for example DOMAIN.de), reachable via IPv4 and IPv6 (with an A Record and an AAAA Record)
  * ipv4 subdomain (ipv4.DOMAIN.de), reachable only via IPv4 (only an A Record)
  * ipv6 subdomain (ipv6.DOMAIN.de), reachable only via IPv6 (only an AAAA Record)
* Map Services
  * OpenStreetMap (Sub)domain and Tile-Server-(Sub)domain (optional)
  * Apple Maps API Key (optional)
  * Google Maps API Key (optional)
* p0f-mtu running on same Server [GitHub](https://github.com/ValdikSS/p0f-mtu) / [README](README-p0f-mtu.md)

## Install
* [download](https://github.com/sebastianhegge/iptest/archive/master.zip) or clone the project
* copy `config.example.php` to `config.php` and configure your settings and credentials

## Sources
* [jQuery 3.7.1 min](https://jquery.com/download/) in `/assets/jquery`
* [Bootstrap 5.3.8](https://getbootstrap.com/docs/5.3/getting-started/download/) in `/assets/bootstrap`
* [flag-icons 7.5.0](https://github.com/lipis/flag-icons) in `/flags` (the content of `/flags/4x3`)
* the API service of [ip-api.com](http://ip-api.com)
* the API service of [peeringdb.com](https://www.peeringdb.com/apidocs/)
* the API service of [RIPE RDAP-API](https://www.ripe.net/manage-ips-and-asns/db/registration-data-access-protocol-rdap)
* the API service of [userstack](https://userstack.com/)
* the [p0f-tool](https://github.com/ValdikSS/p0f-mtu.git)

## License
[MIT](LICENSE)

## Buy me a coffee
<a href="https://www.buymeacoffee.com/hegge" target="_blank"><img src="https://raw.githubusercontent.com/sebastianhegge/iptest/refs/heads/main/.github/buymeacoffee.png" alt="Buy me a coffee" style="width:200px;" ></a>
