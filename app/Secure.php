<?php
/**
 * Created by PhpStorm.
 * User: apoplavs
 * Date: 6/26/18
 * Time: 5:12 PM
 */

class Secure
{
    public static function checkCSRF($input_token) {

    }

    public static function generateCSRF() {

    }

    public static function checkTimeCSRF($input_token) {
        $csrf_token = self::generateTimeCSRF();
        return ($csrf_token == $input_token ? true : false);
    }

    public static function generateTimeCSRF() {
        if (intval(date('G')) < 23) {
            $csrf_token = hash("whirlpool", date('Yz'));
        } else {
            $csrf_token = hash("whirlpool", date('Y'));
        }
        return ($csrf_token);
    }

    public static function  error(string $error_number = '400') {
        if (file_exists(ROOT . '/views/errors/'.$error_number.'.php')) {
            include(ROOT . '/views/errors/'.$error_number.'.php');
        } else {
            include(ROOT . '/views/errors/404.php');
        }
        exit;
    }
}