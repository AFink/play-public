    <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
        <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="btn btn-info d-inline-block d-md-none mr-auto">
              <svg class="bi bi-justify-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z" clip-rule="evenodd"/></svg>
            </button>
            <a href="#" class="navbar-brand d-md-none"><?php echo $lang["navbar-brand"] ?></a>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarToBeToggled" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
              <svg class="bi bi-justify" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z" clip-rule="evenodd"/></svg>
            </button>

            <div class="collapse navbar-collapse" id="navbarToBeToggled">
                <ul class="nav navbar-nav mr-auto">
                  <li class="d-inline-block d-md-none"><hr></li>
                  <li class="d-inline-block d-md-none"><a href="#" class="navbar-brand"><?php echo $lang["navbar-instances"] ?></a></li>
                  <?php getInstanceList() ?>
                </ul>
                <form action="javascript:void(0)"class="form-inline ml-auto d-none d-sm-flex">
                  <?php if($search): ?>
                    <input type="text" id="search" class="form-control mr-sm-2" placeholder="Search">
                  <?php endif; ?>
                  <button id="running" type="button" style="height:38px;opacity: 1;margin-right: .5rem!important;"class="btn btn-<?php if($instancerunning){echo "success";} else{echo "danger";} ?>" data-placement="bottom">
                      <svg class="bi bi-power" width="15px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.578 4.437a5 5 0 104.922.044l.5-.866a6 6 0 11-5.908-.053l.486.875z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z" clip-rule="evenodd"/></svg>
                  </button>
                  <?php //getInstanceDropdown(); ?>
                </form>

            </div>
        </div>
    </nav>
