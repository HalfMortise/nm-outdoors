<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 8/14/2018
 * Time: 2:48 PM
 */


namespace HalfMortise\NmOutdoors\Profile;

use http\Exception\InvalidArgumentException;

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * API to check profile activation status
 * @author HalfMortise <https://www.github.com/halfmortise>
 */

//Check the session; if not active, start the session

if(session_status() !== PHP_SESSION_ACTIVE) {
   session_start();
}

// \session check

//prepare an empty reply

   $reply = new \stdClass();
   $reply->status = 200;
   $reply->data = null;

   try {
      //grab the MySQL connection
      $pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/nmoutdoors.in");
      //check the HTTP method being used
      $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
      //sanitize input for security purposes
      $activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);
      //make sure the activation token is the correct length
      if(strlen($activation) !== 32){
         throw(new InvalidArgumentException("activation token is an incorrect length", 405));
      }
      //verify that the activation token is a string value of a hexadecimal
      if(ctype_xdigit($activation) === false) {
         throw (new \InvalidArgumentException("activation is empty or has invalid contents", 405));
      }
   }
















