<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 6:51 PM
 */

$password="esnslife";

$options = [
	'cost' => 12,
];
echo password_hash($password, PASSWORD_BCRYPT, $options);
