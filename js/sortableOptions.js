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
          var children = $("ul[data-term="+list_id+"]").parent().children();
          var credit_hours_div = children.last();
          console.log(credit_hours_div);
          var old_credits = credit_hours_div.html().split(" ")[0];
          var added_credits = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-credits');
          var new_credits = parseInt(old_credits) + parseInt(added_credits);
          credit_hours_div.html(new_credits+" credit hours");

          /* Update GPA */
          var gpa_div = children.filter(":nth-last-child(2)");
          var old_gpa = gpa_div.html().split(" ")[0];
          var old_points = parseFloat(old_gpa) * parseInt(old_credits);
          var added_gpa = $("ul[data-term="+list_id+"] > li[data-cid="+item_id+"]").attr('data-gpa');
          var added_points = parseFloat(added_gpa) * parseInt(added_credits);
          var new_points = old_points + added_points;
          var new_gpa = new_points / new_credits;
          new_gpa = new_gpa.toFixed(2);
          gpa_div.html(new_gpa+" GPA");

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
