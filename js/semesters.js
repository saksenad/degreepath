$(function() {
  $("#new-semester").click(function(event) {
    var current_term = $("#semester-buckets").children().last().prev().children().children("ul").attr("data-term");

    var div = $(
      '<div class="span3"> \
        <div id="semester" class="color-cccddd bucket"> \
          <h3 id="semester-header" align="center">'
            +displayTermName(autoIncrementSemester(current_term))+
            '<img class="remove-semester" src="/img/icons/x.png"></img> \
          </h3> \
          <ul id="sortable" class="connectedSortable" data-term="'
           +autoIncrementSemester(current_term)+'"> \
          </ul> \
        </div> \
      </div>'
    );

    $(div).insertBefore($("#semester-buckets").children().last());

    $(".remove-semester").on('click', function(event) {
      deleteSemester(this);
    });

  });
});

function autoIncrementSemester(current_term) {
  var increment = {"01":"05", "05":"08", "08":"01"};

  var season = current_term.substring(4,6);
  var year = current_term.substring(0,4);
 
  if (season == "08") {
    year++;
  }

  var new_term = year+increment[season];
  return new_term;
}

function displayTermName(term_code) {
  var seasons = {"01":"Spring", "05":"Summer", "08":"Fall"};

  var season = term_code.substring(4,6);
  var year = term_code.substring(0,4);

  return seasons[season]+" "+year;
}

function deleteSemester(x) {
  //Delete semester bucket
  $(x).parent().parent().parent().remove();
}

$(function() {
  $(".remove-semester").on('click', function(event) {
    deleteSemester(this);
  });
});
