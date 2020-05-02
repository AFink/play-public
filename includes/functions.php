<?php
/**
 *  for all :)
 */
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
 function cmpName($a, $b) {
     return strcmp(strtoupper($a->getName()), strtoupper($b->getName()));
 }

/**
 *  for config.php
 */

function makeSinusbot(){
  global $sinusbot;
  $sinusbot = new SinusBot\API(_SINUSURL);
  $sinusbot->login(_USERNAME, _PASSWORD);
}

function selectInstance(){
  global $lang;
  global $instanceUUID;
  global $sinusbot;
    if (isset($_POST['instance'])) {
      if(in_array($_POST['instance'],_INSTANCEUUIDS)){
        $instanceUUID = $_POST['instance'];
        $_SESSION['instance'] = $instanceUUID;
        if (isset($_POST["extra"])) {
          if ($_POST["extra"] == "showMsg") {

            echo(json_encode(array("status" => "success", "message" => $lang["instance-selected1"] . "\"" . $sinusbot->getInstanceByUUID($instanceUUID)->getNick() ."\"" . $lang["instance-selected2"] . ".")));
          }
        }
      }else if (isset($_SESSION['instance'])){
          $instanceUUID = $_SESSION['instance'];
      }else {
        $instanceUUID = _INSTANCEUUIDS[0];
      }
    } else if (isset($_SESSION['instance'])){
        $instanceUUID = $_SESSION['instance'];
    } else {
      $instanceUUID = _INSTANCEUUIDS[0];
    }
    return $instanceUUID;
}

function makeGoogle(){
  global $googleClient;
  global $youtube;
  $googleClient = new Google_Client();
  $googleClient->setDeveloperKey(_DEVELOPER_KEY);
  $youtube = new Google_Service_YouTube($googleClient);
}


/**
 *  for includes/navbar.php
 */


function getInstanceDropdown(){
  global $lang;
  global $sinusbot;
  global $instanceUUID; ?>
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo($sinusbot->getInstanceByUUID($instanceUUID)->getNick()) ?>
    </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="left:auto;right:0;">
  <?php
  foreach (_INSTANCEUUIDS as $uuid) {
    $instance = $sinusbot->getInstanceByUUID($uuid);
    $nick = $instance->getNick(); ?>
      <a class="dropdown-item" onclick="chooseInstance('<?php echo($uuid) ?>')"><?php echo($nick) ?></a>
    <?php
  }
  ?>
   </div>
   <?php
}

function getInstanceList(){
  global $lang;
  global $sinusbot;
  global $instanceUUID;
  global $iUUID;
  foreach (_INSTANCEUUIDS as $uuid) {
    $instance = $sinusbot->getInstanceByUUID($uuid);
    $nick = $instance->getNick(); ?>
    <li class="nav-item <?php if($uuid == $iUUID){echo("active");} ?>">
      <a class="nav-link" id="<?php echo($uuid) ?>" onclick="chooseInstance('<?php echo($uuid) ?>')"><?php echo($nick) ?></a>
    </li>
    <?php
  }
}

function getLangDropdown()
{
  global $language;
  foreach ($language->getExistingLangs() as $key) {
    $info = $language->getSpecificLangInfo($key);
    if ($info["code"] != $language->getLangInfo()["code"]) {
      // code...

      ?>
      <a class="dropdown-item" onclick="selectLang("<?php echo $info["code"] ?>")"><?php echo $info["display"] ?></a>
      <?php
    }
  }
}

function getLangList()
{
  ?>
  <li class="nav-item d-inline-block d-md-none">
    <a class="nav-link" href="#">German</a>
  </li>
  <li class="nav-item d-inline-block d-md-none">
    <a class="nav-link" href="#">German</a>
  </li>
  <li class="nav-item d-inline-block d-md-none">
    <a class="nav-link" href="#">German</a>
  </li>
  <li class="nav-item d-inline-block d-md-none">
    <a class="nav-link" href="#">German</a>
  </li>
  <?php
}
/**
 *  for public/act.php
 */


