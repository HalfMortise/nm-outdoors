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
 * @var \Uuid $profileActivationToken
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
 * @param Uuid $newProfileActivationToken activation token for profile setup
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

   public function __construct($newProfileId, $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, $newProfileHash, string $newProfileImageUrl) {
      try {
         $this->setProfileId($newProfileId);
         $this->setProfileActivationToken($newProfileActivationToken);
         $this->setProfileAtHandle($newProfileAtHandle);
         $this->setProfileEmail($newProfileEmail);
         $this->setProfileHash($newProfileHash);
         $this->setProfileImageUrl($newProfileImageUrl);
      }
      //determine exception thrown
      catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
         $exceptionType = get_class($exception);
         throw(new $exceptionType($exception->getMessage(), 0, $exception));
      }
   }

}