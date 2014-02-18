<?php

/* Display PHP errors in browser */
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

/* Require Slim Framework */
require 'Slim/Slim.php';

/* Require Smarty template engine and Slim Views */
require 'Slim/View.php';
require 'Slim/Views/Smarty.php';

/* Other php stuff */
require 'queries.php';

\Slim\Slim::registerAutoloader();

/* Instantiate a Slim application */
$app = new \Slim\Slim(array(
  'view' => new \Slim\Views\Smarty()
));

/* Define the Slim routes 
   .htaccess tells Apache to use pretty URLs 
   MAKE SURE /etc/apache2/sites-available/default has AllowOverride ALL
*/
$app->get('/', function() use ($app) {
  $courses = getCourses('SPAN');
  $terms = array('0' => '201308', '1' => '201401', '2' => '201408', '3' => '201501');
  $enrollments = getEnrollments(1);
  $app->render('index.tpl', array(
    'courses' => $courses,
    'terms' => $terms,
    'enrollments' => $enrollments
  ));
});

$app->run();

?>