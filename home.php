<?php

require_once 'api/api.php';

$app = \Slim\Slim::getInstance();
$app->render('home.tpl');

?>