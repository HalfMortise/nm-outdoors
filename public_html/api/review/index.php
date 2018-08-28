<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";

use HalfMortise\NmOutdoors\{
	Review, 
	// profile is for testing
	Profile
};

/**
 * API for the Review Class
 *
 * @author ryolambert <https://github.com/ryolambert>
 **/

//verify the session, start if not active
if(session_status() !==PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reviewProfileId = filter_input(INPUT_GET, "reviewProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reviewRecAreaId = filter_input(INPUT_GET, "reviewRecAreaId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$reviewContent = filter_input(INPUT_GET, "reviewContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the comment id is valid for methods that require it (required field)
	if(($method === "DELETE" || $method === "PUT") && empty($id) === true) {
		throw(new InvalidArgumentException("id cannot be empty", 405));
	}

	// handle GET request - if id is present, that review is returned, otherwise all reviews are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//gets a specific review based on its reviewId
		if(empty($id) === false) {
			$review = Review::getReviewByReviewId($pdo, $id);
//			if($review !== null) {
//				$reply->data = $review;
//			}
			//get all the reviews associated with a profileId
		} else if(empty($reviewProfileId) === false) {
			$review = Review::getReviewByReviewProfileId($pdo, $reviewProfileId)->toArray();
			//get all the reviews associated with the RecAreaId
		} else if(empty($reviewRecAreaId) === false) {
			$review = Review::getReviewByReviewRecAreaId($pdo, $reviewRecAreaId)->toArray();
			//get all the reviews associated with the reviewContent
		}else {
			$reply->data = Review::getAllReviews($pdo)->toArray();
		}
	} else if ($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();
		
		// enforce the user is signed in
		if (empty($_SESSION["profile"]) === true) {
			throw (new \InvalidArgumentException("You must be logged in to post reviews", 401));
		}
		
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		//make sure review content is available (required field)
		if (empty($requestObject->reviewContent) === true) {
			throw (new \InvalidArgumentException("No content for review.", 405));
		}
		
		// make sure review date is accurate (optional field)
		if (empty($requestObject->reviewDate) === true) {
			$requestObject->reviewDate = null;
		}
			//perform the actual put or post
	if ($method === "PUT") {

			// retrieve the review to update
		$review = Review::getReviewByReviewId($pdo, $id);
		if ($review === null) {
			throw (new RuntimeException("Review does not exist", 404));
		}

			//enforce the user is signed in and only trying to edit their own review
		if (empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $review->getReviewProfileId()->toString()) {
			throw (new \InvalidArgumentException("You are not allowed to edit this review", 403));
		}

		// //enforce the end user has a JWT token
		// validateJwtHeader();
	
			// update all attributes
		$review->setReviewContent($requestObject->reviewContent);
//		$review->setReviewDateTime($requestObject->reviewDateTime);
		$review->setReviewRating($requestObject->reviewRating);
		$review->update($pdo);

			// update reply
		$reply->message = "Review updated OK";
	
		/**
		 * Post for review
		 **/
	} else if($method === "POST") {

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to review a recreational area", 403));
		}

		// //enforce the end user has a JWT token
		// validateJwtHeader();

		// create new review and insert into the database
		$review = new Review(generateUuidV4(), $_SESSION["profile"]->getProfileId(),$requestObject->reviewRecAreaId, $requestObject->reviewContent, null, $requestObject->reviewRating);
		$review->insert($pdo);

		// update reply
		$reply->message = "Review posted successfully";
	}
	// if any other HTTP request is sent throw an exception
	} else if ($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the review to be deleted
		$review = Review::getReviewByReviewId($pdo, $id);
		if ($review === null) {
			throw (new RuntimeException("Review does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own review
		if (empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $review->getReviewProfileId()->toString()) {
			throw (new \InvalidArgumentException("You are not allowed to delete this review", 403));
		}

		// //enforce the end user has a JWT token
		// validateJwtHeader();

		// delete review
		$review->delete($pdo);
		// update reply
		$reply->message = "Review deleted OK";
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
echo json_encode($reply);