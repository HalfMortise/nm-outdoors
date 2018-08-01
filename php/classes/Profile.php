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





}