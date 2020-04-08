<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php

include_once("./src/php/sinusbot/autoload.php");
include("config.php");

$title = $instancecurrent->getTitle();
$artist = $instancecurrent->getArtist();
$thumbnail = $instancecurrent->getThumbnail();
$uuid = $instancecurrent->getUUID();
$duration = $instancecurrent->getDuration();
$position = $instance->getPosition();

function msToMin($ms){
$input = $ms;
$uSec = $input % 1000;
$input = floor($input / 1000);

$seconds = $input % 60;
if($seconds<10){
  $seconds = "0" . $seconds;
}

$input = floor($input / 60);

$minutes = $input % 60;
if($minutes<10){
  $minutes = "0" . $minutes;
}
return $minutes . ":" . $seconds;
}
 ?>
 <div style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #eee; box-shadow: 0 -6px 8px rgba(0,0,0,0.14)" class="container-fluid foot-player ng-scope">
     <div class="progress" style="height:auto;">
         <div style="position: absolute; top: -5px; left: 0px; right: 0px; height: 5px;transition: all 1s ease-out;">
             <div class="progress-bar" id="progress" role="progressbar" style="height:5px; width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
         </div>
     </div>
     <div class="row"    style="height:60px;" >
         <!--             <div class="col-xs-1">
                     <div style="background-image: url(/cache/{{status.currentTrack.thumbnail}}); height: 60px; background-size: cover; background-repeat: no-repeat; background-position: 50% 50%; height: 120px; width: 120px; position: absolute; bottom: -75px;"></div>
                 </div> -->
         <div class="col-sm-5 trackinfo" style="padding-left:0;">
             <!-- ngIf: status.currentTrack.thumbnail --><img style="float: left; width: 60px; height: 60px; margin-right: 15px;" class="ng-scope" src="https://sinusbot.andreasfink.xyz<?php echo $thumbnail ?>">
             <!-- end ngIf: status.currentTrack.thumbnail -->
             <h3 class="tracktitle ng-binding" style="margin: 8px 0 0; padding-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 23px;"><?php echo $title;?></h3>
             <h4 class="trackartist ng-binding" style="margin: -3px 0 0; padding-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 17px;"><?php echo $artist;?></h4>
             <!-- <div style="text-align: center; font-size: 0.8em">{{status.position | amDurationFormatTime:'seconds':true}}</div> -->
         </div>
         <div class="col-sm-3" style="text-align: center">
             <table style="height: 60px; width: 100%; background-color: transparent !important" class="foot-controls">
                 <tbody>
                     <tr>
                         <td id="play" style="vertical-align: middle; cursor: pointer; text-align:center;" onclick="Play()"><svg class="bi bi-play-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"/></svg></td>
                         <td id="pause" style="vertical-align: middle; cursor: pointer;text-align:center;" onclick="Pause()"><svg class="bi bi-pause-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M5.5 3.5A1.5 1.5 0 017 5v6a1.5 1.5 0 01-3 0V5a1.5 1.5 0 011.5-1.5zm5 0A1.5 1.5 0 0112 5v6a1.5 1.5 0 01-3 0V5a1.5 1.5 0 011.5-1.5z"/></svg></td>
                     </tr>
                 </tbody>
             </table>
         </div>
         <div class="col-sm-2" style="text-align: center">
             <table style="height: 60px; width: 100%; background-color: transparent !important" class="foot-controls">
                 <tbody>
                     <tr>
                         <td style="vertical-align: middle; cursor: pointer; text-align:right;"><h3 class="volume"><?php echo $instancevolume ?>%</h3></td>
                         <td style="vertical-align: middle; cursor: pointer;text-align:center;"><svg class="bi bi-volume-up-fill"  height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"> <path d="M11.536 14.01A8.473 8.473 0 0014.026 8a8.473 8.473 0 00-2.49-6.01l-.708.707A7.476 7.476 0 0113.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/> <path d="M10.121 12.596A6.48 6.48 0 0012.025 8a6.48 6.48 0 00-1.904-4.596l-.707.707A5.483 5.483 0 0111.025 8a5.483 5.483 0 01-1.61 3.89l.706.706z"/> <path d="M8.707 11.182A4.486 4.486 0 0010.025 8a4.486 4.486 0 00-1.318-3.182L8 5.525A3.489 3.489 0 019.025 8 3.49 3.49 0 018 10.475l.707.707z"/> <path fill-rule="evenodd" d="M6.717 3.55A.5.5 0 017 4v8a.5.5 0 01-.812.39L3.825 10.5H1.5A.5.5 0 011 10V6a.5.5 0 01.5-.5h2.325l2.363-1.89a.5.5 0 01.529-.06z" clip-rule="evenodd"/></svg></td>
                     </tr>
                 </tbody>
             </table>
         </div>
         <div class="col-sm-2" style="font-size: 22px; text-align: right; cursor: pointer;">
             <div style="margin-top: 12px;"><span class="tracktime" id="position"></span><span class="tracktime">/</span><span class="tracktime" id="duration"></span></div>
         </div>
     </div>
     <div class="bottom-gap"></div>
 </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript">
/*
function millisToMinutesAndSeconds(millis) {
var minutes = Math.floor(millis / 60000);
var seconds = ((millis % 60000) / 1000).toFixed(0);
return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}

function updateValues(){
  document.getElementById("position").innerHTML = millisToMinutesAndSeconds(position);
  document.getElementById("duration").innerHTML = millisToMinutesAndSeconds(duration);  //maybe just once but
  document.getElementById("progress").style.width = (position/duration) * 100 + '%';
  if (playing) {
    document.getElementById("play").style.display = 'none';
    document.getElementById("pause").style.display = '';
  }else {
    document.getElementById("play").style.display = '';
    document.getElementById("pause").style.display = 'none';
  }

}

var position = <?php echo $position ?>;
var duration = <?php echo $duration ?>;
var playing = <?php if($instance->isPlaying()){echo "true";}else{echo "false";} ?>;
updateValues();
var t=setInterval(updateTimer,1000);

function updateTimer(){
  if (playing) {
    position = position + 1000;
  }

if (position >= duration) {
  position = duration;
}
updateValues();
console.log(position/duration);

}

function Play(){
  $(function()
        {
            $.ajax( "act.php?action=play" )

        });
        playing = true;
        position = 0;
}


function Pause(){
  $(function()
        {
            $.ajax( "act.php?action=pause" )

        });
      playing = false;
}
*/
</script>

<script type="text/javascript">
var position = <?php echo $position ?>;
var duration = <?php echo $duration ?>;
var playing = <?php if($instance->isPlaying()){echo "true";}else{echo "false";} ?>;
updateValues();
//updateTimer();
//var t = 0;
//t=setInterval(updateTimer,1000);
</script>
