<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class RegisterController extends Controller
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
			include_once (ROOT . '/views/login.php');
			return (true);
		}
		
        $csrf_token = Secure::generateCSRF();
        include_once (ROOT . '/views/register.php');
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
			include_once (ROOT . '/views/register.php');
			return (true);
		}
		// validate data and creating new user
		$token = Secure::generateToken($request['login']);
        $login = Secure::protectionXSS($request['login']);
        $email = Secure::protectionXSS($request['email']);
		
		// sending mail
        self::sendConfirmationMail($login, $email, $token);
        // write new user to DB
  		User::createNewUser($email, $login,	Secure::encryptPass($request['password']), $token);
  		
  		$message = 'перевірте Ваш email';
		include_once (ROOT . '/views/login.php');
		return (true);
	}

	public static function edit($id, $request) {
	    return (false);
	}
	public static function delete($id) {
        return (false);
	}
	
	
	
	// PRIVATE METHODS
	private static function checkInputData($request) {
		if (!array_key_exists("login", $request) || !array_key_exists("email", $request)
			|| !array_key_exists("password", $request) || !array_key_exists("confirm-password", $request)
			|| !array_key_exists("csrf", $request) || !Secure::checkCSRF($request["csrf"])) {
			Secure::error(400);
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
	
	
	private static function sendConfirmationMail(string $login, string $email, string $token) {
		// sending mail
		$message = 'Для завершення процедури реєстрації, необхідно підтвердити Ваш email <h3><a href="'
			.$_SERVER['HTTP_ORIGIN'].ROOT_URI.'/register?t='.$token.'&u='.$login.'">підтвердити</a></h3>';
		$subject = 'Реєстрація на '.$_SERVER['HTTP_ORIGIN'];
		
		if (!Mail::send($email, $message, $subject)) {
			$error_message = 'не вдалось надіслати email';
			$csrf_token = Secure::generateCSRF();
			include_once (ROOT . '/views/register.php');
			exit(1);
		}
	}
	
	
	
}