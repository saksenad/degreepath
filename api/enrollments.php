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
      WHERE enrollments.user_id =  %d
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

function changeEnrollment() {
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

?>
