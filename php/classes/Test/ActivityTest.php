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
	/**
	 * test inserting a Tweet, editing it, and then updating it
	 **/
	public function testUpdateValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->VALID_NAME);
		$activity->insert($this->getPDO());

		// edit the Activity and update it in mySQL
		$activity->setActivityName($this->VALID_NAME2);
		$activity->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityName(), $this->VALID_NAME);
	}
	/**
	 * test creating a Activity and then deleting it
	 **/
	public function testDeleteValidActivity() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->VALID_NAME);
		$activity->insert($this->getPDO());

		// delete the Activity from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$activity->delete($this->getPDO());

		// grab the data from mySQL and enforce the Activity does not exist
		$pdoActivity = Activity::getActivityByActivityId($this->getPDO(), $activity->getActivityId());
		$this->assertNull($pdoActivity);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("activity"));
	}
	/**
	 * test grabbing an Activity that does not exist
	 **/
	public function testGetInvalidActivityByActivityId() : void {
		// grab an activity id that exceeds the maximum allowable activity id
		$activity = Activity::getActivityByActivityId($this->getPDO(), generateUuidV4());
		$this->assertNull($activity);
	}
	/**
	 * test grabbing a Activity by activity Name
	 **/
	public function testGetValidActivityByActivityName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		// create a new Activity and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->VALID_NAME);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getActivityByActivityName($this->getPDO(), $activity->getActivityName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\Activity", $results);

		// grab the result from the array and validate it
		$pdoActivity = $results[0];
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityName(), $this->VALID_NAME);
	}
	/**
	 * test grabbing an Activity by content that does not exist
	 **/
	public function testGetInvalidActivityByActivityName() : void {
		// grab an activity by content that does not exist
		$activity = Activity::getActivityByActivityId($this->getPDO(), "activity");
		$this->assertCount(0, $activity);
	}
	/**
	 * test grabbing all Activities
	 **/
	public function testGetAllValidActivities() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activity");

		// create a new Tweet and insert to into mySQL
		$activityId = generateUuidV4();
		$activity = new Activity($activityId, $this->VALID_NAME);
		$activity->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Activity::getActivityByActivityName($this->getPDO(), $activity->getActivityName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activity"));
		$this->assertCount(1, $results);

		// grab the result from the array and validate it
		$pdoActivity = $results[0];
		$this->assertEquals($pdoActivity->getActivityId(), $activityId);
		$this->assertEquals($pdoActivity->getActivityName(), $this->VALID_NAME);
	}
}