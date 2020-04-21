<?php
$search = true;
$currentPage = 'Home';
include_once("../main.php");
include("../includes/head.php");
?>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><?php echo $lang["sidebar-header"] ?></h3>
            </div>

            <ul class="list-unstyled components">
                <li id="files" onclick="showFiles()"><a><?php echo $lang["sidebar-music"] ?></a></li>
                <li id="queue" onclick="showQueue()"><a><?php echo $lang["sidebar-queue"] ?><span id="queueLength" class="badge float-right align-middle ml-auto">0</span></a></li>
                <li id="youtube" onclick="showYoutube()"><a><?php echo $lang["sidebar-youtube"] ?></a></li>
                <li id="radio" onclick="showRadio()"><a><?php echo $lang["sidebar-radio"] ?></a></li>
            </ul>
            <ul id="playlists" class="list-unstyled components">
            </ul>
                <ul class="list-unstyled CTAs">
                    <li>
                        <a href="https://git.syslul.de/sysLUL/play-public" target="_blank" class="download"><?php echo $lang["sidebar-download"] ?></a>
                    </li>
                    <li>
                        <a href="https://git.syslul.de/sysLUL/play-public/src/branch/master/README.md" target="_blank" class="sources"><?php echo $lang["sidebar-libaries"] ?></a>
                    </li>
                </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

          <?php include("../includes/navbar.php"); ?>

            <div id="filesTableDiv">
                <table id="filesTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $lang["filestable-img"] ?></th>
                            <th><?php echo $lang["filestable-id"] ?></th>
                            <th><?php echo $lang["filestable-title"] ?></th>
                            <th><?php echo $lang["filestable-duration"] ?></th>
                            <th><?php echo $lang["filestable-artist"] ?></th>
                            <th><?php echo $lang["filestable-album"] ?></th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                    </tbody>
                </table>
            </div>

            <div id="radioTableDiv" style="display:none;">
                <table id="radioTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo $lang["radiotable-name"] ?></th>
                            <th><?php echo $lang["radiotable-desc"] ?></th>
                        </tr>
                    </thead>
                    <tbody class="tbody-radio">
                    </tbody>
                </table>
            </div>

            <div id="youtubeDiv" style="display:none;">
                <div class="container">
                    <form id="ytForm" class="" action="javascript:void(0)">
                        <div class="card-body row no-gutters align-items-center">
                            <div class="col">
                                <input id="ytSearch" class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search topics or keywords">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-lg btn-success" type="submit"><?php echo $lang["youtube-search"] ?></button>
                            </div>
                        </div>
                    </form>
                    <div id="changeType" class="row" style="display:none;">
                        <div class="col-lg-12 my-3">
                            <div class="pull-right">
                                <button class="btn btn-info" id="list">
                                    <?php echo $lang["youtube-listview"] ?>
                                </button>
                                <button class="btn btn-danger" id="grid" style="display:none;">
                                    <?php echo $lang["youtube-gridview"] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="ytResponse" class="row view-group">

                    </div>
                    <button id="loadMore" type="button" class="btn btn-info btn-lg btn-block" onclick="ytMore()" name="button" style="display:none;"><?php echo $lang["youtube-loadmore"] ?></button>
                    <br>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="progress">
                        <div class="progress-bar" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row" style="height:60px;">
                        <div class="col-sm-5 trackinfo ml-auto d-none d-sm-block">
                            <img id="thumbnail" src="">
                            <h3 id="title" class="tracktitle"></h3>
                            <h4 id="artist" class="trackartist"></h4>
                        </div>
                        <div class="col-sm-3 controls">
                            <table class="responsive foot-controls">
                                <tbody>
                                    <tr>
                                        <td id="repeat" class="icon" onclick="toggleRepeat()">
                                            <svg class="bi bi-arrow-repeat" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M2.854 7.146a.5.5 0 00-.708 0l-2 2a.5.5 0 10.708.708L2.5 8.207l1.646 1.647a.5.5 0 00.708-.708l-2-2zm13-1a.5.5 0 00-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 00-.708.708l2 2a.5.5 0 00.708 0l2-2a.5.5 0 000-.708z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M8 3a4.995 4.995 0 00-4.192 2.273.5.5 0 01-.837-.546A6 6 0 0114 8a.5.5 0 01-1.001 0 5 5 0 00-5-5zM2.5 7.5A.5.5 0 013 8a5 5 0 009.192 2.727.5.5 0 11.837.546A6 6 0 012 8a.5.5 0 01.501-.5z" clip-rule="evenodd"></path>
                                            </svg>
                                        </td>
                                        <td id="back" class="icon" onclick="back()">
                                            <svg class="bi bi-skip-backward-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M.5 3.5A.5.5 0 000 4v8a.5.5 0 001 0V4a.5.5 0 00-.5-.5z" clip-rule="evenodd"></path>
                                                <path d="M.904 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.692-1.01-1.233-.696L.904 7.304a.802.802 0 000 1.393z"></path>
                                                <path d="M8.404 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.693-1.01-1.233-.696L8.404 7.304a.802.802 0 000 1.393z"></path>
                                            </svg>
                                        </td>
                                        <td id="play" class="icon" onclick="play()">
                                            <svg class="bi bi-play-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"></path>
                                            </svg>
                                        </td>
                                        <td id="stop" class="icon" onclick="stop()">
                                            <svg class="bi bi-stop-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 3.5h6A1.5 1.5 0 0112.5 5v6a1.5 1.5 0 01-1.5 1.5H5A1.5 1.5 0 013.5 11V5A1.5 1.5 0 015 3.5z"></path>
                                            </svg>
                                        </td>
                                        <td id="forward" class="icon" onclick="forward()">
                                            <svg class="bi bi-skip-forward-fill" height="50px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M15.5 3.5a.5.5 0 01.5.5v8a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd"></path>
                                                <path d="M7.596 8.697l-6.363 3.692C.693 12.702 0 12.322 0 11.692V4.308c0-.63.693-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"></path>
                                                <path d="M15.096 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.693-1.01 1.233-.696l6.363 3.692a.802.802 0 010 1.393z"></path>
                                            </svg>
                                        </td>
                                        <td id="shuffle" class="icon active" onclick="toggleShuffle()">
                                            <svg class="bi bi-shuffle" height="30px" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M12.646 1.146a.5.5 0 01.708 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 01-.708-.708L14.793 4l-2.147-2.146a.5.5 0 010-.708zm0 8a.5.5 0 01.708 0l2.5 2.5a.5.5 0 010 .708l-2.5 2.5a.5.5 0 01-.708-.708L14.793 12l-2.147-2.146a.5.5 0 010-.708z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M0 4a.5.5 0 01.5-.5h2c3.053 0 4.564 2.258 5.856 4.226l.08.123c.636.97 1.224 1.865 1.932 2.539.718.682 1.538 1.112 2.632 1.112h2a.5.5 0 010 1h-2c-1.406 0-2.461-.57-3.321-1.388-.795-.755-1.441-1.742-2.055-2.679l-.105-.159C6.186 6.242 4.947 4.5 2.5 4.5h-2A.5.5 0 010 4z" clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M0 12a.5.5 0 00.5.5h2c3.053 0 4.564-2.258 5.856-4.226l.08-.123c.636-.97 1.224-1.865 1.932-2.539C11.086 4.93 11.906 4.5 13 4.5h2a.5.5 0 000-1h-2c-1.406 0-2.461.57-3.321 1.388-.795.755-1.441 1.742-2.055 2.679l-.105.159C6.186 9.758 4.947 11.5 2.5 11.5h-2a.5.5 0 00-.5.5z" clip-rule="evenodd"></path>
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-3 ml-auto d-none d-sm-block">
                            <div class="slider">
                                <input type="range" min="0" max="100" step="1" value="0" data-rangeslider="" style="position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0;">
                            </div>
                        </div>
                        <div class="col-sm-1 ml-auto d-none d-sm-block time">
                            <span id="position">0:00</span>
                        </div>
                    </div>
                    <div class="bottom-gap"></div>
                </div>
            </footer>

        </div>
    </div>








    <?php include("../includes/footer.php") ?>
    <script type="text/javascript">
        showFiles();
    </script>
  </body>

</html>
