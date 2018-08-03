<?php
namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\Test\{ActivityType, Activity, RecArea};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the ActivityType class
 *
 * This is a complete PHPUnit test of the ActivityType class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \HalfMortise\NmOutdoors\ActivityType
 **/

class ActivityTypeTest extends NmOutdoorsTest {
/**
 * Activity that created the ActivityType; this is for foreign key relations
 * @var Activity $activity
 **/
	protected $activity;

	/**
	 * RecArea that was referenced; this if for foreign key relations
	 * @var RecArea $recArea
	 */
	protected $recArea;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		//run the default setUp() method first
		parent::setUp();

		//create and insert the mocked profile
		$this->activity = new Activity(generateUuidV4(), null, "@phpunit",)
	}
}