<?php

include_once("sinusbot/src/autoload.php");

$sinusbot = new SinusBot\API("http://127.0.0.1:8087");
$sinusbot->login("webUser", "yH>q]7rC+:g?$]Q#");

$files = $sinusbot->getFiles();

function return_if_exists($key, $arr) {
  if (array_key_exists($key, $arr)) {
    return $arr[$key];
  }
  return "-";
}


$instances = $sinusbot->getInstances();
/*$instance = $instances[1];
*/

$instance= $sinusbot->getInstanceByUUID("4d7971ca-3638-e267-6bea-076b54fa637d");
if(isset($_GET['play'])){
$instance->playTrack($_GET['play']);
echo $_GET['play'];
}



?>

<table style="width:100%">
  <tr>
    <th>Name:</th>
    <th>Telephone:</th>
    </tr>


<?php
foreach ($files as $file): ?>
<tr onclick="window.location='?play=<?php echo $file['uuid']?>';">
<td><?php echo return_if_exists("artist", $file) ?></td>
<td><?php echo return_if_exists("title", $file) ?></td>

</tr>
<?php endforeach;
?>
</table>

<?php print_r($instances); ?>
