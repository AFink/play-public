<?php
try {
  require_once 'vendor/autoload.php';
} catch (\Exception $e) {
  echo "run composer install to let this work.";
  exit();
}
try {
  require_once 'sinusbot-api-php/src/autoload.php';
} catch (\Exception $e) {
  echo "sinusbot-api not found";
  exit();
}

try {
  require_once 'config.php';
} catch (\Exception $e) {
  echo "You need to copy the config.php.example to config.php and edit it to work.";
  exit();
}
try {
  require_once 'includes/language.php';
  $language = New Language();
  $lang =  $language->userLanguage();
  $langinfo = $language->getLangInfo();
} catch (\Exception $e) {
  echo "Error while loading language";
  exit();
}

require_once 'includes/functions.php';


try {
  makeSinusbot();
} catch (\Exception $e) {
  echo "That Logindata (URL, USERNAME, PASSWORD) are wrong, ore you don't have permissions to login. Please check the config.php!";
  exit();
}



try {
  $iUUID = selectInstance();
  $instance = $sinusbot->getInstanceByUUID($iUUID);
} catch (\Exception $e) {
  echo "That Instance " . $iUUID . " can not be found. Please check the config.php!";
  exit();
}
try {
  $instancenick = $instance->getNick();
  $instancerunning = $instance->isRunning();
  $instanceplaying = $instance->isPlaying();
  $instancevolume = $instance->getVolume();
  $instancecurrent = $instance->getCurrentTrack();
} catch (\Exception $e) {
  echo "You have no rights to see the instance - information.";
  exit();
}



?>
