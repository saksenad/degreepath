<?php
/* 
 * Courses.php
 * All code for maintaining Course data will be in this file. 
 *
 */

require_once 'prefix.php';

$app = \Slim\Slim::getInstance();

$app->get('/courses/:dept/:format', function($dept, $format) use ($app) {
  // We are returning JSON
  header("Content-Type: application/" + $format);
  $courses = getCourses($dept);
  echo json_encode($courses);
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
?>