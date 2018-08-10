<?php
/**
 * Created by PhpStorm.
 * User: bashirshafii
 * Date: 8/1/18
 * Time: 3:44 PM
 */

namespace HalfMortise\NmOutdoors\Test;

use HalfMortise\NmOutdoors\RecArea;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


/**
 * Full PHPUnit test for the RecArea class
 *
 * This is a complete PHPUnit test of the RecArea class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see RecArea
 * @author  Bashir Shafii<bashir.shafii@blackswantech.com>
 **/
class RecAreaTest extends NmOutdoorsTest {
	/**
	 * Description of RecArea
	 * @var string $recAreaDescription
	 **/
	protected $VALID_RECAREADESCRIPTION = "This is the first phpunit testing on recarea.";


	protected $VALID_RECAREADIRECTIONS = "For our first time through the rec area test you're going to test once then twice.";
	/**
	 * a url string holding a stock image of rec area
	 * @var string $recAreaImageUrl
	 **/
	protected $VALID_RECAREAIMAGEURL = "https://ridb.recreation.gov/images/2315.jpg";
	/**
	 * Latitude position  of a rec area
	 * @var double $recAreaLat
	 **/
	protected $VALID_RECAREALAT = 42.123456;


	/**
	 * Latitude position  of a rec area
	 * @var double $recAreaLat2
	 **/
	protected $VALID_RECAREALAT2 = -39.987654;


	/**
	 * longitude position of rec area
	 * @var double $recAreaLong
	 **/
	protected $VALID_RECAREALONG = 122.765678;


	/**
	 * longitude position of rec area
	 * @var double $recAreaLong2
	 **/
	protected $VALID_RECAREALONG2 = -165.789543;


	/**
	 * url of the rec area map
	 * @var string $recAreaMapUrl
	 **/
	protected $VALID_RECAREAMAPURL = "http://www.emnrd.state.nm.us/prd/ParksPages/documents/brantleylake.pdf";

	/**
	 * rec area name
	 * @var string $recAreaName
	 **/
	protected $VALID_RECAREANAME = "Brantley Reservoir";

	/**
	 * origin of where distance is measured from
	 * @var array $VALID_ORIGIN
	 **/
	protected $VALID_ORIGIN = [36.12, -86.67];
	/**
	 * destination of where distance is measured to
	 * @var array $VALID_DESTINATION
	 **/
	protected $VALID_DESTINATION = [33.94, -118.4];
	/**
	 * distance from the origin to the destination
	 * @var float $VALID_DISTANCE
	 **/
	protected $VALID_DISTANCE = 1793.55595844;


	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
	}

	public function testInsertValidRecArea() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recArea");

		// create a new recArea and insert to into mySQL
		$recAreaId = generateUuidV4();
		$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
		$recArea->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecArea = RecArea::getRecAreaByRecAreaId($this->getPDO(), $recArea->getRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
		$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
		$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
		$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
		$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
		$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT);
		$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG);
		$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
		$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);
	}

	public function testUpdateValidRecArea() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recArea");

		// create a new recArea and insert to into mySQL
		$recAreaId = generateUuidV4();
		$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
		$recArea->insert($this->getPDO());

		// edit the RecArea and update it in mySQL
		$recArea->setRecAreaLat($this->VALID_RECAREALAT2);
		$recArea->setRecAreaLong($this->VALID_RECAREALONG2);
		$recArea->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecArea = RecArea::getRecAreaByRecAreaId($this->getPDO(), $recArea->getRecAreaId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
		$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
		$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
		$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
		$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
		$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT2);
		$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG2);
		$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
		$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);
	}

	public function testDeleteValidRecArea() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recArea");

		// create a new recArea and insert to into mySQL
		$recAreaId = generateUuidV4();
		$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
		$recArea->insert($this->getPDO());

		// delete recArea from mySQl
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
		$recArea->delete($this->getPDO());

		// grab the data from mySQL and enforce the recArea doesn't exist
		$pdoRecArea = RecArea::getRecAreaByRecAreaId($this->getPDO(), $recArea->getRecAreaId());
		$this->assertNull($pdoRecArea);
		$this->assertEquals($numRows,$this->getConnection()->getRowCount("recArea"));

	}

public function testGetValidRecAreaByRecAreaId(){
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("recArea");

	// create a new recArea and insert to into mySQL
	$recAreaId = generateUuidV4();
	$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
	$recArea->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoRecArea = RecArea::getRecAreaByRecAreaId($this->getPDO(), $recArea->getRecAreaId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
	$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
	$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
	$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
	$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
	$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT);
	$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG);
	$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
	$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);


}

