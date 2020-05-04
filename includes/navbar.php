<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <button type="button" id="sidebarCollapse" class="btn btn-info d-inline-block d-md-none mr-auto">
    <svg class="bi bi-justify-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z" clip-rule="evenodd"/></svg>
  </button>
  <a class="navbar-brand d-md-none" href="#"><?php echo $lang["navbar"]["brand"] ?></a>
  <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target=".dual-collapse2" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <svg class="bi bi-justify" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z" clip-rule="evenodd"/></svg>
  </button>
  <div class="nav-row">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
      <ul class="navbar-nav mr-auto">
        <li class="d-inline-block d-md-none">
          <hr>
        </li>
        <li class="nav-item d-md-none">
          <a class="navbar-brand"><?php echo $lang["navbar"]["instances"] ?></a>
        </li>
        <?php getInstanceList() ?>
      </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <form class="form-inline d-none d-sm-flex">
            <input class="form-control mr-sm-2" type="search" placeholder="<?php echo $lang["navbar"]["search"] ?>" aria-label="<?php echo $lang["navbar"]["search"] ?>">
          </form>
        </li>
        <li class="d-inline-block d-md-none">
          <hr>
        </li>
        <li class="nav-item dropdown d-none d-sm-flex">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $langinfo["display"] ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <?php getLangDropdown() ?>
          </div>
        </li>
        <li class="nav-item d-md-none">
          <a class="navbar-brand"><?php echo $lang["navbar"]["languages"] ?></a>
        </li>
        <?php getLangList() ?>
      </ul>
    </div>
  </div>

</nav>
