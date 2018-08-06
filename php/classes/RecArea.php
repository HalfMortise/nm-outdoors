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
	 **/

	private $recAreaId;
	/**
	 * rec area description
	 * @var string $recAreaDescription
	 **/
	private $recAreaDescription;

	/**
	 * Good Map Directions to rec area
	 * @var string $recAreaDirections
	 **/

	private $recAreaDirections;
	/**
	 * a url string holding a stock image of rec area
	 * @var string $recAreaImageUrl
	 **/
	private $recAreaImageUrl;
	/**
	 * Latitude position  of a rec area
	 * @var double $recAreaLat
	 **/
	private $recAreaLat;

	/**
	 * longitude position of rec area
	 * @var double $recAreaLong
	 **/
	private $recAreaLong;

	/**
	 * url of the rec area map
	 * @var string $recAreaMapUrl
	 **/
	private $recAreaMapUrl;

	/**
	 * rec area name
	 * @var string $recAreaName
	 **/
	private $recAreaName;

	/**
	 * constructor for the RecArea class
	 * @param string Uuid $newRecAreaId Id of of the rec area
	 * @param string $newRecAreaDescription string containing description of the rec area
	 * @param string $newRecAreaDirections string containing google map directions to the rec area
	 * @param string $newRecAreaImageUrl string link containing a stock photo of the rec area
	 * @param double $newRecAreaLat double  containing the latitude value of the rec area location
	 * @param double $newRecAreaLong double  containing the longitude  value of the rec area location
	 * @param string $newRecAreaMapUrl string containing link to the rec area map
	 * @param string $newRecAreaName string containing the name of the rec area
	 * @throws \InvalidArgumentException if data type is not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data type violates data hint
	 * @throws \Exception if some other exceptions occur
	 **/


	public function __construct($newRecAreaId, string $newRecAreaDescription, string $newRecAreaDirections, string $newRecAreaImageUrl, float $newRecAreaLat, float $newRecAreaLong, string $newRecAreaMapUrl, string $newRecAreaName) {

		try {
			$this->setRecAreaId($newRecAreaId);
			$this->setRecAreaDescription($newRecAreaDescription);
			$this->setRecAreaDirections($newRecAreaDirections);
			$this->setRecAreaImageUrl($newRecAreaImageUrl);
			$this->setRecAreaLat($newRecAreaLat);
			$this->setRecAreaLong($newRecAreaLong);
			$this->setRecAreaMapUrl($newRecAreaMapUrl);
			$this->setRecAreaName($newRecAreaName);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));

		}


	}

	/**
	 * accessor method for recArea id
	 * @return Uuid value of rec area id
	 *
	 **/

	public function getRecAreaId(): Uuid {
		return ($this->recAreaId);
	}

	/**
	 * mutator method for recArea Id
	 * @param Uuid $recAreaId
	 * @throws \RangeException if the $recAreaId is not positive
	 * @throws \TypeError if $recAreaId is not unique (valid Uuid)
	 **/
	public function setRecAreaId(string $newRecAreaId): void {

		try {
			$uuid = self::validateUuid($newRecAreaId);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));

		}
		//convert and store rec area id
		$this->recAreaId = $uuid;
	}

	/**
	 * accessor method for rec Area Description
	 * @return string value of the rec Area Description
	 **/
	public function getRecAreaDescription(): string {
		return ($this->recAreaDescription);
	}

	/**
	 * mutator method for recArea Description
	 * @param string $recAreaDescription
	 * @throws \InvalidArgumentException if description is not string or insecure
	 * @throws \RangeException if description is longer than 2048 characters
	 * @throws \TypeError if rec area description is not string
	 **/
	public function setRecAreaDescription(string $recAreaDescription): void {
		if(strlen($recAreaDescription) > 2048) {
			throw(new\RangeException("Description can't be longer than 2048 characters"));
		}

		$this->recAreaDescription = $recAreaDescription;
	}

	/**
	 * accessor method for rec area directions
	 * @return string
	 **/
	public function getRecAreaDirections(): string {
		return ($this->recAreaDirections);
	}

	/**
	 * mutator method for rec area directions
	 * @param string $recAreaDirections
	 **/
	public function setRecAreaDirections(string $recAreaDirections): void {
		$this->recAreaDirections = $recAreaDirections;
	}

	/**
	 * accessor method for rec area image url
	 * @return mixed
	 **/
	public function getRecAreaImageUrl(): string {
		return $this->recAreaImageUrl;
	}

	/**
	 * mutator method for rec area image url
	 */
	/**
	 * @param mixed $recAreaImageUrl
	 */
	public function setRecAreaImageUrl(string $recAreaImageUrl): void {
		if(strlen($recAreaImageUrl) > 255) {
			throw(new\RangeException("Image Url can't be longer than 255 characters"));
		}
		$this->recAreaImageUrl = $recAreaImageUrl;
	}


	/**
	 * accessor method for rec area Latitude location
	 * @returns float value of the latitudinal location
	 **/
	public function getRecAreaLat(): float {
		return $this->recAreaLat;
	}

	/**
	 * mutator method for rec area Latitude location
	 * @param float $newRecAreaLat is a float object
	 * @throws \TypeError if $newRecAreaLat is not a float
	 * @throws \RangeException if $newRecAreaLat is less than -90, more than 90, or empty string
	 **/
	public function setRecAreaLat(float $newRecAreaLat): void {
		if($newRecAreaLat < -90 || $newRecAreaLat > 90 || empty($newRecAreaLat) === true) {
			throw(new \RangeException("Latitude must be between -90 and 90 and can't be empty"));
		}
		//Store new rec area Latitude value
		$this->recAreaLat = $newRecAreaLat;
	}

	/**
	 * accessor method for new rec area Longitude location
	 * @returns float value of the Longitudinal location
	 **/
	public function getRecAreaLong(): float {
		return $this->recAreaLong;
	}

	/**
	 * mutator method for the new rec area Longitude location
	 * @param float $newrecAreaLong is a float object
	 * @throws \TypeError if $newRecAreaLong is not a float
	 * @throws \RangeException if $newRecAreaLong is less than -180, more than 180, or empty string
	 **/
	public function setRecAreaLong(float $newRecAreaLong): void {
		if($newRecAreaLong < -180 || $newRecAreaLong > 180 || empty($newRecAreaLong) === true) {
			throw(new \RangeException("Longitude must be between -180 and 180 and can't be empty"));
		}
		//store new rec area  Longitude Location
		$this->recAreaLong = $newRecAreaLong;
	}
	/**
	 * accessor method for rec area map url
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaMapUrl(): string {

		return $this->recAreaMapUrl;
	}

	/**
	 * mutator method for rec area map url
	 */
	/**
	 * @param mixed $recAreaMapUrl
	 */
	public function setRecAreaMapUrl(string $recAreaMapUrl): void {
		if(strlen($recAreaMapUrl) > 255) {
			throw(new\RangeException("Map Url can't be longer than 255 characters"));
		}
		$this->recAreaMapUrl = $recAreaMapUrl;
	}

	/**
	 * accessor method for rec area name
	 */
	/**
	 * @return mixed
	 */
	public function getRecAreaName(): string {
		return $this->recAreaName;
	}

	/**
	 * mutator method for rec area name
	 */
	/**
	 * @param mixed $recAreaName
	 */
	public function setRecAreaName(string $recAreaName): void {
		if(strlen($recAreaName) > 255) {
			throw(new\RangeException("Rec Area name  can't be longer than 255 characters"));
		}
		$this->recAreaName = $recAreaName;
	}




	/**
	 * Begin PDO Methods
	 */
	/**
	 * inserts rec area into SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL relations error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		//create a query template for the insert method
		$query = "INSERT INTO recArea(recAreaId,recAreaDescription,recAreaDirections,recAreaImageUrl,recAreaLat,recAreaLong,recAreaMapUrl,
	recAreaName) VALUES (:recAreaId,:recAreaDescription,:recAreaDirections,:recAreaImageUrl,:recAreaLat,:recAreaLong,:recAreaMapUrl,:recAreaName)";
		$statement = $pdo->prepare($query);
		//bind variables to their place in the query template
		$parameters =
			["recAreaId" => $this->recAreaId->getBytes(),
				"recAreaDescription" => $this->recAreaDescription,
				"recAreaDirections" => $this->recAreaDirections,
				"recAreaImageUrl" => $this->recAreaImageUrl,
				"recAreaLat" => $this->recAreaLat,
				"recAreaLong" => $this->recAreaLong,
				"recAreaMapUrl" => $this->recAreaMapUrl,
				"recAreaName" => $this->recAreaName];
		$statement->execute($parameters);
	}

	/**
	 * deletes the rec area from SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template for the delete method
		$query = "DELETE FROM recArea WHERE recAreaId = :recAreaId";
		$statement = $pdo->prepare($query);
		//bind variables to their place in the query template
		$parameters = ["recAreaId" => $this->recAreaId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates the rec area  in SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo): void {
		//create query template for the update method
		$query = "UPDATE recArea SET 
	recAreaId = :recAreaId,
	recAreaDescription = :recAreaDescription,
	recAreaDirections = :recAreaDirections,
	recAreaImageUrl = :recAreaImageUrl,
	recAreaLat = :recAreaLat,
	recAreaLong = :recAreaLong,
	recAreaMapUrl = :recAreaMapUrl,
	recAreaName = :recAreaName
	WHERE recAreaId = :recAreaId";
		$statement = $pdo->prepare($query);
		//bind variable to their place in the query template
		$parameters =
			["recAreaId" => $this->recAreaId->getBytes(),
				"recAreaDescription" => $this->recAreaDescription,
				"recAreaDirections" => $this->recAreaDirections,
				"recAreaImageUrl" => $this->recAreaImageUrl,
				"recAreaLat" => $this->recAreaLat,
				"recAreaLong" => $this->recAreaLong,
				"recAreaMapUrl" => $this->recAreaMapUrl,
				"recAreaName" => $this->recAreaName,];
		$statement->execute($parameters);
	}

	public static function getrecAreaByRecAreaId(\PDO $pdo, $recAreaId): ? recArea {
		//sanitize the recAreaId before searching
		try {
			$recAreaId = self::validateUuid($recAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// creating query template
		$query = "SELECT recAreaId,recAreaDescription,recAreaDirections,
	recAreaImageUrl,recAreaLat,recAreaLong,recAreaMapUrl,recAreaName 
	FROM recArea WHERE recAreaId = :recAreaId";
		$statement = $pdo->prepare($query);
		//binding the recAreaId to the placeholders in the template
		$parameters = ["recAreaId" => $recAreaId->getBytes()];
		$statement->execute($parameters);
		//retrieve the recArea from mySQL
		try {
			$recArea = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$recArea = new RecArea($row["recAreaId"], $row["recAreaDescription"], $row["recAreaDirections"], $row["recAreaImageUrl"], $row["recAreaLat"], $row["recAreaLong"], $row["recAreaMapUrl"], $row["recAreaName"]);
			}
		} catch(\Exception $exception) {
			//if the new row cannot be converted, throw it again
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($recArea);
	}
//	public static function getDistanceToRecArea(\PDO $pdo, $recAreaLat1, $recAreaLong1, $recAreaLat2, $recAreaLong2){
//		// convert lat1 and lat2 into radians now, to avoid doing it twice below
//		$lat1rad = deg2rad($recAreaLat1);
//		$lat2rad = deg2rad($recAreaLat2);
//		// apply the spherical law of cosines to our latitudes and longitudes, and set the result appropriately
//		// 6378.1 is the approximate radius of the earth in kilometres
//		return acos( sin($lat1rad) * sin($lat2rad) + cos($lat1rad) * cos($lat2rad) * cos( deg2rad($recAreaLong2) - deg2rad($recAreaLong1) ) ) * 6378.1;
//
//	}
	/**
	 * gets the recArea by distance
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param float $userLat latitude coordinate of where user is
	 * @param float $userLong longitude coordinate of where user is
	 * @param float $distance distance in miles that the user is searching by
	 * @return \SplFixedArray SplFixedArray of pieces of recArea found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * **/
	public static function getRecAreaByDistance(\PDO $pdo, float $userLong, float $userLat, float $distance) : \SplFixedArray {
		// create query template
		$query = "SELECT recAreaId, recAreaDescription, recAreaDirections, recAreaImageUrl, recAreaLat, recAreaLong, recAreaMapUrl, recAreaName FROM recArea WHERE haversine(:userLong, :userLat, recAreaLong, recAreaLat) < :distance";
		$statement = $pdo->prepare($query);
		// bind the recArea distance to the place holder in the template
		$parameters = ["distance" => $distance, "userLat" => $userLat, "userLong" => $userLong];
		$statement->execute($parameters);
		// build an array of recArea
		$recAreas = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recArea = new recArea($row["recAreaId"], $row["recAreaDescription"], $row["recAreaDirections"], $row["recAreaImageUrl"], $row["recAreaLat"], $row["recAreaLong"], $row["recAreaMapUrl"], $row["recAreaName"]);
				$recAreas[$recAreas->key()] = $recArea;
				$recAreas->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($recAreas);
	}
}