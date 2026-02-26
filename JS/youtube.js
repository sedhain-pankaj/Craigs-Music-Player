function search_youtube() {
  //create a input field for user to enter search query
  $("#div_img_video_loader").html(
    //create an input field with class="use-keyboard-input"
    "<input type='text' id='search_query' placeholder='Search YouTube' autocomplete='off'>" +
      "<button id='search_button'> &#9658; </button>" +
      "<h3>Interaction is restricted  for YouTube contents.<br><br>" +
      "API Keys provided by Google LLC. <br>" +
      "Copyright&copy; belongs to YouTube. <br><br>" +
      "<button class='button-left' id='speedtest' onclick='internet_speed()'> Perform SpeedTest </button>" +
      "<p id='internet_speed' style='font-size:clamp(1vw, 1.2vw, 2vw);'></p></h3>",
  );
}

//function to load youtube video
const load_youtube = () => {
  const search_query = $("#search_query").val();
  const search_query_url = `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${search_query}&type=video&videoEmbeddable=true&maxResults=10&key=${YT_API_Key}`;

  $.ajax({
    url: search_query_url,
    method: "GET",
    dataType: "json",
    success: (data) => {
      $("#div_img_video_loader").html(
        `<h3>
          Top 10 YouTube Results for : ' ${search_query} '
        </h3><br>
        <div id='search_results'></div>`,
      );

      data.items.forEach((item, i) => {
        const search_result = `
          <table class='search_result_table'> 
            <th id='index'>${i + 1}.</th>
            <th class='search_result_img'>
              <img src='${item.snippet.thumbnails.default.url}'>
            </th>
            <td class='yt_video_title'>${item.snippet.title}</td>
            <td class='yt_video_id' style='display:none;'>${
              item.id.videoId
            }</td>
          </table>`;

        $("#search_results").append(search_result);
      });

      loadYoutubeIframeAPI();

      $(".search_result_table").click(handleSearchResultClick);
    },
    error: (error) => {
      console.log(error);
      $("#div_img_video_loader").html(`<h3>Error: ${error.statusText}</h3>`);
    },
  });
};

const loadYoutubeIframeAPI = () => {
  const tag = document.createElement("script");
  tag.src = "https://www.youtube.com/iframe_api";
  const firstScriptTag = document.getElementsByTagName("script")[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
};

const handleSearchResultClick = function () {
  const yt_dir = `https://www.youtube.com/embed/${$(this)
    .find(".yt_video_id")
    .text()}`;

  if (queue_array.includes(yt_dir)) {
    var position = queue_array.indexOf(yt_dir) + 1;
    jquery_modal({
      message:
        "This song is already queued at number " + position + ". Once it is played from the queue, it can be added again.",
      title: "Song Already Queued",
    });
    return;
  }

  if (video.src.includes($(this).find(".yt_video_id").text())) {
    jquery_modal({
      message:
        "This song is being played currently. Once it ends completely, it can be re-added to queue.",
      title: "Song Being Played Currently",
    });
    return;
  }

  queue_array.push(yt_dir);

  $("#right-block-down").append(
    `<div class='queue_div'>
      <div class='queue_top'>
        <img src='${$(this).find(".search_result_img img").attr("src")}'>
        <div class='queue_buttons'>
          <button class='queue_remove_button' onclick='queue_array_remove(this, "${yt_dir}")'>Remove <i class='material-icons' id='backspace'>backspace</i></button>
          <button class='queue_movetop_button' onclick='queue_move_to_top(this, "${yt_dir}")'>Move to Top <i class='material-icons' id='move_to_top'>vertical_align_top</i></button>
        </div>
      </div>
      <div class='queue_bottom'>
        <span class='queue_number'></span>
        <span class='queue_name'>(YouTube) : ${$(this).find(".yt_video_title").text()}</span>
      </div>
    </div>`,
  );
  renumber_Queue();

  $("#right-block-down").animate(
    { scrollTop: $("#right-block-down").prop("scrollHeight") },
    500,
  );

  if (queue_array.length === 1 && $("video").attr("src") === "") {
    play_Queue();
  }
};

function internet_speed() {
  $("#internet_speed").html(
    "Wait <br> <i class='material-icons' style='font-size:clamp(1vw, 4vw, 5vw);'>network_check</i>",
  );

  var testUrl =
    "https://upload.wikimedia.org/wikipedia/commons/3/3d/LARGE_elevation.jpg"; // A large image file for testing
  var startTime = new Date().getTime();

  fetch(testUrl + "?t=" + startTime, { cache: "no-store" })
    .then(function (response) {
      if (!response.ok) throw new Error(response.statusText);
      return response.blob();
    })
    .then(function (blob) {
      var endTime = new Date().getTime();
      var duration = (endTime - startTime) / 1000;
      var bitsLoaded = blob.size * 8;
      var speedMbps = (bitsLoaded / duration / 1024 / 1024).toFixed(2);

      var icon =
        "<i class='material-icons' style='font-size:clamp(1vw, 4vw, 5vw);'>";
      var quality;

      if (speedMbps >= 5) {
        quality = icon + "verified</i><br>Excellent for YouTube";
      } else if (speedMbps >= 2) {
        quality = icon + "verified</i><br>Good for YouTube";
      } else if (speedMbps >= 0.5) {
        quality = icon + "warning</i><br>May buffer on YouTube";
      } else {
        quality = icon + "error</i><br>Too slow for YouTube";
      }

      $("#internet_speed").html(quality + "<br>" + speedMbps + " Mbps");
    })
    .catch(function (err) {
      console.log(err);
      $("#internet_speed").html("Error: Could not perform speed test.");
    });
}
