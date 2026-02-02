function find_get_parameter(parameter_name){
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameter_name) result = decodeURIComponent(tmp[1]);
    }
    return result;
};

const valid_v4_range = string => [...string].every(c => '0123456789. -/'.includes(c));
const valid_v6_range = string => [...string].every(c => '0123456789abcdef: -/'.includes(c));

var map_service = document.cookie.split('; ').find(row => row.startsWith('MAP_SERVICE' + '='))?.split('=')[1];
var ipv4_lat;
var ipv4_lon;
var ipv6_lat;
var ipv6_lon;
var map_service_ready = false;

function lang(){
  if(present(find_get_parameter('lang'))){
    var lang = find_get_parameter('lang');
  } else {
    var lang = navigator.language || navigator.userLanguage;
    lang = lang.substr(0,2);
  }
  if(lang != 'de'){
    lang = 'en';
  }
  return lang;
};

function map_service_callback(){
  map_service_ready = true;
  if(present(ipv4_lat) && present(ipv4_lon)){
    init_map('ipv4', ipv4_lat, ipv4_lon);
  }
  if(present(ipv6_lat) && present(ipv6_lon)){
    init_map('ipv6', ipv6_lat, ipv6_lon);
  }
}

function init_map_ipv4(){
  if(config['openstreetmap']['active'] && map_service == 'openstreetmap'){
    document.getElementById('map-ipv4').classList.add('map-height');
    var map = L.map('map-ipv4')
      .setView([ipv4_lat, ipv4_lon], 10);
    var osm = L.tileLayer('//{s}.' + config['openstreetmap']['domain'] + '/{z}/{x}/{y}.png', {
      subdomains: config['openstreetmap']['subdomains'],
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> ' + (lang() == 'de' ? 'Mitwirkende' : 'contributors')
    }).addTo(map);
    L.marker([ipv4_lat, ipv4_lon])
      .addTo(map)
      .openPopup();
  }
  if(config['applemaps']['active'] && map_service == 'applemaps' && map_service_ready){
    document.getElementById('map-ipv4').classList.add('map-height');
    var region = new mapkit.CoordinateRegion(
      new mapkit.Coordinate(ipv4_lat, ipv4_lon),
      new mapkit.CoordinateSpan(0.25, 0.25)
    );
    var map_ipv4 = new mapkit.Map('map-ipv4', {
      region: region,
      showsZoomControl: true
    });
    var annotation = new mapkit.MarkerAnnotation(
      new mapkit.Coordinate(ipv4_lat, ipv4_lon),{}
    );
    map_ipv4.addAnnotation(annotation);
  }
  if(config['googlemaps']['active'] && map_service == 'googlemaps' && map_service_ready){
    document.getElementById('map-ipv4').classList.add('map-height');
    var pos = {lat: ipv4_lat, lng: ipv4_lon};
    var map_ipv4 = new google.maps.Map(document.getElementById('map-ipv4'), {
      zoom: 10,
      center: pos,
      disableDefaultUI: true,
      zoomControl: true,
      mapId: config['googlemaps']['map_id']
    });
    var marker = new google.maps.marker.AdvancedMarkerElement({
      position: pos,
      map: map_ipv4
    });
  }
};

function init_map(ip_version, lat, lon){
  switch (map_service) {
    case 'openstreetmap':
      if(config['openstreetmap']['active']){
        document.getElementById('map-' + ip_version).classList.add('map-height');
        var map = L.map('map-' + ip_version)
          .setView([lat, lon], 10);
        var osm = L.tileLayer('//{s}.' + config['openstreetmap']['domain'] + '/{z}/{x}/{y}.png', {
          subdomains: config['openstreetmap']['subdomains'],
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> ' + (lang() == 'de' ? 'Mitwirkende' : 'contributors')
        }).addTo(map);
        L.marker([lat, lon])
          .addTo(map)
          .openPopup();
      } else {
        document.getElementById('map-' + ip_version).innerHTML =
          lang() === 'de'
            ? '<div class="map-na-message">Der gewählte Kartenservice ist nicht länger verfügbar.</div>'
            : '<div class="map-na-message">The selected map service is no longer available.</div>';
      }
      break;
    case 'applemaps':
      if(map_service_ready){
        if(config['applemaps']['active']){
          document.getElementById('map-' + ip_version).classList.add('map-height');
          var region = new mapkit.CoordinateRegion(
            new mapkit.Coordinate(lat, lon),
            new mapkit.CoordinateSpan(0.25, 0.25)
          );
          var map = new mapkit.Map('map-' + ip_version, {
            region: region,
            showsZoomControl: true
          });
          var annotation = new mapkit.MarkerAnnotation(
            new mapkit.Coordinate(lat, lon),{}
          );
          map.addAnnotation(annotation);
        } else {
          document.getElementById('map-' + ip_version).innerHTML =
            lang() === 'de'
              ? '<div class="map-na-message">Der gewählte Kartenservice ist nicht länger verfügbar.</div>'
              : '<div class="map-na-message">The selected map service is no longer available.</div>';
        }
      }
      break;
    case 'googlemaps':
      if(map_service_ready){
        if(config['googlemaps']['active']){
          document.getElementById('map-' + ip_version).classList.add('map-height');
          var pos = {lat: lat, lng: lon};
          var map = new google.maps.Map(document.getElementById('map-' + ip_version), {
            zoom: 10,
            center: pos,
            disableDefaultUI: true,
            zoomControl: true,
            mapId: config['googlemaps']['map_id']
          });
          var marker = new google.maps.marker.AdvancedMarkerElement({
            position: pos,
            map: map
          });
        } else {
          document.getElementById('map-' + ip_version).innerHTML =
            lang() === 'de'
              ? '<div class="map-na-message">Der gewählte Kartenservice ist nicht länger verfügbar.</div>'
              : '<div class="map-na-message">The selected map service is no longer available.</div>';
        }
      }
      break;
  }
};

