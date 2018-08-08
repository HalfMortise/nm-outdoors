<?php
namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\{ActivityType, Activity, recArea};

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
		$this->activity = new Activity(generateUuidV4(), "biking");
		$this->activity->insert($this->getPDO());
		$this->recArea = new RecArea(generateUuidV4(), "This 5,200 surface acre reservoir offers some of the finest fishing in northern New Mexico. Reptile fossils 200 million years old have been found in the area. The area includes a fine panoramic view of the Cerro Pedernal from the dam. It is surrounded by red sandstone formations on Hwy 84 and adjacent to historical Pedernal Mountain to the south on Hwy 96.", "Abiquiu Lake is located in northern New Mexico, 61 miles north of Santa Fe on Highway 84 at the intersection of Highway 96. From Espanola, 30 miles west on US 84, 2 miles south on NM 96.", "https://ridb.recreation.gov/images/2315.jpg", "42.123456", "122.765678", "http://www.emnrd.state.nm.us/prd/ParksPages/documents/brantleylake.pdf", "Brantley Reservoir");
		$this->recArea->insert($this->getPDO());
	}

	/**
	 * test inserting a valid ActivityType and verify that the actual mySQL data matches
	 **/
	public function testInsertValidActivityType(): void {
		//count the number od rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new activityType and insert it into mySQL
		$activityType = new ActivityType($this->activity->getActivityId(), $this->recArea->getRecAreaId());
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
	/**
	 * test grabbing an ActivityType by ActivityId
	 **/
	public function testGetValidActivityTypeByActivityId() : void {
		//count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new ActivityType and insert it into mySQL
		$activityType = new ActivityType($this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$activityType->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = ActivityType::getActivityTypeByActivityTypeActivityId($this->getPDO(), $this->activity->getActivityId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activityType"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("HalfMortise\NmOutdoors\ActivityType", $results);

		//grab the result from the array and validate it
		$pdoActivityType = $results[0];
		$this->assertEquals($pdoActivityType->getActivityTypeActivityId(), $this->activity->getActivityId());
		$this->assertEquals($pdoActivityType->getActivityTypeRecAreaId(), $this->recArea->getRecAreaId());
	}
	/**
	 * test grabbing an ActivityType by an ActivityId that does not exist
	 **/
	public function testGetInvalidActivityTypeByActivityId(): void {
		//grab an activity Id that exceeds the maximum allowable activityId
		$activityType = ActivityType::getActivityTypeByActivityTypeActivityId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $activityType);
	}
	/**
	 * test grabbing an activityType by RecAreaId
	 **/
	public function testGetValidActivityTypeByRecAreaId() : void {
		//count number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("activityType");

		//create a new ActivityType and insert it into mySQL
		$activityType = new ActivityType($this->activity->getActivityId(), $this->recArea->getRecAreaId());
		$activityType->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = ActivityType::getActivityTypeByActivityTypeRecAreaId($this->getPDO(), $this->recArea->getRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("activityType"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\ActivityType", $results);

		//grab the result from the array and validate it
		$pdoActivityType = $results[0];
		$this->assertEquals($pdoActivityType->getActivityTypeActivityId(), $this->activity->getActivityId());
		$this->assertEquals($pdoActivityType->getActivityTypeRecAreaId(), $this->recArea->getRecAreaId());
	}
	/**
	 * test grabbing an ActivityType by an RecAreaId that does not exist
	 **/
	public function testGetInvalidActivityTypeByRecAreaId(): void {
		//grab an RecAreaId that exceeds the maximum allowable recAreaId
		$activityType = ActivityType::getActivityTypeByActivityTypeRecAreaId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $activityType);
	}
}