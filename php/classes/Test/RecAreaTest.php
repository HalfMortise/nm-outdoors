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
	protected $VALID_RECAREADESCRIPTION = "This 5,200 surface acre reservoir offers some of the finest fishing in northern New Mexico. Reptile fossils 200 million years old have been found in the area. The area includes a fine panoramic view of the Cerro Pedernal from the dam. It is surrounded by red sandstone formations on Hwy 84 and adjacent to historical Pedernal Mountain to the south on Hwy 96.";


	protected $VALID_RECAREADIRECTIONS = "Abiquiu Lake is located in northern New Mexico, 61 miles north of Santa Fe on Highway 84 at the intersection of Highway 96. From Espanola, 30 miles west on US 84, 2 miles south on NM 96.";
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



}