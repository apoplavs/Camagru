<?php

/**
* 
*/
class Mail
{
	private static $from = "apoplavs@camagru.unit.ua";

	public static function send($email, $message, $subject = "Camagru", $cc = "", $bcc ="",
		$priority = "3") {

		// setting headers
		$headers = self::getHeaders(self::$from, $cc, $bcc, $priority);
		
		// send mail
		if (mail($email, $subject, $message, $headers)) {
			return true;
		} else {
			return false;
		}
	}


	private static function getHeaders($from, $cc = "", $bcc ="", $priority = "2") {
		$headers = "";
		$headers .= "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "Date: ".date("r (T)")." \r\n";

		if (strpos($from, "camagru.unit.ua") != false || strpos($from, "camagru.unit.ua") != "") {
			$headers .= "From: camagru.unit.ua <" . $from . ">\r\n";
		} else {
			$headers .= "From: " . $from . " <" . $from . ">\r\n";
		}

		$headers .= "X-Sender: <" . $from . ">\r\n";
		$headers .= "X-Priority: " . $priority . "\r\n";
		$headers .= "X-Mailer: PHP\r\n";
		$headers .= "Return-Path: <apoplavs@camagru.unit.ua>\r\n";

		if ($cc != "") {
			$headers .= "cc:" . $cc . "\r\n";
		}
		if ($bcc != "") {
			$headers .= "bcc:" . $bcc . "\r\n";
		}
		return $headers;
	}

}



// $result = send_html('contact@ourwebsite.com', "p.andriy.v@gmail.com", utf8_decode("the subject"), "<h1>test<br>erfreg er gwer yes </h1>");
// var_dump($result);