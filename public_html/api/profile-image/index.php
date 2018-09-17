<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";

use HalfMortise\NmOutdoors\Profile;

/**
 * Cloudinary API for Images
 *
 * @author Bashir Shafii
 * @version 1.0
 */

// start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new StdClass();
$reply->status = 200;
$reply->data = null;

try {
	// Grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
	//determine which HTTP method is being used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	$config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
	$cloudinary = json_decode($config["cloudinary"]);

	//UPDATE THESE KEYS AFTER ADDING THIS FILE TO .GITIGNORE
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, $cloudinary->apiKey, $cloudinary->apiSecret]);

	// process GET requests

	if($method === "POST") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// verify the user is logged in
		if(empty($_SESSION["profile"]) === true) {
			throw (new \InvalidArgumentException("you must be logged in to post images", 401));

			// grab the user using the session


			// assigning variable to the user profile, add image extension
			$tempUserFileName = $_FILES["image"]["tmp_name"];

			// upload image to cloudinary and get public id
			$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, array("width" => 500, "crop" => "scale"));

			//use the setProfileImageUrl() to set the image url
			//update the profile and attach a reply message
		}
	}
} catch
(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-Type: application/json");

// encode and return reply to front end caller
echo json_encode($reply);