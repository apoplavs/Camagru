<?php

/**
* Controller for main Page
*/
class WelcomeController extends Controller
{
	
	public static function index() {
		include_once (ROOT . '/views/welcome.php');
		return (true);
	}

	public static function store($request) {
		return (false);
	}

	public static function edit($id, $request) {
		return (false);
	}

	public static function delete($id) {
		return (false);
	}
	
	
}