<?php
/*
 * Enrollments.php
 * Methods for the enrollments API
 */

require_once 'prefix.php';

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
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
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