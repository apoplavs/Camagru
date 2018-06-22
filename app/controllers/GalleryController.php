<?php

/**
 *
 */
class HomeController extends Controller
{

    public static function index() {
        include_once (ROOT . '/views/gallery.php');
        return (true);
    }

    public static function store($request) {

    }

    public static function edit($id, $request) {

    }

    public static function delete($id) {

    }
}