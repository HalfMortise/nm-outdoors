<?php
/**
 * Created by PhpStorm.
 * User: bashirshafii
 * Date: 7/31/18
 * Time: 5:58 PM
 */
class RecArea{

		private $recAreaId;
		private $recAreaDescription;
		private $recAreaDirections;
		private $recAreaImageUrl;
		private $recAreaLat;
		private $recAreaLong;
		private $recAreaMapUrl;
		private $recAreaName;

		//constructor for the RecArea class


		public function __construct($newRecAreaId, $newRecAreaDescription, $newRecAreaDirections, $newRecAreaImageUrl, $newRecAreaLat, $newRecAreaLong, $newRecAreaMapUrl, $newRecAreaName){

		        try{
		        				$this->setRecAreaId($newRecAreaId);
		        				$this->setRecAreaDescription($newRecAreaDescription);
		        				$this->setRecAreaDirections($newRecAreaDirections);
		        				$this->setRecAreaImageUrl($newRecAreaImageUrl);
		        				$this->setRecAreaLat($newRecAreaLat);
		        				$this->setRecAreaLong($newRecAreaLong);
		        				$this->setAreaMapUrl($newRecAreaMapUrl);
		        				$this->setRecAreaName($newRecAreaName);

				  } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
		        				$exceptionType = get_class($exception);
		        				throw(new $exceptionType($exception->getMessage(), 0 , $exception));

				  }



		}

		/**
		 * accessor method for recArea id
		 *
		 */

		public function getRecAreaId() : string {
			return ($this->recAreaId);
		}

		/**
		 * mutator method for recArea Id
		 */
	/**
	 * @param mixed $recAreaId
	 */
	public function setRecAreaId($recAreaId): void {
		$this->recAreaId = $recAreaId;
	}

	/**
	 * accessor method for rec Area Description
	 */
	/**
	 * @return mixed
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