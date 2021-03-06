<?php
require_once("../main.php");

$uuid = $instancecurrent->getUUID();

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'getData':
      echo(getData());
      break;
    case 'ytSearch':
      if (isset($_GET['q'])) {
        makeGoogle();
        youtubeSearch($_GET['q']);
      }else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["youtube"]["noqueryset"])));
      }
      break;
    case 'changeVolume':
      if (isset($_GET['volume'])) {
        if($instance->setVolume($_GET['volume'])["success"]){
          echo(json_encode(array("status" => "success", "message" =>$lang["alert"]["instance"]["volumesetto"] . " " . $_GET['volume'])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["volumecantset"])));
        }
        ;
      }else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["novolumeprovided"])));
      }
      break;
    case 'togglerepeat':
      if ($instance->getRepeat()) {
        if ($instance->playRepeat(0)["success"]) {
          echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["repeatoff"])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["repeatcantoff"])));
        }

      } else {
        if ($instance->playRepeat(1)["success"]) {
          echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["repeaton"])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["repeatcanton"])));
        }
      }
      break;
    case 'toggleshuffle':
      if ($instance->getShuffle()) {
        if ($instance->playShuffle(0)["success"]) {
          echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["shuffleoff"])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["shufflecantoff"])));
        }

      } else {
        if ($instance->playShuffle(1)["success"]) {
          echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["shuffleon"])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["shufflecanton"])));
        }
      }
      break;
    case 'back':
      if ($instance->playPrevious()["success"]) {
        echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playprevious"])));
      }else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayprevious"])));
      }
      break;
    case 'forward':
      if ($instance->playNext()["success"]) {
        echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playnext"])));
      }else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplaynext"])));
      }
      break;
    case 'play':
      if (strlen($uuid)>2) {
        if ($instance->playTrack($uuid)["success"]) {
          echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playfile"])));
        }else {
          echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayfile"])));
        }
      } else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["selecttoplay"])));
      }
      break;
    case 'stop':
      if ($instance->stop()["success"]) {
        echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["stop"])));
      }else {
        echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantstop"])));
      }
      break;
    default:
      break;
  }
}


if (isset($_GET['playuuid'])) {
  if ($instance->playTrack($_GET['playuuid'])["success"]) {
    echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playfile"])));
  }else {
    echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayfile"])));
  }
}

if (isset($_GET['playurl'])) {
  if ($instance->playURL($_GET['playurl'])["success"]) {
    echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playradio"])));
  }else {
    echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayradio"])));
  }
}

if (isset($_GET['playpl'])) {
  if (isset($_GET['i'])) {
    if ($instance->playPlaylist($_GET['playpl'],$_GET['i'])["success"]) {
      echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["playfile"])));
    }else {
      echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayfile"])));
    }
  }echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantplayfile"])));
}

if (isset($_GET['ytQueue'])) {
    if ($instance->ytEnq($_GET['ytQueue'])[0]["success"]) {
      echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["ytqueue"])));
    }else {
      echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantytqueue"])));
    }
}

if (isset($_GET['ytUrl'])) {
  if ($instance->ytPlay($_GET['ytUrl'])[0]["success"]) {
    echo(json_encode(array("status" => "success", "message" => $lang["alert"]["instance"]["ytplay"])));
  }else {
    echo(json_encode(array("status" => "error", "message" => $lang["alert"]["instance"]["cantytplay"])));
  }
}



if(isset($_POST['view'])){
  switch($_POST['view']){
    case 'playlists':
      displayPlaylists();
      break;
    case 'queue':
      displayQueueGrid();
      break;
    case 'folder':
      if (isset($_POST['folders'])) {
        $folderIndexs = $_POST['folders'];
        $folder = $sinusbot->getFiles()[$folderIndexs[0]];
        unset($folderIndexs[0]);
        foreach ($folderIndexs as $folderIndex) {
          $folder = $folder->getChildren()[$folderIndex];
        }
        $files = $folder->getChildren();
        displayFolderGrid();
      }
      break;
    case 'playlist':
      if (isset($_POST['uuid'])) {
        $playlistUUID = $_POST['uuid'];
        $playlist = $sinusbot->getPlaylistByUUID($playlistUUID);
        $files = $playlist->getEntries();
        displayPlGrid();
      }

      break;
    case 'files':
    default:
      $files = $sinusbot->getFiles();
      displayFilesGrid();
      break;
  }
}
?>
