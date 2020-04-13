<?php

include("../config.php");
makeGoogle();
function youtubeSearch2($q){
  // Define an object that will be used to make all API requests.
global $youtube;
    try {
      $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $q,
        'maxResults' => $_GET['maxResults'],
        'type' => 'video',
      ));


      // Add each result to the appropriate list, and then display the lists of
      // matching videos, channels, and playlists.
      foreach ($searchResponse['items'] as $searchResult) {
        $title = $searchResult['snippet']['title'];
        $videourl = "https://www.youtube.com/watch?v=" . $searchResult['id']['videoId'];
        $channeltitle = $searchResult['snippet']['channeltitle'];
        $channelurl = "https://www.youtube.com/channel/" . $searchResult['snippet']['channeltitle'];
        $thumbnailurl = $searchResult['snippet']['thumbnails']['high']['url'];

var_dump($searchResult);
      }

    } catch (Google_Service_Exception $e) {
      $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
      $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    }
  }
if (isset($_GET['q'])) {
youtubeSearch2($_GET['q']);

}
?>
