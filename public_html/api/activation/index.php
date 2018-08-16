<?php
/**
 * Created by PhpStorm.
 * User: Joy
 * Date: 8/14/2018
 * Time: 2:48 PM
 */
//TO DO: add xsrf.php to lib dir

namespace HalfMortise\NmOutdoors\Profile;

//use http\Exception\InvalidArgumentException;

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
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

// end session check

//prepare an empty reply

   $reply = new \stdClass();
   $reply->status = 200;
   $reply->data = null;

   try {
      //grab the MySQL connection
      $pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      //check the HTTP method being used
      $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
      //sanitize input for security purposes
      $activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);
      //make sure the activation token is the correct length
      if(strlen($activation) !== 32){
         throw(new \InvalidArgumentException("activation token is an incorrect length", 405));
      }
      //verify that the activation token is a string value of a hexadecimal
      if(ctype_xdigit($activation) === false) {
         throw (new \InvalidArgumentException("activation is empty or has invalid contents", 405));
      }
      //handle the GET HTTP request
      if($method === "GET") {
         ///set the XSRF cookie
         setXsrfCookie();
         //find profile associated with the activation token
         $profile = Profile::getProfileByProfileActivationToken($pdo, $activation);
         //verify that the profile is not null
         if($profile !== null) {
            //make sure the activation token matches
            if($activation === $profile->getProfileActivationToken()) {
               //set activation to null
               $profile->setProfileActivationToken(null);
               //update the profile in the database
               $profile->update($pdo);
               $reply->data = "Thank you for activating your account; you will now be redirected to your profile.";
            }
         } else {
            //throw an exception if the activation token does not exist
            throw(new \RuntimeException("Profile with this activation token does not exist", 404));
         }
      } else {
         //throw an exception if the HTTP request is not  GET
         throw(new \InvalidArgumentException("Invalid HTTP method request", 403));
      }
      //update the reply object's status and message state variables if an exception or type exception was thrown;
   } catch (\Exception $exception) {
      $reply->status = $exception->getCode();
      $reply->message = $exception->getMessage();
   } catch(\TypeError $typeError) {
      $reply->status = $typeError->getCode();
      $reply->status = $typeError->getMessage();
   }
   //prepare and send the reply
header("Content-type: application/json");
   if($reply->data === null) {
      unset($reply->data);
   }

   echo json_encode($reply);
