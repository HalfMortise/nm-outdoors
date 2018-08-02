<?php
namespace HalfMortise\NmOutdoors;
require_once("autoload.php"); //autoload.php file in Classes directory
require_once(dirname(__DIR__, 2) . "../vendor/autoload.php"); //composer-generated autoload
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
 * @var string|Uuid $profileId
 */
   private $profileId;

/**
 * Activation token for profile
 * @var string $profileActivationToken
 */
   private $profileActivationToken;

/**
 * Handle for profile
 * @var string $profileAtHandle
 */
   private $profileAtHandle;

/**
 * Email provided for profile setup
 * @var string $profileEmail
 */
   private $profileEmail;

/**
 * Hash-password for profile
 * @var string|Uuid $profileHash
 */
   private $profileHash;

/**
 * Image-avatar provided for profile
 * @var string $profileImageUrl
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

   public function __construct($newProfileId, string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, $newProfileHash, string $newProfileImageUrl) {
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
 * @return uuid value of profile id
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
   public function getProfileActivationToken(): string {
      return ($this->profileActivationToken);
   }
/**end accessor method for profileActivationToken*/


/**
 * mutator method for profileActivationToken
 *
 * @param string $newProfileActivationToken new value of profileActivationToken
 * @throws \InvalidArgumentException if the token is not a string or not secure
 * @throws \RangeException if $newProfileActivationToken is > 32 characters
 * @throws \TypeError if $newProfileActivationToken is not a string
 **/
   public function setProfileActivationToken($newProfileActivationToken): void {
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


/**
 * accessor method for profileAtHandle
 *
 * @return string value of profileAtHandle
 **/
   public function getProfileAtHandle(): string {
      return ($this->profileAtHandle);
   }
/**end accessor method for profileAtHandle*/


/**
 * mutator method for profileAtHandle
 *
 * @param string $newProfileAtHandle new value of profileAtHandle
 * @throws \InvalidArgumentException if $newProfileAtHandle is not secure
 * @throws \RangeException if $newProfileAtHandle is > 32 characters
 * @throws \TypeError if $newProfileAtHandle is not a string
 **/
   public function setProfileAtHandle(string $newProfileAtHandle) : void {
      /**verify security of the handle*/
      $newProfileAtHandle = trim($newProfileAtHandle);
      $newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($newProfileAtHandle) === true) {
         throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
      }

      /**verify the handle will fit in the database range*/
      if(strlen($newProfileAtHandle) > 32) {
         throw(new \RangeException("profile at handle is too large"));
      }

      /**store the at handle*/
      $this->profileAtHandle = $newProfileAtHandle;
   }
/**end mutator method for profileAtHandle*/


/**
 * accessor method for profileAtHandle
 *
 * @return string value of profileEmail
 **/
   public function getProfileEmail(): string {
      return ($this->profileEmail);
   }
/**end accessor method for profileEmail*/


/**
 * mutator method for profileEmail
 *
 * @param string $newProfileEmail new value of profile Email
 * @throws \InvalidArgumentException if $newProfileEmail is not valid or secure
 * @throws \RangeException if $newProfileEmail is > 128 characters
 * @throws \TypeError if $newProfileEmail is not a string
 **/
   public function setProfileEmail(string $newProfileEmail): void {
      /**verify the email is secure*/
      $newProfileEmail = trim($newProfileEmail);
      $newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
      if(empty($newProfileEmail) === true) {
         throw(new \InvalidArgumentException("profile email is empty or insecure"));
      }

      /**store the email*/
      $this->profileEmail = $newProfileEmail;
   }
/**end mutator method for profileEmail*/


/**
 * accessor method for profileHash
 *
 * @return string value of profileHash
 **/
   public function getProfileHash(): string {
      return ($this->profileHash);
   }
/**end accessor method for profileHash*/


/**
 * mutator method for profileHash password
 *
 * @param string $newProfileHash
 * @throws \InvalidArgumentException if $newProfileHash is not secure
 * @throws \RangeException if $newProfileHash is > 97 characters
 * @throws \TypeError if $newProfileHash is not a string
 **/
   public function setProfileHash(string $newProfileHash): void {
      /**enforce that the hash is properly formatted*/
      $newProfileHash = trim($newProfileHash);
      if(empty($newProfileHash) === true) {
         throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
      }

      /**enforce the hash is really an Argon hash*/
      $profileHashInfo = password_get_info($newProfileHash);
      if($profileHashInfo["algoName"] !== "argon2i") {
         throw(new \InvalidArgumentException("profile hash is not a valid hash"));
      }

      /**enforce that the hash is exactly 97 characters*/
      if(strlen($newProfileHash) !== 97) {
         throw(new \RangeException("profile hash must be 97 characters"));
      }

      /**store the hash*/
      $this->profileHash = $newProfileHash;
   }
/**end mutator method for profileHash*/


/**
 * accessor method for profileImageUrl
 *
 * @return string value of profileImageUrl
 **/
   public function getProfileImageUrl(): string {
      return ($this->profileImageUrl);
   }
/**end accessor method for profileImageUrl*/


/**
 * mutator method for profileImageUrl
 *
 * @param string $newProfileImageUrl
 * @throws \InvalidArgumentException if $newProfileImageUrl is not a string or is insecure
 * @throws \RangeException if $newProfileImageUrl is > 97 characters
 * @throws \TypeError if $newProfileImageUrl is not a string
 **/
   public function setProfileImageUrl(string $newProfileImageUrl): void {
      $newProfileImageUrl = trim($newProfileImageUrl);
      $newProfileImageUrl = filter_var($newProfileImageUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

      /**verify the image url will fit in the database*/
      if(strlen($newProfileImageUrl) > 255) {
         throw(new \RangeException("image url content is too large"));
      }
      /**store the image url content*/
      $this->profileImageUrl = $newProfileImageUrl;
   }
/**end mutator method for profileImageUrl*/


/******************PDOs**********************/

/**
 * INSERTs this Profile into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
   public function insert(\PDO $pdo): void {

      /**create query template*/
      $query = "INSERT INTO profile(profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileImageUrl) VALUES (:profileId, :profileActivationToken, :profileAtHandle, :profileEmail, :profileHash, :profileImageUrl)";
      $statement = $pdo->prepare($query);

      $parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileImageUrl" => $this->profileHash];
      $statement->execute($parameters);
   }

