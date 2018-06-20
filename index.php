<?php

if (isset($_SESSION)) {
	//Define settings
	ini_set('display_startup_errors', 1);
	ini_set('max_input_vars', 20);
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

//Define root directory
define('ROOT', __DIR__);

//including files
require_once (ROOT.'/app/Router.php');

require_once (ROOT.'/app/DB.php');
require_once (ROOT.'/app/Sendmail.php');
// include_once(ROOT.'/app/controllers/Sendmail.php');

//Call Router
$router = new Router();
// getting response page
$response = $router->getResponse();
// show_page
echo $response;