<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use HalfMortise\NmOutdoors\{
	Review, Profile, RecArea
};

/**
 * API for the Review Class
 *
 * @author Ryo Lambert <ryolambert@gmail.com>
 **/

//verify the session, stRecArea if not active
if(session_status() !==PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");

	//determin which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$reviewProfileId = $id = filter_input(INPUT_GET, "reviewProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reviewRecAreaId = $id = filter_input(INPUT_GET, "reviewRecAreaId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//gets a specific review based on its reviewId
		if(empty($id) === false) {
			$review = Review::getReviewByReviewId($pdo, $id);
			if($review !== null) {
				$reply->data = $review;
			}
			//get all the reviews associated with a profileId
		} else if(empty($reviewProfileId) === false) {
			$review = Review::getReviewByReviewProfileId($pdo, $reviewProfileId)->toArray();
			if($review !== null) {
				$reply->data = $review;
			}
			//get all the reviews associated with the RecAreaId
		} else if(empty($reviewRecAreaId) === false) {
			$review = Review::getReviewByReviewRecAreaId($pdo, $reviewRecAreaId)->toArray();
			if($review !== null) {
				$reply->data = $review;
			}
		} else {
			throw new InvalidArgumentException("incorrect search parameters ", 404);
		}
		/**
		 * Post for review
		 **/
	} else if($method === "POST") {
		//enforce that the end user has a XSRF token.
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->reviewProfileId) === true) {
			throw (new \InvalidArgumentException("no profile linked to the review", 405));
		}
		if(empty($requestObject->reviewRecAreaId) === true) {
			throw (new \InvalidArgumentException("no recreational area linked to the review", 405));
		}
		if(empty($requestObject->reviewDateTime) === true) {
//			$requestObject->reviewDateTime = date("y-m-d H:i:s");
		}

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to review on RecArea", 403));
		}
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $_SESSION["profile"]->getProfileId(),$requestObject->reviewRecAreaId, $requestObject->reviewContent, $requestObject->reviewDateTime, $requestObject->reviewRating);
		$review->insert($pdo);
		$reply->message = "review posted successfully";

		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
