<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

$newSemester=$_POST['receiver'];
$cid=$_POST['classId'];
$oldSemester=$_POST['sender'];
$user_email=$_POST['user'];

$query="UPDATE enrollments
SET Semester='".$newSemester."'
WHERE user_email='".$user_email."' AND CID=".$cid." AND Semester='".$oldSemester."';";
mysql_query($query) or die('Error, INSERT failed!');

$query="SELECT Semester,CID FROM enrollments WHERE CID IN 
(SELECT PreRequisite_CID FROM Prerequisites WHERE CID=".$cid.")
AND user_email='".$user_email."';"
$result = mysql_query($query) or die('Error, query failed');

echo "Success";


(SELECT Semester,CID FROM enrollments WHERE CID IN 
(SELECT PreRequisite_CID FROM Prerequisites WHERE CID=23)
AND user_email='vercetti21@gmail.com') AND Semester<'2014-08-15';

?>