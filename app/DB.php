<?php

// require_once(ROOT.'/config/database.php');

abstract class DB
{
	protected $db = null;
	private static $connect_error_mode = true;

	public function  __construct($DB_DSN, $DB_USER, $DB_PASSWORD) {
		try	{
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			/*
			* ATTR_ERRMODE - Режим повідомлень про помилки.
			* ERRMODE_EXCEPTION - викидати Exception.
			*/
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// відключити клієнт-серверну емуляцію підготовлених запитів
			$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			// встановлення кодування
			$this->db->exec("SET NAMES UTF8");
			} catch (PDOException $e) {
				die('Error : ' . $e->getMessage());
			}
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

	public static function query($query_string, $params = array(), $fetch_mode = true)
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