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
	 * @var
	 */
	protected $VALID_PROFILE_REFRESH_TOKEN;


}