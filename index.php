<?php

if (!isset($_SESSION)) {
	//Define settings
	ini_set('display_startup_errors', 1);
	ini_set('max_input_vars', 20);
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

echo "<pre>";
print_r($_SERVER);
echo "</pre>";




//Define root directory
if (!defined('ROOT')) {
	define('ROOT', __DIR__);
}

//Define root URI
if (!defined('ROOT_URI')) {
	define('ROOT_URI', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
	// echo $_SERVER['REQUEST_URI'];
}


//including files
require_once (ROOT.'/app/Router.php');

require_once (ROOT.'/app/models/DB.php');
require_once (ROOT.'/app/controllers/Controller.php');
require_once (ROOT.'/app/Mail.php');
// include_once(ROOT.'/app/controllers/Sendmail.php');

//Call Router
$router = new Router();
// getting response page
$response = $router->getResponse();
// show_page
echo $response;