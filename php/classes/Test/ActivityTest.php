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
	protected $VALID_NAME;

}