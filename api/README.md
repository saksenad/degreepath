DegreePath API Structure README
===============================

Modules
-------
API Modules are files that contain all of the important function calls for a certain suite of API calls. 

For example, all of the function calls that manipulate course data will be within the Courses Module.

Each module is associated with a file. 
Eg. The Courses Module is associated with courses.php


Prefix.php
------
This file does everything needed to load all of the Slim and Smarty frameworks, and instantiate and configure our Slim Application. 

You need to use the syntax `` require_once 'prefix.php'; `` at the top of every new module. 

Creating a New Module
---------------------
As stated above begin by importing the prefix header. 
Get the Slim Instance.
Then, declare all of the URI calls that this API can handle using the Slim Routing methods. 
Write all of the supporting functions that you need to support the above methods, and make the appropriate function calls in the above configuration. 


A template for doing this is below. 


	require_once 'prefix.php';

	$app = \Slim\Slim::getInstance();

	$app->get('/apiname/:arg', function($arg) use ($app) {
		header(...);
		$result = myFunction($arg);
		echo $result; // this could change to be something like echo json_encode($result), or the Smarty templated version, depending on the application type.
	});

	function getCourses($subject) {
		// allow us to use the global variable that exists in the prefix.php file for the database connection. 
		global $conn; 

		// Do your MYSQL database calls here

		// Return your result in some way
		return $result
	}