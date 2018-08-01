<?php
namespace HalfMortise\NmOutdoors;
require_once("autoload.php"); //autoload.php file in Classes directory
require_once(dirname(__DIR__, 2) . "./vendor/autoload.php"); //composer-generated autoload
use Ramsey\Uuid\Uuid;
/**
 * Small cross section of a web application for outdoor enthusiasts that enables users
 * to set up an individual profile.
 *
 * Class identified as Profile
 *
 * @author HalfMortise
 * @version 1.0
 */

class Profile {
   use ValidateUuid;

/**
 * Id for profile; this is the primary key for the class
 * @var \Uuid $profileId
 */
   private $profileId;

/**
 * Activation token for profile
 * @var \string $profileActivationToken
 */
   private $profileActivationToken;

/**
 * Handle for profile
 * @var \SplString $profileAtHandle
 */
   private $profileAtHandle;

/**
 * Email provided for profile setup
 * @var \SplString $profileEmail
 */
   private $profileEmail;

/**
 * Hash-password for profile
 * @var \Uuid $profileHash
 */
   private $profileHash;

/**
 * Image-avatar provided for profile
 * @var \SplString $profileImageUrl
 */
   private $profileImageUrl;

/**
 * Constructor for this class
 *
 * @param Uuid $newProfileId Id of this Profile
 * @param string $newProfileActivationToken activation token for profile setup
 * @param string $newProfileAtHandle handle used for profile
 * @param string $newProfileEmail email used for profile setup
 * @param Uuid $newProfileHash hash-password used for profile
 * @param string $newProfileImageUrl URL for image used as profile avatar
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 * @Documentation https://php.net/manual/en/language.oop5.decon.php
 *
 */

   public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, $newProfileHash, string $newProfileImageUrl) {
      try {
         $this->setProfileId($newProfileId);
         $this->setProfileActivationToken($newProfileActivationToken);
         $this->setProfileAtHandle($newProfileAtHandle);
         $this->setProfileEmail($newProfileEmail);
         $this->setProfileHash($newProfileHash);
         $this->setProfileImageUrl($newProfileImageUrl);
      } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
         //determine exception thrown
         $exceptionType = get_class($exception);
         throw(new $exceptionType($exception->getMessage(), 0, $exception));
      }
      /**end exception*/
   }
   /**end constructor*/

/**
 * accessor method for profileId
 *
 * @return Uuid value of profile id
 **/
   public function getProfileId(): Uuid {
      return ($this->profileId);
   }
/**end accessor method for profileId*/


/**
 * mutator method for profileId
 *
 * @param Uuid $newProfileId new value of new profile id
 * @throws \RangeException if $newProfileId is not positive
 * @throws \TypeError if $newProfileId is not unique
 **/
   public function setProfileId($newProfileId): void {
      try {
         $uuid = self::validateUuid($newProfileId);
      } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
         $exceptionType = get_class($exception);
         throw(new $exceptionType($exception->getMessage(), 0, $exception));
      }
      /**convert and store the profile id*/
      $this->profileId = $uuid;
   }
/**end mutator method for profileId*/


/**
 * accessor method for profileActivationToken
 *
 * @return string value of profileActivationToken
 **/
   public function setProfileActivationToken(): ?string {
      return ($this->profileActivationToken);
   }
/**end accessor method for profileActivationToken
 *
 *
 *
 * mutator method for profileActivationToken
 *
 * @param string $newProfileActivationToken new value of profileActivationToken
 * @throws \InvalidArgumentException if the token is not a string or not secure
 * @throws \RangeException if $newProfileActivationToken is within the character range
 * @throws \TypeError if $newProfileId is not a string
 **/
   public function getProfileActivationToken($newProfileActivationToken): void {
      if($newProfileActivationToken === null) {
         $this->profileActivationToken = null;
         return;
      }

      $newProfileActivationToken = strtolower(trim($newProfileActivationToken));
      if(ctype_xdigit($newProfileActivationToken) === false) {
         throw(new\RangeException("user activation is not valid"));
      }

      /**make sure the user activation token is only 32 characters*/
      if(strlen($newProfileActivationToken) !== 32) {
         throw (new\RangeException("user activation token must be under 32 characters"));
      }
      $this->profileActivationToken = $newProfileActivationToken;
   }
/**end mutator method for profileActivationToken*/



}