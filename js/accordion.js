var selectedDepartment;
var newDiv;

/*Give the accordion functionality*/

$(function() {
    $("#accordion").accordion({
        collapsible: true,
        heightStyle: "content"
    });
});

$(function() {
    $("#transfer-accordion").accordion({
        collapsible: true,
        heightStyle: "content"
    });
});

/*Create the dropdwon auto correcting menu*/
$(document).ready(function() {
	$.ajax({
    url:"/api/departments",
    type:'POST',
    success: function(departments) {
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

              $.ajax({
                  url:"/api/users/subjects",
                  type:'POST',
                  data: {
                    subject: selectedDepartment
                  }
              });

             /* Add a new accordion for the selected course */
             var newDiv = 
               '<h3> \
                 <span class="subject">'+selectedDepartment+'</span> \
                 <img class="remove-subject" src="/img/icons/x.png"></img> \
               </h3> \
               <div id="accordionWrapper" class="color-cccddd"> \
                 <ul class="pending connectedSortable" data-term="999999">';

             JSON.parse(courses).forEach(function(course) {
                console.log(course);
                var item ='<li data-cid='+course["id"]+' data-credits='+course['credit_hours']+' data-gpa=' +course['GPA']+ '>'+course["subject"]+' '+course["course_number"]+'</li>';
                newDiv += item;
             });

             newDiv +=
                '</ul> \
               </div>';

   

             $('#accordion').append(newDiv);
             $(".pending").sortable(sortableOptions).disableSelection();
             

             $(".remove-subject").on('click', function(event) {
                removeAccordionSubject(this);
              });


             $("#accordion" ).accordion("refresh"); 
           }
        });  
    });
});

function removeAccordionSubject(x) {
  var subject = $(x).parent().children().eq(1).text();

  $.ajax({
    url:"/api/users/subjects/"+subject,
    type:'DELETE',
    success: function() {
      // Remove list of courses
      $(x).parent().next().remove();

      // Remove subject header
      $(x).parent().remove();
    }
  });
} 

$(document).ready(function(){
  $(function() {
    $(".remove-subject").on('click', function(event) {
      removeAccordionSubject(this);
    });
  });
});

 
