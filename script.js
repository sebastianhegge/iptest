function init_map_ipv4(lat, lng) {
  var uluru = {lat: lat, lng: lng};
  var map_ipv4 = new google.maps.Map(document.getElementById('map-ipv4'), {
    zoom: 10,
    center: uluru
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map_ipv4
  });
}
function init_map_ipv6(lat, lng) {
  var uluru = {lat: lat, lng: lng};
  var map_ipv6 = new google.maps.Map(document.getElementById('map-ipv6'), {
    zoom: 10,
    center: uluru
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map_ipv6
  });
}

function translate_link_type(link_type){
  var lang = navigator.language || navigator.userLanguage;
  lang = lang.substr(0,2);
  if(lang == 'de'){
    var link_types = {
      'Ethernet or modem': 'Netzwerk oder Modem',
      'L2TP': 'L2TP oder PPPoE',
      'Probably IPsec or other VPN': 'IPsec oder anderes VPN',
      'generic tunnel or VPN': 'Generischer Tunnel, VPN oder LTE',
      'IPSec or GRE': 'IPSec oder Generic Routing Encapsulation',
      'IPIP or SIT': 'IPIP oder SIT',
      '': '-'
    }
  } else {
    var link_types = {
      'Ethernet or modem': 'Netzwerk or Modem',
      'L2TP': 'L2TP or PPPoE',
      'Probably IPsec or other VPN': 'IPsec or other VPN',
      'generic tunnel or VPN': 'Generic Tunnel, VPN or LTE',
      'IPSec or GRE': 'IPSec or Generic Routing Encapsulation',
      '': '-'
    }
  }
  if(lang == 'de'){
    var probably = ' (vermutlich)';
  } else {
    var probably = ' (probably)';
  }

  if (link_types[link_type] == undefined){
    return link_type + probably;
  }
  else{
    return link_types[link_type] + probably;
  }
}

function format_isp(data){
  isp = '';
  if(present(data.isp_website)){
    isp = '<a href="' + data.isp_website + '" target="_blank">' + data.isp + '</a>';
  }
  else{
    isp = data.isp;
  }
  if(present(data.zip)){
    if(isp.substr(-5) != '<br/>'){
      isp += '<br/>';
    }
    isp += data.zip;
  }
  if(present(data.city)){
    if(present(data.zip)){
      isp += ' ';
    }
    else if(isp.substr(-5) != '<br/>'){
      isp += '<br/>';
    }
    isp += data.city;
  }
  if(present(data.country)){
    if(isp.substr(-5) != '<br/>'){
      isp += '<br/>';
    }
    isp += data.country + ' <img src="flags/' + data.country_code.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">';
  }
  return isp;
}

function format_as(data){
  as = '';
  if(present(data.as_number)){
    as += '#' + data.as_number;
  }
  if(present(data.as_name)){
    if(present(data.as_number)){
      as += ', ';
    }
    as += data.as_name;
  }
  if(present(data.as_number)){
    if(as.substr(-5) != '<br/>'){
      as += '<br/>';
    }
    as += data.as_organisation;
  }
  if(present(data.as_street)){
    if(as.substr(-5) != '<br/>'){
      as += '<br/>';
    }
    as += data.as_street;
  }
  if(present(data.as_zip)){
    if(as.substr(-5) != '<br/>'){
      as += '<br/>';
    }
    as += data.as_zip;
  }
  if(present(data.as_city)){
    if(present(data.as_zip)){
      as += ' ';
    }
    as += data.as_city;
  }
  if(present(data.as_country)){
    if(as.substr(-5) != '<br/>'){
      as += '<br/>';
    }
    as += data.as_country + ' <img src="flags/' + data.as_country_code.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">';
  }
  return as;
}

function present(val){
  return !(val === undefined || val == null || val.length <= 0)
}

