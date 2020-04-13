<?php include_once("../main.php");?>
<?php
$uuid = $instancecurrent->getUUID();

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'ytSearch':
      if (isset($_GET['q'])) {
        makeGoogle();
        youtubeSearch($_GET['q']);
      }
      break;
    case 'queueLength':
      echo(count($instance->getQueueTracks()));
      break;
    case 'changeVolume':
      if (isset($_GET['volume'])) {
        $instance->setVolume($_GET['volume']);
      }
      break;
    case 'togglerepeat':
      if ($instance->getRepeat()) {
        $instance->playRepeat(0);
      } else {
        $instance->playRepeat(1);
      }
      break;
    case 'toggleshuffle':
      if ($instance->getShuffle()) {
        $instance->playShuffle(0);
      } else {
        $instance->playShuffle(1);
      }
      break;
    case 'back':
      $instance->playPrevious();
      break;
    case 'forward':
      $instance->playNext();
      break;
    case 'play':
      if (strlen($uuid)>2) {
        $do = $instance->playTrack($uuid);
        $do["message"] = "hi";
        echo(json_encode($do));
      } else {
        echo(json_encode(array("success" => false, "message" => "Please select a file to be played")));
      }

      break;

    case 'stop':
      $instance->stop();
      break;
    default:
      // code...
      break;
  }
}


if (isset($_GET['playuuid'])) {
  $instance->playTrack($_GET['playuuid']);
}

if (isset($_GET['playurl'])) {
  print_r("a");
  $instance->playURL($_GET['playurl']);
}

if (isset($_GET['playpl'])) {
  if (isset($_GET['i'])) {
    $instance->playPlaylist($_GET['playpl'],$_GET['i']);
  }
}

if (isset($_GET['ytQueue'])) {
    $instance->ytEnq($_GET['ytQueue']);
}


if (isset($_GET['ytUrl'])) {
  $instance->ytPlay($_GET['ytUrl']);
}



if(isset($_POST['view'])){
  switch($_POST['view']){
    case 'player':
      playerJson();
      break;
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
