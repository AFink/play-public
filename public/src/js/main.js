var title = ""
var artist = ""
var thumbnail = ""
var uuid = ""
var duration = ""
var position = ""
var shuffle = ""
var repeat = ""
var playing = ""
var running = ""
var volume = 0
var instanceuuid = ""
var queueLength = 0

var filesTable = null;

var darkmode = false;

var q = ""
var i = 0
var i2 = 0

var folder = []
$('#radioTableDiv').hide();

$('.dropdown-menu a').click(function(event){
  $('.dropdown-toggle').html($(this).html());
})

$('#list').click(function(event){
  event.preventDefault();
  $('#ytResponse .item').removeClass('grid-group-item');
  $('#ytResponse .item').addClass('list-group-item');
  $('#list').hide();
  $('#grid').show();
});

$('#grid').click(function(event){
  event.preventDefault();
  $('#ytResponse .item').removeClass('list-group-item');
  $('#ytResponse .item').addClass('grid-group-item');
  $('#grid').hide();
  $('#list').show();
});

$('#sidebarCollapse').click(function(event){
  sidebarCollapse();
});

var sidebar = document.getElementById('sidebar');
var sidebarToggler = document.getElementById('sidebarCollapse');
document.addEventListener('click', function(event) {
    if (!sidebar.contains(event.target)) {
      if (!sidebarToggler.contains(event.target)) {
        if ($("#content").hasClass("active")) {
          sidebarCollapse();
        }
      }
    }
});


$(document).ready(function () {
  $("#sidebar").mCustomScrollbar({
      theme: "minimal"
  });
  setDarkmode(isInDarkmode());
});


$('.darkmode-toggle').click(function(){
  toggleDarkmode();
})

function isInDarkmode() {
 if (window.matchMedia) {
   if(window.matchMedia('(prefers-color-scheme: dark)').matches){
     return true;
   } else {
     return false;
   }
 }
 var cookie = getCookie(darkmode);
 if (cookie != null){
   setDarkmode(cookie);
 }
 return false;
}

function toggleDarkmode(){
  if (darkmode) {
    darkmode = false;
  }else {
    darkmode = true;
  }
  applyDarkmode();
}
function setDarkmode(value){
  darkmode = value;
  applyDarkmode();
}
function applyDarkmode(){
  if(darkmode){
    setCookie(darkmode,true,1);
    $('.darkmode-toggle').addClass("darkmode-toggle--light");
    $('body').addClass("darkmode");
  }else {
    setCookie(darkmode,false,1);
    $('.darkmode-toggle').removeClass("darkmode-toggle--light");
    $('body').removeClass("darkmode");
  }
}

showFiles();
makeSlider();
getPlaylists();
getData();
var playerinterval = setInterval(getData, 10000);
var t = setInterval(updateTimer, 200);
requestAnimationFrame(updateValues);


/**
 * Helpers
 */
 function setCookie(name,value,days) {
     var expires = "";
     if (days) {
         var date = new Date();
         date.setTime(date.getTime() + (days*24*60*60*1000));
         expires = "; expires=" + date.toUTCString();
     }
     document.cookie = name + "=" + (value || "")  + expires + "; path=/";
 }
 function getCookie(name) {
     var nameEQ = name + "=";
     var ca = document.cookie.split(';');
     for(var i=0;i < ca.length;i++) {
         var c = ca[i];
         while (c.charAt(0)==' ') c = c.substring(1,c.length);
         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
     }
     return null;
 }
 function eraseCookie(name) {
     document.cookie = name+'=; Max-Age=-99999999;';
 }




function millisToMinutesAndSeconds(millis) {
  var minutes = Math.floor(millis / 60000);
  var seconds = ((millis % 60000) / 1000).toFixed(0);
  return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
}
function makeSlider() {
  $('input[type="range"]').rangeslider({
       polyfill: false,
       onInit: function() {
         },
        onSlide: function(position, value) {
         },
       onSlideEnd: function (value, percent, position) {
         $.ajax({
             url: "act.php?action=changeVolume&volume=" + percent,
             success: function(data) {
                 infoMsg(data);
                 getData();
               },
             error: function (xhr, ajaxOptions, thrownError) {
               errorAlert.fire();
             }
         });
       }
     })

}
/**
 * Sidebar-Action
 */

