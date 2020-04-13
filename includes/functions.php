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

function selectInstance(){
  global $instanceUUID;
    if (isset($_POST['instance'])) {
      var_dump($_POST['instance']);
      if(in_array($_POST['instance'],_INSTANCEUUIDS)){
        $instanceUUID = $_POST['instance'];
        $_SESSION['instance'] = $instanceUUID;
      }
    } else if (isset($_SESSION['instance'])){
        $instanceUUID = $_SESSION['instance'];
    } else {
      $instanceUUID = _INSTANCEUUIDS[0];
    }
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
  global $sinusbot;
  global $instanceUUID;
  foreach (_INSTANCEUUIDS as $uuid) {
    $instance = $sinusbot->getInstanceByUUID($uuid);
    $nick = $instance->getNick(); ?>
    <li class="d-inline-block d-md-none"><a class="nav-link" id="<?php echo($uuid) ?>" onclick="chooseInstance('<?php echo($uuid) ?>')"><?php echo($nick) ?></a></li>
    <?php
  }
}
/**
 *  for public/act.php
 */


function displayFilesGrid(){
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
      <td>nothing found here</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>


  <?php endif;
};

function displayFolderGrid(){ global $folders;?>
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
      <tr onclick="<?php if($file->getType() !== "folder"): ?>playFile('<?php echo $file->getUUID()?>')<?php else: ?>showFolder('<?php echo ($i-1) ?>')<?php endif;?>">
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
    <td>nothing found here</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>


  <?php endif;

};

function displayPlGrid(){
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
      <td>nothing found here</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  <?php endif;
}

function displayQueueGrid(){
  global $instance;
  $i = 0; foreach ($instance->getQueueTracks() as $file):
    $i++;
  ?>
  <tr>
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
    <td>nothing found here</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>


  <?php endif;

}



