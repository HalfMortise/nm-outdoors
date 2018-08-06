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

		//create and insert the mocked Activity
		$this->activity = new Activity(generateUuidV4(), null, "@phpunit",);
		$this->activity->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ActivityType and verify that the actual mySQL data matches
	 **/
	public function testInsertValidActivityType(): void {
		//count the number od rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new activityType and insert it into mySQL
		$activityType = new ActivityType($this->recArea->getRecAreaId(), $this->activity->getActivityId);
		$activityType->insert($this->getPDO());

		//grab the data from mySQL and enfore the fields match our expectations
		$pdoActivityType = ActivityType::getActivityTypeByActivityTypeActivityIdAndActivityTypeRecAreaId($this->getPDO(), $this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activityType"));
		$this->assertEquals($pdoActivityType->getActivityTypeActivityId(), $this->activity->getActivityId());
		$this->assertEquals($pdoActivityType->getActivityTypeRecAreaId(), $this->recArea->getRecAreaId());
	}
	/**
	 * test creating a valid activityType and then deleting it
	 **/
	public function testDeleteValidActivityType(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new ActivityType and insert it into mySQL
		$activityType = new ActivityType($this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$activityType->insert($this->getPDO());

		//delete the activityType from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activityType"));
		$activityType->delete($this->getPDO());

		//grab the data from mySQL and enforce the ActivityType does not exist
		$pdoActivityType = ActivityType::getActivityTypeByActivityTypeActivityIdAndActivityTypeRecAreaId($this->getPDO(), $this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$this->assertNull($pdoActivityType);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("activityType"));
	}
	/**
	 * test inserting an ActivityType and regrabbing it from mySQL
	 **/
	public function testGetValidActivityTypeByActivityIdAndRecAreaId(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new ActivityType and insert it into mySQL
		$activityType = new ActivityType($this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$activityType->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoActivityType = ActivityType::getActivityTypeByActivityTypeActivityIdAndActivityTypeRecAreaId($this->getPDO(), $this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activityType"));
		$this->assertEquals($pdoActivityType->getActivityTypeActivityId(), $this->activity->getActivityId());
		$this->assertEquals($pdoActivityType->getActivityTypeRecAreaId(), $this->recArea->getRecAreaId());
	}
	/**
	 * test grabbing an ActivityType that does not exist
	 **/
	public function testGetInvalidActivityTypeByActivityIdAndRecAreaId() {
		//grab an ActivityId and RecAreaId that exceeds the maximum allowable ActivityId and RecAreaId
		$activityType = ActivityType::getActivityTypeByActivityTypeActivityIdAndActivityTypeRecAreaId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($activityType);
	}

}