function get_dns_data(){
  var random_string = '';
  for (i = 0; i < 32; i++) {
    random_string += '0123456789abcdefghijklmnopqrstuvwxyz'[Math.round(Math.random() * 35)]
  }
  $.ajax({
    url: location.protocol + '//' + random_string + '.edns.ip-api.com/json?lang=' + lang(),
    type: 'GET',
    crossDomain: true,
    success: function(dns_data){
      $.ajax({
        url: location.protocol + '//' + location.host + '/api/?lang=' + lang() + '&ip=' + dns_data.dns.ip,
        type: 'GET',
        crossDomain: true,
        success: function(dns_ip_data){
          item = dns_data.dns.ip + '<br>';
          if(present(present(dns_ip_data['isp']) || dns_ip_data['zip']) || present(dns_ip_data['city']) || present(dns_ip_data['country']) || present(dns_ip_data['country_code'])){
            if(present(dns_ip_data['isp'])){
              item += dns_ip_data['isp'] + '<br>';
            }
            if(present(dns_ip_data['zip'])){
              item += dns_ip_data['zip'];
            }
            if(present(dns_ip_data['city'])){
              if(item.endsWith(dns_ip_data['zip'])){
                item += ' ';
              }
              item += dns_ip_data['city'];
            }
            if(present(dns_ip_data['zip']) || present(dns_ip_data['city'])){
              item += '<br>';
            }
            if(present(dns_ip_data['country'])){
              item += dns_ip_data['country'];
            }
            if(present(dns_ip_data['country_code'])){
              if(item.endsWith(dns_ip_data['country'])){
                item += ' ';
              }
              item += flag(dns_ip_data['country_code']);
            }
            $('#content-dns').html(item);
          } else {
            $('#content-dns').text('-');
          }
        }
      });
      if(dns_data && dns_data.edns){
        $.ajax({
          url: location.protocol + '//' + location.host + '/api/?lang=' + lang() + '&ip=' + dns_data.edns.ip,
          type: 'GET',
          crossDomain: true,
          success: function(edns_ip_data){
            item = dns_data.edns.ip + '<br>';
            if(present(edns_ip_data['isp']) || present(edns_ip_data['zip']) || present(edns_ip_data['city']) || present(edns_ip_data['country']) || present(edns_ip_data['country_code'])){
              if(present(edns_ip_data['isp'])){
                item += edns_ip_data['isp'] + '<br>';
              }
              if(present(edns_ip_data['zip'])){
                item += edns_ip_data['zip'];
              }
              if(present(edns_ip_data['city'])){
                if(item.endsWith(edns_ip_data['zip'])){
                  item += ' ';
                }
                item += edns_ip_data['city'];
              }
              if(present(edns_ip_data['zip']) || present(edns_ip_data['city'])){
                item += '<br>';
              }
              if(present(edns_ip_data['country'])){
                item += edns_ip_data['country'];
              }
              if(present(edns_ip_data['country_code'])){
                if(item.endsWith(edns_ip_data['country'])){
                  item += ' ';
                }
                item += flag(edns_ip_data['country_code']);
              }
              $('#content-edns').html(item);
            } else {
              $('#content-edns').text('-');
            }
          }
        });
      }
      else {
        $('#content-edns').text('-');
      }
    },
    error: function(error){
      $('#content-dns').text('-');
      $('#content-edns').text('-');
    }
  });
};

function fill_gui_general_area(data){

};

