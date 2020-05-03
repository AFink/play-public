<?php
class Language {

  private $UserLng;
  private $langSelected;
  private $lang;
  private $langinfo;
  private $langs;


  public function __construct(){
      if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
        echo $lang;
      }elseif (isset($_SESSION["lang"])) {
        $lang = $_SESSION["lang"];
      }else {
        $lang = null;
      }
      echo $lang;
      $this->UserLng = $this->detectLang($this->getExistingLangs(), 'de', $lang, false);
      echo $this->UserLng;
      $_SESSION["lang"] = $this->UserLng;
      //construct lang file
      $langFile = '../langs/'. $this->UserLng . '.json';
      if(!file_exists($langFile)){
        throw new Execption("Language could not be loaded"); //or default to a language
      }

      $file = file_get_contents($langFile);
      $filecontent = json_decode($file, true);
      $this->langinfo = $filecontent["langinfo"];
      $this->lang = $filecontent["translations"];
  }

  private function detectLang($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
      // $_SERVER['HTTP_ACCEPT_LANGUAGE'] verwenden, wenn keine Sprachvariable mitgegeben wurde
      if ($lang_variable === null) {
        $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
      }

      // wurde irgendwelche Information mitgeschickt?
      if (empty($lang_variable)) {
        // Nein? => Standardsprache zurückgeben
        return $default_language;
      }

      // Den Header auftrennen
      $accepted_languages = preg_split('/,\s*/', $lang_variable);

      // Die Standardwerte einstellen
      $current_lang = $default_language;
      $current_q = 0;

      // Nun alle mitgegebenen Sprachen abarbeiten
      foreach ($accepted_languages as $accepted_language=>$accepted_language2) {
        // Alle Infos über diese Sprache rausholen
        $res = preg_match (
          '/^([a-z]{1,8}(?:-[a-z]{1,8})*)(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i',
          $accepted_language,
          $matches
        );

        // war die Syntax gültig?
        if (!$res) {
          // Nein? Dann ignorieren
          continue;
        }

        // Sprachcode holen und dann sofort in die Einzelteile trennen
        $lang_code = explode ('-', $matches[1]);

        // Wurde eine Qualität mitgegeben?
        if (isset($matches[2])) {
          // die Qualität benutzen
          $lang_quality = (float)$matches[2];
        } else {
          // Kompabilitätsmodus: Qualität 1 annehmen
          $lang_quality = 1.0;
        }

        // Bis der Sprachcode leer ist...
        while (count ($lang_code)) {
          // mal sehen, ob der Sprachcode angeboten wird
          if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
            // Qualität anschauen
            if ($lang_quality > $current_q) {
              // diese Sprache verwenden
              $current_lang = strtolower (join ('-', $lang_code));
              $current_q = $lang_quality;
              // Hier die innere while-Schleife verlassen
              break;
            }
          }
          // Wenn wir im strengen Modus sind, die Sprache nicht versuchen zu minimalisieren
          if ($strict_mode) {
            // innere While-Schleife aufbrechen
            break;
          }
          // den rechtesten Teil des Sprachcodes abschneiden
          array_pop ($lang_code);
        }
      }

      // die gefundene Sprache zurückgeben
      return $current_lang;
  }


  public function getExistingLangs(){
    $path    = '../langs/';
    $files = scandir($path);
    $files = array_diff(scandir($path), array('.', '..'));
    $this->langs = str_replace(".json", "", $files);
    return $this->langs;
  }

  public function getSpecificLangInfo($l){
    $langFile = '../langs/'. $l . '.json';
    if(!file_exists($langFile)){
      throw new Execption("Language could not be found");
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
