<?php
/*
 * API.php
 * Including all of the different modules that contain the functionality for the API. 
 */

/* 
* API Files
* Any new API that is added should be added to this list of files to include.
*/

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);

require_once "api/prefix.php";
require_once "api/courses.php";
require_once "api/enrollments.php";
require_once "api/users.php";

$app = \Slim\Slim::getInstance();
$app->get("/", function() use ($app) {});
$app->run();

?>