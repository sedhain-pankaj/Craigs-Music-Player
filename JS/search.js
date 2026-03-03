//ajax to get the search results for all and karaoke
const searchDelay = 1000; // ms delay to let user finish typing

$(function () {
  var searchAllTimer = null;
  var searchKaraokeTimer = null;

  //Ajax to get the search_all results (debounced for both virtual and physical keyboard)
  $("#search_all").on("click input", function () {
    clearTimeout(searchAllTimer);
    searchAllTimer = setTimeout(function () {
      performSearch("search_all", "Karaoke", "All Songs (except Karaoke)");
    }, searchDelay);
  });

  //Ajax to get the search_karaoke results (debounced for both virtual and physical keyboard)
  $("#search_karaoke").on("click input", function () {
    clearTimeout(searchKaraokeTimer);
    searchKaraokeTimer = setTimeout(function () {
      performSearch("search_karaoke", null, "Only Karaoke", "Karaoke");
    }, searchDelay);
  });
});

function performSearch(searchId, excludeKey, searchMsg, searchKey = null) {
  var searchValue = $(`#${searchId}`).val();

  // Guard clause for empty input field
  if (searchValue == "") {
    $("#div_img_video_loader").html(
      `<h3>Search activated for ${searchMsg}.<br>` +
        "Fullscreen halts if Keyboard is active.</h3>",
    );
    return; // Exit function early
  }

  var searchLower = searchValue.toLowerCase();
  var filteredResults = [];

  //search on the cache for the searchValue except for the excludeKey category
  for (var key in cache) {
    if (searchKey && key !== searchKey) continue;
    if (!searchKey && key === excludeKey) continue;

    // Use regex to extract each <table>...</table> as a string instead of DOM parsing
    var tables = cache[key].response.match(/<table[^>]*>[\s\S]*?<\/table>/gi);
    if (!tables) continue;

    for (var t = 0; t < tables.length; t++) {
      var tableHtml = tables[t];
      // Extract the last <td> content using regex instead of DOM query
      var tdMatches = tableHtml.match(/<td[^>]*>([\s\S]*?)<\/td>/gi);
      if (!tdMatches || tdMatches.length === 0) continue;

      var lastTd = tdMatches[tdMatches.length - 1];
      // Strip tags to get text content
      var textContent = lastTd.replace(/<[^>]+>/g, "");

      if (textContent.toLowerCase().includes(searchLower)) {
        var regex = new RegExp(
          "(" + searchValue.replace(/[.*+?^${}()|[\]\\]/g, "\\$&") + ")",
          "gi",
        );
        var highlightedText = textContent.replace(
          regex,
          '<span style="background-color: #ffff99;">$1</span>',
        );
        // Replace the last td content in the table HTML
        var lastTdIndex = tableHtml.lastIndexOf(lastTd);
        var updatedTable =
          tableHtml.substring(0, lastTdIndex) +
          "<td>" +
          highlightedText +
          "</td>" +
          tableHtml.substring(lastTdIndex + lastTd.length);
        filteredResults.push(updatedTable);
      }
    }
  }

  // Guard clause for no results
  if (filteredResults.length === 0) {
    $("#div_img_video_loader").html(
      "<h3>No results found for your search <br>" +
        "'" +
        searchValue +
        "'. <br><br>" +
        "Try YouTube Search.</h3>",
    );
    return; // Exit function early
  }

  // Build all results as a single string, then insert once
  var resultsHtml = filteredResults.join("");

  $("#div_img_video_loader").html(
    `<h3> ${searchMsg} Results for : ' ${searchValue} '</h3><br>` +
      `<div id='${searchId}_results'>${resultsHtml}</div>`,
  );

  // replace the original index with the new <table> index
  $("#div_img_video_loader table").each(function (index) {
    $(this)
      .find("th#index")
      .text(index + 1);
  });
}
