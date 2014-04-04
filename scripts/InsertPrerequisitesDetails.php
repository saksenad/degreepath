<?php

//Initial Setup
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysqli_select_db($conn, $dbname);
// Get cURL resource
$curl = curl_init();

/*The CRNs in the courses table in the database should be the ones that inset_buzzapi_data would pull
because the CRN should belong to the term that the term code denotes*/
$termcode=date("Y")."02";

$query = sprintf("SELECT course_CRN FROM courses;");
$result = mysqli_query($conn, $query) or die('Error, query failed');

if (mysqli_num_rows($result) > 0) {

	while ($row = mysqli_fetch_assoc($result)) {
		$crn=$row['course_CRN'];
	  	
	  	//Getting the data from the API

		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_URL => "https://api.gatech.edu/apiv3/central.academics.course_catalog.course_details/search?term_code=".$termcode."&crn=".$crn."&api.app_id=degreepath-dev&api.app_password=Nkj6payxmdf&api_request_mode=sync",
			CURLOPT_RETURNTRANSFER => true
		));
		// Send the request & save response to $resp
		$api_response = curl_exec($curl);
		
		$classInfo=json_decode($api_response,true);
		$preReqDetailsArray=$classInfo["api_result_data"][0]["prerequisites"]["prerequisites_details"];


		//Prereq String (Space Separated)
		if(sizeof($preReqDetailsArray)>0) {
		$parenBal=0;
		$prs="[ ";

			foreach($preReqDetailsArray as $prd){

				//Logical Connectors
				if($prd["connector"]=="and"){
					$prs.="& ";
				} elseif ($prd["connector"]=="or") {
					$prs.="| ";
				}

				//Left Opening Parenthesis
				if($prd["left_paren"]=="(") {
					$prs.="( ";
					$parenBal+=1;
				}

				//Cleaning Course number
				$courseNumber=str_replace("X","_",$prd["course_number"]);
				//Adding the Actual Class
				$prs.=$prd["subject_code"].":".$courseNumber." ";

				//Right Closing Parenthesis
				if($prd["right_paren"]==")") {
					$prs.=") ";
					$parenBal-=1;
				}

			}

		$prs.="]";

		} else {
			$prs = '[ ]';
		}
		

		//Inserting PreReq String into DB
		$updateQuery = sprintf("UPDATE courses
				SET prereqs ='%s'
				WHERE course_CRN =%d ;
			",$prs,$crn);
		$updateSuccessful = mysqli_query($conn, $updateQuery) or die('Error, query failed');	
	}     

}

// Close request to clear up some resources
curl_close($curl);

?>




