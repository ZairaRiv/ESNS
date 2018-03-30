<?php
/**
 * Created by PhpStorm.
 * User: agust
 * Date: 11/27/2017
 * Time: 9:41 PM
 */

setcookie('cookiehash', '', time() + (1));
header("Location: /index.php");
