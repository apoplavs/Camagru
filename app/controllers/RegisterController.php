<?php

/**
* 
*/
class RegisterController extends Controller
{
	
	public static function index() {
        $csrf_token = Secure::generateTimeCSRF();
//        $error_message = "fewfefr";
        include_once (ROOT . '/views/register.php');
        return (true);
	}

	public static function store($request) {
	    Debug::dd($request);
	    if (!array_key_exists("login", $request) || !array_key_exists("email", $request)
            || !array_key_exists("password", $request) || !array_key_exists("confirm-password", $request)
            || !array_key_exists("csrf", $request) || !Secure::checkTimeCSRF($request["csrf"])) {
	        Secure::error(400);
        }
        include_once (ROOT . '/views/register.php');
        return (true);
	}

	public static function edit($id, $request) {
	    return (false);
	}

	public static function delete($id) {
        return (false);
	}
}