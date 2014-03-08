<?php

require_once 'api/api.php';

$session_stat = session_status();

if ($session_stat == PHP_SESSION_ACTIVE &&
	isset($_SESSION['username']) &&
	isset($_SESSION['user_id']) &&
	$_SESSION['username'] != null && 
	$_SESSION['user_id'] != null) 
{
	header("Location: schedule.php");
}

$app = \Slim\Slim::getInstance();
$app->render('login.tpl');

?>