/**
 * DELETEs this Profile from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
   public function delete(\PDO $pdo): void {

      /**create query template*/
      $query = "DELETE FROM profile WHERE profileId = :profileId";
      $statement = $pdo->prepare($query);

      /**bind the member variables to the place holders in the template*/
      $parameters = ["profileId" => $this->profileId->getBytes()];
      $statement->execute($parameters);
   }

/**
 * UPDATEs this Profile from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
   public function update(\PDO $pdo): void {

      /**create query template*/
      $query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileImageUrl = :profileImageUrl, profileEmail = :profileEmail, profileHash = :profileHash, WHERE profileId = :profileId";
      $statement = $pdo->prepare($query);

      /**bind the member variables to the place holders in the template*/
      $parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileImageUrl" => $this->profileImageUrl];
      $statement->execute($parameters);
   }


   /**
    * gets the Profile by profile id
    *
    * @param \PDO $pdo $pdo PDO connection object
    * @param string $profileId profile Id to search for
    * @return Profile|null Profile or null if not found
    * @throws \PDOException when mySQL related errors occur
    * @throws \TypeError when a variable are not the correct data type
    **/
   public static function getProfileByProfileId(\PDO $pdo, string $profileId):?Profile {

      /**sanitize the profileId before searching*/
      try {
         $profileId = self::validateUuid($profileId);
      } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }

      /**create query template*/
      $query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileImageUrl FROM profile WHERE profileId = :profileId";
      $statement = $pdo->prepare($query);

      /**bind the profile id to the place holder in the template*/
      $parameters = ["profileId" => $profileId->getBytes()];
      $statement->execute($parameters);

      /**grab the profile from MySQL*/
      try {
         $profile = null;
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         $row = $statement->fetch();
         if($row !== false) {
            $profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profileImageUrl"]);
         }
      } catch(\Exception $exception) {
         /**if the row couldn't be converted, rethrow it*/
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }
      return ($profile);
   }


/**
 * gets the Profile by email
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileEmail email to search for
 * @return Profile|null Profile or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
   public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {

      /**sanitize the profileId before searching*/
      $profileEmail = trim($profileEmail);
      $profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);

      if(empty($profileEmail) === true) {
         throw(new \PDOException("not a valid email"));
      }

      /**create a query template*/
      $query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileImageUrl FROM profile WHERE profileEmail = :profileEmail";
      $statement = $pdo->prepare($query);

      /**bind the profileId to the place holder in the template*/
      $parameters = ["profileEmail" => $profileEmail];
      $statement->execute($parameters);

      /**grab the profile from MySQL*/
      try {
         $profile = null;
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         $row = $statement->fetch();
            $profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profileImageUrl"]);
      } catch(\Exception $exception) {
         /**if the row couldn't be converted, rethrow it*/
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }
      return ($profile);
   }


/**
 * get the profile by profile activation token
 *
 * @param string $profileActivationToken
 * @param \PDO object $pdo
 * @return Profile|null Profile or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
   public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {

      /**make sure the activation token is in the right format and that it is a string representation of a hexadecimal*/
      $profileActivationToken = trim($profileActivationToken);
      if(ctype_xdigit($profileActivationToken) === false) {
         throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
      }

      /**create the query template*/
      $query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileImageUrl FROM profile WHERE profileActivationToken = :profileActivationToken";
      $statement = $pdo->prepare($query);

      /**bind the profile activation token to the place holder in the template*/
      $parameters = ["profileActivationToken" => $profileActivationToken];
      $statement->execute($parameters);

      /**grab the Profile from MySQL*/
      try {
         $profile = null;
         $statement->setFetchMode(\PDO::FETCH_ASSOC);
         $row = $statement->fetch();
         if($row !== false) {
            $profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profileImageUrl"]);
         }
      } catch(\Exception $exception) {

         /**if the row couldn't be converted, rethrow it*/
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }
         return ($profile);
   }


/**
 * gets the Profile by at handle
 *
 * @param \PDO $pdo PDO connection object
 * @param string $profileAtHandle at handle to search for
 * @return \SPLFixedArray of all profiles found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
   public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle) : SPLFixedArray {

      /**sanitize the at handle before searching*/
      $profileAtHandle = trim($profileAtHandle);
      $profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      if(empty($profileAtHandle) === true) {
         throw(new \PDOException("not a valid at handle"));
      }

      /**create a query template*/
      $query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileImageUrl FROM profile WHERE profileAtHandle = :profileAtHandle";
      $statement = $pdo->prepare($query);

      /**bind the profile at handle to the place holder in the template*/
      $parameters = ["profileAtHandle" => $profileAtHandle];
      $statement->execute($parameters);

      $profiles = new \SPLFixedArray($statement->rowCount());
      $statement->setFetchMode(\PDO::FETCH_ASSOC);

      while (($row = $statement->fetch()) !== false) {
         try {
            $profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profileImageUrl"]);
            $profiles[$profiles->key()] = $profile;
            $profiles->next();
         } catch(\Exception $exception) {

            /**if the row couldn't be converted, rethrow it*/
            throw(new \PDOException($exception->getMessage(), 0, $exception));
         }
      }
      return ($profiles);
   }


}