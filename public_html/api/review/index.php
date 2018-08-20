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
	session_stRecArea();
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
