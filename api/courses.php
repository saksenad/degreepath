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

$app->get('/course/:id', function($id) use ($app) {
  echo json_encode(getCourseInfo($id));
});


$app->get('/demo', function() use ($app) {
    $courses = getCourses('SPAN');
    $terms = array('0' => '201308', '1' => '201401', '2' => '201408', '3' => '201501');
    $season = array('01' => 'Spring', '05' => 'Summer', '08' => 'Fall');
    $enrollments = getEnrollments(1);
    $app->render('index.tpl', array(
      'courses' => $courses,
      'terms' => $terms,
      'season' => $season,
      'enrollments' => $enrollments
    ));
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

?>
