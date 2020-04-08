<?php

include("../config.php");



/*print_r($instancecurrent);
print_r($instance->currentPlaylist());
print_r($instance->currentPlaylistTrackID());

print_r($instance->isCurrentFromPlaylist()); */

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



?>
