<?php
require_once (ROOT.'/app/models/User.php');
/**
* 
*/
class RegisterController extends Controller
{
	
	public static function index() {
		User::checkExistsValue('email', 'p.andiy.v@gmail.com');
        $csrf_token = Secure::generateCSRF();
//        $error_message = "fewfefr";
        include_once (ROOT . '/views/register.php');
        return (true);
	}

	public static function store($request) {
	    $is_valid = self::checkInputData($request);
	    
	    // if input data is not valid
        if ($is_valid !== true) {
			$error_message = $is_valid;
			include_once (ROOT . '/views/register.php');
			return (true);
		}
  
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
		if ($request['password'] != $request['confirm-password']) {
			return('паролі не збігаються');
		}
		if (filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
			return('некоректний email');
		}
		// @todo зробити перевірку унікальності email і login
//		$is_unique =
		if ($request['email']) {
		
		}
		if ($request['email']) {
		
		}
		return (true);
	}
	
}