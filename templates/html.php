<?php header_web($nonce); ?>
<!doctype html>
<html lang="<?php p(lang()); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.3.8" nonce="<?php p($nonce); ?>">
    <link rel="stylesheet" href="/assets/style.css?v=ed3fa593f1e4ee247f460648029f0860" nonce="<?php p($nonce); ?>">

    <?php export_vars_to_js($nonce); ?>

    <script src="/assets/jquery/jquery-3.7.1.min.js" nonce="<?php p($nonce); ?>"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.3.8" nonce="<?php p($nonce); ?>"></script>
    <script src="/assets/script.js?v=aca71d1a8a1fc19ccd3eb4ec27f1d336" nonce="<?php p($nonce); ?>"></script>
    <?php activate_map_service($nonce); ?>

    <title>IP Test</title>
  </head>
  <body>


    <div class="modal fade" id="api-doc" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Documentation</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <h4>Usage</h4>
            <p>The API is very easy to use - simply append <code>/api</code> to the URL.</p>
            <p>You can optionally provide a specific IP address using the <code>ip</code> parameter, as well as the desired response language using the <code>lang</code> parameter.<br>Alternatively, you can use the ipv4- or ipv6-specific subdomains to retrieve information about the corresponding address type:</p>
            <p><code><?php p($_SERVER['REQUEST_SCHEME']); ?>://<?php p($_SERVER['HTTP_HOST']); ?>/api?<span class="text-success">lang</span>=<span class="text-primary">de</span>&amp;<span class="text-success">ip</span>=<span class="text-primary">185.222.222.222</span></code></p>
            <p><code><?php p($_SERVER['REQUEST_SCHEME']); ?>://<?php p($_SERVER['HTTP_HOST']); ?>/api?<span class="text-success">lang</span>=<span class="text-primary">en</span>&amp;<span class="text-success">ip</span>=<span class="text-primary">2a09::</span></code></p>
            <p><code><?php p($_SERVER['REQUEST_SCHEME']); ?>://ipv4.<?php p($_SERVER['HTTP_HOST']); ?>/api?<span class="text-success">lang</span>=<span class="text-primary">de</span></code></p>
            <p><code><?php p($_SERVER['REQUEST_SCHEME']); ?>://ipv6.<?php p($_SERVER['HTTP_HOST']); ?>/api?<span class="text-success">lang</span>=<span class="text-primary">en</span></code></p>
            <p><br>You can also use curl to retrieve IP address information from CLI:</p>
            <p><code>curl <?php p($_SERVER['HTTP_HOST']); ?></code></p>
            <p><code>curl -4 <?php p($_SERVER['HTTP_HOST']); ?></code></p>
            <p><code>curl -6 <?php p($_SERVER['HTTP_HOST']); ?>?<span class="text-success">ip</span>=<span class="text-primary">185.222.222.222</span></code></p>
            <p><code>curl "<?php p($_SERVER['HTTP_HOST']); ?>?<span class="text-success">ip</span>=<span class="text-primary">2a09::</span>&<span class="text-success">lang</span>=<span class="text-primary">en</span>"</code></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div class="container mb-4">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header text-bg-secondary text-center position-relative">
              <h4 class="my-0"><?php p($_SERVER['HTTP_HOST']); ?></h4>
              <div class="position-absolute top-50 end-0 translate-middle-y me-2 d-flex gap-2">
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#api-doc">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-code" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.646 5.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 8 8.646 6.354a.5.5 0 0 1 0-.708m-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 8l1.647-1.646a.5.5 0 0 0 0-.708"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                  </svg>
                </button>
                <form method="post" action="/">
                  <button type="submit" class="btn btn-outline-light btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                      <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                    </svg>
                  </button>
                </form>
              </div>
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
                  <?php if(isset($_COOKIE['MAP_SERVICE']) && $_COOKIE['MAP_SERVICE'] != 'no_map'){ ?>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php if(isset($_COOKIE['MAP_SERVICE']) && $_COOKIE['MAP_SERVICE'] != 'no_map'){ ?>
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
                  <?php if(isset($_COOKIE['MAP_SERVICE']) && $_COOKIE['MAP_SERVICE'] != 'no_map'){ ?>
                  <tr class="table-secondary">
                    <td colspan="2"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php if(isset($_COOKIE['MAP_SERVICE']) && $_COOKIE['MAP_SERVICE'] != 'no_map'){ ?>
              <div id="map-ipv6">
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
          <div class="card mt-4">
            <div class="card-header card-header-no-border text-center">
              &copy; Sebastian Hegge &middot; <a href="https://heg.ge/impressum" target="_blank"><?php tp('Imprint & Privacy policy'); ?></a> &middot; <a href="https://github.com/sebastianhegge/iptest" target="_blank"><?php tp('Source on GitHub'); ?></a> &middot; v5.0
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
