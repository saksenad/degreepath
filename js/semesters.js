$(function() {
  $("#new-semester").click(function(event) {

    var div = $(
      '<div class="span3"> \
        <div id="semester" class="color-cccddd bucket"> \
          <h3 align="center">Summer 2015</h3> \
          <ul id="sortable" class="connectedSortable" data-term=201505> \
          </ul> \
        </div> \
      </div>'
    );

    $(div).insertBefore($("#semester-buckets").children().last());

  });
});
