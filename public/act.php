<?php include_once("../config.php");?>
<?php
$uuid = $instancecurrent->getUUID();

if (isset($_GET['action'])) {
  switch ($_GET['action']) {
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
      if ($instance->isCurrentFromPlaylist()) {
        $instance->playPlaylist('"' . $instance->currentPlaylist() . '"',$instance->currentPlaylistTrackID());
      } else {
        $instance->playTrack($uuid);
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
  $instance->playURL($_GET['playurl']);
}

if (isset($_GET['playpl'])) {
  if (isset($_GET['i'])) {
    $instance->playPlaylist($_GET['playpl'],$_GET['i']);
  }
}

if (isset($_GET['ytUrl'])) {
  $instance->ytPlay($_GET['ytUrl']);
}


if(isset($_POST['view'])){
  switch($_POST['view']){
    case 'player':
      displayPlayer();
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


function displayFilesGrid(){
  global $files ?>
      <?php $i = 0; foreach ($files as $file):
        $i++;
      ?>
      <tr onclick="<?php if($file->getType() !== "folder"): ?>playFile('<?php echo $file->getUUID()?>')<?php else: ?>showFolder('<?php echo ($i-1) ?>')<?php endif;?>">
        <td><?php if($file->getType() !== "folder"): ?><img style="width:30px;height:30px;"src="//sinusbot.awedel.de<?php echo $file->getThumbnail(); ?>"><?php else: ?><svg class="bi bi-folder-fill" width="30px" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 011.992 2.181l-.637 7A2 2 0 0113.174 14H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 006.172 2H2.5a1 1 0 00-1 .981l.006.139z" clip-rule="evenodd"/></svg><?php endif;?></td>
        <td><?php echo $i?></td>
        <td><?php echo $file->getTitle(); ?></td>
        <td><?php if($file->getType() !== "folder"){echo msConv($file->getDuration());} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->getArtist();}else {echo "";} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->getAlbum();}else {echo "";} ?></td>
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
        <td><?php if($file->getType() !== "folder"): ?><img style="width:30px;height:30px;"src="//sinusbot.awedel.de<?php echo $file->getThumbnail(); ?>"><?php else: ?><svg class="bi bi-folder-fill" width="30px" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 011.992 2.181l-.637 7A2 2 0 0113.174 14H2.826a2 2 0 01-1.991-1.819l-.637-7a1.99 1.99 0 01.342-1.31L.5 3a2 2 0 012-2h3.672a2 2 0 011.414.586l.828.828A2 2 0 009.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 006.172 2H2.5a1 1 0 00-1 .981l.006.139z" clip-rule="evenodd"/></svg><?php endif;?></td>
        <td><?php echo $i?></td>
        <td><?php echo $file->getTitle(); ?></td>
        <td><?php if($file->getType() !== "folder"){echo msConv($file->getDuration());} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->array->artist;}else {echo "a";} ?></td>
        <td><?php if($file->getType() !== "folder"){echo $file->getAlbum();}else {echo "";} ?> <?php var_dump($file->array->artist) ?></td>
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
foreach ($playlists as $playlist) {
  $name = $playlist->getName();
  $count = count($playlist->getEntries());
  $uuid = $playlist->getUUID();
?>
    <li id="<?php echo $uuid ?>" onclick="showPlaylist('<?php echo $uuid ?>')" class=""><a class="ng-binding" ><?php echo $name ?><span class="badge pull-right ng-binding"><?php echo $count ?></span></a></li>


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
                         <td id="play" class="icon" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="Play()"><svg class="bi bi-play-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"/></svg></td>
                         <td id="stop" class="icon" style="vertical-align: middle; cursor: pointer;text-align:center;" onclick="Stop()"><svg class="bi bi-stop-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M5 3.5h6A1.5 1.5 0 0112.5 5v6a1.5 1.5 0 01-1.5 1.5H5A1.5 1.5 0 013.5 11V5A1.5 1.5 0 015 3.5z"/></svg></td>
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

?>
