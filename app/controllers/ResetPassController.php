<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class ResetPassController extends Controller
{
	
	public static function index() {
		if (Secure::auth()) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		// if need verify email of user
		if ($_GET && array_key_exists('t', $_GET) && array_key_exists('u', $_GET)) {
			User::verifyUser($_GET['u'], $_GET['t']);
			$object_data = User::getUser($_GET['t'], 'signup_token');
			$object_id = $object_data['id'];
			$object_token = $object_data['signup_token'];
			include_once (ROOT . '/views/create_new_pass.php');
			return (true);
		}
		include_once (ROOT . '/views/reset_pass.php');
		return (true);
	}

	public static function store($request) {
		if (Secure::auth()) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		
		$is_valid = self::checkInputData($request);
		// if input data is not valid
		if ($is_valid !== true) {
			$error_message = $is_valid;
			include_once (ROOT . '/views/reset_pass.php');
			return (true);
		}
		$user = User::getUser($request['email'], 'email');
		self::sendResetMail($user['login'], $user['email'], $user['signup_token']);
		$message = '<h1 align="center">посилання для відновлення паролю надіслано на Ваш email<h1>';
		echo($message);
		return (true);
	}

	public static function edit($id, $request) {
		
		$is_valid = self::checkInputPass($request);
		// if input data is not valid
		if ($is_valid !== true) {
			$error_message = $is_valid;
			$object_id = $id;
			$object_token = $request['token'];
			include_once (ROOT . '/views/create_new_pass.php');
			return (true);
		}
		User::updatePass(Secure::encryptPass($request['password']), $id, $request['token']);
		include_once (ROOT . '/views/login.php');
		return(true);
	}

	public static function delete($id) {
		return(false);
	}
	
	
	
	
	
	
	// PRIVATE METHODS
	private static function checkInputData($request) {
		if (!array_key_exists("email", $request)
			|| !array_key_exists("csrf", $request)	|| !Secure::checkCSRF($request["csrf"])) {
			Secure::error(400);
		}
		$is_exists = User::getFirst('email', $request['email']);
		if ($is_exists === false) {
			return('не знайдено жодного користувача з вказаним email');
		}
		return (true);
	}
	
	
	private static function checkInputPass($request) {
		if (!array_key_exists("password", $request)
			|| !array_key_exists("csrf", $request) || !Secure::checkCSRF($request["csrf"])) {
			Secure::error(400);
		}
		if (strlen($request['password']) < 6) {
			return('мінімальна довжина паролю 6 символів');
		}
		if (strlen($request['password']) > 32) {
			return('максимальна довжина паролю 32 символа');
		}
		return (true);
	}
	
	
	private static function sendResetMail(string $login, string $email, string $token) {
		// sending mail
		$message = 'Для відновлення паролю перейдіть за <a href="'
			.$_SERVER['HTTP_ORIGIN'].ROOT_URI.'/reset-pass?t='.$token.'&u='.$login.'">посиланням</a>';
		$subject = 'Відновлення паролю на '.$_SERVER['HTTP_ORIGIN'];
		
		if (!Mail::send($email, $message, $subject)) {
			$error_message = 'не вдалось надіслати email';
			include_once (ROOT . '/views/reset_pass.php');
			exit(1);
		}
	}
	
	
}