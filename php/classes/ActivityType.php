<?php

namespace Sarahheckendorn\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class ActivityType {
	use ValidateUuid;
	/**
	 * id for the ActivityTypeActivityId; this is a foreign key
	 * @var $songTabSongId
	 */
	private $activityTypeActivityId;
	/**
	 * id for the ActivityTypeRecId; this is a foreign key
	 * @var $activityTypeRecId
	 */
	private $activityTypeRecId;

	/**
	 * ActivityType constructor.
	 * @param string|UUID $newActivityTypeActivityId gives the id of ActivityTypeActivityID
	 * @param string|UUID $newActivityTypeRecId gives the ID of ActivityTypeRecId
	 * @throws \InvalidArgumentException if data is not filled out
	 * @throws \RangeException if data exceeds limit
	 * @throws \Exception for any other exception
	 */
	public function __construct($newActivityTypeActivityId, $newActivityTypeRedId) {
		try {
			$this->setActivityTypeActivityId($newActivityTypeActivityId);
			$this->setActivityTypeRecId($newActivityTypeRedId);
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
	 */
	public function getActivityTypeActivityId() : Uuid {
		return($this->activityTypeActivityId);
	}
	/**
	 * mutator method for activityTypeActivityId
	 *
	 * @param Uuid/string $newActivityTypeActivityId new value of activityTypeActivityId
	 * @throws \RangeException if $newActivityTypeActivityId is not alphanumeric
	 * @throws \TypeError if $newActivityTypeActivityId is not a uuid
	 */
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
	 *Accessor method for activityTypeRecId
	 *
	 *@return Uuid value of activityTypeRecId
	 */
	public function getActivityTypeRecId() : Uuid {
		return($this->activityTypeRecId);
	}
	/**
	 * mutator method for activityTypeRecId
	 *
	 * @param Uuid/string $newActivityTypeRecId new value of activityTypeRecId
	 * @throws \RangeException if $newActivityTypeRecId is not alphanumeric
	 * @throws \TypeError if $newActivityTypeRecId is not a uuid
	 */
	public function setActivityTypeRecId($newActivityTypeRecId) : void {
		try{
			$uuid = self::validateUuid ($newActivityTypeRecId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and stores the ActivityTypeRecId
		$this->activityTypeRecId = $uuid;
	}
}