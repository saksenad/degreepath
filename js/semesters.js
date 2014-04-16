$(function() {
  $("#new-semester").click(function(event) {
    addSemester(this)
  });
});

function addSemester(bucket) {
  var current_term = '201405';
  if ($("#semester-buckets").children().length > 1) {
    current_term = $("#semester-buckets").children().last().prev().children().children("ul").attr("data-term");
  }

  var new_term = autoIncrementSemester(current_term);

  $.ajax({
    url:"/api/users/semesters",
    type:'POST',
    data: {
      term_code: new_term
    },
    success: function() {
      var div = $(
        '<div class="span3"> \
          <div id="semester" class="color-cccddd bucket"> \
            <h3 id="semester-header" align="center">'
              +displayTermName(new_term)+
              '<img class="remove-semester" src="/img/icons/x.png"></img> \
            </h3> \
            <ul class="sortable connectedSortable" data-term="'
             +new_term+'"> \
            </ul> \
            <h5 class="pull-right" style="margin-right:10px">0 GPA</h5> \
            <h5 class="pull-left" style="margin-left:10px">0 credit hours</h5> \
          </div> \
        </div>'
      );

      $(div).insertBefore($("#semester-buckets").children().last());
      $(".sortable").sortable(sortableOptions).disableSelection();

      $(".remove-semester").on('click', function(event) {
        deleteSemester(this);
      });
    }
  });
}

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
  var term_code = $(x).parent().parent().children('ul').attr("data-term");

  $.ajax({
    url:"/api/users/"+term_code,
    type:'DELETE',
    success: function() {
      $(x).parent().parent().parent().remove(); 
    }
  });
}

$(function() {
  $(".remove-semester").on('click', function(event) {
    deleteSemester(this);
  });
});
