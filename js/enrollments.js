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
      /* Update semester with correct number of credit hours */
      var credit_hours_div = $("ul[data-term="+list_id+"]").parent().children().last();
      var old_credits = credit_hours_div.html().split(" ")[0];
      var removed = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-credits');
      var new_credits = parseInt(old_credits) - parseInt(removed);
      credit_hours_div.html(new_credits+" credit hours");

      /* Remove div */
      $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").remove();

    }
  });
}

$(function() {
  $(".sortable li img").on('click', function(event) {
    deleteEnrollment(this);
  });
});
