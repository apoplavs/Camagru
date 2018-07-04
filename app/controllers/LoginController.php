<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class LoginController extends Controller
{
	
	public static function index() {
		if (session_status() == PHP_SESSION_ACTIVE) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		$csrf_token = Secure::generateCSRF();
		include_once (ROOT . '/views/login.php');
		return (true);
	}

	public static function store($request) {
		if (session_status() == PHP_SESSION_ACTIVE) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		
		$user = self::checkInputData($request);
		// if input data is not valid
		if ($user === false) {
			return (true);
		}
		self::makeSession($user);
		header("location: ".ROOT_URI."/home");
		return (true);
	}
	
	
	
	// PRIVATE METHODS
	private static function checkInputData($request) {
		if (!array_key_exists("login", $request) || !array_key_exists("password", $request)
			|| !array_key_exists("csrf", $request)	|| !Secure::checkCSRF($request["csrf"])) {
			Secure::error(400);
		}
		$user = User::getUser($request['login']);
		if ($user === false || !password_verify($request['password'], $user['password'])) {
			$error_message = 'неправильний логін або пароль';
			$csrf_token = Secure::generateCSRF();
			include_once (ROOT . '/views/login.php');
			return(false);
		}
		return ($user);
	}
	
	
	/**
	 * making session start and setting necessary values
	 * @param $user
	 */
	private static function makeSession($user) {
		// make new session for user
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
			$_SESSION['csrf'] = Secure::generateCSRF();
			$_SESSION['user'] = $user;
		}
	}
	
	
}