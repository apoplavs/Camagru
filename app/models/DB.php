<?php

// require_once(ROOT.'/config/database.php');

class DB
{
	protected static $db = null;
	private static $connect_error_mode = true;

	public static function connect() {
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;
		
		try	{
			self::$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			/*
			* ATTR_ERRMODE - Error message mode
			* ERRMODE_EXCEPTION - throw Exception.
			*/
			self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// disable client-server emulation of prepared queries
			self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			// set encode
			self::$db->exec("SET NAMES UTF8");
			} catch (PDOException $e) {
				die('Error : ' . $e->getMessage());
			}
	}
	
	public static function insert(string $table, array $data) {
		if (self::$db == null) {
			self::connect();
		}
	}
	
	public static function update(string $table, array $data) {
		if (self::$db == null) {
			self::connect();
		}
	}
	
	public static function query(string $query, $params = [], $mode = null) {
		if (self::$db == null) {
			self::connect();
		}
		try {
			$result = self::$db->prepare($query);
			Debug::dd($result);
			Debug::dd($query);
			$result->execute($params);
			if ($mode) {
				return $result->fetchAll($mode);
			}
		} catch(PDOException $e) {
//			header("location: /");
			die('Error : ' . $e->getMessage());
		}
		return ($result);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	private static function delFolder($dir)
	{
		if (!file_exists($dir))
			return false;
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file)
			(is_dir("$dir/$file")) ? self::delFolder("$dir/$file") : unlink("$dir/$file");
		return rmdir($dir);
	}

	private static function delete()
	{
		try
		{
			self::$db->exec("DROP DATABASE IF EXISTS camagru");
			echo "Database 'camagru' has been deleted" . PHP_EOL;
			self::delFolder(ROOT.'/database');
			return true;
		}
		catch (PDOException $error) {
			echo 'Deletion failed: ' . $error->getMessage() . PHP_EOL;
		}
		return false;
	}

	public static function create()
	{
		global $DB_DSN;
		global $DB_USER;
		global $DB_PASSWORD;
		self::$connect_error_mode = false;
		if (self::connect($DB_DSN, $DB_USER, $DB_PASSWORD))
			self::delete();
		else
			self::connect(str_replace("dbname=camagru;", "", $DB_DSN), $DB_USER, $DB_PASSWORD);
		if (self::$db !== null)
		{
			$create_query = file_get_contents(ROOT.'/config/sql/create.sql');
			$user_query = file_get_contents(ROOT.'/config/sql/user.sql');
			$image_query = file_get_contents(ROOT.'/config/sql/image.sql');
			$comment_query = file_get_contents(ROOT.'/config/sql/comment.sql');
			$vote_query = file_get_contents(ROOT.'/config/sql/vote.sql');
			try
			{
				self::$db->exec($create_query);
				self::$db->exec($user_query);
				self::$db->exec($image_query);
				self::$db->exec($comment_query);
				self::$db->exec($vote_query);
				echo "Database 'camagru' has been created" . PHP_EOL;
				return true;
			}
			catch (PDOException $error) {
				echo 'Creation failed: ' . $error->getMessage() . PHP_EOL;
			}
		}
		return false;
	}

	public static function dquery1($query_string, $params = array(), $fetch_mode = true)
	{
		$database = self::get();
		$request = $database->prepare($query_string);
		foreach ($params as $item)
			$item = trim(htmlspecialchars($item));
		$request->execute($params);
		if ($fetch_mode)
			return $request->fetchAll(PDO::FETCH_ASSOC);
		return $request;
	}

	public static function get()
	{
		if (self::$db == null)
		{
			global $DB_DSN;
			global $DB_USER;
			global $DB_PASSWORD;
			self::connect($DB_DSN, $DB_USER, $DB_PASSWORD);
		}
		return self::$db;
	}
}