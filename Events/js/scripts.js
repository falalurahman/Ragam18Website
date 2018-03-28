$(document).ready(function () {
    var url = window.location.href;
    var res = url.split("#");
    var category = res[1];
    load_data(category);
});
function load_data(category){
  $.ajax({
    async: false,
    global: false,
    url:"data.json",
    dataType: "json",
    success:function(e){
      events=e;
      create_events_page(category);
    },
    complete:function(e){
    }
  });
}

var events=[];
function create_events_page(category){
  events=events[category];
  var i=0;
  var html="";
  events.forEach(function(event){
      var imgname=event.name.toLowerCase().replace(" ","_").replace("(","-").replace(")","-").replace(" ","").replace(" ","_").replace(" ","_");
    var image='img/events/'+imgname+'.jpg';
    if(i===0){
      html+="<div class='bg_image' id='event_bg0' style='background-image: url("+image+")'></div>";
    }
    else{
      html+="<div class='bg_image' id='event_bg"+i+"' style='display:none;background-image: url("+image+")'></div>";
    }
    i=i+1;
  });
  html+="<div id='grey_filter'></div>";
  html+="<div id='fullpage'>";
  html+="  <div class='section'>";
  i=0;
  events.forEach(function(event){
    var imgname=event.name.toLowerCase().replace(" ","_").replace("(","-").replace(")","-").replace(" ","").replace(" ","_").replace(" ","_");
    var eventid=event.id;
    var image='img/events/'+imgname+'.jpg';
    html+="<div class='slide'>";
    html+="  <div class='event' id='event"+i+"'>";
    html+="    <div class='event_row'>";
    html+="      <div class='event_left'>";
    html+="          <div class='event_image' style='background-image: url("+image+");'></div>";
    html+="          <div class='event_name'>"+event.name+"</div>";
    html+="      </div>";
    html+="<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>"
    html+="      <div class='event_right'>";
    html+="          <div class='event_tabs'>";
    html+="            <div id='event_tab"+i+"_1' class='event_tab event_tab"+i+" event_tab_active' onclick='display_content("+i+",1)'>Description</div>|";
    html+="            <div id='event_tab"+i+"_2' class='event_tab event_tab"+i+"' onclick='display_content("+i+",2)'>Prize</div>|";
    html+="            <div id='event_tab"+i+"_3' class='event_tab event_tab"+i+"' onclick='display_content("+i+",3)'>Contact</div>";
    html+="          </div>";
    html+="          <div class='event_info' id='info"+i+"'>"+event.description+"</div>";
    html+="          <div class='event_register'>";
    if(category!=='RAGNAROK') {
        html += "            <div class='event_register_button intense' data-image=\"img/event_details/" + eventid + ".jpg\">More details</div>";
    }
    if(category!=='KALOLSAVAM' && category!=='QUIZZING' && category!=='RAGNAROK'){
      html+="            <div id='reg_act"+eventid+"' class='event_register_button' onclick='register(\""+eventid+"\")'>Register</div>";
    }
    html+="          </div>";
    html+="      </div>";
    html+="    </div>";
    html+="  </div>";
    html+="</div>";
    i=i+1;
  });
  html+=" </div>";
  html+="</div>";
  $("#screen").html(html);
  $("#fullpage").fullpage({
    controlArrows:true,
    slidesNavigation : true,
    normalScrollElements: '.event_info, .event_image',
    normalScrollElementTouchThreshold: 5,
    onSlideLeave: function( anchorLink, index, slideIndex, direction, nextSlideIndex){
                      $("#event_bg"+slideIndex).fadeOut();
                      /*if(slideIndex<nextSlideIndex){
                        $("#event"+slideIndex).hide('clip', {direction: 'right'}, 600);
                        $("#event"+nextSlideIndex).show('slide', {direction: 'left'}, 600);
                      }
                      else{
                        $("#event"+slideIndex).hide('clip', {direction: 'left'}, 600);
                        $("#event"+nextSlideIndex).show('slide', {direction: 'right'}, 600);
                      }*/
                      $("#event_bg"+nextSlideIndex).fadeIn();
                  }
  });
  $(document).mousemove(function(e) {
      var left_bias=(e.pageX-(window.innerWidth/2))/window.innerWidth;
      var top_bias=(e.pageY-(window.innerHeight/2))/window.innerHeight;
      var background_X=40+left_bias*20;
      var background_Y=40+top_bias*20;
      $(".bg_image").css('background-position',background_X+'% '+background_Y+'%');
  });
  window.addEventListener("deviceorientation", function(e){
      var left_bias=e.gamma/100;
      var top_bias=e.beta/90;
      var background_X=40+left_bias*20;
      var background_Y=40+top_bias*20;
      $(".bg_image").css('background-position',background_X+'% '+background_Y+'%');

  }, true);

}


