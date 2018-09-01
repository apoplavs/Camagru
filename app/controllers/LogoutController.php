<?php
require_once (ROOT.'/app/models/User.php');
/**
 *
 */
class LogoutController extends Controller
{
	
	/**
	 * logout current user and destroy session
	 * @return bool
	 */
	public static function index() {
		if (Secure::auth()) {
			$_SESSION['auth'] = false;
			$_SESSION['user'] = NULL;
			session_destroy();
			header("location: ".ROOT_URI."/");
			return (true);
		}
		include_once (ROOT . '/views/login.php');
		return (true);
	}
	
	public static function store($request) {
		return (false);
	}
}