var sortableOptions = {
  connectWith: '.connectedSortable',
  stop: function(event, ui) {
    var to = ui.item[0].parentNode.getAttribute("class");
    
    /* Don't allow dropping courses into "pending" course selection list */
    if (to.indexOf("pending") != -1) {
      $(this).sortable('cancel');
    }
  },
  receive: function(event, ui) {
    var action = "change";
    if (ui.sender.attr("data-term") == "999999") {
      action = "add";

      $.ajax({
        type: "GET",
        url: "api/course/"+ui.item.attr("data-cid"),
        success: function(data) {
          /* Update UI element with the course description */
          $(event.toElement).html(
            '<div class="course-title">'+event.toElement.innerHTML+' - '+JSON.parse(data)["name"]+'</div> \
             <img class="remove" src="/img/icons/x.png"></img>'                    
          );

          $(".sortable li img").on('click', function(event) {
            deleteEnrollment(this);
          });

          /* Update semester with correct number of credit hours */
          var list_id = $(event.toElement).parent().attr("data-term");
          var item_id = $(event.toElement).attr("data-cid");
          var credit_hours_div = $("ul[data-term="+list_id+"]").parent().children().last();
          var old_credits = credit_hours_div.html().split(" ")[0];
          var added = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-credits');
          var new_credits = parseInt(old_credits) + parseInt(added);
          credit_hours_div.html(new_credits+" credit hours");

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
