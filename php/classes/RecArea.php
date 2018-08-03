<?php
/**
 * Created by PhpStorm.
 * User: bashirshafii
 * Date: 7/31/18
 * Time: 5:58 PM
 */

namespace HalfMortise\NmOutdoors;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;


class RecArea {
	use ValidateUuid;
	/**
	 * id for the rec area ; this is the primary key
	 * @var Uuid| $recAreaId
	 */

		private $recAreaId;
	/**
	 * rec area description
	 * @var string $recAreaDescription
	 */
		private $recAreaDescription;

	/**
	 * Good Map Directions to rec area
	 * @var string $recAreaDirections
	 */

		private $recAreaDirections;
	/**
	 * a url string holding a stock image of rec area
	 * @var string $recAreaImageUrl
	 */
		private $recAreaImageUrl;
	/**
	 * Latitude position  of a rec area
	 * @var double $recAreaLat
	 */
		private $recAreaLat;

	/**
	 * longitude position of rec area
	 * @var double $recAreaLong
	 */
		private $recAreaLong;

	/**
	 * url of the rec area map
	 * @var string $recAreaMapUrl
	 */
		private $recAreaMapUrl;

	/**
	 * rec area name
	 * @var string $recAreaName
	 */
		private $recAreaName;

		/**
		 * constructor for the RecArea class
		 * @param string Uuid $newRecAreaId Id of of the rec area
		 * @param string $newRecAreaDescription string containing description of the rec area
		 * @param string $newRecAreaDirections string containing google map directions to the rec area
		 * @param string $newRecAreaImageUrl string link containing a stock photo of the rec area
		 * @param double  $newRecAreaLat double  containing the latitude value of the rec area location
		 * @param double $newRecAreaLong double  containing the longitude  value of the rec area location
		 * @param string $newRecAreaMapUrl string containing link to the rec area map
		 * @param string $newRecAreaName string containing the name of the rec area
		 * @throws \InvalidArgumentException if data type is not valid
		 * @throws \RangeException if data values are out of bounds
		 * @throws \TypeError if data type violates data hint
		 * @throws \Exception if some other exceptions occur
		 **/


		public function __construct($newRecAreaId, $newRecAreaDescription, $newRecAreaDirections, $newRecAreaImageUrl, $newRecAreaLat, $newRecAreaLong, $newRecAreaMapUrl, $newRecAreaName){

		        try{
		        				$this->setRecAreaId($newRecAreaId);
		        				$this->setRecAreaDescription($newRecAreaDescription);
		        				$this->setRecAreaDirections($newRecAreaDirections);
		        				$this->setRecAreaImageUrl($newRecAreaImageUrl);
		        				$this->setRecAreaLat($newRecAreaLat);
		        				$this->setRecAreaLong($newRecAreaLong);
		        				$this->setRecAreaMapUrl($newRecAreaMapUrl);
		        				$this->setRecAreaName($newRecAreaName);

				  } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
		        				$exceptionType = get_class($exception);
		        				throw(new $exceptionType($exception->getMessage(), 0 , $exception));

				  }



		}

		/**
		 * accessor method for recArea id
		 * @return Uuid value of rec area id
		 *
		 */

		public function getRecAreaId() : string {
			return ($this->recAreaId);
		}

		/**
		 * mutator method for recArea Id
		 */
	/**
	 * @param Uuid $recAreaId
	 * @throws \RangeException if the $recAreaId is not positive
	 * @throws \TypeError if $recAreaId is not unique (valid Uuid)
	 */
	public function setRecAreaId($newRecAreaId): void {

		try { $uuid = self::validateUuid($newRecAreaId);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0 , $exception));

		}
		$this->recAreaId = $uuid;
	}

	/**
	 * accessor method for rec Area Description
	 */
	/**
	 * @return string value of the recAreaId
	 */
	public function getRecAreaDescription() {
		return $this->recAreaDescription;
	}

	/**
	 * mutator method for recArea Description
	 */
	/**
	 * @param mixed $recAreaDescription
	 */
	public function setRecAreaDescription($recAreaDescription): void {
		$this->recAreaDescription = $recAreaDescription;
	}

	/**
	 * accessor method for rec area directions
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaDirections() {
		return $this->recAreaDirections;
	}

	/**
	 * mutator method for rec area directions
	 */
	/**
	 * @param mixed $recAreaDirections
	 */
	public function setRecAreaDirections($recAreaDirections): void {
		$this->recAreaDirections = $recAreaDirections;
	}

	/**
	 * accessor method for rec area image url
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaImageUrl() {
		return $this->recAreaImageUrl;
	}

	/**
	 * mutator method for rec area image url
	 */
	/**
	 * @param mixed $recAreaImageUrl
	 */
	public function setRecAreaImageUrl($recAreaImageUrl): void {
		$this->recAreaImageUrl = $recAreaImageUrl;
	}

	/**
	 * accessor method for rec area latitude
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaLat() {
		return $this->recAreaLat;
	}

	/**
	 * mutator method for rec area latitude
	 */
	/**
	 * @param mixed $recAreaLat
	 */
	public function setRecAreaLat($recAreaLat): void {
		$this->recAreaLat = $recAreaLat;
	}

	/**
	 * accessor method for rec area longitude
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaLong() {
		return $this->recAreaLong;
	}

	/**
	 * mutator method for rec area longitude
	 */
	/**
	 * @param mixed $recAreaLong
	 */
	public function setRecAreaLong($recAreaLong): void {
		$this->recAreaLong = $recAreaLong;
	}

	/**
	 * accessor method for rec area map url
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaMapUrl() {
		return $this->recAreaMapUrl;
	}

	/**
	 * mutator method for rec area map url
	 */
	/**
	 * @param mixed $recAreaMapUrl
	 */
	public function setRecAreaMapUrl($recAreaMapUrl): void {
		$this->recAreaMapUrl = $recAreaMapUrl;
	}

	/**
	 * accessor method for rec area name
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaName() {
		return $this->recAreaName;
	}

	/**
	 * mutator method for rec area name
	 */
	/**
	 * @param mixed $recAreaName
	 */
	public function setRecAreaName($recAreaName): void {
		$this->recAreaName = $recAreaName;
	}


}