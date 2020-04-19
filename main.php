<?php
require_once 'vendor/autoload.php';
require_once 'sinusbot-api-php/src/autoload.php';
require_once 'includes/functions.php';
require_once 'config.php';
session_start();

makeSinusbot();


$instance = $sinusbot->getInstanceByUUID(selectInstance());
$instancenick = $instance->getNick();
$instancerunning = $instance->isRunning();
$instanceplaying = $instance->isPlaying();
$instancevolume = $instance->getVolume();
$instancecurrent = $instance->getCurrentTrack();


?>
