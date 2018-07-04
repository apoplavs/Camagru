<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class ResetPassController extends Controller
{
	
	public static function index() {
		if (session_status() == PHP_SESSION_ACTIVE) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		// if need verify email of user
		if ($_GET && array_key_exists('t', $_GET) && array_key_exists('u', $_GET)) {
			User::verifyUser($_GET['u'], $_GET['t']);
			$message = 'email підтверджено';
			include_once (ROOT . '/views/create_new_pass.php');
			return (true);
		}
		
		$csrf_token = Secure::generateCSRF();
		include_once (ROOT . '/views/reset_pass.php');
		return (true);
	}

	public static function store($request) {
		if (session_status() == PHP_SESSION_ACTIVE) {
			header("location: ".ROOT_URI."/home");
			return (true);
		}
		
		$is_valid = self::checkInputData($request);
		// if input data is not valid
		if ($is_valid !== true) {
			$error_message = $is_valid;
			$csrf_token = Secure::generateCSRF();
			include_once (ROOT . '/views/reset_pass.php');
			return (true);
		}
		$user = User::getUser($request['email'], 'email');
		self::sendResetMail($user['login'], $user['email'], $user['signup_token']);
		$message = 'посилання для відновлення паролю надіслано на Ваш email';
		
		return (true);
	}

	public static function edit($id, $request) {
		return(false);
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
	
	
	private static function sendResetMail(string $login, string $email, string $token) {
		// sending mail
		$message = 'Для відновлення паролю перейдіть за <a href="'
			.$_SERVER['HTTP_ORIGIN'].ROOT_URI.'/reset-pass?t='.$token.'&u='.$login.'">посиланням</a>';
		$subject = 'Відновлення паролю на '.$_SERVER['HTTP_ORIGIN'];
		
		if (!Mail::send($email, $message, $subject)) {
			$error_message = 'не вдалось надіслати email';
			$csrf_token = Secure::generateCSRF();
			include_once (ROOT . '/views/reset_pass.php');
			exit(1);
		}
	}
	
	
}