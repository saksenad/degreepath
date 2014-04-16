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
    var to = this.getAttribute("data-term");
    var from = ui.sender.attr("data-term");
    var cid = ui.item.attr("data-cid");

    if (ui.sender.attr("data-term") == "999999") {
      action = "add";

      $.ajax({
        type: "GET",
        url: "api/course/"+cid,
        success: function(data) {
          /* Update UI element with the course description */
          $(event.toElement).html(
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
        receiver: to,
        course_id: cid,
        sender: from
      },
      success: function(data) {
        /* Update semester with correct number of credit hours */
        var children = $("ul[data-term="+to+"]").parent().children();
        var credit_hours_div = children.last();
        var old_credits = credit_hours_div.html().split(" ")[0];
        var added_credits = $("ul[data-term="+to+"] > li[data-cid="+cid+"]").attr('data-credits');
        if (added_credits == null) added_credits = 0;
        var new_credits = parseInt(old_credits) + parseInt(added_credits);
        credit_hours_div.html(new_credits+" credit hours");

        /* Update GPA */
        var gpa_div = children.filter(":nth-last-child(2)");
        var old_gpa = gpa_div.html().split(" ")[0];
        var old_points = parseFloat(old_gpa) * parseInt(old_credits);
        var added_gpa = $("ul[data-term="+to+"] > li[data-cid="+cid+"]").attr('data-gpa');
        if (added_gpa == null) added_gpa = 0;
        var added_points = parseFloat(added_gpa) * parseInt(added_credits);
        var new_points = old_points + added_points;
        var new_gpa = (new_credits > 0)? (new_points / new_credits) : 0;
        new_gpa = new_gpa.toFixed(2);
        gpa_div.html(new_gpa+" GPA");

        if(action == "change") {
          /* Update semester with correct number of credit hours */
          var children = $("ul[data-term="+from+"]").parent().children();
          var credit_hours_div = children.last();
          var old_credits = credit_hours_div.html().split(" ")[0];
          var removed_credits = $("ul[data-term="+to+"] > li[data-cid="+cid+"]").attr('data-credits');
          if (removed_credits == null) removed_credits = 0;
          var new_credits = parseInt(old_credits) - parseInt(removed_credits);
          credit_hours_div.html(new_credits+" credit hours");

          /* Update GPA */
          var gpa_div = children.filter(":nth-last-child(2)");
          var old_gpa = gpa_div.html().split(" ")[0];
          var old_points = parseFloat(old_gpa) * parseInt(old_credits);
          var removed_gpa = $("ul[data-term="+to+"] > li[data-cid="+cid+"]").attr('data-gpa');
          if (removed_gpa == null) removed_gpa = 0;
          var removed_points = parseFloat(removed_gpa) * parseInt(removed_credits);
          var new_points = old_points - removed_points;
          var new_gpa = (new_credits > 0)? (new_points / new_credits) : 0;
          new_gpa = new_gpa.toFixed(2);
          gpa_div.html(new_gpa+" GPA");
        }

      }
    });
  } 
};
