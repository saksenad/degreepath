$(function() {
  $("#new-semester").click(function(event) {

    var div = $(
      '<div class="span3"> \
        <div id="semester" class="color-cccddd bucket"> \
          <h3 id="semester-header" align="center"> \
            Spring 2015 \
            <img class="remove-semester" src="/img/icons/x.png"></img> \
          </h3> \
          <ul id="sortable" class="connectedSortable" data-term=201505> \
          </ul> \
        </div> \
      </div>'
    );

    $(div).insertBefore($("#semester-buckets").children().last());

  });
});

$(function() {
  $(".remove-semester").click(function(event) {
    $(this).parent().parent().parent().remove();
  });
});