function displayPlaylists(){
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

function displayPlayer(){
  global $instancecurrent;
  global $instance;
  global $instancevolume;
  $title = $instancecurrent->getTitle();
  $artist = $instancecurrent->getArtist();
  $thumbnail = $instancecurrent->getThumbnail();
  $uuid = $instancecurrent->getUUID();
  if ($instancecurrent->getDuration() !== "") {
    $duration = $instancecurrent->getDuration();
  }else {
    $duration = 999999999;
  }
  $position = $instance->getPosition();
  $shuffle = $instance->getShuffle();
  $repeat = $instance->getRepeat();
  ?>


   <div style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #eee; box-shadow: 0 -6px 8px rgba(0,0,0,0.14)" class="container-fluid foot-player ng-scope">
       <div class="progress" style="height:auto;">
           <div style="position: absolute; top: -5px; left: 0px; right: 0px; height: 5px;transition: all 1s ease-out;">
               <div class="progress-bar" id="progress" role="progressbar" style="height:5px; width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
           </div>
       </div>
       <div class="row"    style="height:60px;" >
           <div class="col-sm-5 trackinfo" style="padding-left:0;">
              <img style="float: left; width: 60px; height: 60px; margin-right: 15px;" class="ng-scope" src="<?php echo _SINUSURL ?><?php echo $thumbnail ?>">
               <h3 class="tracktitle ng-binding" style="margin: 8px 0 0; padding-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 23px;"><?php echo $title;?></h3>
               <h4 class="trackartist ng-binding" style="margin: -3px 0 0; padding-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 17px;"><?php echo $artist;?></h4>
               <!-- <div style="text-align: center; font-size: 0.8em">{{status.position | amDurationFormatTime:'seconds':true}}</div> -->
           </div>
           <div class="col-sm-3" style="text-align: center">
               <table style="height: 60px; width: 100%; background-color: transparent !important" class="responsive foot-controls">
                   <tbody>
                       <tr>
                         <td id="repeat" class="icon <?php if ($repeat) {echo "active";} ?>" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="toggleRepeat()"><svg class="bi bi-arrow-repeat" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 00-.708 0l-2 2a.5.5 0 10.708.708L2.5 8.207l1.646 1.647a.5.5 0 00.708-.708l-2-2zm13-1a.5.5 0 00-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 00-.708.708l2 2a.5.5 0 00.708 0l2-2a.5.5 0 000-.708z" clip-rule="evenodd"/> <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 00-4.192 2.273.5.5 0 01-.837-.546A6 6 0 0114 8a.5.5 0 01-1.001 0 5 5 0 00-5-5zM2.5 7.5A.5.5 0 013 8a5 5 0 009.192 2.727.5.5 0 11.837.546A6 6 0 012 8a.5.5 0 01.501-.5z" clip-rule="evenodd"/></svg></td>
                         <td id="back" class="icon" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="back()"><svg class="bi bi-skip-backward-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M.5 3.5A.5.5 0 000 4v8a.5.5 0 001 0V4a.5.5 0 00-.5-.5z" clip-rule="evenodd"/> <path d="M.904 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.692-1.01-1.233-.696L.904 7.304a.802.802 0 000 1.393z"/> <path d="M8.404 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.693-1.01-1.233-.696L8.404 7.304a.802.802 0 000 1.393z"/></svg></td>
                         <td id="play" class="icon" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="play()"><svg class="bi bi-play-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"/></svg></td>
                         <td id="stop" class="icon" style="vertical-align: middle; cursor: pointer;text-align:center;" onclick="stop()"><svg class="bi bi-stop-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M5 3.5h6A1.5 1.5 0 0112.5 5v6a1.5 1.5 0 01-1.5 1.5H5A1.5 1.5 0 013.5 11V5A1.5 1.5 0 015 3.5z"/></svg></td>
                         <td id="forward" class="icon" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="forward()"><svg class="bi bi-skip-forward-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M15.5 3.5a.5.5 0 01.5.5v8a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd"/> <path d="M7.596 8.697l-6.363 3.692C.693 12.702 0 12.322 0 11.692V4.308c0-.63.693-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"/> <path d="M15.096 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.693-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"/></svg></td>
                         <td id="shuffle" class="icon <?php if ($shuffle) {echo "active";} ?>" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="toggleShuffle()"><svg class="bi bi-shuffle" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.646 1.146a.5.5 0 01.708 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 01-.708-.708L14.793 4l-2.147-2.146a.5.5 0 010-.708zm0 8a.5.5 0 01.708 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 01-.708-.708L14.793 12l-2.147-2.146a.5.5 0 010-.708z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M0 4a.5.5 0 01.5-.5h2c3.053 0 4.564 2.258 5.856 4.226l.08.123c.636.97 1.224 1.865 1.932 2.539.718.682 1.538 1.112 2.632 1.112h2a.5.5 0 010 1h-2c-1.406 0-2.461-.57-3.321-1.388-.795-.755-1.441-1.742-2.055-2.679l-.105-.159C6.186 6.242 4.947 4.5 2.5 4.5h-2A.5.5 0 010 4z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M0 12a.5.5 0 00.5.5h2c3.053 0 4.564-2.258 5.856-4.226l.08-.123c.636-.97 1.224-1.865 1.932-2.539C11.086 4.93 11.906 4.5 13 4.5h2a.5.5 0 000-1h-2c-1.406 0-2.461.57-3.321 1.388-.795.755-1.441 1.742-2.055 2.679l-.105.159C6.186 9.758 4.947 11.5 2.5 11.5h-2a.5.5 0 00-.5.5z" clip-rule="evenodd"/></svg></td>
                       </tr>
                   </tbody>
               </table>
           </div>
           <div class="col-sm-1" style="text-align: right">

           </div>
           <div class="col-sm-2" style="text-align: right">
               <input type="range" min="0" max="100" step="5" value="<?php echo $instancevolume ?>" data-rangeslider="" style="position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0;">

           </div>
           <div class="col-sm-1" style="font-size: 22px; text-align: right; cursor: pointer;">
               <div style="margin-top: 12px;"><span class="tracktime" id="position"></span></div>
           </div>
       </div>
       <div class="bottom-gap"></div>
   </div>

  <script type="text/javascript">
  var position = <?php echo $position ?>;
  var duration = <?php echo $duration ?>;
  var playing = <?php if($instance->isPlaying()){echo "true";}else{echo "false";} ?>;
  updateValues();

  </script>


  <?php };
function playerJson(){
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


    echo(json_encode($out));

  };    //enable this function

function getCurrentBotStatus(){
  if ($instancerunning) {
    echo(json_encode(array('running' => true, )));
  }
}


function youtubeSearch($q){
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
                      <a id="playBtn" class="btn btn-success" onclick="ytPlay('<?php echo $videourl ?>')">Play</a>
                      <a id="enqueueBtn" class="btn btn-success" onclick="ytQueue('<?php echo $videourl ?>')">add to queue</a>
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
      $title = "ERROR: Youtube-API";
      $message = "Zu viele Requests! Probiere einen anderen API-Key oder versuche es morgen erneut.";
      break;

    default:
      $message = "error";
      break;
  }
  echo(json_encode(array("status" => "error", "title" => $title, "message" => $message)));
}

?>
