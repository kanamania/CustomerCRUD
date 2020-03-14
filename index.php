<?php
date_default_timezone_set('Africa/Dar_es_Salaam');
//error_reporting(0);
include_once 'DB.php';
include_once 'functions.php';
include_once 'configs.php';

$db = null;
$routes = [];
$db = new DB($config);

require('controller.php');

$action = $_SERVER['REQUEST_URI'];
dispatch($action);