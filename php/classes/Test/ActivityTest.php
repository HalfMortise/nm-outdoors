<?php
namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\Activity;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Activity class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 *
 **/
class ActivityTest extends NmOutdoorsTest {
	/**
	 * valid name to create the profile object to own the test
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME= "PHPUnit First Test";
	/**
	 * Name of the Activity
	 * @var string $VALID_NAME2
	 **/
	protected $VALID_NAME2 = "PHPUnit test passing";
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
	}

	/**
	 * test inserting a valid Name and verify that the actual mySQL data matches
	 **/
	public function testInsertValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->VALID_NAME);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityName(), $this->VALID_NAME);
	}
}