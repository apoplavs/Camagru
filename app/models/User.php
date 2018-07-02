<?php
/**
 * Created by PhpStorm.
 * User: apoplavs
 * Date: 7/2/18
 * Time: 16:55 PM
 */



class User extends DB {
	public static function checkExistsValue($field, $value) {
		$query = "SELECT $field FROM users WHERE $field = :val";
		$result = parent::query($query, [':val' => $value], PDO::FETCH_COLUMN);
		Debug::dd($result, "query result");
	}
}