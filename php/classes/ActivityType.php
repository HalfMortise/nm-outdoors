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
}