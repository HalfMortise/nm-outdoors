<?php

namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\{Profile, RecArea, Review};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Tweet class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \HalfMortise\NmOutdoors\review
 * @author Ryo Lambert <ryolambert@gmail.com>
 **/
class ReviewTest extends NmOutdoorsTest {

	/**
	 * Profile that created comment for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * @var RecArea recArea
	 */
	protected $recArea = null;

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
	protected $VALID_REVIEWDATETIME = null;

	/**
	 * Valid timestamp to use as sunriseReviewDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetReviewDate
	 */
	protected $VALID_SUNSETDATE = null;

	protected final function setUp(): void {
		// run setUp() method
		parent::setUp();
		$this->VALID_PROFILE_REFRESH_TOKEN = bin2hex(random_bytes(16));
		// create and insert a Profile to own the test (write the review)
		// order: profileId email image Refresh token username
	}
}