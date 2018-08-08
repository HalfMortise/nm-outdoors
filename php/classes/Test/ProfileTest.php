<?php
namespace HalfMortise\NmOutdoors\Test;
//require_once("/autoload.php");
require_once(dirname(__DIR__) . "/autoload.php");//pulling from Classes dir.
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

use HalfMortise\NmOutdoors\Profile;

/**
 * This is the PHPUnit test for the class Profile
 *
 * If is complete because ALL MySQL / PDO-enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see \HalfMortise\NmOutdoors\Profile
 * @author HalfMortise
 **/

   class ProfileTest extends NmOutdoorsTest {

/**
 * placeholder until account activation is created
 * @var string $VALID_ACTIVATION
 **/
      protected $VALID_ACTIVATION;

/**
 * valid at handle to use
 * @var string $VALID_ATHANDLE
 **/
      protected $VALID_ATHANDLE = "@phpunit";

/**
 * second valid at handle to use
 * @var string $VALID_ATHANDLE2
 **/
      protected $VALID_ATHANDLE2 = "@passingtests";


/**
 * valid email to use
 * @var string $VALID_EMAIL
 **/
      protected $VALID_EMAIL = "test@phpunit.de";

/**
 * valid hash to use
 * @var $VALID_HASH
 **/
      protected $VALID_HASH;

/**
 * valid image url to use
 * @var $VALID_PROFILE_IMAGE_URL
 **/
      protected $VALID_PROFILE_IMAGE_URL = "https://i.pinimg.com/736x/9d/ee/44/9dee44874ccde3a64da97bdac18dd9c8.jpg";


      /**this runs the default setup operation to create the argon password and hash*/

      public final function setUp() : void {
         parent::setUp();

         $password = "abc123";
         $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
         $this->VALID_ACTIVATION = bin2hex(random_bytes(16));
      }
/**
 * test inserting a valid Profile and verify that the actual MySQL data matches
 **/
      public function testInsertValidProfile() : void {
         //count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         //grab the data from MySQL and enforce the fields match our expectations
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         $this->assertEquals($pdoProfile->getProfileId(), $profileId);
         $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE );
         $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
         $this->assertEquals($pdoProfile->getProfileImageUrl(), $this->VALID_PROFILE_IMAGE_URL);
      }


/**
 * test to insert a Profile, edit it, and then update it
 **/
      public function testUpdateValidProfile() {
         // count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         // create a new Profile and insert to into MySQL
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH,$this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         // edit the Profile and update it in MySQL
         $profile->setProfileAtHandle($this->VALID_ATHANDLE2);
         $profile->update($this->getPDO());
         // grab the data from MySQL and enforce the fields match our expectations
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         $this->assertEquals($pdoProfile->getProfileId(), $profileId);
         $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE2);
         $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
         $this->assertEquals($pdoProfile->getProfileImageUrl(), $this->VALID_PROFILE_IMAGE_URL);
      }


/**
 * test to create a Profile, then delete it
 **/
      public function testDeleteValidProfile() : void {
         //count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         //delete the Profile from MySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         //grab the data from MySQL and enforce the profile does not exist
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertNull($pdoProfile);
         $this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
      }


/**
 * test to insert a Profile and re-grab it from MySQL
 **/
      public function testGetValidProfileByProfileId() : void {
         //count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         //grab the data from MySQL and enforce the fields match expectations
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         $this->assertEquals($pdoProfile->getProfileId(), $profileId);
         $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
         $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
         $this->assertEquals($pdoProfile->getProfileImageUrl(), $this->VALID_PROFILE_IMAGE_URL);
      }


/**
 * test grabbing a non-existent profile
 **/
      public function testGetInvalidProfileByProfileId() : void {
         //grab a profile id that exceeds the maximum allowable profile id
         $fakeProfileId = generateUuidV4();
         $profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId);
         $this->assertNull($profile);
      }


/**
 * test for grabbing a profile by a valid email
 **/
      public function testGetValidProfileByEmail() : void {
         //count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         //grab the data from MySQL and enforce the fields match expectations
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         $this->assertEquals($pdoProfile->getProfileId(), $profileId);
         $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
         $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
         $this->assertEquals($pdoProfile->getProfileImageUrl(), $this->VALID_PROFILE_IMAGE_URL);
      }


/**
 * test for grabbing a profile by an email not tied to an existent profile
 **/
      public function testGetInvalidProfileByEmail() : void {
         //grab an email not tied to an existent profile
         $profile = Profile::getProfileByProfileEmail($this->getPDO(), "email@non.existent");
         $this->assertNull($profile);
      }


/**
 * test for grabbing a profile by its activation token
 **/
      public function testGetProfileByActivationToken() : void {
         //count the number of rows and save the result for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_PROFILE_IMAGE_URL);
         $profile->insert($this->getPDO());
         //grab the data from MySQL and enforce the fields match expectations
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
         $this->assertEquals($pdoProfile->getProfileId(), $profileId);
         $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
         $this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
         $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
         $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
         $this->assertEquals($pdoProfile->getProfileImageUrl(), $this->VALID_PROFILE_IMAGE_URL);
      }


/**
 * test for grabbing a profile by an invalid (nonexistent) activation token
 **/
      public function testGetInvalidProfileActivation() : void {
         //grab an activation token that does not exist or is invalid
         $profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "7b26311cb4ba4a3daad612f9985c2fe4");
         $this->assertNull($profile);
      }
   }