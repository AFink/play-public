<?php

include_once("./src/php/sinusbot/autoload.php");
include("config.php");

$files = $sinusbot->getFiles();



$instances = $sinusbot->getInstances();

function msConv($ms){
$uSec = $ms % 1000;
$ms = floor($ms / 1000);

$seconds = $ms % 60;
$ms = floor($ms / 60);

$minutes = $ms % 60;
$ms = floor($ms / 60);

$hour = $ms ;
return $minutes . ":" . $seconds;
}


?>

<table style="width:100%">
  <tr>
    <th>Name:</th>
    <th>Telephone:</th>
    </tr>


<?php
foreach ($files as $file):?>

<tr onclick="window.location='?play=<?php echo $file->getUUID()?>';">

<td>  <?php if ($instancecurrent->getUUID() == $file->getUUID()) {echo "penis";} ?><?php echo $file->getTitle(); ?><?php echo msConv($file->getDuration())?></td>
<td><?php if($file->getType() !== "folder"){echo $file->getArtist();}else {echo "";} ?></td>
<td><?php if($file->getType() !== "folder"){echo $file->getThumbnail();} else {echo "";} ?></td>



</tr>
<?php endforeach;
?>
</table>

<?php print_r($instance->getStatus()); ?>