function display_content(eventid,content){
  if(content==1){
    $("#info"+eventid).html(events[eventid].description);
  }
  if(content==2){
    $("#info"+eventid).html(events[eventid].prize);
  }
  if(content==3){
    $("#info"+eventid).html(events[eventid].contact);
  }
  $(".event_tab"+eventid).removeClass('event_tab_active');
  $("#event_tab"+eventid+"_"+content).addClass("event_tab_active");
}


function register(eventid){
  if(eventid==='EID001'){
  	alert("Send your submissions to dance@ragam.org.in");
  }else if(eventid === 'EID005'){
  	alert("Send your submissions to drama@ragam.org.in");
  }else if(eventid === 'EID013'){
  	alert("Send your submissions to fs@ragam.org.in");
  }else if(eventid === 'EID033'){
  	alert("Send your submissions to acoustics@ragam.org.in");
  }else if(eventid === 'EID034'){
  	alert("Send your submissions to amplified@ragam.org.in");
  }else if(eventid === 'EID037'){
  	alert("Send your submissions to swararaaga@ragam.org.in");
  }else
  if(loggedIn) {
      $.ajax({
          method: "POST",
          url: "php/addEventRegistration.php",
          data: "EventID=" + eventid,
          success: function (response) {
              if (response == "SUCCESS") {
                  alert("Registration Successful");
                  $("#reg_act" + eventid).html("Unregister");
                  $("#reg_act" + eventid).attr('onclick', "unregister(\"" + eventid + "\")");
              }
              else {
                  alert("Registration error");
              }
          },
          complete: function (response) {
          }
      });
  }else {
    window.location.href = redirectUrl;
  }
}

function unregister(eventid){
    $.ajax({
        method:"POST",
        url : "php/deleteEventRegistration.php",
        data : "EventID="+eventid,
        success:function(response){
            if(response=="SUCCESS"){
                alert("Unregistration Successful");
                $("#reg_act"+eventid).html("Register");
                $("#reg_act"+eventid).attr('onclick',"register(\""+eventid+"\")");
            }
            else{
                alert("Unregistration error");
            }
        },
        complete:function(response){
        }
    });
}

var loggedIn = -1;
var redirectUrl;


$(window).on("load", function() {
    checkLogin();
    loaded();
    var elements = document.querySelectorAll( '.intense' );
    Intense( elements );
});

function checkLogin() {
    $.post('../Login/checkLogin.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            var status = data_decoded['status'];

            if( status === "Success" )
            {
                loggedIn = 1;
                $(".login").remove();
                checkMainRegistration();
                checkEventRegistration();
            }else
            {
                loggedIn = 0;
                redirectUrl = data_decoded['redirectUrl'];
                $(".barcode").remove();
                $(".logout").remove();
                $(".login").click(function () {
                    window.location.href = data_decoded['redirectUrl'];
                });
            }
        });
}

function checkEventRegistration(){
    $.post('php/checkEventRegistration.php',{},
        function ( data ) {
            var data_decoded = JSON.parse(data);
            for( var i in data_decoded ){
                $("#reg_act"+data_decoded[i]).html("Unregister");
                $("#reg_act"+data_decoded[i]).attr('onclick',"unregister(\""+data_decoded[i]+"\")");
            }
        });
}
