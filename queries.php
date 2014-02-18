<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";

/* Connect to mysql database */
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysqli_select_db($conn, $dbname);

/* Get courses for a given subject code (ex: 'CS') */
function getCourses($subject) {
  global $conn;
  $courses = array();
  
  $query = sprintf("SELECT *  
    FROM courses
    WHERE courses.subject ='%s';", $subject);
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysql_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($courses, $row);
    }        
  }
  return $courses;
}

/* Get all of the enrollments for a user_id */
function getEnrollments($user_id) {
  global $conn;
  
  $term_codes = array(
   201308,
   201401,
   201408,
   201501
  );

  $enrollments = array();

  for ($i = 0; $i < sizeof($term_codes); $i++){
      $query = sprintf("SELECT * 
      FROM enrollments
      INNER JOIN courses ON courses.id = enrollments.course_id
      WHERE enrollments.user_id =  '%s'
      AND enrollments.term_code =  '%s';", $user_id, $term_codes[$i]);
      $result = mysqli_query($conn, $query) or die('Error, query failed');

      $enrollments[$i] = array();
      if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
          array_push($enrollments[$i], $row);
        }        
      }
      else {
        array_push($enrollments[$i], null);
      }
  }
  return $enrollments;
}

?>

