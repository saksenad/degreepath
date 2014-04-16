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
      var children = $("ul[data-term="+list_id+"]").parent().children();

      var credit_hours_div = children.last();
      var old_credits = credit_hours_div.html().split(" ")[0];
      var removed_credits = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-credits');
      if (removed_credits == null) removed_credits = 0;
      var new_credits = parseInt(old_credits) - parseInt(removed_credits);
      credit_hours_div.html(new_credits+" credit hours");

      /* Update GPA */
      var gpa_div = children.filter(":nth-last-child(2)");
      var old_gpa = gpa_div.html().split(" ")[0];
      var old_points = parseFloat(old_gpa) * parseInt(old_credits);
      var removed_gpa = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-gpa');
      if (removed_gpa == null) removed_gpa = 0;
      var removed_points = parseFloat(removed_gpa) * parseInt(removed_credits);
      var new_points = old_points - removed_points;
      var new_gpa = (new_credits > 0)? (new_points / new_credits) : 0;
      new_gpa = new_gpa.toFixed(2);
      gpa_div.html(new_gpa+" GPA");

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