function displayFilesGrid(){
  global $lang;
  global $files;
    $i = 0;
    foreach ($files as $file):
        $i++;
      ?>
      <tr id="<?php echo $file->getUUID()?>" onclick="<?php if($file->getType() !== "folder"): ?>playFile('<?php echo $file->getUUID()?>')<?php else: ?>showFolder('<?php echo ($i-1) ?>')<?php endif;?>">
        <td><?php if($file->getType() !== "folder"): ?><img style="width:30px;height:30px;"src="<?php echo _SINUSURL . "/cache/" . $file->getThumbnail(); ?>"><?php else: ?><svg class="bi bi-folder-fill" width="30px" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 011.992 2.181l-.637 7A2 2 0 0113.174 14H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 006.172 2H2.5a1 1 0 00-1 .981l.006.139z" clip-rule="evenodd"/></svg><?php endif;?></td>
        <td><?php echo $i?></td>
        <td><?php echo $file->getTitle(); ?></td>
        <td><?php if($file->getType() !== "folder"){echo msConv($file->getDuration());} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->getArtist();}else {echo "";} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->getAlbum();}else {echo "";} ?></td>
      </tr>
      <?php endforeach;
    if ($i === 0):?>
    <tr>
      <td></td>
      <td></td>
      <td><?php $lang["filestable-nothingfound"] ?></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>


  <?php endif;
};

function displayFolderGrid(){
  global $lang;
  global $folders;?>
  <tr onclick="folderBack()">
    <td><svg class="bi bi-folder-fill" width="30px" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 011.992 2.181l-.637 7A2 2 0 0113.174 14H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 006.172 2H2.5a1 1 0 00-1 .981l.006.139z" clip-rule="evenodd"/></svg></td>
    <td></td>
    <td>..</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>


  <?php global $files;
   $i = 0; foreach ($files as $file):

        $i++;
      ?>
      <tr <?php if($file->getType() !== "folder"): ?>id="<?php echo $file->getUUID()?>" onclick="playFile('<?php echo $file->getUUID()?>')<?php else: ?>onclick="showFolder('<?php echo ($i-1) ?>')<?php endif;?>">
        <td><?php if($file->getType() !== "folder"): ?><img style="width:30px;height:30px;"src="<?php echo _SINUSURL . "/cache/" . $file->getThumbnail(); ?>"><?php else: ?><svg class="bi bi-folder-fill" width="30px" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 011.992 2.181l-.637 7A2 2 0 0113.174 14H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 006.172 2H2.5a1 1 0 00-1 .981l.006.139z" clip-rule="evenodd"/></svg><?php endif;?></td>
        <td><?php echo $i?></td>
        <td><?php echo $file->getTitle(); ?></td>
        <td><?php if($file->getType() !== "folder"){ echo msConv($file->getDuration()); } ?></td>
       <td><?php if($file->getType() !== "folder"){ echo $file->getArtist();}else {echo "a"; } ?></td>
        <td><?php if($file->getType() !== "folder"){ echo $file->getAlbum();}else {echo ""; } ?></td>
      </tr>
      <?php endforeach;?>
  <?php
  if ($i === 0):?>
  <tr>
    <td></td>
    <td></td>
    <td><?php $lang["foldertable-nothingfound"] ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>


  <?php endif;

};

function displayPlGrid(){
  global $lang;
  global $playlistUUID;
  global $files;?>
      <?php $i = 0; foreach ($files as $file):
        $i++;
      ?>
      <tr onclick="playPl('<?php echo $playlistUUID ?>',<?php echo $i-1 ?>)">
        <td></td>
        <td><?php echo $i?></td>
        <td><?php echo $file['title']; ?></td>
        <td>0:00</td>
        <td><?php echo $file['artist']?></td>
        <td><?php echo $file['album']?></td>
      </tr>
      <?php endforeach;
    if ($i === 0):?>
    <tr>
      <td></td>
      <td></td>
      <td><?php $lang["playlist-nothingfound"] ?></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  <?php endif;
}

function displayQueueGrid(){
  global $lang;
  global $instance;
  $i = 0; foreach ($instance->getQueueTracks() as $file):
    $i++;
  ?>
  <tr id="<?php echo $file['uuid']; ?>">
    <td></td>
    <td><?php echo $i?></td>
    <td><?php echo $file['title']; ?></td>
    <td><?php echo msconv($file['duration']) ?></td>
    <td><?php echo $file['artist']?></td>
    <td><?php echo $file['album']?></td>
  </tr>
  <?php endforeach;
  if ($i === 0):?>
  <tr>
    <td></td>
    <td></td>
    <td><?php $lang["queue-nothingfound"] ?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>


  <?php endif;

}

