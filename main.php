<?php


define("_SINUSURL","https://sinusbot.andreasfink.xyz");
define("_USERNAME","webUser");
define("_PASSWORD","yH>q]7rC+:g?$]Q#");
define("_INSTANCEUUIDS",array("38feb4a3-99df-15e9-5cd0-06d73137141f","3efa09aa-112f-3327-d728-9db7defc4c36"));
define("_MAXRESULTS", 25);
define("_DEVELOPER_KEY", "AIzaSyALeP3J11Rex2L9I0xOnqpYPjBwdIuhkBQ");

session_start();

require_once '../vendor/autoload.php';
require_once '../includes/functions.php';


selectInstance();



$sinusbot = new SinusBot\API(_SINUSURL);
$sinusbot->login(_USERNAME, _PASSWORD);
$instance = $sinusbot->getInstanceByUUID($instanceUUID);
$instancenick = $instance->getNick();
$instancerunning = $instance->isRunning();
$instanceplaying = $instance->isPlaying();
$instancevolume = $instance->getVolume();
$instancecurrent = $instance->getCurrentTrack();



 ?>
