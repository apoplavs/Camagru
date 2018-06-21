<?php

/**
* 
*/
class Mail
{
	private static $from = "apoplavs@camagru.unit.ua";

	public static function send($email, $message, $from = self::from, $subject = "Camagru", $cc = "", $bcc ="", $priotity = "3") {

		// setting headers
		$headers = self::getHeaders($from, $cc, $bcc, $priotity);
		
		// send mail
		if (mail($email, $subject, $message, $headers)) {
			return true;
		} else {
			return false;
		}
	}


	private static function getHeaders($from, $cc = "", $bcc ="", $priotity = "3") {
		$headers = "";
		$headers .= "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "Date: ".date("r (T)")." \r\n";

		if (strpos($from, "ourwebsite.com") != false || strpos($from, "rencontresportive.com") != "") {
			$headers .= "From: Ourwebsite.com <" . $from . ">\r\n";
		} else {
			$headers .= "From: " . $from . " <" . $from . ">\r\n";
		}

		$headers .= "X-Sender: <" . $from . ">\r\n";
		$headers .= "X-Priority: " . $priotity . "\r\n";
		$headers .= "X-Mailer: PHP\r\n";
		$headers .= "Return-Path: <admin@ourwebsite.com>\r\n";

		if ($cc != "") {
			$headers .= "cc:" . $cc . "\r\n";
		}
		if ($bcc != "") {
			$headers .= "bcc:" . $bcc . "\r\n";
		}
	}

}



// $result = send_html('contact@ourwebsite.com', "p.andriy.v@gmail.com", utf8_decode("the subject"), "<h1>test<br>erfreg er gwer yes </h1>");
// var_dump($result);