$(document).ready(function(){
  $.ajax({
    url: location.protocol + '//ipv4.' + location.host + '/ip.php',
    type: 'GET',
    crossDomain: true,
    success: function(data){
      $('#content-ipv4-ip').text(data);
      get_ipv4_host();
      get_ipv4_data();
    },
    error: function(error){
      $('#content-ipv4-ip').text('-');
      $('#content-ipv4-hostname').text('-');
      $('#content-ipv4-ip-network').text('-');
      $('#content-ipv4-isp').text('-');
      $('#content-ipv4-as').text('-');
    }
  });

  $.ajax({
    url: location.protocol + '//ipv6.' + location.host + '/ip.php',
    type: 'GET',
    crossDomain: true,
    success: function(data){
      $('#content-ipv6-ip').html(data.replace(/:/g, ':<wbr>'));
      get_ipv6_host();
      get_ipv6_data();
    },
    error: function(error){
      $('#content-ipv6-ip').text('-');
      $('#content-ipv6-hostname').text('-');
      $('#content-ipv6-ip-network').text('-');
      $('#content-ipv6-isp').text('-');
      $('#content-ipv6-as').text('-');
    }
  });

  get_dns_data();
  get_fingerprint();

  function get_ipv4_host() {
    $.ajax({
      url: location.protocol + '//ipv4.' + location.host + '/host.php',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data == $('#content-ipv4-ip').text()) {
          $('#content-ipv4-hostname').text('-');
        }
        else{
          $('#content-ipv4-hostname').text(data);
        }
      },
      error: function(error){
        $('#content-ipv4-hostname').text('-');
      }
    });
  }

  function get_ipv6_host() {
    $.ajax({
      url: location.protocol + '//ipv6.' + location.host + '/host.php',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data == $('#content-ipv6-ip').text()) {
          $('#content-ipv6-hostname').text('-');
        }
        else{
          $('#content-ipv6-hostname').text(data);
        }
      },
      error: function(error){
        $('#content-ipv6-hostname').text('-');
      }
    });
  };

  function get_ipv4_data() {
    $.ajax({
      url: location.protocol + '//ipv4.' + location.host + '/geo.php',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data && data.status && data.status == 'success') {
          $('#content-ipv4-ip-network').text(data.ip_network);
          $('#content-ipv4-isp').html(format_isp(data));
          $('#content-ipv4-as').html(format_as(data));
          /* $('#content-ipv4-country').html(data.zip + ' ' + data.city + ', ' + data.country + ' <img src="flags/' + data.country_code.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">'); */
          $('#map-ipv4').addClass('map-height');
          init_map_ipv4(data.lat, data.lon);
        }
        else {
          $('#content-ipv4-ip-network').text('-');
          $('#content-ipv4-isp').text('-');
          $('#content-ipv4-as').text('-');
        }
      }
    });
  };

  function get_ipv6_data(ip) {
    $.ajax({
      url: location.protocol + '//ipv6.' + location.host + '/geo.php',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data && data.status && data.status == 'success') {
          $('#content-ipv6-ip-network').text(data.ip_network);
          $('#content-ipv6-isp').html(format_isp(data));
          $('#content-ipv6-as').html(format_as(data));
          /* $('#content-ipv6-country').html(data.zip + ' ' + data.city + ', ' + data.country + ' <img src="flags/' + data.country_code.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">'); */
          $('#map-ipv6').addClass('map-height');
          init_map_ipv6(data.lat, data.lon);
        }
        else {
          $('#content-ipv6-ip-network').text('-');
          $('#content-ipv6-isp').text('-');
          $('#content-ipv6-as').text('-');
        }
      }
    });
  };

  function get_dns_data() {
    var random_string = '';
    for (i = 0; i < 32; i++) {
      random_string += '0123456789abcdefghijklmnopqrstuvwxyz'[Math.round(Math.random() * 35)]
    }
    $.ajax({
      url: location.protocol + '//' + random_string + '.edns.ip-api.com/json?lang=de',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        $.ajax({
          url: location.protocol + '//' + location.host + '/geo.php?ip=' + data.dns.ip,
          type: 'GET',
          crossDomain: true,
          success: function(data2){
            if (data2 && data2.status && data2.status == 'success') {
              $('#content-dns').html(data.dns.ip + ' (' + data2.isp + ' <img src="flags/' + data2.countryCode.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">)');
            }
            else {
              $('#content-dns').text('-');
            }
          }
        });
        if(data && data.edns){
          $.ajax({
            url: location.protocol + '//' + location.host + '/geo.php?ip=' + data.edns.ip,
            type: 'GET',
            crossDomain: true,
            success: function(data3){
              if (data3 && data3.status && data3.status == 'success') {
                $('#content-edns').html(data.edns.ip + ' (' + data3.isp + ' <img src="flags/' + data3.countryCode.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">)');
              }
              else {
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

  function get_fingerprint(){
    $.ajax({
      url: 'http://fp.ip-api.com/json',
      type: 'GET',
      crossDomain: true,
      success: function(data){
        $('#content-mtu').text(data.link_mtu);
        $('#content-link-type').text(translate_link_type(data.link_type));
      },
      error: function(error){
        $('#content-mtu').text('-');
        $('#content-link-type').text('-');
      }
    });
  };
});
