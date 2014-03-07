$(function() {
  $('#pending, #sortable').sortable({
    connectWith: '.connectedSortable',
    stop: function(event, ui) {
      var from = this.getAttribute("id");
      var to = ui.item[0].parentNode.getAttribute("id");

      /* Don't allow dropping courses into "pending" course selection list */
      if (to == "pending") {
        $(this).sortable('cancel');
      }
    },
    receive: function(event, ui) {
      var action = "change";
      if (ui.sender.attr("data-term") == "000000") {
        action = "add";

        $.ajax({
          type: "GET",
          url: "api/course/"+ui.item.attr("data-cid"),
          success: function(data) {
            /* Update UI element with the course description */
            event.toElement.innerHTML += " - "+JSON.parse(data)["name"];
          }
        });
      }

      $.ajax({
        type: "GET", 
        url: "api/user",
        success: function (data) {
            user_id = JSON.parse(data)['user_id'];
            console.log("got user id: " + user_id);
            $.ajax({
              type: "POST",
              url: "api/enrollment/"+action,
              data:
              {
                receiver: this.getAttribute("data-term"),
                user: user_id,
                course_id: ui.item.attr("data-cid"),
                sender: ui.sender.attr("data-term")
              }
            });
        }
      });
    } 
  }).disableSelection();
});