/**
 * test grabbing a recArea that doesn't exist
 **/
public function  testGetInvalidRecAreaByRecAreaId() : void {
	//grab a recArea id that is invalid or exceeds the maximum allowable length
	$recArea = RecArea::getRecAreaByRecAreaId($this->getPDO(),generateUuidV4());
	$this->assertNull($recArea);

}


	public function testGetValidRecAreaByRecName(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recArea");

		// create a new recArea and insert to into mySQL
		$recAreaId = generateUuidV4();
		$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
		$recArea->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = RecArea::getRecAreaByRecAreaName($this->getPDO(), $recArea->getRecAreaName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("HalfMortise\NmOutdoors\RecArea",$results);
		$pdoRecArea = $results[0];
		$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
		$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
		$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
		$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
		$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT);
		$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG);
		$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
		$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);


	}

	/**
	 * test grabbing a recArea that doesn't exist by name
	 **/
	public function  testGetInvalidRecAreaByRecAreaName() : void {
		//grab a recArea id that is invalid or exceeds the maximum allowable length
		$recArea = RecArea::getRecAreaByRecAreaName($this->getPDO(),"Bashir");
		$this->assertCount(0,$recArea);

	}

	/**
	 * test valid recArea distance
	 */
	public function testGetRecAreaByDistance(){
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recArea");

		// create a new recArea and insert to into mySQL
		$recAreaId = generateUuidV4();
		$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
		$recArea->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = RecArea::getRecAreaByDistance($this->getPDO(),122.1,45.4,107);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\RecArea", $results);
		$pdoRecArea = $results[0];
		$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
		$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
		$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
		$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
		$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT);
		$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG);
		$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
		$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);


	}
//

	/**
	 * test grabbing an invalid  recArea distance
	 **/
	public function  testGetInvalidRecAreaByRecAreaDistance() : void {
		//grab a recArea id that is invalid or exceeds the maximum allowable length
		$recArea = RecArea::getRecAreaByDistance($this->getPDO(),272.5, 101.3, -200);
		$this->assertCount(0,$recArea);

	}




	/**
	 * test returning all rec Areas
	 **/
public function testGetAllRecAreas() : void {
	//count the number of rows of rec areas
	$numRows = $this->getConnection()->getRowCount("recArea");

	//create a new recArea and insert it into mySQl
	$recAreaId = generateUuidV4();
	$recArea = new RecArea($recAreaId, $this->VALID_RECAREADESCRIPTION, $this->VALID_RECAREADIRECTIONS,$this->VALID_RECAREAIMAGEURL,$this->VALID_RECAREALAT,$this->VALID_RECAREALONG,$this->VALID_RECAREAMAPURL,$this->VALID_RECAREANAME);
	$recArea->insert($this->getPDO());

	//grab the data from mySQL and enforce the fields match our expectations
	$results = RecArea::getAllRecAreas($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recArea"));
	$this->assertCount(1, $results);

	// enforce no other objects are bleeding into test
	$this->assertContainsOnlyInstancesOf("HalfMortise\\NmOutdoors\\RecArea", $results);

	//receive the results from the array and validate it
	$pdoRecArea = $results[0];
	$this->assertEquals($pdoRecArea->getRecAreaId(), $recAreaId);
	$this->assertEquals($pdoRecArea->getRecAreaDescription(), $this->VALID_RECAREADESCRIPTION);
	$this->assertEquals($pdoRecArea->getRecAreaDirections(),$this->VALID_RECAREADIRECTIONS);
	$this->assertEquals($pdoRecArea->getRecAreaImageUrl(),$this->VALID_RECAREAIMAGEURL);
	$this->assertEquals($pdoRecArea->getRecAreaLat(),$this->VALID_RECAREALAT);
	$this->assertEquals($pdoRecArea->getRecAreaLong(),$this->VALID_RECAREALONG);
	$this->assertEquals($pdoRecArea->getRecAreaMapUrl(),$this->VALID_RECAREAMAPURL);
	$this->assertEquals($pdoRecArea->getRecAreaName(),$this->VALID_RECAREANAME);

}
/**
 * TODO
 * 1. testGetValidRecAreaByDistance
 * 2. testGetInvalidRecAreaByDistance
 * 3. testGetValidRecAreaByRecAreaName
 * 4. testGetInvalidRecAreaByRecAreaName
 */
}