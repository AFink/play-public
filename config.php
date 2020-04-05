<?php

define("_BOTCONN","http://127.0.0.1:8087");
define("_USERNAME","webUser");
define("_PASSWORD","yH>q]7rC+:g?$]Q#");
define("_INSTANCEUUID","4d7971ca-3638-e267-6bea-076b54fa637d");






$sinusbot = new SinusBot\API(_BOTCONN);
$sinusbot->login(_USERNAME, _PASSWORD);
$instance = $sinusbot->getInstanceByUUID(_INSTANCEUUID);
$instancenick = $instance->getNick();
$instancerunning = $instance->isRunning();
$instanceplaying = $instance->isPlaying();
$instancevolume = $instance->getVolume();
$instancecurrent = $instance->getCurrentTrack();

 ?>
