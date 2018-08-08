<?php

namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\{Profile, RecArea, Review};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the REVIEW class
 *
 * This is a complete PHPUnit test of the REVIEW class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \HalfMortise\NmOutdoors\review
 * @author Ryo Lambert <ryolambert@gmail.com>
 **/
class ReviewTest extends NmOutdoorsTest {

	/**
	 * Profile that created review for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * RecArea that is reviewed: this is for foreign key relations
	 * @var RecArea recArea
	 **/
	protected $recArea = null;

	/**
	 * valid profile has to create the profile object to own the test
	 * @var $VALID_HASH
	 **/
	protected $VALID_PROFILE_HASH;

	/**
	 * @var string derivative from Oauth
	 **/
	protected $VALID_PROFILE_REFRESH_TOKEN;

	/**
	 * content of the Comment
	 * @var string $VALID_COMMENT_CONTENT
	 **/
	protected $VALID_REVIEWCONTENT = "PHPUnit test passing";

	/**
	 * content of the updated Comment
	 * @var string
	 **/
	protected $VALID_REVIEWCONTENT2 = "PHPUnit test still passing";

	/**
	 * timestamp of the review; this starts as null and is assigned later
	 * @var null
	 **/
	protected $VALID_REVIEWDATETIME = null;

	/**
	 * rating of the Review
	 * @var int
	 **/
	protected $VALID_REVIEWRATING = 1;

	/**
	 * rating of the updated Review
	 * @var int
	 **/
	protected $VALID_REVIEWRATING2 = 2;
	/**
	 * Valid timestamp to use as sunriseReviewDate
	 **/
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetReviewDate
	 **/
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		// create and insert a RecArea to own the test Review
		$this->recArea = new RecArea(generateUuidV4(), "Random rec area test description", "Take a left, a right, then test.", "https://morganfillman.space/g/300/300", 35.084386, -106.650422, "https://morganfillman.space/g/300/300", "Test Location 1");

		// create and insert a Profile to own the test REVIEW
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "@handle", "email@gmail.com", $this->VALID_PROFILE_HASH, "https://morganfillman.space/g/300/300");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_REVIEWDATETIME = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test inserting a valid Review and verify that mySQL data matches
	 */
	public function testInsertValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");
		// create a new Review and insert it into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields to match our expectations
		$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertEquals($pdoReview->getReviewId(), $reviewId);
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRecAreaId(), $this->recArea->getRecAreaId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT);

		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDateTime()->getTimestamp(), $this->VALID_REVIEWDATETIME->getTimestamp());

		$this->assertEquals($pdoReview->getReviewRating(), $this->VALID_REVIEWRATING);
	}

	/**
	 * test inserting a Review, editing it, and then updating it
	 */
	public function testUpdateValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert it into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// edit the Review and update it in mySQL
		$review->setReviewContent($this->VALID_REVIEWCONTENT2);
		$review->setReviewRating($this->VALID_REVIEWRATING2);
		$review->update($this->getPDO());

		// grab the data from mySQL and enforce the fields to match out expectations
		$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertEquals($pdoReview->getReviewId(), $reviewId);
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRecAreaId(), $this->recArea->getRecAreaId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT2);

		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDateTime()->getTimestamp(), $this->VALID_REVIEWDATETIME->getTimestamp());

		$this->assertEquals($pdoReview->getReviewRating(), $this->VALID_REVIEWRATING2);
	}

	/**
	 * test creating a Review and then deleting it
	 **/
	public function testDeleteValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert it into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// delete the Review from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$review->delete($this->getPDO());

		// take the data from mySQL and enforce that the Review does not exist
		$pdoReview = Review::getReviewByReviewId($this->getPDO(), $review->getReviewId());
		$this->assertNull($pdoReview);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("review"));
	}

	/**d
	 * test grabbing a Review that does not exist
	 **/
	public function testGetInvalidReviewByReviewProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$review = Review::getReviewByReviewProfileId($this->getPDO(), generateUuidV4());
		$this->assertEmpty($review);
	}

	/**
	 * test grabbing a Review that does not exist
	 **/
	public function testGetInvalidReviewByReviewRecAreaId(): void {
		// grab a rec area id that exceeds the maximum allowable rec area id
		$review = Review::getReviewByReviewRecAreaId($this->getPDO(), generateUuidV4());
		$this->assertEmpty($review);
	}

	/**
	 * test grabbing a Review that does not exist
	 **/
	public function testGetInvalidReviewByReviewId(): void {
		// grab a comment id that exceeds the maximum allowable review id
		$review = Review::getReviewByReviewId($this->getPDO(), generateUuidV4());
		$this->assertNull($review);
	}

	/**
	 * test grabbing a Review by profile id
	 **/
	public function testGetValidReviewByProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert to into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Review::getReviewByReviewProfileId($this->getPDO(), $review->getReviewProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\Php\\Classes\\Review", $results);

		// grab the result from the array and validate it
		$pdoReview = $results[0];
		$this->assertEquals($pdoReview->getReviewId(), $reviewId);
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRecAreId(), $this->recArea->getRecAreaId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT);

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDate()->getTimestamp(), $this->VALID_REVIEWDATETIME->getTimestamp());

		$this->assertsEquals($pdoReview->getReviewRating(), $this->VALID_REVIEWRATING);
	}

	/**
	 * test grabbing a Review by a profile id that does not exist
	 **/
	public function testGetInvalidReviewByProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$review = Review::getReviewByReviewProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $review);
	}

	/**
	 * test grabbing a Review by rec area id
	 **/
	public function testGetValidReviewByRecAreaId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert to into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Review::getReviewByReviewRecAreaId($this->getPDO(), $review->getReviewRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\Php\\Classes\\Review", $results);

		// grab the result from the array and validate it
		$pdoReview = $results[0];
		$this->assertEquals($pdoReview->getReviewId(), $reviewId);
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRecAreId(), $this->recArea->getRecAreaId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT);

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDate()->getTimestamp(), $this->VALID_REVIEWDATETIME->getTimestamp());

		$this->assertsEquals($pdoReview->getReviewRating(), $this->VALID_REVIEWRATING);
	}

	/**
	 * test grabbing a Review by a rec area id that does not exist
	 **/
	public function testGetInvalidReviewByRecAreaId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$review = Review::getReviewByReviewRecAreaId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $review);
	}

	/**
	 * test grabbing all Reviews
	 **/
	public function testGetAllValidReviews() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("review");

		// create a new Review and insert to into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, $this->profile->getProfileId(), $this->recArea->getRecAreaId(), $this->VALID_REVIEWCONTENT, $this->VALID_REVIEWDATETIME, $this->VALID_REVIEWRATING);
		$review->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Review::getAllReviews($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("review"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\Php\\Classes\\Review", $results);

		// grab the result from the array and validate it
		$pdoReview = $results[0];
		$this->assertEquals($pdoReview->getReviewId(), $reviewId);
		$this->assertEquals($pdoReview->getReviewProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoReview->getReviewRecAreId(), $this->recArea->getRecAreaId());
		$this->assertEquals($pdoReview->getReviewContent(), $this->VALID_REVIEWCONTENT);

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoReview->getReviewDate()->getTimestamp(), $this->VALID_REVIEWDATETIME->getTimestamp());

		$this->assertsEquals($pdoReview->getReviewRating(), $this->VALID_REVIEWRATING);
	}
}
