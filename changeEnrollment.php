<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$new_term=$_POST['receiver'];
$course_id=$_POST['course_id'];
$old_term=$_POST['sender'];
$user_id=$_POST['user'];

$query = sprintf("UPDATE enrollments 
  SET term_code = %d
  WHERE user_id = %d
  AND course_id = '%s'
  AND term_code = %d;",
  $new_term, 1, $course_id, $old_term);

echo $query;
$result = mysql_query($query) or die('Error, query failed');

?>
