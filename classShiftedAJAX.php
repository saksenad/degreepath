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

//Updating Movement in DataBase to store pattern
$query="UPDATE enrollments
SET Semester='".$newSemester."'
WHERE user_email='".$user_email."' AND CID=".$cid." AND Semester='".$oldSemester."';";
mysql_query($query) or die('Error, INSERT failed!');

//To check is moved Class needs a prereuisite at the new position
$query="SELECT * FROM classes WHERE CID = (SELECT CID FROM enrollments WHERE Semester >='".$newSemester."' AND CID IN 
(SELECT PreRequisite_CID FROM Prerequisites WHERE CID=".$cid.")
AND user_email='".$user_email."');";
$result = mysql_query($query) or die('Error, query failed');

if (mysql_num_rows($result) != 0) { 
	echo "Prerequisites check failed";
	echo "for class ".$cid;//CID of the class whose prereq is not fullfilled and should become red

	//Update PreReqsCleared to persist redness
	$query="UPDATE enrollments 
	SET PreReqsCleared=0
	WHERE CID=".$cid." AND user_email='".$user_email."';";
	$result = mysql_query($query) or die('Error, query failed');
} 
else{
	$query="UPDATE enrollments 
	SET PreReqsCleared=1
	WHERE CID=".$cid." AND user_email='".$user_email."';";
	$result = mysql_query($query) or die('Error, query failed');
}  	

//To Check if moved class was a prerequisite for something and now is ahead of it
$query="SELECT * FROM classes WHERE CID = (SELECT CID FROM enrollments WHERE Semester <='".$newSemester."' AND CID IN 
(SELECT CID FROM Prerequisites WHERE PreRequisite_CID=".$cid.")
AND user_email='".$user_email."');";
$result = mysql_query($query) or die('Error, query failed');

if (mysql_num_rows($result) != 0) { 
	echo "Prerequisites check failed|||||||";
	while($row = mysql_fetch_array($result)){
		$query="UPDATE enrollments 
		SET PreReqsCleared=0
		WHERE CID=".$row["CID"]." AND user_email='".$user_email."';";
		$result = mysql_query($query) or die('Error, query failed');
	}
}   


?>