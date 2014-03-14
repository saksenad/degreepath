<?php

require_once 'api/api.php';

if (!isset($_SESSION['username']) ||
	!isset($_SESSION['user_id']) ||
	$_SESSION['username'] == null || 
	$_SESSION['user_id'] == null) 
{
	header("Location: home.php");
}

$app = \Slim\Slim::getInstance();

$season = array('01' => 'Spring', '05' => 'Summer', '08' => 'Fall');
$userInfo = getUserInfo($_SESSION['user_id']);
$terms = semestersForUser($_SESSION['user_id']);
$enrollments = array();
foreach ($terms as $term) {
  $enrollments[$term] = getEnrollments($_SESSION['user_id'], $term);
}
$departments = getAccordionDepartments();


$app->render('schedule.tpl', array(
	'terms' => $terms,
	'season' => $season,
	'enrollments' => $enrollments,
	'departments' => $departments,
  'userInfo' => $userInfo
));


?>
