<?php
$search = true;
$currentPage = 'Home';
include_once("../config.php");
include("../includes/head.php"); ?>
<link rel="stylesheet" href="./src/css/datatables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<?php
include("../includes/navbar.php");
?>

<div class="row">
  <div class="col-md-2 sidebar" ng-class="{visible: leftMenu}">
      <div>
          <ul class="nav nav-pills nav-stacked">
              <li id="files" ui-sref-active="active" class="" onclick="showFiles()"><a>All Music</a></li>
              <li id="queue" ui-sref-active="active" onclick="showQueue()"><a>Queue<span class="badge pull-right ng-binding">0</span></a></li>
              <li id="radio" ui-sref-active="active" onclick="showRadio()"><a>Radio Stations</a></li>
          </ul>
          <hr>

          <ul id="playlists" class="nav nav-pills nav-stacked">

          </ul>

          <!-- <div ng-show="dragging" ng-drop="true" ng-drop-success="onDropComplete($data,$event)">New playlist</div> -->
      </div>
  </div>

  <div class="col-md-10 col-md-offset-2 gutter" style="min-height: 500px;">
    <table id="filesTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>ID</th>
          <th>Titel</th>
          <th>Länge</th>
          <th>Autor<br></th>
          <th>Album</th>
        </tr>
      </thead>
      <tbody class="tbody">
      </tbody>
    </table>
  </div>
</div>



<div class="playbar">

</div>

<?php include("../includes/footer.php") ?>
<script src="./src/js/datatables.min.js" type="text/javascript"></script>
<script type="text/javascript">
  showFiles();
</script>
