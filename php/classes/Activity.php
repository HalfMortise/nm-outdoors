<?php

namespace HalfMortise\NmOutdoors;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This is the placeholder for all of the activities users can find on our interactive site
 *
 * Class identified as Activity
 *
 * @package HalfMortise\NmOutdoors
 * @author sarahheckendorn
 * @version 1.0
 **/

class Activity implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for the activity; this is the primary key
	 * @var Uuid|string $activityId
	 **/
	private $activityId;
	/**
	 * @var string $activityName
	 **/
	private $activityName;
	/**
	 * Activity constructor.
	 * @param string|UUID $newActivityId gives ID of this ActivityID
	 * @param string| $newActivityName gives input of this Name
	 * @throws \InvalidArgumentException if data is not filled out
	 * @throws \RangeException if data exceeds limit
	 * @throws \Exception for any other exception
	 **/
	public function __construct($newActivityId, string $newActivityName) {
		try{
			$this->setActivityId($newActivityId);
			$this->setActivityName($newActivityName);
			//determines what exception type was thrown
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for activity Id
	 *
	 * @return Uuid value of activity id
	 **/
	public function getActivityId() :Uuid {
		return ($this->activityId);
	}
	/**
	 * mutator method for activityId
	 *
	 * @param Uuid/string $newActivityId new value of activityId
	 * @throws \RangeException if $newActivityId is not alphanumeric
	 * @throws \TypeError if $newActivityId is not uuid
	 **/
	public function setActivityId($newActivityId) : void {
		try {
			$uuid = self::validateUuid($newActivityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the activity Id
		$this->activityId = $uuid;
	}

	/**
	 * accessor method for activityName
	 *
	 * @return string value of Activity Name
	 **/
	public function getActivityName() :string {
		return($this->activityName);
	}
	/**
	 * mutator method for activityName
	 *
	 * @param string $newActivityName new value of activityName
	 * @throws \InvalidArgumentException if $newActivityName is not a string or insecure
	 * @throws \RangeException if $newActivityName is > 60 characters
	 * @throws \TypeError if $newActivityName is not a string
	 **/
	public function setActivityName(string $newActivityName) : void {
		//verify that activity Name is secure
		$newActivityName = trim($newActivityName);
		$newActivityName = filter_var($newActivityName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newActivityName) === true){
			throw(new \InvalidArgumentException("Activity Name cannot be empty"));
		}
		//verify that Activity Name will fit in the database
		if(strlen($newActivityName) > 60) {
			throw(new \RangeException("Activity Name characters exceed limit"));
		}
		$this->activityName = $newActivityName;
	}
	/**
	 * inserts this activityId into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO activity(activityId, activityName) VALUES (:activityId, :activityName)";
		$statement = $pdo->prepare($query);
		$parameters = ["activityId" => $this->activityId->getBytes(), "activityName" => $this->activityName];
		$statement->execute($parameters);
	}
	/**
	 * deletes this activityId from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM activity WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["activityId" => $this->activityId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Activity from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE activity SET activityName = :activityName WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["activityId" => $this->activityId->getBytes(), "activityName" => $this->activityName];
		$statement->execute($parameters);
	}
	/**
	 * gets the activity by activity id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param string $activityId Activity Id to search for
	 * @return Activity|null Tab or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getActivityByActivityId(\PDO $pdo, string $activityId):?Activity {
		// sanitize the activity id before searching
		try {
			$activityId = self::validateUuid($activityId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT activityId, activityName FROM activity WHERE activityId = :activityId";
		$statement = $pdo->prepare($query);
		// bind the activity id to the place holder in the template
		$parameters = ["activityId" => $activityId->getBytes()];
		$statement->execute($parameters);
		// grab the Activity from mySQL
		try {
			$activity = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$activity = new Activity($row["activityId"], $row["activityName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($activity);
	}

	/**
	 * gets all Activities
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllActivities(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT activityId, activityName FROM activity";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of activities
		$activities = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$activity = new Activity($row["activityId"], $row["activityName"]);
				$activities[$activities->key()] = $activity;
				$activities->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($activities);
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["activityId"] = $this->activityId->toString();
		return ($fields);
	}
}