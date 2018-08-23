<?php


namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/lib/uuid.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use GuzzleHttp\Client;


/**
 * This class will download data from  RIDB.Recreation.Gov.
 *
 * @author Dylan McDonald dmcdonald21@cnm.edu
 * @author HalfMortise <https://www.github.com/halfmortise>
 * @author SHeckendorn <https://www.github.com/sheckendorn>
 *
 **/
class DataDownloader {
	/*
	 * @var array
	 */
	private $activities;
	/**
	 * @var Client
	 */
	private $guzzle;

	/**
	 * @var \PDO $pdo
	 */
	private $pdo;

	/*
	 * constructor for the class
	 */

	public function __construct() {
		$config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
		//connection to the api
		$this->guzzle = new Client(["base_uri" => "https://ridb.recreation.gov/api/v1/", "headers" => ["apikey" => $config["recgov"]]]);
		$this->pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
		$this->activities = Activity::getAllActivities($this->pdo)->toArray();
	}

	/*
	 * function to call api and pull data and inject into SQL tables for both RecArea and Activity
	 */

	public function getRecAreaAndActivities(\stdClass $apiRecArea): void {
		//place holder image in event that api does not provide RecAreaImageUrl
		$imageUrl = "https://bootcamp-coders.cnm.edu/~sheckendorn/nm-outdoors/public_html/images/facepalm.jpg";
		if(count($apiRecArea->MEDIA) > 0) {
			$imageUrl = $apiRecArea->MEDIA[0]->URL;
		}
		//excludes from api call the recAreas that do not include lat and long
		if(empty($apiRecArea->RecAreaLatitude) === true || empty ($apiRecArea->RecAreaLongitude) === true) {
			return;
		}
		//process to inject api data into RecAreaSQL table
		$recArea = new RecArea(generateUuidV4(), $apiRecArea->RecAreaDescription, $apiRecArea->RecAreaDirections, $imageUrl, $apiRecArea->RecAreaLatitude, $apiRecArea->RecAreaLongitude, $apiRecArea->RecAreaMapURL, $apiRecArea->RecAreaName);
		$recArea->insert($this->pdo);
		foreach($apiRecArea->ACTIVITY as $apiActivity) {
			$currActivity = array_filter($this->activities, function ($mySqlActivity) use ($apiActivity) {
				return $mySqlActivity->getActivityName() === $apiActivity->RecAreaActivityDescription;
			});
			//process to inject api data into Activity SQL table
			$currActivity = array_shift($currActivity);
			if($currActivity !== null) {
				$activityType = new ActivityType($currActivity->getActivityId(), $recArea->getRecAreaId());
				$activityType->insert($this->pdo);
			}
		}
	}

	/*
	 * incorporates guzzle
	 * maps to json and loops 50x and then repeats until all data is acquired
	 */

	public function processJson(): void {
		$currResult = 0;
		$numResults = null;
		do {
			$reply = $this->guzzle->get("recareas.json", ["query" => ["full" => "true", "offset" => $currResult, "state" => "NM"]]);
			$apiReply = json_decode($reply->getBody());
			if ($numResults === null) {
				$numResults = $apiReply->METADATA->RESULTS->TOTAL_COUNT;
			}
			foreach($apiReply->RECDATA as $apiRecArea) {
				$this->getRecAreaAndActivities($apiRecArea);
			}
			$currResult = $currResult + 50;
		} while($currResult < $numResults);
	}
}
try {
	$downloader = new DataDownloader();
	$downloader->processJson();
} catch(\Exception $exception) {
	echo $exception->getMessage() . PHP_EOL;
	echo $exception->getTraceAsString() . PHP_EOL;
}