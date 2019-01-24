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
  link_types = {
    'Ethernet or modem': 'Netzwerk oder Modem (vermutlich)',
    'PPPoE': 'PPPoE (vermutlich)',
    'L2TP': 'L2TP oder PPPoE (vermutlich)',
    'GIF': 'GIF (vermutlich)',
    'Probably IPsec or other VPN': 'IPsec oder anderes VPN (vermutlich)',
    'generic tunnel or VPN': 'Generischer Tunnel, VPN oder LTE (vermutlich)',
    'IPSec or GRE': 'IPSec oder Generic Routing Encapsulation (vermutlich)',
    'IPIP or SIT': 'IPIP oder SIT (vermutlich)',
    '': '-'
  }
  if (link_types[link_type] == undefined){
    return link_type + ' (vermutlich)';
  }
  else{
    return link_types[link_type];
  }
}

$(document).ready(function(){
  $.ajax({
    url: location.protocol + '//ipv4.' + location.host + '/ip.php',
    type: 'GET',
    crossDomain: true,
    success: function(data){
      $('#content-ipv4-ip').text(data);
      get_ipv4_host();
      get_ipv4_data(data);
    },
    error: function(error){
      $('#content-ipv4-ip').text('-');
      $('#content-ipv4-hostname').text('-');
      $('#content-ipv4-isp').text('-');
      $('#content-ipv4-as').text('-');
      $('#content-ipv4-country').text('-');
    }
  });

  $.ajax({
    url: location.protocol + '//ipv6.' + location.host + '/ip.php',
    type: 'GET',
    crossDomain: true,
    success: function(data){
      $('#content-ipv6-ip').html(data.replace(/:/g, ':<wbr>'));
      get_ipv6_host();
      get_ipv6_data(data);
    },
    error: function(error){
      $('#content-ipv6-ip').text('-');
      $('#content-ipv6-hostname').text('-');
      $('#content-ipv6-isp').text('-');
      $('#content-ipv6-as').text('-');
      $('#content-ipv6-country').text('-');
    }
  });

  get_dns_data();
  get_local_ip();
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

  function get_ipv4_data(ip) {
    $.ajax({
      url: location.protocol + '//' + location.host + '/geo.php?ip=' + ip,
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data && data.status && data.status == 'success') {
          $('#content-ipv4-isp').text(data.isp);
          $('#content-ipv4-as').text(data.as);
          $('#content-ipv4-country').html(data.zip + ' ' + data.city + ', ' + data.country + ' <img src="flags/' + data.countryCode.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">');
          $('#map-ipv4').addClass('map-height');
          init_map_ipv4(data.lat, data.lon);
        }
        else {
          $('#content-ipv4-isp').text('-');
          $('#content-ipv4-as').text('-');
          $('#content-ipv4-country').text('-');
        }
      }
    });
  };

  function get_ipv6_data(ip) {
    $.ajax({
      url: location.protocol + '//' + location.host + '/geo.php?ip=' + ip,
      type: 'GET',
      crossDomain: true,
      success: function(data){
        if (data && data.status && data.status == 'success') {
          $('#content-ipv6-isp').text(data.isp);
          $('#content-ipv6-as').text(data.as);
          $('#content-ipv6-country').html(data.zip + ' ' + data.city + ', ' + data.country + ' <img src="flags/' + data.countryCode.toLowerCase() + '.svg" width="20" height="16" style="margin-bottom: 2px;">');
          $('#map-ipv6').addClass('map-height');
          init_map_ipv6(data.lat, data.lon);
        }
        else {
          $('#content-ipv6-isp').text('-');
          $('#content-ipv6-as').text('-');
          $('#content-ipv6-country').text('-');
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

  function get_local_ip() {
    var RTCPeerConnection = /*window.RTCPeerConnection ||*/ window.webkitRTCPeerConnection || window.mozRTCPeerConnection;
    if (RTCPeerConnection) (function () {
      var rtc = new RTCPeerConnection({iceServers:[]});
      if (1 || window.mozRTCPeerConnection) {
        rtc.createDataChannel('', {reliable:false});
      };

      rtc.onicecandidate = function (evt) {
        if (evt.candidate) grepSDP('a='+evt.candidate.candidate);
      };
      rtc.createOffer(function (offerDesc) {
        grepSDP(offerDesc.sdp);
        rtc.setLocalDescription(offerDesc);
      }, function (e) { console.warn('offer failed', e); });

      var addrs = [];
      function updateDisplay(newAddr) {
        if (newAddr != '0.0.0.0' && addrs.indexOf(newAddr) == -1) {
          addrs.push(newAddr);
        }
        $('#content-local-ip').text(addrs.join(', ') || '-');
      }

      function grepSDP(sdp) {
        var hosts = [];
        sdp.split('\r\n').forEach(function (line) {
          if (~line.indexOf('a=candidate')) {
            var parts = line.split(' '),
              addr = parts[4],
              type = parts[7];
            if (type === 'host') updateDisplay(addr);
          } else if (~line.indexOf('c=')) {
            var parts = line.split(' '),
              addr = parts[2];
            updateDisplay(addr);
          }
        });
      }
    })(); else {
      $('#content-local-ip').text('-');
    }
  };
});
