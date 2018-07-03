<?php
/**
 * Created by PhpStorm.
 * User: apoplavs
 * Date: 6/26/18
 * Time: 5:12 PM
 */

class Secure {
	
	/**
	 * checking CSRF key from forms
	 * @param $input_token
	 * @return bool
	 */
	public static function checkCSRF($input_token) {
		// if session is active
		if (session_status() == PHP_SESSION_ACTIVE && $_SESSION['csrf']) {
			$csrf_token = $_SESSION['csrf'];
		} else {
			$csrf_token = self::generateCSRF();
		}
		return ($csrf_token == $input_token ? true : false);
    }
	
	
	/**
	 * generation CSRF key
	 * @return string
	 */
	public static function generateCSRF() {
		// if session is active
		if (session_status() == PHP_SESSION_ACTIVE) {
			$csrf_token =  hash("whirlpool", $_SERVER['REMOTE_ADDR'].strval(time()));
		} else {
			// if session is active, and not the end of the current day
			if (intval(date('G')) < 22) {
				$csrf_token = hash("whirlpool", $_SERVER['REMOTE_ADDR'].date('Yz'));
			} else {
				$csrf_token = hash("whirlpool", $_SERVER['REMOTE_ADDR'].date('Y'));
			}
		}
		return ($csrf_token);
    }
	
	
	/**
	 * generation unique users token
	 * for confirmation email
	 * @param $user_login
	 * @return string
	 */
	public static function generateToken($user_login) {
		return (md5(uniqid($user_login)));
	}
	
	
	
	/**
	 * encrypting users passwords
	 * @param $pass
	 * @return string
	 */
	public static function encryptPass($pass) {
		return (password_hash($pass, PASSWORD_DEFAULT));
	}
	
	
	/**
	 * checking input params
	 * and delete any HTML tags
	 * @param $str
	 * @return string
	 */
	public static function protectionXSS($str) {
    	$protect_str = strip_tags($str);
    	if ($protect_str != $str) {
			Log::createLog("XSS attack attempt");
		}
		return ($protect_str);
	}
	
	
	/**
	 * show error page
	 * @param string $error_number
	 */
	public static function  error(string $error_number = '400') {
        if (file_exists(ROOT . '/views/errors/'.$error_number.'.php')) {
            include(ROOT . '/views/errors/'.$error_number.'.php');
        } else {
            include(ROOT . '/views/errors/404.php');
        }
        exit;
    }
}