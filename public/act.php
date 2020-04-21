<?php require_once("../main.php");

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
        echo(json_encode(array("status" => "error", "message" => "No query set.")));
      }
      break;
    case 'changeVolume':
      if (isset($_GET['volume'])) {
        if($instance->setVolume($_GET['volume'])["success"]){
          echo(json_encode(array("status" => "success", "message" => "Volume set to " . $_GET['volume'])));
        }else {
          echo(json_encode(array("status" => "error", "message" => "Volume couldn't be set")));
        }
        ;
      }else {
        echo(json_encode(array("status" => "error", "message" => "No volume provided")));
      }
      break;
    case 'togglerepeat':
      if ($instance->getRepeat()) {
        if ($instance->playRepeat(0)["success"]) {
          echo(json_encode(array("status" => "success", "message" => "Repeat is now toggled off.")));
        }else {
          echo(json_encode(array("status" => "error", "message" => "Repeat couldn't be disabled")));
        }

      } else {
        if ($instance->playRepeat(1)["success"]) {
          echo(json_encode(array("status" => "success", "message" => "Repeat is now toggled on.")));
        }else {
          echo(json_encode(array("status" => "error", "message" => "Repeat couldn't be enabled")));
        }
      }
      break;
    case 'toggleshuffle':
      if ($instance->getShuffle()) {
        if ($instance->playShuffle(0)["success"]) {
          echo(json_encode(array("status" => "success", "message" => "Shuffle is now toggled off.")));
        }else {
          echo(json_encode(array("status" => "error", "message" => "Shuffle couldn't be disabled")));
        }

      } else {
        if ($instance->playShuffle(1)["success"]) {
          echo(json_encode(array("status" => "success", "message" => "Shuffle is now toggled on.")));
        }else {
          echo(json_encode(array("status" => "error", "message" => "Shuffle couldn't be enabled")));
        }
      }
      break;
    case 'back':
      if ($instance->playPrevious()["success"]) {
        echo(json_encode(array("status" => "success", "message" => "Previous played.")));
      }else {
        echo(json_encode(array("status" => "error", "message" => "Previous couldn't be played")));
      }
      break;
    case 'forward':
      if ($instance->playNext()["success"]) {
        echo(json_encode(array("status" => "success", "message" => "Next played.")));
      }else {
        echo(json_encode(array("status" => "error", "message" => "Next couldn't be played")));
      }
      break;
    case 'play':
      if (strlen($uuid)>2) {
        if ($instance->playTrack($uuid)["success"]) {
          echo(json_encode(array("status" => "success", "message" => "File played")));
        }else {
          echo(json_encode(array("status" => "error", "message" => "File couldn't be played.")));
        }
      } else {
        echo(json_encode(array("status" => "error", "message" => "Please select somethig to play")));
      }
      break;
    case 'stop':
      if ($instance->stop()["success"]) {
        echo(json_encode(array("status" => "success", "message" => "Playback stopped.")));
      }else {
        echo(json_encode(array("status" => "error", "message" => "Playback couldn't be stopped.")));
      }
      break;
    default:
      break;
  }
}


if (isset($_GET['playuuid'])) {
  if ($instance->playTrack($_GET['playuuid'])["success"]) {
    echo(json_encode(array("status" => "success", "message" => "File played")));
  }else {
    echo(json_encode(array("status" => "error", "message" => "File couldn't be played.")));
  }
}

if (isset($_GET['playurl'])) {
  if ($instance->playURL($_GET['playurl'])["success"]) {
    echo(json_encode(array("status" => "success", "message" => "Radio played")));
  }else {
    echo(json_encode(array("status" => "error", "message" => "Radio couldn't be played.")));
  }
}

if (isset($_GET['playpl'])) {
  if (isset($_GET['i'])) {
    if ($instance->playPlaylist($_GET['playpl'],$_GET['i'])["success"]) {
      echo(json_encode(array("status" => "success", "message" => "Playlist-item played")));
    }else {
      echo(json_encode(array("status" => "error", "message" => "Playlist-item couldn't be played.")));
    }
  }echo(json_encode(array("status" => "error", "message" => "Playlist-item couldn't be played")));
}

if (isset($_GET['ytQueue'])) {
    if ($instance->ytEnq($_GET['ytQueue'])[0]["success"]) {
      echo(json_encode(array("status" => "success", "message" => "Video added to queue")));
    }else {
      echo(json_encode(array("status" => "error", "message" => "Video couldn't be added to queue.")));
    }
}

if (isset($_GET['ytUrl'])) {
  if ($instance->ytPlay($_GET['ytUrl'])[0]["success"]) {
    echo(json_encode(array("status" => "success", "message" => "Video will be played soon")));
  }else {
    echo(json_encode(array("status" => "error", "message" => "Video couldn't be played.")));
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
