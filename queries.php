<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";

/* Connect to mysql database */
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

/* Get courses for a given subject code (ex: 'CS') */
function getCourses($subject) {
  $courses = array();
  
  $query = sprintf("SELECT *  
    FROM courses
    WHERE courses.subject ='%s';", $subject);
  $result = mysql_query($query) or die('Error, query failed');

  if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
      array_push($courses, $row);
    }        
  }
  return $courses;
}

/* Get all of the enrollments for a user_id */
function getEnrollments($user_id) {
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
      $result = mysql_query($query) or die('Error, query failed');

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

