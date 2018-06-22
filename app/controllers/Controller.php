<?php

/**
* The main class controller 
* from which all classes of controllers are extending
*/
abstract class Controller {
	abstract public static function index(); // GET
	abstract public static function store($request); // POST
	abstract public static function edit($id, $request); // PUT
	abstract public static function delete($id); // DELETE
}
