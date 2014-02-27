<?php
/*
 * API.php
 * Including all of the different modules that contain the functionality for the API. 
 */

/* 
* API Files
* Any new API that is added should be added to this list of files to include.
*/
require_once "api/prefix.php";
require_once "api/courses.php";
require_once "api/enrollments.php";

$app = \Slim\Slim::getInstance();
$app->run();

?>