<?php

namespace HalfMortise\nmoutdoors;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


class Activity {
	use ValidateUuid;
	/**
	 * id for the activity; this is the primary key
	 * @var $activityId
	 */
	private $activityId;
	/**
	 * @var $activityName
	 */
	private $activityName;
	/**
	 * Activity constructor.
	 * @param string|UUID $newActivityId gives ID of this ActivityID
	 * @param string| $newActivityName gives input of this Name
	 * @throws \InvalidArgumentException if data is not filled out
	 * @throws \RangeException if data exceeds limit
	 * @throws \Exception for any other exception
	 */
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
	 */
	public function getActivityId() :Uuid {
		return ($this->activityId);
	}
	/**
	 * mutator method for activityId
	 *
	 * @param Uuid/string $newActivityId new value of activityId
	 * @throws \RangeException if $newActivityId is not alphanumeric
	 * @throws \TypeError if $newActivityId is not uuid
	 */
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
	 */
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
	 */
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

}