function displayPlaylists(){
  global $lang;
  global $sinusbot;

  $playlists = $sinusbot->getPlaylists();


  usort($playlists, "cmpName");

  foreach ($playlists as $playlist) {
    $name = $playlist->getName();
    $count = count($playlist->getEntries());
    $uuid = $playlist->getUUID();
  ?>
    <li id="<?php echo $uuid ?>" onclick="showPlaylist('<?php echo $uuid ?>')"><a><?php echo $name ?><span class="badge float-right align-middle ml-auto"><?php echo $count ?></span></a></li>
  <?php
  };
};

function getData(){
    global $instancecurrent;
    global $instance;
    global $instancevolume;
    global $instancerunning;

    if ($instancecurrent->getDuration() !== "") {
      $duration = $instancecurrent->getDuration();
    }else {
      $duration = 999999999;
    }

    $out = [];

    if($instancecurrent->getType() == "url")
    {
      $out["title"] = $instancecurrent->getTempTitle();
      $out["artist"] = $instancecurrent->getTempArtist();
    }else {
      $out["title"] = $instancecurrent->getTitle();
      $out["artist"] = $instancecurrent->getArtist();
    }
    if ($instancecurrent->getThumbnail() == "") {
    $out["thumbnail"] = "none";
    }else {

        $out["thumbnail"] = _SINUSURL . '/cache/' . $instancecurrent->getThumbnail();
    }
    $out["uuid"] = $instancecurrent->getUUID();
    $out["duration"] = $duration;
    $out["position"] = $instance->getPosition();
    $out["shuffle"] = $instance->getShuffle();
    $out["repeat"] = $instance->getRepeat();
    $out["playing"] = $instance->isPlaying();
    $out["volume"] = $instancevolume;
    $out["queueLength"] = count($instance->getQueueTracks());
    $out["running"] = $instancerunning;
    $out["instanceuuid"] = $instance->getUUID();


    return json_encode($out);

  };    //enable this function

function youtubeSearch($q){
  global $lang;
  // Define an object that will be used to make all API requests.
  if (isset($_GET['pageToken'])) {
    $pageToken = $_GET['pageToken'];
  }else {
    $pageToken = "";
  }
  global $youtube;
    try {
      $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $q,
        'maxResults' => _MAXRESULTS,
        'type' => 'video',
        'pageToken' => $pageToken,
      ));

      // Add each result to the appropriate list, and then display the lists of
      // matching videos, channels, and playlists.
      //
      foreach ($searchResponse['items'] as $searchResult) {
        $title = $searchResult['snippet']['title'];
        $videourl = "https://www.youtube.com/watch?v=" . $searchResult['id']['videoId'];
        $channeltitle = $searchResult['snippet']['channelTitle'];
        $channelurl = "https://www.youtube.com/channel/" . $searchResult['snippet']['channeltitle'];
        $thumbnailurl = $searchResult['snippet']['thumbnails']['high']['url'];

  ?>
  <div class="item col-xs-4 col-lg-4">
      <div class="thumbnail card">
          <div class="img-event">
              <img class="group list-group-image img-fluid" src="<?php echo $thumbnailurl ?>" alt="" />
          </div>
          <div class="caption card-body">
              <h4 class="group card-title inner list-group-item-heading">
                  <?php echo $title ?></h4>
              <p class="group inner list-group-item-text">
                <?php echo $channeltitle ?>
              </p>
              <div class="row">
                  <div class="col-xs-12 col-md-12">
                      <a id="playBtn" class="btn btn-success" onclick="ytPlay('<?php echo $videourl ?>')"><?php echo $lang["youtube"]["play"] ?></a>
                      <a id="enqueueBtn" class="btn btn-success" onclick="ytQueue('<?php echo $videourl ?>')"><?php echo $lang["youtube"]["queue"] ?></a>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <?php
        }
        ?>
        <script type="text/javascript">
          var nextPageToken = "<?php echo $searchResponse['nextPageToken'] ?>";
        </script>
        <?php

      } catch (Google_Service_Exception $e) {
        handleGoogleExeption($e);
      } catch (Google_Exception $e) {
        handleGoogleExeption($e);
      }
  }

function handleGoogleExeption($e){
  $json = json_decode($e->getMessage());
  $reason = $json->error->errors[0]->reason;
  switch ($reason) {
    case 'quotaExceeded':
      $title = $lang["youtube"]["quotaexeeded"]["title"];
      $message = $lang["youtube"]["quotaexeeded"]["msg"];
      break;

    default:
      $title = $lang["youtube"]["error"]["title"];
      $message = $lang["youtube"]["error"]["msg"];
      break;
  }
  echo(json_encode(array("status" => "error", "title" => $title, "message" => $message)));
}

?>
