<?php
/**
 * Created by PhpStorm.
 * User: apoplavs
 * Date: 7/2/18
 * Time: 16:55 PM
 */



class User extends DB {
	
	public static function createNewUser(string $email, string $login, string $password, string $token) {
		$query = "INSERT INTO users (email, login, password, signup_token) VALUES (:email, :login, :password, :token)";
		parent::query($query, [':email' => $email, ':login' => $login, ':password' => $password, ':token' => $token]);
	}
	
	
	/**
	 * getting first field from DB
	 * and return it is exists
	 * @param $field
	 * @param $value
	 * @return bool
	 */
	public static function getFirst($field, $value) {
		$query = "SELECT $field FROM users WHERE $field = :val LIMIT 1";
		$result = parent::query($query, [':val' => $value], PDO::FETCH_COLUMN);
		// if value not exists
		if (empty($result)) {
			return (false);
		}
		// if value exists in DB
		return ($result[0]);
	}
	
	/**
	 * getting first field from DB
	 * and return it is exists
	 * @param $field
	 * @param $value
	 * @return bool
	 */
	public static function getUser($val, $field = "login") {
		$query = "SELECT id, email, login, password, first_name, last_name, signup_token, active FROM users WHERE $field = :val LIMIT 1";
		$result = parent::query($query, [':val' => $val], PDO::FETCH_ASSOC);
		// if value not exists
		if (empty($result)) {
			return (false);
		}
		// if value exists in DB
		return ($result[0]);
	}
	
	
	
	/**
	 * insert one value to DB
	 * @param $field
	 * @param $value
	 * @return bool
	 */
	public static function updateOne($field, $value, $search_field, $search_value) {
		$query = "UPDATE users SET $field = :val WHERE $search_field = :search_val LIMIT 1";
		parent::query($query, [':search_val' => $search_value, ':val' => $value]);
	}
	
	
	/**
	 * insert new password to DB
	 * @param $new_pass
	 * @param $id
	 * @param $token
	 * @return bool
	 */
	public static function updatePass($new_pass, $id, $token) {
		$query = "UPDATE users SET password = :new_pass WHERE id = :id AND signup_token = :token  LIMIT 1";
		parent::query($query, [':new_pass' => $new_pass, ':id' => $id, ':token' => $token]);
	}
	
	
	/**
	 * verifying user email
	 * @param $login
	 * @param $token
	 * @return bool
	 */
	public static function verifyUser($login, $token) {
		$query = "UPDATE users SET active = 1 WHERE login = :login AND signup_token = :token LIMIT 1";
		parent::query($query, [':login' => $login, ':token' => $token]);
	}
}