<?php
/* 
 * Courses.php
 * All code for maintaining Course data will be in this file. 
 *
 */

require_once 'api/prefix.php';

$app->get('/courses/:dept/:format', function($dept, $format) use ($app) {
  // We are returning JSON
  header("Content-Type: application/" + $format);
  $courses = getCourses($dept);
  echo json_encode($courses);
});

$app->get('/course/:id', function($id) use ($app) {
  echo json_encode(getCourseInfo($id));
});


/* Get courses for a given subject code (ex: 'CS') */
function getCourses($subject) {
  global $conn;
  $courses = array();
  
  $query = sprintf("SELECT *  
    FROM courses
    WHERE courses.subject ='%s';", $subject);
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($courses, $row);
    }        
  }
  return $courses;
}

function getCourseInfo($id) {
  global $conn;
  
  $query = sprintf("SELECT *  
    FROM courses
    WHERE id ='%d'
    LIMIT 1;", $id);
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    $info = mysqli_fetch_assoc($result);   
  }
  return $info;
}

/*Get a list of all the Departments*/
function getDepartments() {
  global $conn;

  $query = "SELECT DISTINCT subject FROM courses;";
  $info=array();
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($info, $row);
    }  
  }
  return $info;

}

?>
