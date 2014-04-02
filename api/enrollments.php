<?php
/*
 * Enrollments.php
 * Methods for the enrollments API
 */

require_once 'api/prefix.php';

$app->post('/enrollment/:action', function($action) use ($app) {
  if ($action == 'change') {
    changeEnrollment();
  }
  if ($action == 'add') {
    addEnrollment();
  }
  if ($action == 'delete') {
    deleteEnrollment();
  }
});

/* Get all of the enrollments for a user_id */
function getEnrollments($user_id, $term_code) {
  global $conn;

  $enrollments = array();

  $query = sprintf("SELECT * 
    FROM enrollments
    INNER JOIN courses ON courses.id = enrollments.course_id
    WHERE enrollments.user_id =  %d
    AND enrollments.term_code =  '%s';", $user_id, $term_code);
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  $enrollments = array();
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($enrollments, $row);
    }        
  }
  else {
    array_push($enrollments, null);
  }
  return $enrollments;
}

function changeEnrollment() {

  //Change the enrollment in the DB
  global $conn;

  $new_term=$_POST['receiver'];
  $course_id=$_POST['course_id'];
  $old_term=$_POST['sender'];
  
  $user_id = $_SESSION['user_id'];

  $query = sprintf("UPDATE enrollments 
    SET term_code = %d
    WHERE user_id = %d
    AND course_id = %d
    AND term_code = %d;",
    $new_term, $user_id, $course_id, $old_term);

  $result = mysqli_query($conn, $query) or die('Error, query failed');

  //Getting Classes that failed the PreReqs and previous fails that succedded

  echo getPreReqsFailedOnChange($course_id,$user_id);

}


function addEnrollment() {
  global $conn;

  $course_id=$_POST['course_id'];
  $term=$_POST['receiver'];

  $user_id = $_SESSION['user_id'];

  $query = sprintf("INSERT INTO 
    enrollments(course_id, user_id, term_code)
    VALUES(%d, %d, %d);",
    $course_id, $user_id, $term);

  $result = mysqli_query($conn, $query) or die('Error, query failed');
}

function deleteEnrollment() {
  global $conn;

  $course_id=$_POST['course_id'];
  $term_id=$_POST['sender'];
  
  $user_id = $_SESSION['user_id'];

  $query = sprintf("DELETE FROM enrollments 
    WHERE user_id = %d
    AND course_id = %d
    AND term_code = %d;",
    $user_id, $course_id, $term_id);

  $result = mysqli_query($conn, $query) or die('Error, query failed');
}

function getTransferEnrollments($user_id) {
  global $conn;

  $enrollments = array();


  $query = sprintf("SELECT * 
  FROM enrollments
  INNER JOIN courses ON courses.id = enrollments.course_id
  WHERE enrollments.user_id =  %d
  AND enrollments.term_code =  '%s';", $user_id, "000000");
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  $enrollments = array();
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($enrollments, $row);
    }        
  }
  
  return $enrollments;
}

//Prereq Processing Functions

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
    if(passClassPreReq($class,$user_id)){
      array_push($pass, $class);
    } else {
      array_push($fail, $class);
    }
    break;
  }

  return json_encode(array( "pass" => $pass,
                            "fail" => $fail
          ));


}

/*Checks if the class passed in has prereqs satisfied
and returns true(if everything is order) or false*/
function passClassPreReq($courseRow,$user_id){
  echo var_dump($course_id);
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
