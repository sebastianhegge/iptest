<?php header_web($nonce); ?>
<!doctype html>
<html lang="<?php p(lang()); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3.8" nonce="<?php p($nonce); ?>">
    <link rel="stylesheet" href="/assets/style.css?v=ed3fa593f1e4ee247f460648029f0860" nonce="<?php p($nonce); ?>">

    <script type="text/javascript" nonce="<?php p($nonce); ?>">
      var GOOGLE_MAPS_ACTIVE = <?php p(json_encode($GLOBALS['GOOGLE_MAPS_ACTIVE'])); ?>;
    </script>

    <script src="/assets/jquery/jquery-3.7.1.min.js" nonce="<?php p($nonce); ?>"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3.8" nonce="<?php p($nonce); ?>"></script>
    <script src="/assets/script.js?v=aca71d1a8a1fc19ccd3eb4ec27f1d336" nonce="<?php p($nonce); ?>"></script>
    <?php activate_google_maps($nonce); ?>

    <title>IP Test</title>
  </head>
  <body>

    <div class="container mb-4">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header text-bg-secondary text-center">
              <h4 class="my-0"><?php p($_SERVER['HTTP_HOST']); ?></h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">User-Agent:</th>
                    <td id="content-user-agent"><small><?php p($_SERVER['HTTP_USER_AGENT']); ?></small></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Device type'); ?>:</th>
                    <td id="content-device-type"><?php mp([$data['client_device_type'], $data['client_device']], ' - '); ?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Operating system'); ?>:</th>
                    <td id="content-os"><?php p($data['client_device_os']); ?></td>
                  </tr>
                  <tr>
                    <th scope="row">Browser:</th>
                    <td id="content-browser"><?php mp([$data['client_browser_name'], $data['client_browser_major_version']]); ?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Language'); ?>:</th>
                    <td id="content-language"><?php p(lang_string()); ?></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Connection via'); ?>:</th>
                    <td id="content-ip-version">IP<?php p($data['ip_version']); ?></td>
                  </tr>
                  <tr>
                    <th scope="row">DNS-Server:</th>
                    <td id="content-dns"><img src="/assets/loader.gif" width="16" height="16" id="loader-dns"></td>
                  </tr>
                  <tr>
                    <th scope="row">EDNS-Subnetz:</th>
                    <td id="content-edns"><img src="/assets/loader.gif" width="16" height="16" id="loader-edns"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
          <div class="card mt-4">
            <div class="card-header text-bg-secondary text-center">
              <h4 class="my-0">IPv4</h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">IP:</th>
                    <td id="content-ipv4-ip"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-ip"></td>
                  </tr>
                  <tr>
                    <th scope="row">Hostname:</th>
                    <td id="content-ipv4-hostname"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-hostname"></td>
                  </tr>
                  <tr>
                    <th scope="row">ISP:</th>
                    <td id="content-ipv4-isp"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-isp"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Address'); ?>:</th>
                    <td id="content-ipv4-address"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-address"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row">MTU:</th>
                    <td id="content-ipv4-mtu"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-mtu"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Connection type'); ?>:</th>
                    <td id="content-ipv4-connection-type"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-connection-type"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Hop distance'); ?>:</th>
                    <td id="content-ipv4-distance"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-distance"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network'); ?>:</th>
                    <td id="content-ipv4-network"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-network"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network name'); ?>:</th>
                    <td id="content-ipv4-network-name"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-network-name"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network contact'); ?>:</th>
                    <td id="content-ipv4-network-contact"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-network-contact"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Autonomous system'); ?>:</th>
                    <td id="content-ipv4-as"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv4-as"></td>
                  </tr>
                  <?php if($GLOBALS['GOOGLE_MAPS_ACTIVE']){ ?>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php if($GLOBALS['GOOGLE_MAPS_ACTIVE']){ ?>
              <div id="map-ipv4">
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6">
          <div class="card mt-4">
            <div class="card-header text-bg-secondary text-center">
              <h4 class="my-0">IPv6</h4>
            </div>
            <div class="card-body">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">IP:</th>
                    <td id="content-ipv6-ip"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-ip"></td>
                  </tr>
                  <tr>
                    <th scope="row">Hostname:</th>
                    <td id="content-ipv6-hostname"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-hostname"></td>
                  </tr>
                  <tr>
                    <th scope="row">ISP:</th>
                    <td id="content-ipv6-isp"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-isp"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Address'); ?>:</th>
                    <td id="content-ipv6-address"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-address"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row">MTU:</th>
                    <td id="content-ipv6-mtu"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-mtu"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Connection type'); ?>:</th>
                    <td id="content-ipv6-connection-type"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-connection-type"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Hop distance'); ?>:</th>
                    <td id="content-ipv6-distance"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-distance"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network'); ?>:</th>
                    <td id="content-ipv6-network"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-network"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network name'); ?>:</th>
                    <td id="content-ipv6-network-name"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-network-name"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Network contact'); ?>:</th>
                    <td id="content-ipv6-network-contact"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-network-contact"></td>
                  </tr>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <th scope="row"><?php tp('Autonomous system'); ?>:</th>
                    <td id="content-ipv6-as"><img src="/assets/loader.gif" width="16" height="16" id="loader-ipv6-as"></td>
                  </tr>
                  <?php if($GLOBALS['GOOGLE_MAPS_ACTIVE']){ ?>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php if($GLOBALS['GOOGLE_MAPS_ACTIVE']){ ?>
              <div id="map-ipv6">
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header card-header-no-border text-center">
              &copy; Sebastian Hegge &middot; <a href="https://heg.ge/impressum" target="_blank"><?php tp('Imprint & Privacy policy'); ?></a> &middot; <a href="https://github.com/sebastianhegge/iptest" target="_blank"><?php tp('Source on GitHub'); ?></a> &middot; v4.0
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
