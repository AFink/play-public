<?php


define("_SINUSURL","https://sinusbot.andreasfink.xyz");
define("_USERNAME","webUser");
define("_PASSWORD","yH>q]7rC+:g?$]Q#");
define("_INSTANCEUUID","4d7971ca-3638-e267-6bea-076b54fa637d");




include_once("../includes/sinusbot/autoload.php");

$sinusbot = new SinusBot\API(_SINUSURL);
$sinusbot->login(_USERNAME, _PASSWORD);
$instance = $sinusbot->getInstanceByUUID(_INSTANCEUUID);
$instancenick = $instance->getNick();
$instancerunning = $instance->isRunning();
$instanceplaying = $instance->isPlaying();
$instancevolume = $instance->getVolume();
$instancecurrent = $instance->getCurrentTrack();




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
