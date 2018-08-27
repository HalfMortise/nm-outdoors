<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use HalfMortise\NmOutdoors\{
	Activity
};

/**
 * API for the activity Class
 *
 * @author ryolambert <https://github.com/ryolambert>
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
//	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$activityId = filter_input(INPUT_GET, "activityId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//gets a specific activity based on its activityId
		if(empty($activityId) === false) {
			$activityId = Activity::getActivityByActivityId($pdo, $id);
			if($activityId !== null) {
				$reply->data = $activityId;
			}
		} else if(empty($pdo) === false) {
			$reply->data = Activity::getAllActivities($pdo);
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}
	}
} catch
		(\Exception | \TypeError $exception) {
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
		}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);