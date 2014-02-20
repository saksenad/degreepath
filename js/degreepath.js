$(function() {
  $('#pending, #sortable').sortable({
    connectWith: '.connectedSortable',
    receive: function(event, ui) {
      console.log(ui);
      $.ajax({
        type: "POST",
        url: "enrollment",
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

