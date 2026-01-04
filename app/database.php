<?php
$GLOBALS['db'] = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.';charset=utf8', DB_USER, DB_PASSWORD);

function db_delete_old($table, $days = 91){
  $x = $GLOBALS['db']->prepare("DELETE FROM ".$table." WHERE `created_at` < TIMESTAMP(DATE_SUB(NOW(), INTERVAL :days day));");
  $x->bindParam(':days', $days, PDO::PARAM_INT, $days);
  $x->execute();
}
