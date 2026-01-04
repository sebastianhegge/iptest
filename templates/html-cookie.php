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
              <h5 class="modal-title">Cookie- &amp; Datenschutz-Hinweis</h5>
            </div>
            <div class="modal-body py-0">
              <p>Diese Webseite setzt ein Cookie, um diese Einstellung zu speichern.</p>
              <p>Bitte wählen und akzeptieren sie die Nutzung:</p>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="checkbox_ipapi" id="checkbox_ipapi" checked disabled>
                  <label class="form-check-label" for="checkbox_ipapi">
                    Die Nutzung der Dienste von <a href="https://ip-api.com" target="_blank">ip-api.com</a>
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="checkbox_peeringdb" id="checkbox_peeringdb" checked disabled>
                  <label class="form-check-label" for="checkbox_peeringdb">
                    Die Nutzung der Dienste von <a href="https://www.peeringdb.com" target="_blank">www.peeringdb.com</a>
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="checkbox_ripe" id="checkbox_ripe" checked disabled>
                  <label class="form-check-label" for="checkbox_ripe">
                    Die Nutzung der Dienste von <a href="https://www.ripe.net" target="_blank">www.ripe.net</a>
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="checkbox_userstack" id="checkbox_userstack" checked disabled>
                  <label class="form-check-label" for="checkbox_userstack">
                    Die Nutzung der Dienste von <a href="https://userstack.com" target="_blank">userstack.com</a>
                  </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" name="checkbox_googlemaps" id="checkbox_googlemaps" checked>
                  <label class="form-check-label" for="checkbox_googlemaps">
                    Die Nutzung der Dienste von <a href="https://www.google.de/maps" target="_blank">www.google.de/maps</a>
                  </label>
              </div>
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
