<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

/* Require Slim Framework */
require_once 'Slim/Slim.php';
/* Require Smarty template engine and Slim Views */
require_once 'Slim/View.php';
require_once 'Slim/Views/Smarty.php';

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "degreepath";

/* Connect to mysql database */
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysqli_select_db($conn, $dbname);

\Slim\Slim::registerAutoloader();

/* Instantiate a Slim application */
$app = new \Slim\Slim(array(
  'view' => new \Slim\Views\Smarty(),
  'mode' => 'development',
  'templates.path' => $_SERVER['DOCUMENT_ROOT'].'/templates'
));

$app->configureMode('development', function () use ($app) {
	
	/* Display PHP errors in browser */
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);

});

?>
