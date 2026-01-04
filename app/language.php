<?php
function lang(){
  if(isset($_GET['lang'])){
    $lang = mb_strtolower($_GET['lang']);
  } else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  } else {
    $lang = 'de';
  }
  if($lang != 'de'){
    $lang = 'en';
  }
  return $lang;
}

function lang_string(){
  if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    $local_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  } else {
    $local_lang = lang();
  }

  if($local_lang == lang()){
    $lang_string = locale_get_display_language($local_lang, $local_lang);
  } else{
    $lang_string = locale_get_display_language($local_lang, $local_lang)." (".locale_get_display_language($local_lang, lang()).")";
  }
  return $lang_string;
}
