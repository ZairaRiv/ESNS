<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 9/30/2017
 * Time: 6:35 AM
 */

class Template
{
	function __construct(){
		return file_get_contents("template/template.html");
	}

	public function readFile($fileName) {
		return file_get_contents($fileName);
	}

	public function delete_all_between($beginning, $end, $string) {
		$beginningPos = strpos($string, $beginning);
		$endPos = strpos($string, $end);
		if ($beginningPos === false || $endPos === false) {
			return $string;
		}
		$textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
		return str_replace($textToDelete, '', $string);
	}

}

class Email
{
    public function sendEmail(){}
}

