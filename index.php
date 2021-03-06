<?php


//Define settings
ini_set('display_startup_errors', 1);
ini_set('max_input_vars', 20);
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('DEBUG', true);

//Define root directory
if (!defined('ROOT')) {
	define('ROOT', __DIR__);
}

//Define root URI
if (!defined('ROOT_URI')) {
	define('ROOT_URI', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
}

//including tools for debug
if (DEBUG) {
	require_once (ROOT.'/app/Debug.php');
}

// connect to DB
require_once (ROOT.'/app/models/DB.php');
require_once (ROOT.'/config/database.php');
//DB::connect();

//including files
require_once (ROOT.'/app/Router.php');
require_once (ROOT.'/app/Secure.php');
require_once (ROOT.'/app/controllers/Controller.php');
require_once (ROOT.'/app/Mail.php');


require_once (ROOT.'/app/models/Log.php');

// if SESSION is Undefined then initialise
session_start();
if (!array_key_exists('csrf', $_SESSION)) {
	$_SESSION['csrf'] = Secure::generateCSRF();
}
Debug::dd($_SESSION);

//Debug::dd($_SERVER, "SERVER");
//Call Router
$router = new Router();
// getting and showing response page
$router->showResponse();