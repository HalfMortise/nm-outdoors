<?php
namespace HalfMortise\NmOutdoors;
require_once("../autoload.php");
require_once(dirname(__DIR__, 3) . "../../vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "./ValidateUuid.php");
use HalfMortise\NmOutdoors\Profile;

/**
 * This is the PHPUnit test for the class Profile
 *
 * If is complete because ALL MySQL / PDO-enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see \HalfMortise\NmOutdoors\Profile
 * @author HalfMortise
 */

   class ProfileTest extends NmOutdoorsTest {

/**
 * placeholder until account activation is created
 * @var string $VALID_ACTIVATION
 */
      protected $VALID_ACTIVATION;

/**
 * valid at handle to use
 * @var string $VALID_ATHANDLE
 */
      protected $VALID_ATHANDLE = "@phpunit";

/**
 * second valid at handle to use
 * @var string $VALID_ATHANDLE2
 */
      protected $VALID_ATHANDLE2 = "@passingtests";


/**
 * valid email to use
 * @var string $VALID_EMAIL
 */
      protected $VALID_EMAIL = "test@phpunit.de";

/**
 * valid hash to use
 * @var $VALID_HASH
 */
      protected $VALID_HASH;

/**
 * valid image url to use
 * @var $VALID_PROFILE_IMAGE_URL
 */
      protected $VALID_PROFILE_IMAGE_URL = "https://i.pinimg.com/736x/9d/ee/44/9dee44874ccde3a64da97bdac18dd9c8.jpg";



   }