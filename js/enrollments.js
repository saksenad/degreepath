$(function() {
  $.ajaxSetup({
    cache: false,
    data: null
  });

  $('.pending, .sortable').sortable(sortableOptions).disableSelection();
});

function deleteEnrollment(x) {
  var item = $(x).parent();
  var item_id = item.attr("data-cid");
  var list_id = item.parent().attr("data-term");

  $.ajax({
	  type: "POST",
	  url: "api/enrollment/delete",
    data:
    {
      course_id: item_id,
      sender: list_id
    },
    success: function() {
      $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").remove();
    }
  });
}

$(function() {
  $(".sortable li img").on('click', function(event) {
    deleteEnrollment(this);
  });
});
