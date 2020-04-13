<?php

include("../config.php");
displayPlayer2();
function displayPlayer2(){
  global $instancecurrent;
  global $instance;
  global $instancevolume;

  if ($instancecurrent->getDuration() !== "") {
    $duration = $instancecurrent->getDuration();
  }else {
    $duration = 999999999;
  }

  $out = [];
  $out["title"] = $instancecurrent->getTitle();
  $out["artist"] = $instancecurrent->getArtist();
  if ($instancecurrent->getThumbnail() != "") {
    $out["thumbnail"] = _SINUSURL . '/cache/' . $instancecurrent->getThumbnail();
  }else {
    $out["thumbnail"] = "";
  }
  $out["uuid"] = $instancecurrent->getUUID();
  $out["duration"] = $duration;
  $out["position"] = $instance->getPosition();
  $out["shuffle"] = $instance->getShuffle();
  $out["repeat"] = $instance->getRepeat();
  $out["playing"] = $instance->isPlaying();
  $out["volume"] = $instancevolume;


  echo(json_encode($out));

  };

?>
