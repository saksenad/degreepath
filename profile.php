<?php

require_once 'api/api.php';

if (isset($_SESSION['username']) &&
	isset($_SESSION['user_id']) &&
	$_SESSION['username'] == null || 
	$_SESSION['user_id'] == null) 
{
	header("Location: home.php");
}


$userInfo = getUserInfo($_SESSION['user_id']);
$userDisplayName=getUserDisplayName($_SESSION['user_id']);
$userArray=getUserInformation($_SESSION['user_id']);
$departments=getDepartmentsPHPArray();
$transfers=getTransferEnrollments($_SESSION['user_id']);

$app = \Slim\Slim::getInstance();
$app->render('profile.tpl', array(
		'userDisplayName' => $userDisplayName,
		'departments' => $departments,
		'transfers' => $transfers,
		'userArray' => $userArray,
		'userInfo' => $userInfo 
	));


?>
