<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
use HalfMortise\NmOutdoors\Profile;
/**
 * api for signing up for ABQ Street Art
 *
 * @author Ryo Lambert <ryolambert@gmail.com>
 * @author Gkephart <GKephart@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nm-outdoors.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {

		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//profile username is a required field
		if(empty($requestObject->profileUserName) === true) {
			throw(new \InvalidArgumentException ("Profile username required", 405));
		}

		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("Profile email required", 405));
		}

		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//make sure the password and confirm password match
		if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}

		$hash = password_hash($requestObject->profilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$profileActivationToken = bin2hex(random_bytes(16));

		//create the profile object and prepare to insert into the database
		$profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject->profileEmail, $hash, $salt, $requestObject->profileUserName);
