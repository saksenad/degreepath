$(function() {
  $('#pending, #sortable0, #sortable1, #sortable2, #sortable3').sortable({
    connectWith: '.connectedSortable',
    receive: function(event, ui) {
      console.log(ui);
      $.ajax({
        type: "POST",
        url: "changeEnrollment.php",
        data:
        {
          receiver: this.getAttribute("data-term"),
          user: 1,
          course_id: ui.item.attr("data-cid"),
          sender: ui.sender.attr("data-term")
        }
      });
    } 
  }).disableSelection();
});

