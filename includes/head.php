<html>
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="cache-control" content="no-cache" />
      <meta http-equiv="Pragma" content="no-cache" />
      <meta http-equiv="Expires" content="-1" />
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/rangeslider.css">
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/sweetalert2.min.css">
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/datatables.min.css">
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/mCustomScrollbar.min.css">
      <link rel="stylesheet" href="<?php echo _ROOTURL ?>src/css/main.css">
      <meta charset="utf-8">
      <title><?php echo $lang["head"]["title"] ?></title>
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo _ROOTURL ?>src/img/favicon.ico">
      <!-- SEO META TAG -->
      <meta name="author" content="sysLUL">
      <meta name="publisher" content="sysLUL">
      <meta name="copyright" content="Andreas Fink">
      <meta name="description" content="Richte öffentlich ein Zugang zur Sinusbot Instanz ein.">
      <meta name="page-topic" content="Forschung Technik">
      <meta name="page-type" content="Software Download">
      <meta name="audience" content="Alle">
      <meta http-equiv="content-language" content="de">
      <meta name="robots" content="index, follow">
      <meta property="og:image" content="<?php echo _ROOTURL ?>src/img/Logo.png" />

      <script type="text/javascript">
        var host = "<?php echo _ROOTURL ?>";

        var dataTableLang = {
          "decimal":        "<?php echo $lang["datatable"]["decimal"] ?>",
          "lengthMenu": "<?php echo $lang["datatable"]["lengthmenu"] ?>",
          "zeroRecords": "<?php echo $lang["datatable"]["zerorecords"] ?>",
          "info": "<?php echo $lang["datatable"]["info"] ?>",
          "infoEmpty": "<?php echo $lang["datatable"]["infoempty"] ?>",
          "infoFiltered":  "<?php echo $lang["datatable"]["infofiltered"] ?>",
          "emptyTable":     "<?php echo $lang["datatable"]["emptytable"] ?>",
          "infoPostFix":    "<?php echo $lang["datatable"]["infopostfix"] ?>",
          "thousands":      "<?php echo $lang["datatable"]["thousands"] ?>",
          "loadingRecords": "<?php echo $lang["datatable"]["loading"] ?>",
          "processing":     "<?php echo $lang["datatable"]["processing"] ?>",
          "search":         "<?php echo $lang["datatable"]["search"] ?>",
          "paginate": {
              "first":      "<?php echo $lang["datatable"]["paginate"]["first"] ?>",
              "last":       "<?php echo $lang["datatable"]["paginate"]["next"] ?>",
              "next":       "<?php echo $lang["datatable"]["paginate"]["last"] ?>",
              "previous":   "<?php echo $lang["datatable"]["paginate"]["previous"] ?>",
          },
          "aria": {
              "sortAscending":  "<?php echo $lang["datatable"]["aria"]["sortascending"] ?>",
              "sortDescending": "<?php echo $lang["datatable"]["aria"]["sortdescending"] ?>"
          }
      }

        var alertErrorTitle = "<?php echo $lang["alert"]["error"]["title"] ?>"
        var alertErrorText = "<?php echo $lang["alert"]["error"]["msg"] ?>"

        var alert_load_files_title="<?php echo $lang["alert"]["load"]["files-title"] ?>"
        var alert_load_files_msg="<?php echo $lang["alert"]["load"]["files-msg"] ?>"
        var alert_load_folder_title="<?php echo $lang["alert"]["load"]["folder-title"] ?>"
        var alert_load_folder_msg="<?php echo $lang["alert"]["load"]["folder-msg"] ?>"
        var alert_load_playlist_title="<?php echo $lang["alert"]["load"]["playlist-title"] ?>"
        var alert_load_playlist_msg="<?php echo $lang["alert"]["load"]["playlist-msg"] ?>"
        var alert_load_queue_title="<?php echo $lang["alert"]["load"]["queue-title"] ?>"
        var alert_load_queue_msg="<?php echo $lang["alert"]["load"]["queue-msg"] ?>"
        var alert_load_radio_title="<?php echo $lang["alert"]["load"]["radio-title"] ?>"
        var alert_load_radio_msg="<?php echo $lang["alert"]["load"]["radio-msg"] ?>"
        var alert_load_yt_title="<?php echo $lang["alert"]["load"]["yt-title"] ?>"
        var alert_load_yt_msg="<?php echo $lang["alert"]["load"]["yt-msg"] ?>"
        var alert_load_ytmore_title="<?php echo $lang["alert"]["load"]["ytmore-title"] ?>"
        var alert_load_ytmore_msg="<?php echo $lang["alert"]["load"]["ytmore-msg"] ?>"
      </script>

    </head>

    <body>
      <button class="darkmode-toggle">🌓</button>
