<?php header_web($nonce); ?>
<!doctype html>
<html lang="<?php p(lang()); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css?v=5.2.3" nonce="<?php p($nonce); ?>">

    <script src="/assets/bootstrap/js/bootstrap.min.js?v=5.2.3" nonce="<?php p($nonce); ?>"></script>

    <title>IP Test</title>
  </head>
  <body class="bg-secondary">

    <div class="modal modal-sheet position-static d-block py-5" tabindex="-1" role="dialog" id="modalSheet">
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
          <form method="post" action="">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title"><?php tp('Cookie & Privacy Notice'); ?></h5>
            </div>
            <div class="modal-body py-0">
              <p><?php tp('This website uses cookies to store these settings.'); ?></p>
              <div class="card border-danger mb-3">
                <div class="card-body text-danger">
                  <p class="card-text"><?php tp('This website can only be used if consent is given to the use of all required services.'); ?></p>
                </div>
              </div>
              <p><?php tp('Please select and accept the usage of'); ?>:</p>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="checkbox_ipapi" id="checkbox_ipapi" checked>
                  <label class="form-check-label" for="checkbox_ipapi">
                    <?php tp('The services provided by'); ?> <a href="https://ip-api.com" target="_blank">ip-api.com</a>*
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="checkbox_peeringdb" id="checkbox_peeringdb" checked>
                  <label class="form-check-label" for="checkbox_peeringdb">
                    <?php tp('The services provided by'); ?> <a href="https://www.peeringdb.com" target="_blank">www.peeringdb.com</a>*
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="checkbox_ripe" id="checkbox_ripe" checked>
                  <label class="form-check-label" for="checkbox_ripe">
                    <?php tp('The services provided by'); ?> <a href="https://www.ripe.net" target="_blank">www.ripe.net</a>*
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="checkbox_userstack" id="checkbox_userstack" checked>
                  <label class="form-check-label" for="checkbox_userstack">
                    <?php tp('The services provided by'); ?> <a href="https://userstack.com" target="_blank">userstack.com</a>*
                  </label>
              </div>
              <p>* <?php tp('required'); ?></p>
              <?php if(OPENSTREETMAP_ACTIVE || APPLE_MAPS_ACTIVE || GOOGLE_MAPS_ACTIVE){ ?>
              <p><?php tp('Please select a Map Service'); ?>:</p>
              <?php if(OPENSTREETMAP_ACTIVE){ ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="openstreetmap" name="checkbox_mapservice" id="checkbox_mapservice_openstreetmap" checked>
                  <label class="form-check-label" for="checkbox_mapservice_openstreetmap">
                    OpenStreetMap DE <a href="https://www.openstreetmap.de" target="_blank">www.openstreetmap.de</a>
                  </label>
              </div>
              <?php } ?>
              <?php if(APPLE_MAPS_ACTIVE){ ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="applemaps" name="checkbox_mapservice" id="checkbox_mapservice_applemaps"<?php if(!OPENSTREETMAP_ACTIVE){ ?>checked<?php } ?>>
                  <label class="form-check-label" for="checkbox_mapservice_applemaps">
                    Apple Maps <a href="https://maps.apple.com" target="_blank">maps.apple.com</a>
                  </label>
              </div>
              <?php } ?>
              <?php if(GOOGLE_MAPS_ACTIVE){ ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="googlemaps" name="checkbox_mapservice" id="checkbox_mapservice_googlemaps"<?php if(!OPENSTREETMAP_ACTIVE && !APPLE_MAPS_ACTIVE){ ?>checked<?php } ?>>
                  <label class="form-check-label" for="checkbox_mapservice_googlemaps">
                    Google Maps <a href="https://www.google.de/maps" target="_blank">www.google.de/maps</a>
                  </label>
              </div>
              <?php } ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" value="no_map" name="checkbox_mapservice" id="checkbox_mapservice_no_map">
                  <label class="form-check-label" for="checkbox_mapservice_no_map">
                    <?php tp('No map service'); ?>
                  </label>
              </div>
              <?php } ?>
            </div>
            <div class="modal-footer flex-column border-top-0">
              <button type="submit" class="btn btn-lg btn-success w-100 mx-0 mb-2"><?php tp('Accept'); ?></button>
              <a type="button" class="btn btn-lg btn-danger w-100 mx-0 mb-2" href="about:blank"><?php tp('Leave Website'); ?></a>
              <a href="https://heg.ge/impressum" target="_blank"><?php tp('Imprint & Privacy policy'); ?></a>
            </div>
          </form>
        </div>
      </div>
    </div>

  </body>
</html>
