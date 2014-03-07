var selectedDepartment;
var newDiv




/*Give the accordion functionality*/

$(function() {
    $("#accordion" ).accordion({
        collapsible: true,
        heightStyle: "content"
    });
});

/*Create the dropdwon auto correcting menu*/
$(function() {
	var departments=["AE","AS","APPH","ASE","ARBC","ARCH","BIOL","BMEJ","BMED","BMEM","BC","CETL","CHBE","CHEM","CHIN","CP","CEE","COA","COE","COS","CX","CSE","CS","COOP","UCGA","EAS","ECON","ECE","ENGL","FS","FREN","GT","GTL","GRMN","HS","HIST","HTS","ISYE","ID","IPCO","IPIN","IPFS","IPSA","INTA","IL","INTN","IMBA","JAPN","KOR","LS","LING","LCC","MGT","MOT","MSE","MATH","ME","MP","MSL","MUSI","NS","NRE","PERS","PHIL","PHYS","POL","PTFE","DOPP","PSYC","PUBP","PUBJ","RGTR","RUSS","SOC","SPAN"];
	$( "#deptDropDown" ).autocomplete({
      source: departments
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
        //newDiv = "<h3>This is kewl</h3><div>Me no Likee JS</div>"+selectedDepartment;
        $.ajax({
           url:"http://ec2-50-112-187-67.us-west-2.compute.amazonaws.com/api/departmentDiv/"+selectedDepartment,
           type:'GET',
           success: function(data){
               newDiv=data;
               alert(data);
               $('#accordion').append(newDiv);
               $("#accordion" ).accordion({
                    collapsible: true,
                    heightStyle: "content"
                }); 
           }
        });
        $('#accordion').append(newDiv);     
    });
});



 