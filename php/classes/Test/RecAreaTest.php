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
	protected $VALID_recAreaDescription = null;


	protected $VALID_recAreaDirections = null;
	/**
	 * a url string holding a stock image of rec area
	 * @var string $recAreaImageUrl
	 **/
	protected $VALID_recAreaImageUrl = null;
	/**
	 * Latitude position  of a rec area
	 * @var double $recAreaLat
	 **/
	protected $VALID_recAreaLat = null;

	/**
	 * longitude position of rec area
	 * @var double $recAreaLong
	 **/
	protected $VALID_recAreaLong = null;

	/**
	 * url of the rec area map
	 * @var string $recAreaMapUrl
	 **/
	protected $VALID_recAreaMapUrl = null;

	/**
	 * rec area name
	 * @var string $recAreaName
	 **/
	protected $VALID_recAreaName= null;



}