<?php
/**
 * Created by PhpStorm.
 * User: apoplavs
 * Date: 6/27/18
 * Time: 12:55 PM
 */




class Log extends DB {
	public static function createLog($notice = "") {
		$query = "INSERT INTO logs (client, notice) VALUES (:client, :notice)";
		parent::query($query, [':client' => $_SERVER['REMOTE_ADDR'], ':notice' => $notice]);
	}
}