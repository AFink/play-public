<?php
$search = true;
$currentPage = 'YTLINK';
include_once("../config.php");
include("../includes/head.php");
include("../includes/navbar.php");
?>


<div class="main">
  <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <form action="javascript:void(0)" onsubmit="ytUrl()">
                <div class="form-group">
                    <input class="form-control form-control-lg" id="url" placeholder="URL" type="url">
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Play</button>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<div class="playbar">

</div>

<?php include("../includes/footer.php") ?>
