<?php
/* 
 * Departments.php
 * All code for maintaining department data will be in this file. 
 *
 */

require_once 'api/prefix.php';

$app->get('/departments', function() use ($app) {
  echo getDepartments();
});

/*Get a list of all the Departments*/
function getDepartments() {
  global $conn;

  $query = "SELECT DISTINCT subject FROM courses;";
  $info=array();
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($info, $row['subject']);
    }  
  }
  return json_encode($info);
}

/*Get a list of all the departments that the accordion will display by default */
function getAccordionDepartments() {
  global $conn;

  $query = "SELECT DISTINCT subject FROM courses;";
  $info=array();
  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['subject'] == 'SPAN') {
        array_push($info, $row);
      }
    }  
  }
  return $info;
}

?>
