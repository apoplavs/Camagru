<?php

class Router {
	
	private $controller;
	private $method;
	private $request_status = false;
	
	
	public function __construct() {
		$route_path = $this->getRoutePath();
		$this->controller = $this->getControllerName($route_path);
		$this->method = $this->getMethodName();
		Debug::dd($this->controller);
	}
	
	
	
	/**
	 * include necessary file
	 * and call appropriate method
	 */
	public function showResponse() {
		
		if (file_exists(ROOT.'/app/controllers/'.$this->controller.'.php')) {
			require_once(ROOT.'/app/controllers/'.$this->controller.'.php');
			
			switch ($this->method) {
				case 'GET' :
					$this->request_status = $this->controller::index();
					break;
				case 'POST' :
					$this->request_status = $this->controller::store($_POST);
					break;
				case 'PUT' :
					if (array_key_exists('object', $_POST)) {
						$this->request_status = $this->controller::edit($_POST['object'], $_POST);
					} else {
						Secure::error('400');
					}
					break;
				case 'DELETE' :
					if (array_key_exists('object', $_POST)) {
						$this->request_status = $this->controller::delete($_POST['object']);
					} else {
						Secure::error('400');
					}
					break;
				default :
					Secure::error('400');
			}
		} else {
			Secure::error('404');
		}
		
		// if method returned false
		if ($this->request_status === false) {
			Secure::error('405');
			
			// if method nothing returned
		} else if (!$this->request_status) {
			Secure::error('400');
		}
	}
	
	
	
	// PRIVATE METHODS
	
	private function getRoutePath() {
		$route_len = strlen($_SERVER['REQUEST_URI']) - (strlen($_SERVER['QUERY_STRING']) +
				strlen(ROOT_URI) + (strpos($_SERVER['REQUEST_URI'], '?') > 1 ? 2 : 1));
		
		// getting clear path
		if (!empty($_SERVER['REQUEST_URI'])) {
			return substr($_SERVER['REQUEST_URI'], strlen(ROOT_URI) + 1,
				$route_len);
		} else {
			Secure::error('404');
		}
	}
	
	
	private function getControllerName($route_path) {
		Debug::dd($route_path, "route path");
		// ROOT.'/app/controllers/HomeController.php'
		switch ($route_path) {
			case 'home':
				return 'HomeController';
			case 'login':
				return 'LoginController';
			case 'reset-pass':
				return 'ResetPassController';
			case 'logout':
				return 'LogoutController';
			case 'register':
				return 'RegisterController';
			case 'gallery':
				return 'GalleryController';
			case '':
				return 'WelcomeController';
			
			// case (preg_match('/John.*/', $name) ? true : false) :
			//      		// do stuff for people whose name is John, Johnny, ...
			//      		break;
			
			default:
				Secure::error('404');
		}
	}
	
	
	private function getMethodName() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (array_key_exists('_method', $_POST)) {
				switch (strtoupper($_POST['_method'])) {
					case 'PUT' :
						return ('PUT');
					case 'DELETE' :
						return ('DELETE');
					default :
						Secure::error('405');
				}
			} else {
				return ('POST');
			}
			
		}
		return ('GET');
	}
}