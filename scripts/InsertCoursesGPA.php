<?php

require_once "simple_html_dom.php";
//Initial Setup
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysqli_select_db($conn, $dbname);

$classesAndGPAs=WebScrapeGPA(getClassesList());
updateClassGPA($classesAndGPAs);

/*Getting list of Classes from DB in (DEPTCOURSENO,DEPT,COURSENO,GPA) format eg. (CS2340,CS,2340,0.00)*/
function getClassesList() {
  global $conn;

  $classes = array();

  $query = sprintf("SELECT * FROM courses;");

  $result = mysqli_query($conn, $query) or die('Error, query failed');

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($classes, array($row['subject'].$row['course_number'],$row['subject'],$row['course_number'],0.00));
    }        
  }
  return $classes;
}

/*Scraping critique.gatech.edu for each class in given list returns (CS2340,CS,2340,0.00) with GPA updates*/
function WebScrapeGPA($classList) {
	$baseURL="http://critique.gatech.edu/course.php?id=";

  $gpas= array();
	foreach ($classList as $class) {
    $url=$baseURL.$class[0];
    $webPage = file_get_html($url);
    $gpa=$webPage->find('td',1)->innertext;
		$class[3]=$gpa;
    echo $class[0]." ".$class[3]."\n";
    array_push($gpas, array($class[0],$class[1],$class[2],$gpa));
	}

  echo "Done Scrapeing";
  return $gpas;
}

/*Populates the DB with the GPA Scraped*/
function updateClassGPA($classList) {

  global $conn;
  echo "Now I insert :)";
  foreach($classList as $class) {
    $GPA = $class[3];
    if ($GPA == 0.0) {
      $GPA = 3.5;
    }
    $query = sprintf("UPDATE courses
      SET GPA = %f
      WHERE subject = '%s' AND 
      course_number= %d ;
      ",$GPA,$class[1],$class[2]);
    echo $query;
    $result = mysqli_query($conn, $query) or die('Error, query failed');
  }
}
