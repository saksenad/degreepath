<?php
	
if (!($_POST)) { echo 'This has to be a post jackass!'; }
	
else {
	
	$dbhost = "localhost";
	$dbuser = "DB USER";
	$dbpass = "DB PASS";
	$dbname = "demo_draggable";
	
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	mysql_select_db($dbname);
	
	// THESE COULD BE AUTO GENERATED, HARD CODED FOR DEMONSTRATION
	$contest_id = '1';
	$judge_id = '1';
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$sort1 = '';
	$sort2 = '';

	// PARSES THE POSTS FROM EACH COLUMN INTO AN ARRAY
	parse_str($_POST['sort1'], $sort1);
	parse_str($_POST['sort2'], $sort2);
	
	//FIGURE OUT IF THERE IS ALREADY A RANKING 
	
	$query = "SELECT ranking_id FROM ranking WHERE contest_id = '$contest_id' AND judge_id = '$judge_id'";
	$result = mysql_query($query) or die('Error, query failed');
	
	// IF NO ENTRIES, CREATE THEM FOR EACH COLUMN (ARRAY)
	if (mysql_num_rows($result) == 0) {
		foreach($sort1['entry'] as $key=>$value){
			$insertquery = "INSERT INTO `ranking` (judge_id, contest_id, entry_id, ranking_value, ranking_column, ip_address) VALUES ('$judge_id', '$contest_id', '$value', '$key', '0', '$ip_address')";
			mysql_query($insertquery) or die('Error, INSERT failed!');
			}
		foreach($sort2['entry'] as $key=>$value){
			$insertquery2 = "INSERT INTO `ranking` (judge_id, contest_id, entry_id, ranking_value, ranking_column, ip_address) VALUES ('$judge_id', '$contest_id', '$value', '$key', '1', '$ip_address')";
			mysql_query($insertquery2) or die('Error, INSERT failed!');
			}
		echo 'an insert';
		}
	
	// IF ENTRIES, UPDATE THEM FOR EACH COLUMN (ARRAY)
	else {
		foreach($sort1['entry'] as $key=>$value) {
			$updatequery = "UPDATE `ranking` SET ranking_value = '$key', ranking_column = '0' WHERE entry_id = '$value' AND judge_id = '$judge_id'";	
			mysql_query($updatequery) or die('Error, UPDATE failed!');	
			}
		foreach($sort2['entry'] as $key=>$value) {
			$updatequery2 = "UPDATE `ranking` SET ranking_value = '$key', ranking_column = '1' WHERE entry_id = '$value' AND judge_id = '$judge_id'";	
			mysql_query($updatequery2) or die('Error, UPDATE failed!');
			}	
		echo 'an update';
		}
    }
    
?>