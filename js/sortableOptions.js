var sortableOptions = {
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
          $(event.toElement).append(
            '<div class="course-title">'+event.toElement.innerHTML+' - '+JSON.parse(data)["name"]+'</div> \
             <img class="remove" src="/img/icons/x.png"></img>'                    
          );


          $(".sortable li img").on('click', function(event) {
            deleteEnrollment(this);
          });
        }
      });
    }
    $.ajax({
      type: "POST",
      url: "api/enrollment/"+action,
      data:
      {
        receiver: this.getAttribute("data-term"),
        course_id: ui.item.attr("data-cid"),
        sender: ui.sender.attr("data-term")
      }
    });
  } 
};