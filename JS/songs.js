//variables to cache the song categories data
var cache = {};

//load all the variables to cache the song categories data when program first loads
$(document).ready(function () {
  var categories = [
    { key: "5060", value: "50's & 60's" },
    { key: "70", value: "70's" },
    { key: "80", value: "80's" },
    { key: "90", value: "90's" },
    { key: "2000", value: "2000's" },
    { key: "LatestHits", value: "Latest Hits" },
    { key: "Country", value: "Country" },
    { key: "Karaoke", value: "Karaoke" },
    { key: "SpecialOccasion", value: "Special Occasion" },
    { key: "ChristmasSong", value: "Christmas Song" },
  ];

  categories.forEach(function (category) {
    $.ajax({
      type: "GET",
      url: "logic.php",
      data: category.key,
      dataType: "html",
      success: function (response) {
        cache[category.key] = { response: response, msg: category.value };
      },
    });
  });
});

//when the user clicks on the song category, the cache is parsed by PHP for final render
$(document).on("click", ".button-left", function () {
  var id = $(this).attr("id")
  if (cache[id]) {
    showSongs(cache[id].response, cache[id].msg + ": ");
  }
  $("#div_img_video_loader").scrollTop(0);
});

function showSongs(response, msg) {
  $("#div_img_video_loader").html(
    "<h3>" + msg + "</h3><br>" + "<div id='showSongs'></div>"
  );
  $("#showSongs").append(response);
}