var selectedDepartment;
var newDiv

/*Give the accordion functionality*/

$(function() {
    $("#accordion").accordion({
        collapsible: true,
        heightStyle: "content"
    });
});

/*Create the dropdwon auto correcting menu*/
$(function() {
	$.ajax({
    url:"/api/departments",
    type:'GET',
    success: function(departments){
      $( "#deptDropDown" ).autocomplete({
          source: JSON.parse(departments)
      }); 
    }
  });
});

/*Taking inputs from dropdown*/
$(document).ready(function () {
    $('#deptDropDown').on('autocompletechange change', function () {
        selectedDepartment=this.value;
    }).change();
});

/*Listens to Button*/
$(document).ready(function(){
    $("#deptButton").click(function() {
        $.ajax({
           url:"/api/courses/"+selectedDepartment+"/json",
           type:'GET',
           success: function(courses){

             /* Add a new accordion for the selected course */
             var newDiv = 
               '<h3> \
                 <span class="subject">'+selectedDepartment+'</span> \
                 <img class="remove-subject" src="/img/icons/x.png"></img> \
               </h3> \
               <div id="accordionWrapper" class="color-cccddd"> \
                 <ul id="pending" class="connectedSortable" data-term="000000">';

             JSON.parse(courses).forEach(function(course) {
               newDiv += '<li class="ui-state-default" data-cid={$course["id"]}>'+course["subject"]+' '+course["course_number"]+'</li>';
             });

             newDiv +=
                '</ul> \
               </div>';

             $('#accordion').append(newDiv);



             $(".remove-subject").on('click', function(event) {
                removeAccordionSubject(this);
              });


             $("#accordion" ).accordion({
                  collapsible: true,
                  heightStyle: "content"
              }); 
           }
        });    
    });
});

function removeAccordionSubject(x) {
  // Remove list of courses
  $(x).parent().next().remove();

  // Remove subject header
  $(x).parent().remove();
} 

$(document).ready(function(){
  $(function() {
    $(".remove-subject").on('click', function(event) {
      removeAccordionSubject(this);
    });
  });
});

 
