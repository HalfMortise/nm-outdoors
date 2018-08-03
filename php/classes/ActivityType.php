<?php

namespace Sarahheckendorn\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use HalfMortise\NmOutdoors\Activity;
use Ramsey\Uuid\Uuid;

class ActivityType {
	use ValidateUuid;
	/**
	 * id for the ActivityTypeActivityId; this is a foreign key
	 * @var $songTabSongId
	 **/
	private $activityTypeActivityId;
	/**
	 * id for the ActivityTypeRecId; this is a foreign key
	 * @var $activityTypeRecId
	 **/
	private $activityTypeRecAreaId;

	/**
	 * ActivityType constructor.
	 * @param string|UUID $newActivityTypeActivityId gives the id of ActivityTypeActivityID
	 * @param string|UUID $newActivityTypeRecAreaId gives the ID of ActivityTypeRecAreaId
	 * @throws \InvalidArgumentException if data is not filled out
	 * @throws \RangeException if data exceeds limit
	 * @throws \Exception for any other exception
	 **/
	public function __construct($newActivityTypeActivityId, $newActivityTypeRecAreaId) {
		try {
			$this->setActivityTypeActivityId($newActivityTypeActivityId);
			$this->setActivityTypeRecAreaId($newActivityTypeRecAreaId);
			//determines what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Accessor method for activityTypeActivityId
	 *
	 * @return Uuid value of activityTypeActivityId
	 **/
	public function getActivityTypeActivityId() : Uuid {
		return($this->activityTypeActivityId);
	}
	/**
	 * mutator method for activityTypeActivityId
	 *
	 * @param Uuid/string $newActivityTypeActivityId new value of activityTypeActivityId
	 * @throws \RangeException if $newActivityTypeActivityId is not alphanumeric
	 * @throws \TypeError if $newActivityTypeActivityId is not a uuid
	 **/
	public function setActivityTypeActivityId($newActivityTypeActivityId) : void {
		try{
			$uuid = self::validateUuid ($newActivityTypeActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the ActivityTypeActivityId
		$this->activityTypeActivityId = $uuid;
	}
	/**
	 *Accessor method for activityTypeRecAreaId
	 *
	 *@return Uuid value of activityTypeRecAreaId
	 **/
	public function getActivityTypeRecAreaId() : Uuid {
		return($this->activityTypeRecAreaId);
	}
	/**
	 * mutator method for activityTypeRecAreaId
	 *
	 * @param Uuid/string $newActivityTypeRecAreaId new value of activityTypeRecAreaId
	 * @throws \RangeException if $newActivityTypeRecAreaId is not alphanumeric
	 * @throws \TypeError if $newActivityTypeRecAreaId is not a uuid
	 **/
	public function setActivityTypeRecAreaId($newActivityTypeRecAreaId) : void {
		try{
			$uuid = self::validateUuid ($newActivityTypeRecAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and stores the ActivityTypeRecAreaId
		$this->activityTypeRecAreaId = $uuid;
	}
	/**
	 * inserts this ActivityType into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO activityType(activityTypeActivityId, activityTypeRecAreaId) VALUES(:activityTypeActivityId, :activityTypeRecAreaId)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["activityTypeActivityId" => $this->activityTypeActivityId->getBytes(), "activityTypeRecAreaId" => $this->activityTypeRecAreaId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * deletes the ActivityType from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM activityType WHERE activityTypeActivityId = :activityTypeActivityId AND activityTypeRecAreaId = :activityTypeRecAreaId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters = ["activityTypeActivityId" => $this->activityTypeActivityId->getBytes(), "activityTypeRecAreaId" => $this->activityTypeRecAreaId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this ActivityType in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE activityType SET activityTypeActivityId = :activityTypeActivityId, activityTypeRecAreaId = :activityTypeRecAreaId WHERE activityTypeActivityId = :activityTypeActivityId AND activityTypeRecAreaId = :activityTypeRecAreaId";
		$statement = $pdo->prepare($query);
		//binds variables to the place holders in the template
		$parameters = ["activityTypeActivityId" => $this->activityTypeActivityId->getBytes(), "activityTypeRecAreaId" => $this->activityTypeRecAreaId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * gets the ActivityType by activityTypeActivityId and activityTypeRecAreaId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $activityTypeActivityId and $activityTypeRecAreaId to search for
	 * @return ActivityType|null ActivityType found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public static function getActivityTypeByActivityTypeActivityIdAndActivityTypeRecAreaId(\PDO $pdo, string $activityTypeActivityId, string $acitivityTypeRecAreaId) : ?ActivityType {
		//sanitize the string before searching
		try {
			$activityTypeActivityId = self::validateUuid($activityTypeActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		try {
			$acitivityTypeRecAreaId = self::validateUuid($acitivityTypeRecAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT activityTypeActivityId, activityTypeRecAreaId FROM activityType WHERE activityTypeActivityId = :activityTypeActivityId AND activityTypeRecAreaId = :activityTypeRecAreaId";
		$statement = $pdo->prepare($query);
		//bind the activityTypeActivityId and activityTypeRecAreaId to the place holder in the template
		$parameters = ["activityTypeActivityId" => $activityTypeActivityId->getBytes(), "activityTypeRecAreaId" => $acitivityTypeRecAreaId->getBytes()];
		$statement->execute($parameters);
		// grab the ActivityType from mySQL
		try {
			$activityType = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$activityType = new ActivityType($row["activityTypeActivityId"], $row["activityTypeRecAreaId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($activityType);
	}
	/**
	 * gets the ActivityType by activityTypeActivityId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $activityTypeActivityId activityId to search for
	 * @return \SplFixedArray SplFixedArray of ActivityTypes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getActivityTypeByActivityTypeAcivityId(\PDO $pdo, string $activityTypeActivityId) : \SPLFixedArray {
		try {
			$activityTypeActivityId = self::validateUuid($activityTypeActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT activityTypeActivityId, activityTypeRecAreaId FROM activityType WHERE activityTypeActivityId = :activityTypeActivityId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["activityTypeActivityId" => $activityTypeActivityId->getBytes()];
		$statement->execute($parameters);
		// build an array of activityTypes
		$activityTypes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$activityType = new ActivityType($row["activityTypeActivityId"], $row["activityTypeRecAreaId"]);
				$activityTypes[$activityTypes->key()] = $activityType;
				$activityTypes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($activityTypes);
	}
	/**
	 * gets the ActivityType by activityTypeRecAreaId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $sactivityTypeRecAreaId RecAreaId to search for
	 * @return \SplFixedArray SplFixedArray of ActivityTypes found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getActivityTypeByActivityTypeRecAreaId(\PDO $pdo, string $activityTypeRecAreaId) : \SPLFixedArray {
		try {
			$activityTypeRecAreaId = self::validateUuid($activityTypeRecAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT activityTypeActivityId, activityTypeRecAreaId FROM activityType WHERE activityTypeRecAreaId = :activityTypeRecAreaId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["activityTypeRecAreaId" => $activityTypeRecAreaId->getBytes()];
		$statement->execute($parameters);
		// build an array of activityTypes
		$activityTypes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$activityType = new ActivityType($row["activityTypeActivityId"], $row["activityTypeRecAreaId"]);
				$activityTypes[$activityTypes->key()] = $activityType;
				$activityTypes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($activityTypes);
	}
}
