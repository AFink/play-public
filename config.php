<?php


define("_SINUSURL","https://sinusbot.andreasfink.xyz");
define("_USERNAME","webUser");
define("_PASSWORD","yH>q]7rC+:g?$]Q#");
define("_INSTANCEUUID","38feb4a3-99df-15e9-5cd0-06d73137141f");
define("_MAXRESULTS", 25);



include_once("../includes/sinusbot/autoload.php");
require_once '../includes/vendor/autoload.php';

$sinusbot = new SinusBot\API(_SINUSURL);
$sinusbot->login(_USERNAME, _PASSWORD);
$instance = $sinusbot->getInstanceByUUID(_INSTANCEUUID);
$instancenick = $instance->getNick();
$instancerunning = $instance->isRunning();
$instanceplaying = $instance->isPlaying();
$instancevolume = $instance->getVolume();
$instancecurrent = $instance->getCurrentTrack();

$googleClient = null;
$youtube = null;
function makeGoogle(){
  global $googleClient;
  global $youtube;
  $googleClient = new Google_Client();
  $googleClient->setDeveloperKey(_DEVELOPER_KEY);
  $youtube = new Google_Service_YouTube($googleClient);
}



function msConv($ms){
$uSec = $ms % 1000;
$ms = floor($ms / 1000);

$seconds = $ms % 60;
if ($seconds <10) {
  $seconds = "0" . $seconds;
}
$ms = floor($ms / 60);

$minutes = $ms % 60;
if ($minutes <10) {
  $minutes = "0" . $minutes;
}
$ms = floor($ms / 60);

$hour = $ms ;
if ($hour == 0) {
  $hour = "";
}else {
  if ($hour<10) {
    $hour = "0" . $hour . ":";
  }else {
    $hour = $hour . ":";
  }
}
return $hour . $minutes . ":" . $seconds;
}
 ?>
