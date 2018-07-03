<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class LoginController extends Controller
{
	
	public static function index() {
		$csrf_token = Secure::generateCSRF();
		include_once (ROOT . '/views/login.php');
		return (true);
	}

	public static function store($request) {
		Debug::dd($request);
		$is_valid = self::checkInputData($request);
		
		// if input data is not valid
		if ($is_valid !== true) {
			$error_message = $is_valid;
			$csrf_token = Secure::generateCSRF();
			include_once (ROOT . '/views/login.php');
			return (true);
		}
		return (true);
	}

	public static function edit($id, $request) {

	}

	public static function delete($id) {
		
	}
	
	
	
	
	
	
	// PRIVATE METHODS
	private static function checkInputData($request) {
		if (!array_key_exists("login", $request) || !array_key_exists("password", $request)
			|| !array_key_exists("csrf", $request)	|| !Secure::checkCSRF($request["csrf"])) {
			Secure::error(400);
		}
		$user = User::getUser($request['login']);
		if ($is_exists === false) {
			return('неправильний login');
		}
		
		if ($is_exists === false) {
			return('неправильний login');
		}

		
		
		if (strlen($request['password']) < 6) {
			return('мінімальна довжина паролю 6 символів');
		}
		if (strlen($request['password']) > 32) {
			return('максимальна довжина паролю 32 символа');
		}
		if ($request['password'] != $request['confirm-password']) {
			return('паролі не збігаються');
		}
		if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
			return('некоректний email');
		}
		$is_exists = User::getFirst('email', $request['email']);
		if ($is_exists !== false) {
			return('email вже використовується');
		}
		if (strlen($request['login']) > 16) {
			return('максимальна довжина логіна 16 символів');
		}
		if (strlen($request['login']) < 3) {
			return('мінімальна довжина логіна 3 символи');
		}
		$is_exists = User::getFirst('login', $request['login']);
		if ($is_exists !== false) {
			return('login вже використовується');
		}
		return (true);
	}
	
	
}