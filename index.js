//show or hide different search options
$(document).ready(function () {
  video_scaler();
  selectTextDisabled();
  searchCondition();
  autoShuffle();
  skipVideo();
  queue_scroll_top();
  volume_slider();
  volume_changer();
});

//call function closeNav() when click outside of class sidenav or id randomizer
$(document).click(function (e) {
  if (
    !$(e.target).closest(".sidenav").length &&
    !$(e.target).closest("#randomizer").length
  ) {
    closeNav();
  }
});

//function to scale down video to fit within video_container and pointer events to auto
function video_scaler() {
  var $video = $("video");
  var $container = $("#video_container");
  var w = $container.width();
  var h = $container.height();
  $video.css({ width: w, height: h, "pointer-events": "auto" })
        .attr({ width: w, height: h });

  //non-jQuery to apply for event generated video == $0
  document.getElementById("video").volume = $("#vol").html() / 100;
}

//disable select text on click in whole document
function selectTextDisabled() {
  $(document).on("selectstart", function (e) {
    e.preventDefault();
  });

  //disable image dragging
  $(document).on("dragstart", function (e) {
    e.preventDefault();
  });
}

//search options
function searchCondition() {
  $("#search_karaoke").hide();
  $("#select").selectmenu({
    change: function (event, data) {
      const isKaraoke = data.item.value == "karaoke";
      $("#search_karaoke").toggle(isKaraoke).focus();
      $("#search_all").toggle(!isKaraoke).focus();
    },
  });
}

//run the 80s shuffle function if no songs are playing
function autoShuffle() {
  var timeout = false;
  function onActivity() {
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      if ($("video").attr("src") == "" && queue_array.length == 0) {
        shuffleAjaxCall("shuffle_80", 2);
      }
    }, 1);
  }

  // Single set of listeners for auto-shuffle activity detection
  ["mousedown", "mousemove", "click"].forEach(function (evt) {
    document.addEventListener(evt, onActivity);
  });
  onActivity();
}

//mejs player
function mejs_media_Player(func_restarter) {
  $("video").mediaelementplayer({
    iconSprite: "/jquery-framework/images/mejs-controls.svg",
    success: function (mediaElement, DOMObject, player) {
      mediaElement.addEventListener("ended", function (e) {
        $("video").css("pointer-events", "auto");
        func_restarter();
      });

      //once the video starts, set the volume
      mediaElement.addEventListener("play", function (e) {
        document.getElementById("video").volume = $("#vol").html() / 100;
      });

      mediaElement.addEventListener("rendererready", function (e) {
        document.getElementById("video").volume = $("#vol").html() / 100;
      });

      mediaElement.addEventListener("loadedmetadata", function (e) {
        document.getElementById("video").volume = $("#vol").html() / 100;
      });

      //fullscreen the video afters 7s of inactivity if "video").attr("src") != ""
      //if not already fullscreen
      var timeout2 = false;
      function checkActivity2() {
        clearTimeout(timeout2);
        timeout2 = setTimeout(function () {
          //error handlers and conditions for fullscreen
          if (
            $("video").attr("src") != "" &&
            !player.isFullScreen &&
            !player.paused &&
            !player.error &&
            player.readyState == 4 &&
            //if keyboard is disabled or hidden
            (!displayKeyboard || $(".keyboard--hidden").length)
          ) {
            player.enterFullScreen();
            $("video").attr("width", $("video").width());
            $("video").attr("height", $("video").height());
          }
        }, 7000);
      }

      ["mousedown", "mousemove", "click"].forEach(function (evt) {
        document.addEventListener(evt, checkActivity2);
      });
      checkActivity2();

      //if player is fullscreen, exit fullscreen if user clicks on the video
      document.getElementsByClassName("mejs__mediaelement")[0].addEventListener("click", function () {
        if (player.isFullScreen) {
          player.exitFullScreen();
          $("video").attr("width", $("video").width());
          $("video").attr("height", $("video").height());
          //console.log("video resized");
        } else {
          //if player is paused, play the video
          if (player.paused) {
            player.play();
          }
        }
      });
    },

    error: function (e) {
      console.log("media element error:" + e);

      $("#video_container").empty();
      //create a new media element in the video container
      $("#video_container").html(
        "<video id='video' src='' autoplay preload='auto'></video>",
      );

      //video dimensions scale to fit the container
      video_scaler();

      //if queue_array is not empty, play_Queue()
      func_restarter();

      jquery_modal({
        message:
          "Error usually comes via YouTube's content restrictions. Skipping to next song.",
        title: "An Error was Detected",
      });
    },

    clickToPlayPause: false,
    features: [
      "playpause",
      "progress",
      "current",
      "duration",
      "volume",
      "fullscreen",
    ],
    enableKeyboard: false,
    useFakeFullscreen: true,
    enableAutosize: true,
  });
}

