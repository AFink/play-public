var darkmode = false;


$('.darkmode-toggle').click(function(){
  toggleDarkmode();
})


function isInDarkmode() {
  var cookie = getCookie("darkmode");
  if (cookie != null){
    return cookie;
  }
 if (window.matchMedia) {
   if(window.matchMedia('(prefers-color-scheme: dark)').matches){
     return true;
   } else {
     return false;
   }
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
  if(darkmode.toString() == "true"){
    setCookie("darkmode",true,1);
    $('html').addClass("darkmode");
  }else {
    setCookie("darkmode",false,1);
    $('html').removeClass("darkmode");
  }
}

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
