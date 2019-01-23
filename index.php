<?php
include 'config.php';

$browscap = get_browser(null, true);
$browscap_translation = [
  'device_type' => [
    'Console' => 'Konsole',
    'TV Device' => 'TV Gerät',
    'Tablet' => 'Tablet',
    'Mobile Phone' => 'Smartphone',
    'Mobile Device' => 'Mobiles Gerät',
    'Desktop' => 'Desktop',
    'Ebook Reader' => 'E-Book Reader',
    'Car Entertainment System' => 'Autoradio',
    'Digital Camera' => 'Digitalkamera'
  ]
];

if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'curl')!==false){
  print($_SERVER['REMOTE_ADDR']."\n");
  if($_SERVER['REMOTE_ADDR'] != gethostbyaddr($_SERVER['REMOTE_ADDR'])){ 
    print(gethostbyaddr($_SERVER['REMOTE_ADDR'])."\n");
  }
}
else {
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="jquery/jquery-3.3.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

    <title>IP Test</title>
  </head>
  <body>
    <div class="container mb-4">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header text-center">
              <h4 class="my-0"><?php print($_SERVER['HTTP_HOST']); ?></h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">Verbindung über:</th>
                    <td id="content-ip-version"><?php if(strpos($_SERVER['REMOTE_ADDR'], ":")){print('IPv6');} else{print('IPv4');} ?></td>
                  </tr>
                  <tr>
                    <th scope="row">DNS-Server:</th>
                    <td id="content-dns"><img src="loader.gif" width="16" height="16" id="loader-dns"></td>
                  </tr>
                  <tr>
                    <th scope="row">EDNS-Subnetz:</th>
                    <td id="content-edns"><img src="loader.gif" width="16" height="16" id="loader-dns"></td>
                  </tr>
                  <tr>
                    <th scope="row">Lokale IPs:</th>
                    <td id="content-local-ip"><img src="loader.gif" width="16" height="16" id="loader-local-ip"></td>
                  </tr>
                  <tr>
                    <th scope="row">MTU:</th>
                    <td id="content-mtu"><img src="loader.gif" width="16" height="16" id="loader-mtu"></td>
                  </tr>
                  <tr>
                    <th scope="row">Anschluss-Typ:</th>
                    <td id="content-link-type"><img src="loader.gif" width="16" height="16" id="loader-link-type"></td>
                  </tr>
                  <tr>
                    <th scope="row">User-Agent:</th>
                    <td id="content-user-agent"><small><?php print($_SERVER['HTTP_USER_AGENT']); ?></small></td>
                  </tr>
                  <tr>
                    <th scope="row">Geräte-Typ:</th>
                    <td id="content-os"><?php print($browscap_translation['device_type'][$browscap['device_type']]); ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Betriebssystem:</th>
                    <td id="content-os"><?php print($browscap['platform']); ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Browser:</th>
                    <td id="content-os"><?php print($browscap['browser']); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
          <div class="card mt-4">
            <div class="card-header">
              <h4 class="my-0">IPv4</h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">IP:</th>
                    <td id="content-ipv4-ip"><img src="loader.gif" width="16" height="16" id="loader-ipv4-ip"></td>
                  </tr>
                  <tr>
                    <th scope="row">Hostname:</th>
                    <td id="content-ipv4-hostname"><img src="loader.gif" width="16" height="16" id="loader-ipv4-hostname"></td>
                  </tr>
                  <tr>
                    <th scope="row">ISP:</th>
                    <td id="content-ipv4-isp"><img src="loader.gif" width="16" height="16" id="loader-ipv4-isp"></td>
                  </tr>
                  <tr>
                    <th scope="row">AS:</th>
                    <td id="content-ipv4-as"><img src="loader.gif" width="16" height="16" id="loader-ipv4-as"></td>
                  </tr>
                  <tr>
                    <th scope="row">Adresse:</th>
                    <td id="content-ipv4-country"><img src="loader.gif" width="16" height="16" id="loader-ipv4-country"></td>
                  </tr>
                </tbody>
              </table>
              <div id="map-ipv4">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
          <div class="card mt-4">
            <div class="card-header">
              <h4 class="my-0">IPv6</h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">IP:</th>
                    <td id="content-ipv6-ip"><img src="loader.gif" width="16" height="16" id="loader-ipv6-ip"></td>
                  </tr>
                  <tr>
                    <th scope="row">Hostname:</th>
                    <td id="content-ipv6-hostname"><img src="loader.gif" width="16" height="16" id="loader-ipv6-hostname"></td>
                  </tr>
                  <tr>
                    <th scope="row">ISP:</th>
                    <td id="content-ipv6-isp"><img src="loader.gif" width="16" height="16" id="loader-ipv6-isp"></td>
                  </tr>
                  <tr>
                    <th scope="row">AS:</th>
                    <td id="content-ipv6-as"><img src="loader.gif" width="16" height="16" id="loader-ipv6-as"></td>
                  </tr>
                  <tr>
                    <th scope="row">Adresse:</th>
                    <td id="content-ipv6-country"><img src="loader.gif" width="16" height="16" id="loader-ipv6-country"></td>
                  </tr>
                </tbody>
              </table>
              <div id="map-ipv6">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header card-header-no-border text-center">
              &copy; Sebastian Hegge &middot; <a href="https://heg.ge/impressum" target="_blank">Impressum & Datenschutz</a> &middot; <a href="https://github.com/sebastianhegge/iptest" target="_blank">Source on GitHub</a> &middot; v1.5
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php print(GOOGLE_MAPS_API_KEY); ?>"></script>
  </body>
</html>
<?php
}
?>