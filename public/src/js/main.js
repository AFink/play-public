/**
 * Helpers
 */
function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}
function makeSlider() {
    var selector = '[data-rangeSlider]',
        sliders = document.querySelectorAll(selector);
    rangeSlider.create(sliders, {
        onInit: function () { },
        onSlideEnd: function (value, percent, position) {
          $.ajax({
              url: "act.php?action=changeVolume&volume=" + value,
              success: function() {
                  updatePlayer();
              },
          });
        }
    });


}
/**
 * Sidebar-Action
 */
function removeActive(){

  var elements = $("li.active");
  elements.each(function(){
    $(this).removeClass('active');
  });
}
function getPlaylists(){
  $.ajax({
      type: "POST",
      data: {view:"playlists"},
      url: "act.php",
      success: function(data, textStatus) {
          $("#playlists").html(data);
      },
  });
}
/**
 *  table-action
 */
function datatable(){
  oTable = $('#filesTable').DataTable({
    responsive : true,
    fixedHeader:  true,
      "paging":   false,
      "info":     false
  });
  $('#filesTable_wrapper > div:nth-child(1)').hide();
  $('#search').keyup(function(){
    oTable.search($(this).val()).draw() ;
  })
}

function showFiles(){
  folder.length = 0;
  $.ajax({
      type: "POST",
      url: "act.php",
      data: {view: "files"},
      success: function(data, textStatus) {
          $(".tbody").html(data);
          if (i==0) {
            datatable();
            i++;
          };
          removeActive();
          $("#files").addClass('active');

      },
  });

}

function showFolder(i){
  folder.push(i);
  folderAjax();

}
function folderBack(){
  if (folder.length>1) {
    folder.pop();
    folderAjax();
  }else {
    showFiles();
  }

}
function folderAjax(){
  console.log(folder);
  $.ajax({
      type: "POST",
      url: "act.php",
      data: { view:"folder",
              folders:folder},
      success: function(data, textStatus) {
          $(".tbody").html(data);
      },
  });
}

function showPlaylist(uuid){
  $.ajax({
      type: "POST",
      url: "act.php",
      data: { view:"playlist",
              uuid:uuid},
      success: function(data, textStatus) {
          $(".tbody").html(data);
          removeActive();
          $("#" + uuid).addClass('active');
      },
  });

}

function showQueue(){
  $.ajax({
      type: "POST",
      url: "act.php",
      data: { view:"queue"},
      success: function(data, textStatus) {
          $(".tbody").html(data);
          removeActive();
          $("#queue").addClass('active');
      },
  });

}
/**
 *  Playing
 */

function playFile(uuid) {
     $(function() {
         $.ajax({
             url: "act.php?playuuid=" + uuid,
             success: function() {
               playing = true;
               position = 0;
                 updatePlayer();
             },
         });
     });

 }
function playPl(uuid,i){
   $(function() {
       $.ajax({
           url: "act.php?playpl=" + uuid + "&i=" + i,
           success: function() {
             playing = true;
             position = 0;
               updatePlayer();
           },
       });
   });
 }
function playUrl(url){
  $(function() {
      $.ajax({
          url: "act.php?playurl=" + encodeURIComponent(url),
          success: function() {
            playing = true;
            position = 0;
              updatePlayer();
          },
      });
  });
}

/**
 *  Updater
 */


function updateTimer() {
    if (playing) {
        position = position + 200;
    }

    if (position >= duration) {
        position = duration;
        playing = false;
    }

}
function updateValues() {
    document.getElementById("position").innerHTML = millisToMinutesAndSeconds(position);
    document.getElementById("progress").style.width = (position / duration) * 100 + '%';
    if (playing) {
        document.getElementById("play").style.display = 'none';
        document.getElementById("stop").style.display = '';
    } else {
        document.getElementById("play").style.display = '';
        document.getElementById("stop").style.display = 'none';
    }
    requestAnimationFrame(updateValues);
}
function updatePlayer() {
    $.ajax({
        type: "POST",
        data: {view:"player"},
        url: "act.php",
        success: function(data, textStatus) {
            $(".playbar").html(data);
            makeSlider();
        },
    });
}

/**
 *  Playbar
 */
function play() {
    $(function() {
        $.ajax("act.php?action=play")

    });
    playing = true;
    position = 0;
}
function stop() {
    $(function() {
        $.ajax("act.php?action=stop")

    });
    playing = false;
}
function toggleRepeat() {
  $(function() {
      $.ajax({
          url: "act.php?action=togglerepeat",
          success: function() {
              updatePlayer();
          },
      });
  });
}
function toggleShuffle() {
  $(function() {
      $.ajax({
          url: "act.php?action=toggleshuffle",
          success: function() {
              updatePlayer();
          },
      });
  });
}
function back() {
  $(function() {
      $.ajax({
          url: "act.php?action=back",
          success: function() {
              updatePlayer();
          },
      });
  });
}
function forward() {
  $(function() {
      $.ajax({
          url: "act.php?action=forward",
          success: function() {
              updatePlayer();
          },
      });
  });
}



getPlaylists();
updatePlayer();
var playerinterval = setInterval(updatePlayer, 10000);
var t = setInterval(updateTimer, 200);
requestAnimationFrame(updateValues);
var i = 0;

var folder = [];



/**
 * extra for now
 */


function ytUrl(){
  var url = document.getElementById("url").value;
  $(function() {
      $.ajax({
          url: "act.php?ytUrl=" + encodeURIComponent(url),
          success: function(){
              updatePlayer();
          },
      });
  });
}
