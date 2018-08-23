<?php


namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname (__DIR__, 1) . "/lib/uuid.php");
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

   public function __construct() {
		$config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $this->guzzle = new Client(["base_uri" => "https://ridb.recreation.gov/api/v1/", "headers" => ["apikey" => $config["recgov"]]]);
      $this->pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $this->activities = Activity::getAllActivities($this->pdo)->toArray();
   }


//TODO: use guzzle??? instead of getMetaData function


   public function getRecAreaAndActivities(\stdClass $apiRecArea) : void {
   	$imageUrl = "https://bootcamp-coders.cnm.edu/~sheckendorn/nm-outdoors/public_html/images/facepalm.jpg";
   	if (count($apiRecArea->MEDIA) > 0) {
   		$imageUrl = $apiRecArea->MEDIA[0]->URL;
		}
		if (empty($apiRecArea->RecAreaLatitude) === true || empty ($apiRecArea->RecAreaLongitude) === true) {
   		return;
		}
      $recArea = new RecArea(generateUuidV4(), $apiRecArea->RecAreaDescription, $apiRecArea->RecAreaDirections, $imageUrl, $apiRecArea->RecAreaLatitude, $apiRecArea->RecAreaLongitude, $apiRecArea->RecAreaMapURL, $apiRecArea->RecAreaName);
      $recArea->insert($this->pdo);
      foreach($apiRecArea->ACTIVITY as $apiActivity) {
      	$currActivity = array_filter($this->activities, function ($mySqlActivity) use ($apiActivity){
      		return $mySqlActivity->getActivityName() === $apiActivity->RecAreaActivityDescription;
			});
      	$currActivity = array_shift($currActivity);
      	if ($currActivity !== null){
      		$activityType = new ActivityType($currActivity->getActivityId(), $recArea->getRecAreaId());
      		$activityType->insert($this->pdo);
			}
		}
   }

   public function processJson() : void {
   	$reply = $this->guzzle->get("recareas.json", ["query" => ["full" => "true", "state" => "NM"]]);
   	$apiReply = json_decode($reply->getBody());
   	foreach($apiReply->RECDATA as $apiRecArea) {
   		$this->getRecAreaAndActivities($apiRecArea);
		}
	}

}
try {
	$downloader = new DataDownloader();
	$downloader->processJson();
} catch(\Exception $exception) {
	echo $exception->getMessage() . PHP_EOL;
   echo $exception->getTraceAsString() . PHP_EOL;
}