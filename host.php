<?php
header('Access-Control-Allow-Origin: *');
print(gethostbyaddr($_SERVER['REMOTE_ADDR']));
?>