//function to move queue scrollbar to the top of the queue after 10 seconds of inactivity
function queue_scroll_top() {
  var timeout3 = false;
  function onActivity() {
    clearTimeout(timeout3);
    timeout3 = setTimeout(function () {
      $("#right-block-down").animate({ scrollTop: 0 }, 500);
    }, 10000);
  }

  ["mousedown", "mousemove", "click"].forEach(function (evt) {
    document.addEventListener(evt, onActivity);
  });
  onActivity();
}

// create a jqueryUI slider to control volume for whole system
// Cached volume DOM elements to avoid repeated lookups
var $volEl, $sliderEl, $muteEl, videoEl;

function _cacheVolumeElements() {
  $volEl = $("#vol");
  $sliderEl = $("#slider");
  $muteEl = $("#mute");
  videoEl = document.getElementById("video");
}

function _applyVolumeStyle(vol) {
  if (vol == 0) {
    videoEl.muted = true;
    $muteEl.html("volume_off").css("color", "#7e0000");
    $sliderEl.css("background-color", "#7e0000");
    $volEl.css("color", "#7e0000");
  } else {
    videoEl.muted = false;
    $muteEl.html("volume_up").css("color", "#155d62");
    $sliderEl.css("background-color", "white");
    $volEl.css("color", "#033e30");
  }
}

function volume_slider() {
  _cacheVolumeElements();
  $sliderEl.slider({
    animate: "fast",
    value: 50,
    min: 0,
    max: 100,
    step: 1,
    slide: function (event, ui) {
      $volEl.html(ui.value);
      videoEl.volume = ui.value / 100;
      _applyVolumeStyle(ui.value);
    },
  });
}

function volume_changer() {
  // when clicked on id=vol_down, decrease slider value by 1 and set volume to that value
  $("#vol_down").click(function () {
    var vol = parseInt($volEl.html());
    if (vol > 0) {
      vol--;
      $sliderEl.slider("value", vol);
      videoEl.volume = vol / 100;
      $volEl.html(vol);
      _applyVolumeStyle(vol);
    }
  });

  // when clicked on id=vol_up, increase slider value by 1 and set volume to that value
  $("#vol_up").click(function () {
    var vol = parseInt($volEl.html());
    if (vol < 100) {
      vol++;
      $sliderEl.slider("value", vol);
      videoEl.volume = vol / 100;
      $volEl.html(vol);
    }
    _applyVolumeStyle(vol);
  });

  // volume before mute, used to restore on unmute
  var preMuteVolume = 0;
  var mutedByButton = false;

  // when clicked on id=mute, mute the video and change icon to volume_off
  $muteEl.click(function () {
    var vol = parseInt($volEl.html());
    if (vol > 0) {
      preMuteVolume = vol;
      mutedByButton = true;
      $sliderEl.slider("value", 0);
      videoEl.volume = 0;
      $volEl.html(0);
      _applyVolumeStyle(0);
    } else if (mutedByButton) {
      mutedByButton = false;
      $sliderEl.slider("value", preMuteVolume);
      videoEl.volume = preMuteVolume / 100;
      $volEl.html(preMuteVolume);
      _applyVolumeStyle(preMuteVolume);
    } else {
      jquery_modal({
        message:
          "Volume was already muted via slider. Use the <b style='font-size:1.2rem'>+</b> or <b style='font-size:1.8rem'>-</b>  button to set the volume.",
        title: "Volume Already Muted",
      });
    }
  });
}