function fill_gui_ip_area(data, ip_version){
  if(present(data['ip'])){
    $('#content-ip' + ip_version + '-ip').html(data['ip'].replace(/:/g, ':<wbr>'));
  } else {
    $('#content-ip' + ip_version + '-ip').text('-');
  }

  if(present(data['hostname'])){
    $('#content-ip' + ip_version + '-hostname').text(data['hostname']);
  } else {
    $('#content-ip' + ip_version + '-hostname').text('-');
  }

  if(present(data['isp'])){
    $('#content-ip' + ip_version + '-isp').text(data['isp']);
  } else {
    $('#content-ip' + ip_version + '-isp').text('-');
  }

  if(present(data['zip']) || present(data['city']) || present(data['country']) || present(data['country_code'])){
    item = '';
    if(present(data['zip'])){
      item += data['zip'];
    }
    if(present(data['city'])){
      if(item.length > 0){
        item += ' ';
      }
      item += data['city'];
    }
    if(present(data['country'])){
      if(item.length > 0){
        item += '<br>';
      }
      item += data['country'];
    }
    if(present(data['country_code'])){
      if(item.length > 0){
        item += ' ';
      }
      item += flag(data['country_code']);
    }
    $('#content-ip' + ip_version + '-address').html(item);
  } else {
    $('#content-ip' + ip_version + '-address').text('-');
  }

  if(present(data['connection_mtu'])){
    $('#content-ip' + ip_version + '-mtu').text(data['connection_mtu']);
  } else {
    $('#content-ip' + ip_version + '-mtu').text('-');
  }

  if(present(data['connection_link_type'])){
    $('#content-ip' + ip_version + '-connection-type').text(data['connection_link_type']);
  } else {
    $('#content-ip' + ip_version + '-connection-type').text('-');
  }

  if(present(data['connection_distance'])){
    $('#content-ip' + ip_version + '-distance').text(data['connection_distance']);
  } else {
    $('#content-ip' + ip_version + '-distance').text('-');
  }

  if(
    present(data['network_handle']) && (
      (ip_version == 'v4' && valid_v4_range(data['network_handle'])) ||
      (ip_version == 'v6' && valid_v6_range(data['network_handle']))
    )
  ){
    $('#content-ip' + ip_version + '-network').text(data['network_handle']);
  } else if(present(data['network_start_address']) && present(data['network_end_address'])){
    $('#content-ip' + ip_version + '-network').text(data['network_start_address'] + ' - ' + data['network_end_address']);
  } else {
    $('#content-ip' + ip_version + '-network').text('-');
  }

  if(present(data['network_name'])){
    $('#content-ip' + ip_version + '-network-name').text(data['network_name']);
  } else {
    $('#content-ip' + ip_version + '-network-name').text('-');
  }

  if(present(data['network_contact_address']) || present(data['network_contact_abuse']) || present(data['network_contact_email'])){
    item = '';
    if(present(data['network_contact_address'])){
      item += data['network_contact_address'].replace(/\n/g, '<br>');
    }
    if(present(data['network_contact_address']) && present(data['network_country_code'])){
      item += ' ' + flag(data['network_country_code']);
    }
    if(present(data['network_contact_abuse']) || present(data['network_contact_email'])){
      if(item.length > 0){
        item += '<br>';
      }
      if(present(data['network_contact_email'])){
        item += '<a href="mailto:' + data['network_contact_email'] + '">' + data['network_contact_email'] + '</a>';
      }
      if(present(data['network_contact_abuse']) && data['network_contact_abuse'] != data['network_contact_email']){
        if(!item.endsWith('<br>')){
          item += '<br>';
        }
        item += '<a href="mailto:' + data['network_contact_abuse'] + '">' + data['network_contact_abuse'] + '</a>';
      }
    }
    $('#content-ip' + ip_version + '-network-contact').html(item);
  } else {
    $('#content-ip' + ip_version + '-network-contact').text('-');
  }

  if(present(data['as_number']) || present(data['network_contact_abuse']) || present(data['network_contact_email'])){
    item = '';
    if(present(data['as_number'])){
      item += '#' + data['as_number'] + '<br>';
    }
    if(present(data['as_peering_alias'])){
      item += data['as_peering_alias'] + '<br>';
    }
    if(present(data['as_peering_name'])){
      item += data['as_peering_name'] + '<br>';
    }
    if(present(data['as_peering_website'])){
      item += '<a href="' + data['as_peering_website'] + '" target="_blank">' + data['as_peering_website'].replace('https://', '').replace('http://', '') + '</a>';
    }
    $('#content-ip' + ip_version + '-as').html(item);
  } else {
    $('#content-ip' + ip_version + '-as').text('-');
  }
};

function flag(country_code){
  return '<img src="/assets/flags/' + country_code.toLowerCase() + '.svg" class="flag">';
};

function present(val){
  return !(val === undefined || val == null || val.length <= 0)
};

$(document).ready(function(){

  get_dns_data();

  $.ajax({
    url: location.protocol + '//ipv4.' + location.host + '/api/?lang=' + lang(),
    type: 'GET',
    crossDomain: true,
    success: function(data){
      fill_gui_ip_area(data, 'v4');
      ipv4_lat = data['lat'];
      ipv4_lon = data['lon'];
      init_map('ipv4', ipv4_lat, ipv4_lon);
    },
    error: function(error){
      fill_gui_ip_area(Array(), 'v4');
    }
  });

  $.ajax({
    url: location.protocol + '//ipv6.' + location.host + '/api/?lang=' + lang(),
    type: 'GET',
    crossDomain: true,
    success: function(data){
      fill_gui_ip_area(data, 'v6');
      ipv6_lat = data['lat'];
      ipv6_lon = data['lon'];
      init_map('ipv6', ipv6_lat, ipv6_lon);

    },
    error: function(error){
      fill_gui_ip_area(Array(), 'v6');
    }
  });
});
