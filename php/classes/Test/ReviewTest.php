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
	 */
	protected $recArea = null;

	/**
	 * valid profile has to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * @var string derivative from Oauth
	 */
	protected $VALID_PROFILE_REFRESH_TOKEN;

	/**
	 * content of the Comment
	 * @var string $VALID_COMMENT_CONTENT
	 */
	protected $VALID_REVIEWCONTENT = "PHPUnit test passing";

	/**
	 * content of the updated Comment
	 * @var string
	 */
	protected $VALID_REVIEWCONTENT2 = "PHPUnit test still passing";

	/**
	 * timestamp of the review; this starts as null and is assigned later
	 * @var null
	 */
	protected $VALID_REVIEWDATE = null;

	/**
	 * Valid timestamp to use as sunriseReviewDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetReviewDate
	 */
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


		// create and insert a Profile to own the test REVIEW
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "@handle", "email@gmail.com", $this->VALID_PROFILE_HASH, "https://morganfillman.space/g/300/300");
		$this->profile->insert($this->getPDO());

		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_REVIEWDATE = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	public function testInsertValidReview(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("Review");
		// create a new Review and insert it into mySQL
		$reviewId = generateUuidV4();
		$review = new Review($reviewId, )
	}
}