<?php

class Router
{
	private $controller;
	private $method;
	private $request_status = false;

	public function __construct() {
		$route_path = $this->getRoutePath();
		$this->controller = $this->getControllerName($route_path);
		$this->method = $this->getMethodName();
	}


	public function  err404() {
		include(ROOT . '/views/errors/404.php');
		exit;
	}

	public function getResponse() {

		if (file_exists($this->route)) {
			require_once($this->route);

		} else {
			$this->err404();
		}


	}



	// PRIVATE METHODS

	private function getRoutePath()	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], ROOT_URI.'/');
		}
	}

	private function getControllerName($route_path)	{
		// ROOT.'/app/controllers/HomeController.php'
		switch ($route_path) {
			case 'home':
				return 'HomeController.php';
			case 'login':
				return 'LoginController.php';
			case 'logout':
				return 'LogoutController.php';	
			case 'register':
				return 'RegisterController.php';
			case 'gallery':
				return 'GalleryController.php';
						
			// case (preg_match('/John.*/', $name) ? true : false) :
   //      		// do stuff for people whose name is John, Johnny, ...
   //      		break;	
			
			default:
				$this->err404();
		}
	}

	private function getMethodName() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], ROOT_URI.'/');
		}
	}













	// ELSE

	

	private function getURI()
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
		return null;
	}

	private function authRedirect($pattern)
	{
		if (!isset($_SESSION))
			session_start();
		if ($pattern === 'gallery/([0-9]+)')
			return;
		if ($pattern === 'authentication' || $pattern === 'recovery')
		{
			if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
			{
				header("location: /selfie");
				exit;
			}
		}
		else if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
		{
			header("location: /authentication");
			exit;
		}
	}

	public function run()
	{
		//Get request string
		$uri = $this->getURI();

		//Check the value of the request
		foreach ($this->routes as $pattern => $path)
		{
			if (preg_match("~(/|^){$pattern}/?$~", $uri))
			{
				//Authentication check
				$this->authRedirect($pattern);
				$internalRoute = preg_replace("~{$pattern}~", $path, $uri);
				//Determine controller, action, params
				$segments = explode('/', $internalRoute);
				$controllerName = ucfirst(array_shift($segments).'Controller');
				$actionName = 'action'.ucfirst(array_shift($segments));
				$params = $segments;

				//Connecting controller class
				$controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
				if (file_exists($controllerFile))
					include_once($controllerFile);
				else
					$this->error404();
				//Create controller object
				$controllerObject = new $controllerName;
				//Call controller's action
				$result = call_user_func_array(array($controllerObject, $actionName), $params);
				if ($result) {
					$this->request_status = true;
					break;
				}
			}
		}
		if ($this->request_status === false)
			$this->error404();
	}
}