function sidebarCollapse(){
  $('#sidebar, #content').toggleClass('active');
  $('.collapse.in').toggleClass('in');
  $('a[aria-expanded=true]').attr('aria-expanded', 'false');
}
function removeActive(){
  if ($("#sidebar").hasClass("active")) {
    sidebarCollapse();
  }

  var elements = $("li.active");
  elements.each(function(){
    $(this).removeClass('active');
  });
  $('#search').val("");
  $('#radioTableDiv').hide();
  $('#youtubeDiv').hide();
  $('#ytSearch').val("");
  $("#ytResponse").html("");
  $('#filesTable').show();
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
 *  table-action - ALL have alerts, but no Variables
 */
function datatable(){
  filesTable = $('#filesTable').DataTable({
    responsive : {
      details: false
    },
    "language": {
      "lengthMenu": datatable_lengthmenu,
      "zeroRecords": datatable_zerorecords,
      "info": datatable_info,
      "infoEmpty": datatable_infoempty,
      "infoFiltered": datatable_infofiltered
    },
    columnDefs: [
        {responsivePriority: 2, targets: 0 },
        {responsivePriority: 99, targets: 1 },
        {responsivePriority: 1, targets: 2 }
    ],
    fixedHeader:  false,
      "paging":   false,
      "info":     false
  });
  $('#filesTable_wrapper > div:nth-child(1)').hide();
  $('#search').keyup(function(){
    filesTable.search($(this).val()).draw();
  })
}

function showFiles(){
  folder.length = 0;
  if (i>0) {
    loadingAlert.fire({
      title: alert_load_files_title,
      html: alert_load_files_msg,
    })
  };
  $.ajax({
      type: "POST",
      url: "act.php",
      data: {view: "files"},
      success: function(data, textStatus) {
        removeActive();
        if (i>0) {
          filesTable.destroy();
        };
          $(".tbody").html(data);
          datatable();
          $("#files").addClass('active');
          if (i>0) {
            Swal.close();
          };

          i++;
        },
        error: function (xhr, ajaxOptions, thrownError) {
          Swal.close();
          errorAlert.fire();
        }
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
  loadingAlert.fire({
    title: alert_load_folder_title,
    html: alert_load_folder_msg,
  })
  $.ajax({
      type: "POST",
      url: "act.php",
      data: {view:"folder", folders:folder},
      success: function(data, textStatus) {
        filesTable.destroy();
        $(".tbody").html(data);
        datatable();
        Swal.close();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        Swal.close();
        errorAlert.fire();
      }
  });
}

function showPlaylist(uuid){
  loadingAlert.fire({
    title: alert_load_playlist_title,
    html: alert_load_playlist_msg,
  })
  $.ajax({
      type: "POST",
      url: "act.php",
      data: {view:"playlist",uuid:uuid},
      success: function(data, textStatus) {
        removeActive();
        filesTable.destroy();
        $(".tbody").html(data);
        datatable();
        $("#" + uuid).addClass('active');
        Swal.close();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        Swal.close();
        errorAlert.fire();
      }
  });

}

function showQueue(){
  loadingAlert.fire({
    title: alert_load_queue_title,
    html: alert_load_queue_msg,
  })
  $.ajax({
      type: "POST",
      url: "act.php",
      data: {view:"queue"},
      success: function(data, textStatus) {
          removeActive();
          filesTable.destroy();
          $(".tbody").html(data);
          datatable();
          $("#queue").addClass('active');
          Swal.close();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          Swal.close();
          errorAlert.fire();
        }
  });

}

function showRadio(){
  loadingAlert.fire({
    title: alert_load_radio_title,
    html: alert_load_radio_msg,
  })
  removeActive();
  $("#radio").addClass('active');
  $('#filesTable').hide();
  $('#radioTableDiv').show();
  if(i2 == 0){
  var radioTable = $('#radioTable').DataTable( {
    "createdRow": function( row, data, dataIndex ) {
      $(row).attr('onclick','playUrl(\'' + data['u'] +'\')');
  },
    "language": {
      "lengthMenu": datatable_lengthmenu,
      "zeroRecords": datatable_zerorecords,
      "info": datatable_info,
      "infoEmpty": datatable_infoempty,
      "infoFiltered": datatable_infofiltered
    },
    ajax: {
        url: './src/json/radio.json',
        dataSrc: 'e'
    },
    columns: [
      {data : 'n'},
      {data : 'g'}
      ]
    } );
    i2++;
    $('#radioTable_wrapper > div:nth-child(1)').hide();
  }
  Swal.close();
  $('#search').keyup(function(){
    radioTable.search($(this).val()).draw() ;
  })
}

function showYoutube(){
  removeActive();
  $("#youtube").addClass('active');
  $('#filesTable').hide();
  $('#youtubeDiv').show();
}
/**
 *  Playing
 */

function playFile(uuid) {
     $(function() {
         $.ajax({
             url: "act.php?playuuid=" + uuid,
             success: function(data) {
                 infoMsg(data);
               playing = true;
               position = 0;
                 getData();
               },
               error: function (xhr, ajaxOptions, thrownError) {
                 errorAlert.fire();
               }
         });
     });

 }
function playPl(uuid,i){
   $(function() {
       $.ajax({
           url: "act.php?playpl=" + uuid + "&i=" + i,
           success: function(data) {
               infoMsg(data);
             playing = true;
             position = 0;
               getData();
             },
             error: function (xhr, ajaxOptions, thrownError) {
               errorAlert.fire();
             }
       });
   });
 }
function playUrl(url){
  $(function() {
      $.ajax({
          url: "act.php?playurl=" + encodeURIComponent(url),
          success: function(data) {
              infoMsg(data);
            playing = true;
            position = 0;
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
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
function getData() {
    $.ajax({
        type: "GET",
        url: "act.php?action=getData",
        success: function(data, textStatus) {
            var response = JSON.parse(data);
             title = response.title;
             artist = response.artist;
             thumbnail = response.thumbnail;
             uuid = response.uuid;
             instanceuuid = response.instanceuuid;
             duration = response.duration;
             position = response.position;
             shuffle = response.shuffle;
             repeat = response.repeat;
             playing = response.playing;
             running = response.running;
             volume = response.volume;
             queueLength = response.queueLength;
            setData();
        },
    });
}

function setData(){
  $('#title').html(title);
  $('#artist').html(artist);
  if(thumbnail == "none"){
    $("#thumbnail").hide();
    $('#sidebar-thumbnail').hide();
  }else {
    $("#thumbnail").show();
    $('#thumbnail').attr("src", thumbnail);
    $('#sidebar-thumbnail').show();
    $('#sidebar-thumbnail').css("background-image", '"url('+ thumbnail +')"');
  }


  $('#sidebar-title').html(title);
  $('#sidebar-artist').html(artist);

  $('#queueLength').html(queueLength);


  if (repeat) {
    $('#repeat').addClass("active");
  }else {
    $('#repeat').removeClass("active");
  }
  if (shuffle) {
    $('#shuffle').addClass("active");
  }else {
    $('#shuffle').removeClass("active");
  }

if(running){
  $('#running').addClass("btn-success");
  $('#running').removeClass("btn-danger");
  }else {
    $('#running').addClass("btn-danger");
    $('#running').removeClass("btn-success");
  }


  $("#navbarToBeToggled > ul > li > a").removeClass("active");
  $("#" + instanceuuid).addClass("active");

  $("input[type=range]").val(volume).change();

}
/**
 *  Playbar
 */
function play(){
    $.ajax({
        url: "act.php?action=play",
        success: function(data) {
            infoMsg(data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            errorAlert.fire();
          }
    });
    playing = true;
    position = 0;
}

function stop() {
  $.ajax({
    url: "act.php?action=stop",
    success: function(data) {
        infoMsg(data);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        errorAlert.fire();
      }
    });
    playing = false;
}
function toggleRepeat() {
  $(function() {
      $.ajax({
          url: "act.php?action=togglerepeat",
          success: function(data) {
            infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
  });
}
function toggleShuffle() {
  $(function() {
      $.ajax({
          url: "act.php?action=toggleshuffle",
          success: function(data) {
              infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
  });
}
function back() {
  $(function() {
      $.ajax({
          url: "act.php?action=back",
          success: function(data) {
              infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
  });
}
function forward() {
  $(function() {
      $.ajax({
          url: "act.php?action=forward",
          success: function(data) {
              infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
  });
}


/**
 * extra for now
 */
function chooseInstance(uuid){
  $("#navbarToBeToggled > ul > li > a").removeClass("active");
  $("#" + uuid).addClass("active");
  $.ajax({
      type: "POST",
      data: {instance:uuid, extra: "showMsg"},
      url: "act.php",
      success: function(data) {
          infoMsg(data);
          getData();
      },
  });
}

function ytSearch(q){
  loadingAlert.fire({
    title: alert_load_yt_title,
    html: alert_load_yt_msg,
  })
  $.ajax({
      url: "act.php?action=ytSearch&q=" + encodeURIComponent(q),
      success: function(data){
        try {
          var tmp = JSON.parse(data);
          Swal.fire({
            icon: 'error',
            title: tmp.title,
            text: tmp.message
          })
        } catch (e) {
          $("#ytResponse").html(data);
          $("#loadMore").show();
            if (nextPageToken == "") {
              $("#loadMore").addClass("disabled");
              $("#loadMore").html("There no Results");
              $("#changeType").hide();
            } else {
              $("#loadMore").removeClass("disabled");
              $("#loadMore").html("Show more");
              $("#changeType").show();
            }
        }
        Swal.close();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        Swal.close();
        errorAlert.fire();
      }
  });
}

function ytMore(){
  if (!($("#loadMore").hasClass("disabled"))) {
    loadingAlert.fire({
      title: alert_load_ytmore_title,
      html: alert_load_ytmore_msg,
    })
    $.ajax({
        url: "act.php?action=ytSearch&pageToken=" + encodeURIComponent(nextPageToken) + "&q=" + encodeURIComponent(q),
        success: function(data){
            $("#ytResponse").html($("#ytResponse").html() + data);
            if (nextPageToken == "") {
              $("#loadMore").addClass("disabled");
              $("#loadMore").html("There are no more Results");
              $("#changeType").hide();
            }
            if ($("#ytResponse > div:nth-child(1)").hasClass("list-group-item")) {
              $('#ytResponse .item').removeClass('grid-group-item');
              $('#ytResponse .item').addClass('list-group-item');
            }
            Swal.close();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            Swal.close();
            errorAlert.fire();
          }
    });
  }

}




$('#ytForm').submit(function( event ) {
 q = $('#ytSearch').val();
 ytSearch(q);
});




function ytPlay(url){
      $.ajax({
          url: "act.php?ytUrl=" + encodeURIComponent(url),
          success: function(data) {
              infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
}

function ytQueue(url){
      $.ajax({
          url: "act.php?ytQueue=" + encodeURIComponent(url),
          success: function(data) {
              infoMsg(data);
              getData();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              errorAlert.fire();
            }
      });
}



const errorAlert = Swal.mixin({
  icon: 'error',
  title: alertErrorTitle,
  text: alertErrorText
})

const loadingAlert = Swal.mixin({
  onBeforeOpen: () => {
    Swal.showLoading()
  },
  allowOutsideClick: false,
  allowEscapeKey: false,
  allowEnterKey:false,
})


const InfoMsg = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

function infoMsg(response){
  var data = JSON.parse(response);
  InfoMsg.fire({
      icon: data.status,
      title: data.message
    })
}
