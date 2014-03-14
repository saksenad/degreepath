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

$terms = array('0' => '201308', '1' => '201401', '2' => '201408', '3' => '201501');
$season = array('01' => 'Spring', '05' => 'Summer', '08' => 'Fall');
$enrollments = getEnrollments($_SESSION['user_id']);
$userInfo = getUserInfo($_SESSION['user_id']);
$departments = getAccordionDepartments($userInfo['major']);

$app->render('schedule.tpl', array(
	'terms' => $terms,
	'season' => $season,
	'enrollments' => $enrollments,
	'departments' => $departments,
  'userInfo' => $userInfo
));


?>
