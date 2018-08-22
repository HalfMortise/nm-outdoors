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
 * @author HalfMortise <https://www.github.com/halfmortise>
 * @author SHeckendorn <https://www.github.com/sheckendorn>
 *
 **/
class DataDownloader {
	/*
	 * @var \SplFixedArray
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
      $this->activities = Activity::getAllActivities($this->pdo);
   }


//TODO: use guzzle??? instead of getMetaData function


   public function getRecAreaAndActivities(\stdClass $apiRecArea) : void {
      $recArea = new RecArea(generateUuidV4(), $apiRecArea->RecAreaDescription, $apiRecArea->RecAreaDirections, $apiRecArea->RecAreaLatitude, $apiRecArea->RecAreaLongitude, $apiRecArea->RecAreaMapURL, $apiRecArea->RecAreaName);
      $recArea->insert($this->pdo);
      foreach($apiRecArea->ACTIVITY as $apiActivity) {
      	$currActivity = array_filter($this->activities, function ($mySqlActivity) use ($apiActivity){
      		return $mySqlActivity->getActivityName() === $apiActivity->recAreaActivityDescription;
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
   	var_dump($apiReply);
	}

}
try {
	$downloader = new DataDownloader();
	$downloader->processJson();
} catch(\Exception $exception) {
   echo $exception->getTraceAsString() . PHP_EOL;
}