<?php

require_once 'api/api.php';

$session_stat = session_status();

if ($session_stat == PHP_SESSION_DISABLED || 
	$session_stat == PHP_SESSION_NONE ||
	$_SESSION['username'] == null || 
	$_SESSION['user_id'] == null) 
{
	header("Location: home.php");
}

$app = \Slim\Slim::getInstance();
$app->render('profile.tpl');

?>
