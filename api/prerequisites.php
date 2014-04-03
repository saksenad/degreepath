<?php

require_once 'api/prefix.php';

//Prereq Processing Functions----->Goes to prerequisites.php and uncomment require on top

/*Returns JSON {"pass":[\list of classes\],
"fail":[\list of classes\]} to return 
a list of courses whose preReq status changed with 
moving the course for the given user
Call the function after the move is updted in the DB*/
function getPreReqsFailedOnChange($course_id,$user_id){

  global $conn;
  //Getting class Row
  $query = sprintf("SELECT * 
  FROM courses
  WHERE id = %d;", $course_id);

  $result = mysqli_query($conn, $query) or die('Error, query failed');
  $paramClassRow = mysqli_fetch_assoc($result);

  //Compiling list of classes that need to be checked
  $classesEffected=array();
  $classesEffected=getClassesWithThisPreReq($course_id);
  array_push($classesEffected,$paramClassRow);

  //Creating list of classes that need to be checked
  $pass=array();
  $fail=array();

  foreach($classesEffected as $class){
    if(passClassPreReq($class['id'],$user_id)){
      array_push($pass, $class);
    } else {
      array_push($fail, $class);
    }
  }

  return json_encode(array( "pass" => $pass,
                            "fail" => $fail
          ));

}


/*Checks if the class passed in has prereqs satisfied
and returns true(if everything is order) or false*/
function passClassPreReq($course_id,$user_id){

  global $conn;
  //Getting class Row
  $query = sprintf("SELECT * 
        FROM enrollments
        INNER JOIN courses ON courses.id = enrollments.course_id
        WHERE enrollments.user_id =  %d
        AND courses.id =  '%d';", $user_id, $course_id);

  $result = mysqli_query($conn, $query) or die('Error, query failed');
  $paramClassRow = mysqli_fetch_assoc($result);

  $preReq=explode(" ",$paramClassRow['PreReqs']);
  $logicalString="";

  foreach($preReq as $bit){
    //The String is a class
    if (strpos($bit, ':') !== FALSE){

      $class=explode(":",$bit);

       $query = sprintf("SELECT * 
        FROM enrollments
        INNER JOIN courses ON courses.id = enrollments.course_id
        WHERE enrollments.user_id =  %d
        AND courses.subject =  '%s'
        AND courses.course_number = %d;", $user_id, $class[0], $class[1]);


        $result = mysqli_query($conn, $query) or die('Error, query failed');

        //TODO:Fix this logic and get eval to work and make sure pass and fail contain the correct lists of classes

        if (mysqli_num_rows($result) > 0) {
          $classRow = mysqli_fetch_assoc($result); 

          if(intval($classRow['term_code'])<intval($paramClassRow['term_code'])){

          	//If the prereq class was taken before the Param class
          	$logicalString.="true ";
          } else {

          	//If the prereq class was not take before:
          	// In the same sem or after or not there at all
          	$logicalString.="false ";
          }
        } else {
        	//If PreReq Class not enrolled in
        	$logicalString.="false ";
        }


    } else {

      //Logic Symbols replaced to get evaluated
      switch ($bit) {
        case "(":
          $logicalString.="( ";
            break;
        case ")":
          $logicalString.=") ";
            break;
        case "|":
          $logicalString.="|| ";
          break;
        case "&":
          $logicalString.="&& ";
          break;
      }
    }
  }

  echo $logicalString;
  //TODO NULL return by eval cleaning
  //Returned when class effected not in enrollement
  echo var_dump(eval("return ".$logicalString.";"));
  return true;
}

/*Returns a list of classes that have the passed class
in their list of PreReqs*/
function getClassesWithThisPreReq($course_id) {
   global $conn;

  //Getting class String
  $query = sprintf("SELECT * 
  FROM courses
  WHERE id = %d;", $course_id);

  $result = mysqli_query($conn, $query) or die('Error, query failed');
  $paramClassRow = mysqli_fetch_assoc($result);
  $className = $paramClassRow['subject'].":".$paramClassRow['course_number'];

  //Getting List of Classes that have 
  $classesEffected = array();

  $query = sprintf("SELECT * 
  FROM courses
  WHERE PreReqs
  REGEXP  '.*%s.*' ;", $className);
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($classesEffected, $row);
    }        
  }

  return $classesEffected;
}

?>