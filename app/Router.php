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
                    break ;
                case 'POST' :
                    $this->request_status = $this->controller::store($_POST);
                    break ;
                case 'PUT' :
                    if (array_key_exists('object', $_POST)) {
                        $this->request_status = $this->controller::edit($_POST['object'], $_POST);
                    } else {
                        Secure::error('400');
                    }
                    break ;
                case 'DELETE' :
                    if (array_key_exists('object', $_POST)) {
                        $this->request_status = $this->controller::delete($_POST['object']);
                    } else {
                        Secure::error('400');
                    }
                    break ;
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

	private function getRoutePath()	{
		if (!empty($_SERVER['REQUEST_URI'])) {
            Debug::dd(substr($_SERVER['REDIRECT_URL'], strlen(ROOT_URI) + 1), "trim SERVER");
			return substr($_SERVER['REDIRECT_URL'], strlen(ROOT_URI) + 1);
		} else {
            Secure::error('404');
        }
	}

	private function getControllerName($route_path)	{
        Debug::dd($route_path, "route path");
		// ROOT.'/app/controllers/HomeController.php'
		switch ($route_path) {
			case 'home':
				return 'HomeController';
			case 'login':
				return 'LoginController';
			case 'logout':
				return 'LogoutController';
			case 'register':
				return 'RegisterController';
			case 'gallery':
				return 'GalleryController';
						
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























	// ELSE

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
					Secure::error404();
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
			Secure::error404();
	}
}