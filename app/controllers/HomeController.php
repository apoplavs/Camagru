<?php

/**
* 
*/
class HomeController extends Controller
{
	
	public static function index() {
		if (!Secure::auth()) {
			header("location: ".ROOT_URI."/login");
			return (true);
		}
		include_once (ROOT . '/views/home.php');
		return(true);
	}

	public static function store($request) {

	}

	public static function edit($id, $request) {

	}

	public static function delete($id) {

	}
}