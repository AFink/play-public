<?php
class Language {

  private $path = '../langs/';
  private $extention = '.json';
  private $UserLng;
  private $langSelected;
  private $lang;
  private $langinfo;
  private $langs;


  public function __construct($path = null, $extention = null){
    if ($path !== null) {
      $this->path = $path;
    }
    if ($extention !== null) {
      $this->extention = $extention;
    }
      if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
      }elseif (isset($_COOKIE["lang"])) {
        $lang = $_COOKIE["lang"];
      }else {
        $lang = null;
      }
      $this->UserLng = $this->detectLang($this->getExistingLangs(), 'en', $lang, false);
      setcookie("lang", $this->UserLng, time()+2*24*60*60, "/");
      $langFile = $this->path . $this->UserLng . $this->extention;
      if(!file_exists($langFile)){
        throw new \Execption("Language could not be loaded");
      }

      $file = file_get_contents($langFile);
      $filecontent = json_decode($file, true);
      $this->langinfo = $filecontent["langinfo"];
      $this->lang = $filecontent["translations"];
  }

  private function detectLang($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
    if ($lang_variable === null) {
      $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    if (empty($lang_variable)) {
      return $default_language;
    }

    $accepted_languages = preg_split('/,\s*/', $lang_variable);

    $current_lang = $default_language;
    $current_q = 0;

    foreach ($accepted_languages as $accepted_language) {
      $res = preg_match (
        '/^([a-z]{1,8}(?:-[a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i',
        $accepted_language,
        $matches
      );

      if (!$res) {
        continue;
      }
      $lang_code = explode ('-', $matches[1]);

      if (isset($matches[2])) {
        $lang_quality = (float)$matches[2];
      } else {
        $lang_quality = 1.0;
      }

      while (count ($lang_code)) {
        if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
          if ($lang_quality > $current_q) {
            $current_lang = strtolower (join ('-', $lang_code));
            $current_q = $lang_quality;
            break;
          }
        }
        if ($strict_mode) {
          break;
        }
        array_pop ($lang_code);
      }
    }
    return $current_lang;
  }


  public function getExistingLangs(){
    $files = scandir($this->path);
    $files = array_diff($files, array('.', '..'));
    $files = array_values($files);
    $this->langs = str_replace($this->extention, "", $files);
    return $this->langs;
  }

  public function getSpecificLangInfo($l){
    $langFile = $this->path . $l . $this->extention;
    if(!file_exists($langFile)){
      throw new \Execption("Language could not be found");
    }

    $file = file_get_contents($langFile);
    $filecontent = json_decode($file, true);
    return $filecontent["langinfo"];
  }

  public function getLangInfo(){
    return $this->langinfo;
  }

  public function userLanguage(){
      return $this->lang;
  }

}
 ?>
